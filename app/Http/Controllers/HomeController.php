<?php

namespace App\Http\Controllers;
//use Mail;
use App\Library\Mail;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;

class HomeController extends SiteController {

    public function showIndex(Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!empty($current_user))
        {
            return redirect('/calendar');
        }
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
        $query = ParseUser::query();
        $current_user = $query->get($current_user->getObjectId());

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

    public function showDayView($day, Request $request) {
        $current_user = ParseUser::getCurrentUser();
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Css(elixir('css/calendar.css')));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/calendarDay.js')));

        $tm = strtotime($day);
        $dt = new \DateTime('now');
        //$dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        $dt->setTimestamp($tm);

        try {
            $query = ParseUser::query();
            $current_user = $query->get($current_user->getObjectId());

            $query = new ParseQuery("Groups");
            //$query->equalTo('user', $current_user);
            $query->equalTo('members', $current_user);
            $groups = $query->find();
            $dGroups = array();
            $ddEvents = array();
            $temp = array();
            foreach($groups as $group)
            {
                $relation = $group->getRelation("events");
                $query = $relation->getQuery();

                $dt = new \DateTime('now');
                //$dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
                $tm = strtotime($day);
                $dt->setTimestamp($tm);

                $query->equalTo('date', $dt);
                //$query->addAscending('date');
                $events = $query->find();
                foreach($events as $event)
                {
                    $temp[] = [
                        'group' => $group,
                        'event'=> $event];
                }
            }

        } catch (ParseException $ex) {
            echo $ex->getMessage();die();
        }

        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        $renderData['day'] = $day;
        $renderData['dt'] = $dt;
        $renderData['events'] = $temp;
        return view('calendarDay', $renderData);
    }

    public function showCalendar(Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }
        $dt = new \DateTime('now');
        //$dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        $st = $request->input('st');
        if (!empty($st)) {
            $tm = strtotime($st);
            $dt->setTimestamp($tm);
        }


        $query = ParseUser::query();
        $current_user = $query->get($current_user->getObjectId());

        Html\Assets::addLink(Html\Link::Css('/vendor/responsive-calendar/0.9/css/responsive-calendar.css'));
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Script('/vendor/responsive-calendar/0.9/js/responsive-calendar.min.js'));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/calendar.js')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        $renderData['showdate'] = $dt;
        $renderData['activeBarTab'] = "calendar";
        return view('calendar', $renderData);
    }

    public function showNotifications(Request $request) {
        $current_user = ParseUser::getCurrentUser();
        $query = new ParseQuery("Notifications");
        $query->equalTo("for", $current_user);
        $query->equalTo("read", false);

        $query->includeKey('by');
        $query->includeKey('message');
        $query->addDescending('createdAt');
        try
        {
            $notifications = $query->find();

            Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
            $renderData = $this->getRenderData($request);
            $notes = array();
            foreach ($notifications as $notify)
            {
                if (!empty($notify->get('message')))
                {
                    $byimage = $notify->get('by')->get('image');
                    $chatroom = $notify->get('message')->get('chatRoom');
                    $relation = $notify->get('message')->getRelation('asset');
                    $assets = $relation->getQuery()->find();
                    if (empty($chatroom))
                    {
                        continue;
                    }
                    $chatroom->fetch();
                    $notes[] = [
                        'notification' => $notify,
                        'byimage' => $byimage,
                        'chatRoom' => $chatroom,
                        'assets' => $assets
                    ];
                }
                $notify->set("read", true);
                $notify->save();
            }
            $renderData['user'] = $current_user;
            $renderData['notifications'] = $notes;
            return view('notification', $renderData);
        } catch (\Exception $ex)
        {
            echo $ex->getMessage();die();
        }
    }

    public function emailTest(Request $request)
    {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }

        $sendM = new Mail\Send();
        $rt = $sendM->sendInviteEmail(array('samphomsopha@gmail.com'), $current_user, 'sciiex');
        var_dump($rt);
        echo "Done";
    }
}