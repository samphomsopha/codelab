<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseClient;
use Parse\ParseFile;
use Parse\ParseObject;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Yaml\Exception\ParseException;

class ChatServiceController extends Controller {

    public function deleteMessage($id, Request $request) {
        $current_user = ParseUser::getCurrentUser();
        //TODO Make sure user has permission to delete messages
        $query = new ParseQuery("Messages");
        try {
            $messageObj = $query->get($id);
            $messageObj->destroy();

            $ret = [
                'status' => 'success'
            ];
            return response(json_encode($ret))
                ->header('Content-Type', 'text/json');

        } catch (ParseException $ex) {
            $ret = [
                'status' => 'fail',
                'error' => $ex->getMessage()
            ];
            return response(json_encode($ret))
                ->header('Content-Type', 'text/json');
        }
    }

    public function newMessage(Request $request) {
        $current_user = ParseUser::getCurrentUser();

        $message = $request->input("message");
        $chat_id = $request->input("chat_id");
        $assets = $request->input("assets");
        $utube = $request->input("youtube");

            try {
                $messageObj = new ParseObject("Messages");
                $query = new ParseQuery("ChatRoom");
                $chatRoom = $query->get($chat_id);
                $messageObj->set("message", $message);
                $messageObj->set("user", $current_user);
                $messageObj->set("chatRoom", $chatRoom);
                $messageObj->save();

                $relation = $chatRoom->getRelation("messages");
                $relation->add($messageObj);
                $chatRoom->save();
                if (!empty($assets))
                {
                    $mrelation = $messageObj->getRelation("asset");
                    $crelation = $chatRoom->getRelation("assets");
                    foreach($assets as $asset_id)
                    {
                        $assetQry = new ParseQuery("Assets");
                        $assetObj = $assetQry->get($asset_id);
                        $mrelation->add($assetObj);
                        $crelation->add($assetObj);
                    }
                    $chatRoom->save();
                }

                if (!empty($utube))
                {
                    if (preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $utube, $matches)) {
                        $utube = $matches[1];

                        $assetUobj = new ParseObject("Assets");
                        // add the file we saved above
                        $assetUobj->set("youtube", $utube);
                        $assetUobj->save();
                        $mrelation = $messageObj->getRelation("asset");
                        $crelation = $chatRoom->getRelation("assets");

                        $mrelation->add($assetUobj);
                        $crelation->add($assetUobj);
                        $chatRoom->save();
                    }
                }
                $messageObj->save();

                $ret = [
                    'status' => "success",
                    'data' => [
                        'object' => "messages",
                        'id' => $messageObj->getObjectId(),
                        'message' => $messageObj->get("message")
                    ]
                ];

                return response()->json($ret);

            } catch (ParseException $ex) {
                $ret = [
                    'status' => 'fail',
                    'error' => $ex->getMessage()
                ];
                return response()->json($ret);
            }
    }

    public function upload(Request $request) {
        if ( isset( $_FILES['image'] ) ) {
            $chatRoomId = $request->input('chat_id');
            // save file to Parse
            try {
                $fname = str_replace(' ', '', $_FILES['image']['name']);
                $file = ParseFile::createFromData( file_get_contents( $_FILES['image']['tmp_name'] ), $fname );
                $file->save();

                // save something to class TestObject
                $asset = new ParseObject( "Assets" );
                // add the file we saved above
                $asset->set( "file", $file );
                $asset->save();

                $ret = [
                    'status' => 'success',
                    'data' => [
                        'asset' => ['id' => $asset->getObjectId()],
                        'file' => ['url' => $file->getUrl()]
                    ]
                ];
                return response()->json($ret);

            } catch (ParseException $ex) {
                $ret = [
                    'status' => 'fail',
                    'error' => $ex->getMessage()
                ];
                return response()->json($ret);
            }

        } else {
            $ret = [
                'status' => 'fail',
                'error' => 'no file selected'
            ];
            return response()->json($ret);
        }
    }

    public function getMessages($chatRoomId, $lastMsgId = null, $lastTime = null, Request $request) {
        $query = new ParseQuery("ChatRoom");
        try {
            $chatObj = $query->get($chatRoomId);
            // get events
            $relation = $chatObj->getRelation("messages");
            $query = $relation->getQuery();
            $query->includeKey('user');
            $query->addAscending('createdAt');

            if (!empty($lastMsgId))
            {
                $query->notEqualTo('objectId', $lastMsgId);
            }

            if ($lastTime > 0)
            {
                $dt = new \DateTime('now');
                //$dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
                $dt->setTimestamp($lastTime);
                $createdStr = $dt->format('Y-m-d')."T".$dt->format("H:i:s.000")."Z";
                $query->greaterThan('createdAt', $createdStr);
            }
            $messages = $query->find();
            $ret = [];
            $rtmsg = [];
            foreach ($messages as $msg)
            {
                $relation = $msg->getRelation('asset');
                $assets = $relation->getQuery()->find();
                $asts = array();
                foreach($assets as $asset)
                {
                    $asts[] = [
                        'name' => (!empty($asset->get('file'))) ? $asset->get('file')->getName() : '',
                        'url' => (!empty($asset->get('file'))) ? $asset->get('file')->getUrl() : '',
                        'youtube' => (!empty($asset->get('youtube'))) ? $asset->get('youtube') : ''
                    ];
                }
                $rtmsg[] = [
                    'user' => [
                        'Id' => $msg->get('user')->getObjectId(),
                        'name' => $msg->get('user')->get('name'),
                        'image' => (!empty($msg->get('user')->get('image'))) ? $msg->get('user')->get('image')->getUrl() : ''
                    ],
                    'Id' => $msg->getObjectId(),
                    'message' => $msg->get('message'),
                    'createdAt' => $msg->getCreatedAt()->setTimezone(new \DateTimeZone('America/Los_Angeles'))->format('D M d, h:i:s a'),
                    'timestamp' => $msg->getCreatedAt()->getTimestamp(),
                    'assets' => $asts
                ];
            }
            $ret['status'] = 'success';
            $ret['data'] = $rtmsg;
            return response()->json($ret);

        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            $ret = [
                'status' => 'fail',
                'error' => $ex->getMessage()
                ];
            return response()->json($ret);
        }
    }
}