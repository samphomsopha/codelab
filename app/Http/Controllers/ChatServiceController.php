<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseClient;

class ChatServiceController extends Controller {
    private function init() {
        session_start();
        ParseClient::initialize( config('parse.app_id'), config('parse.api_key'), config('parse.master_key'));
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