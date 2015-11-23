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
            $last_message = $messages[count($messages)-1];

            $renderData = $this->getRenderData($request);
            $renderData['user'] = $current_user;
            $renderData['chatObj'] = $chatObj;
            $renderData['messages'] = $messages;
            $renderData['navTitle'] = $chatObj->get('name');
            $renderData['user'] = $current_user;
            $renderData['lastMsgId'] = $messages[count($messages)-1]->getObjectId();
            $renderData['last_timer'] = $last_message->getCreatedAt()->getTimestamp();
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

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Script('//www.parsecdn.com/js/parse-1.6.7.min.js'));
        Html\Assets::addLink(Html\Link::Script('/vendor/dropzone/dropzone.js'));
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