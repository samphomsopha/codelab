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

    public function getMessages($chatRoomId, $lastTime = null, Request $request) {
        $this->init();
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return "login required";
        }

        $query = new ParseQuery("ChatRoom");
        try {
            $chatObj = $query->get($chatRoomId);
            // get events
            $relation = $chatObj->getRelation("messages");
            $query = $relation->getQuery();
            $query->includeKey('user');
            $query->addAscending('createdAt');
            if ($lastTime > 0)
            {
                $dt = new \DateTime('now', new \DateTimeZone('America/Los_Angeles'));
                //$dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
                $dt->setTimestamp($lastTime);
                echo ($dt->format("Y-m-d H:m:s Z"));
                $query->greaterThan('createdAt', '2015-11-17T02:24:11.813Z');
            }
            $messages = $query->find();
            $ret = [];
            foreach ($messages as $msg)
            {
                echo $msg->getCreatedAt()->format("Y-m-d H:m:s Z");die();
                $ret[] = [
                    'user' => [
                        'name' => $msg->get('user')->get('name')
                    ],
                    'message' => $msg->get('message'),
                    'createdAt' => $msg->getCreatedAt()->setTimezone(new \DateTimeZone('America/Los_Angeles'))->format('D M d, h:i:s a')
                ];
            }
            return json_encode($ret);

        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            echo $ex->getMessage();
        }
    }
}