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
use Symfony\Component\Yaml\Exception\ParseException;

class ChatServiceController extends Controller {
    private function init() {
        session_start();
        ParseClient::initialize( config('parse.app_id'), config('parse.api_key'), config('parse.master_key'));
    }

    public function newMessage(Request $request) {
        $this->init();
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            $ret = [
                'status' => 'fail',
                'error' => "login required"
            ];
            return json_encode($ret);
        }
        $message = $request->input("message");
        $chat_id = $request->input("chat_id");
        $assets = $request->input("assets");

        if (!empty($message)) {
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
                $messageObj->save();
                $ret = [
                    'status' => "success",
                    'data' => [
                        'object' => "messages",
                        'id' => $messageObj->getObjectId(),
                        'message' => $messageObj->get("message")
                    ]
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
    }

    public function upload(Request $request) {
        $this->init();
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            $ret = [
                'status' => 'fail',
                'error' => "login required"
            ];
            return json_encode($ret);
        }
        if ( isset( $_FILES['image'] ) ) {
            $chatRoomId = $request->input('chat_id');
            // save file to Parse
            try {
                $file = ParseFile::createFromData( file_get_contents( $_FILES['image']['tmp_name'] ), $_FILES['image']['name']  );
                $file->save();

                // save something to class TestObject
                $asset = new ParseObject( "Assets" );
                $asset->set( "foo", "bar" );
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

        } else {
            $ret = [
                'status' => 'fail',
                'error' => 'no file selected'
            ];
            return response(json_encode($ret))
                ->header('Content-Type', 'text/json');
        }
    }
    public function getMessages($chatRoomId, $lastMsgId = null, $lastTime = null, Request $request) {

        $this->init();
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            $ret = [
                'status' => 'fail',
                'error' => "login required"
            ];
            return json_encode($ret);
        }

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
                $rtmsg[] = [
                    'user' => [
                        'Id' => $msg->get('user')->getObjectId(),
                        'name' => $msg->get('user')->get('name')
                    ],
                    'Id' => $msg->getObjectId(),
                    'message' => $msg->get('message'),
                    'createdAt' => $msg->getCreatedAt()->setTimezone(new \DateTimeZone('America/Los_Angeles'))->format('D M d, h:i:s a'),
                    'timestamp' => $msg->getCreatedAt()->getTimestamp()
                ];
            }
            $ret['status'] = 'success';
            $ret['data'] = $rtmsg;
            return response(json_encode($ret))
                    ->header('Content-Type', 'text/json');

        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            $ret = [
                'status' => 'fail',
                'error' => $ex->getMessage()
                ];
            return response(json_encode($ret))
                ->header('Content-Type', 'text/json');
        }
    }
}