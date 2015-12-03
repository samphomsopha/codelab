<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseSession;
use Parse\ParseUser;
use Parse\ParseQuery;

class ChatController extends SiteController {

    public function showChat($roomId, Request $request) {

        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/chat.js')));
        Html\Assets::addLink(Html\Link::Script('//www.parsecdn.com/js/parse-1.6.7.min.js'));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));

        $query = new ParseQuery("ChatRoom");
        try {
            $chatObj = $query->get($roomId);
            // get events
            $relation = $chatObj->getRelation("messages");
            $query = $relation->getQuery();
            $query->includeKey('user');
            $query->addAscending('createdAt');
            $messages = $query->find();

            $msArr = [];
            foreach($messages as $messageObj)
            {
                $relation = $messageObj->getRelation('asset');
                $qry = $relation->getQuery();
                $assets = $qry->find();
                $msArr[] = ['message' => $messageObj, 'assets' => $assets];
            }
            $renderData = $this->getRenderData($request);
            if (count($messages) > 0) {
                $last_message = $messages[count($messages)-1];
                $renderData['last_timer'] = $last_message->getCreatedAt()->getTimestamp();
                $renderData['lastMsgId'] = !empty($messages[count($messages)-1]->getObjectId()) ? $messages[count($messages)-1]->getObjectId() : 0;
            } else {
                $renderData['last_timer'] = 0;
                $renderData['lastMsgId'] = 0;
            }



            $renderData['user'] = $current_user;
            $renderData['chatObj'] = $chatObj;
            $renderData['messages'] = $msArr;
            $renderData['navTitle'] = $chatObj->get('name');
            $renderData['user'] = $current_user;

            $renderData['uId'] = $current_user->getObjectId();
            return view('chat', $renderData);

        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            echo $ex->getMessage();
        }
    }

    public function showUploader($roomId, Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }

        $message = $request->input('msg');
        Html\Assets::addLink(Html\Link::Css('/vendor/dropzone/dropzone.css'));
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Script('//www.parsecdn.com/js/parse-1.6.7.min.js'));
        Html\Assets::addLink(Html\Link::Script('/vendor/dropzone/dropzone.js'));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/chatUploader.js')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $query = new ParseQuery("ChatRoom");
        $chatObj = $query->get($roomId);
        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        $renderData['chatObj'] = $chatObj;
        $renderData['message'] = $message;
        return view('chatUploader', $renderData);
    }
}