<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;

class HomeController extends SiteController {

    public function showIndex(Request $request) {

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        return view('welcome', $renderData);
    }

    public function showHome(Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));

        $query = new ParseQuery("ChatRoom");
        $query->equalTo('members', $current_user);
        try {
            $chatRooms = $query->find();
            $query = new ParseQuery("Messages");
            $query->containedIn("chatRoom", $chatRooms);
            $query->descending('createdAt');
            $query->includeKey('chatRoom');
            $query->includeKey('user');
            $query->limit(20);
            $messages = $query->find();

            $data = [];
            foreach($messages as $message)
            {
                $chatRoom = $message->get('chatRoom');
                $event = $chatRoom->get('event');
                $evQuery = new ParseQuery('Events');
                $evQuery->includeKey('group');
                $event = $evQuery->get($event->getObjectId());
                $group = $event->get('group');
                $relation = $message->getRelation("asset");
                $aqry = $relation->getQuery();
                $assets = $aqry->find();
                $temp = [
                    'group' => $group,
                    'event' => $event,
                    'chatRoom' => $chatRoom,
                    'message' => ['msg' => $message, 'assets' => $assets],
                    'user' => $message->get('user'),
                ];
                $data[] = $temp;
            }
        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            echo $ex->getMessage();
        }

        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        $renderData['activeBarTab'] = "dashboard";
        $renderData['data'] = $data;
        return view('home', $renderData);
    }

    public function showCalendar(Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/calendar.js')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        $renderData['activeBarTab'] = "calendar";
        return view('calendar', $renderData);
    }
}