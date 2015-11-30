<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseRelation;

class EventController extends SiteController {

    public function newCalendarEvent($day, Request $request) {
        $current_user = ParseUser::getCurrentUser();

        try {
            $query = ParseUser::query();
            $current_user = $query->get($current_user->getObjectId());

            $query = new ParseQuery("Groups");
            $query->equalTo('user', $current_user);
            $groups = $query->find();

        } catch (ParseException $ex) {
            echo $ex->getMessage();die();
        }

        $dt = new \DateTime('now');
        //$dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        $tm = strtotime($day);
        $dt->setTimestamp($tm);

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/newgroup.js')));
        Html\Assets::addLink(Html\Link::Script('/scripts/newCalendarEvent.js'));

        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        $renderData['navTitle'] = 'New Event';
        $renderData['groups'] = $groups;
        $renderData['day'] = $dt->format('m/d/Y');
        $renderData['st'] = $dt->format('Y-m-d');
        return view('newCalendarEvent', $renderData);
    }

    public function deleteEvent($id, Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }
        $query = new ParseQuery("Events");
        $query->includeKey('user');
        try {
            $event = $query->get($id);
            $owner = $event->get('user');
            if ($current_user->getObjectId() != $owner->getObjectId())
            {
                throwException(401, "Sorry you don't have access to delete this event.");
            }
            else
            {
                $event->destroy();
                return redirect('/groups');
            }

        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            echo $ex->getMessage();
        }
    }

    public function newEvent($gid, Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }
        Html\Assets::addLink(Html\Link::Css('/vendor/pickadate.js-3.5.6/lib/themes/default.css'));
        Html\Assets::addLink(Html\Link::Css('/vendor/pickadate.js-3.5.6/lib/themes/default.date.css'));
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Script('/vendor/pickadate.js-3.5.6/lib/picker.js'));
        Html\Assets::addLink(Html\Link::Script('/vendor/pickadate.js-3.5.6/lib/picker.date.js'));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/newevent.js')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));

        $st = $request->input("st");
        $query = new ParseQuery("Groups");
        try {
            $group = $query->get($gid);

            //--save start
            if ($request->getMethod() == "POST")
            {
                $eventName = $request->input('name');
                $eventDate = $request->input('eventDate');
                $invites = $request->input('invites');

                $id = $request->input('id');
                if (!empty($id)) {
                    $qry = new ParseQuery('Events');
                    $eventObj = $qry->get($id);
                } else {
                    $eventObj = new ParseObject('Events');
                }
                $eventObj->set('name', $eventName);
                if (!empty($eventDate))
                {
                    $eventDate = new \DateTime($eventDate);
                    $eventObj->set('date', $eventDate);
                }
                if (empty($eventObj->get('inviteCode'))) {
                    $eventObj->set('inviteCode', $this->generate_random_letters(6));
                }
                if (empty($invites)) {
                    $invites = [];
                }
                $eventObj->setArray('invites', $invites);
                $eventObj->set('user', $current_user);
                $eventObj->set('group', $group);
                try {
                    $eventObj->save();
                    $relation = $eventObj->getRelation('members');
                    $relation->add($current_user);
                    $eventObj->save();
                    $grelation = $group->getRelation('events');
                    $grelation->add($eventObj);
                    $group->save();
                    //-- create chat room --//
                    $chatObj = new ParseObject('ChatRoom');
                    $chatObj->set('name', $eventObj->get('name'));
                    $chatObj->set('event', $eventObj);
                    $chatObj->save();
                    $relation = $chatObj->getRelation('members');
                    $relation->add($current_user);
                    $chatObj->save();
                    $eventObj->set('chatRoom', $chatObj);
                    $eventObj->save();
                    return redirect('/groups');
                }
                catch (ParseException $ex) {
                    // Execute any logic that should take place if the save fails.
                    // error is a ParseException object with an error code and message.
                    echo 'Failed to create new object, with error message: ' . $ex->getMessage();
                }
            }

            //--save end
            $renderData = $this->getRenderData($request);
            $renderData['user'] = $current_user;
            $renderData['navTitle'] = $group->get('name');
            $renderData['st'] = !empty($st) ? $st : '';
            return view('newevent', $renderData);

        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            echo $ex->getMessage();
        }

    }

    public function editEvent($eventId, Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }

        Html\Assets::addLink(Html\Link::Css('/vendor/pickadate.js-3.5.6/lib/themes/default.css'));
        Html\Assets::addLink(Html\Link::Css('/vendor/pickadate.js-3.5.6/lib/themes/default.date.css'));
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Script('/vendor/pickadate.js-3.5.6/lib/picker.js'));
        Html\Assets::addLink(Html\Link::Script('/vendor/pickadate.js-3.5.6/lib/picker.date.js'));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/newevent.js')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));

        $query = new ParseQuery("Events");
        $query->includeKey('group');
        try {
            $eventObj = $query->get($eventId);
            $renderData = $this->getRenderData($request);
            $renderData['user'] = $current_user;
            $renderData['navTitle'] = $eventObj->get('name');
            $renderData['navBack'] = route('home');
            $renderData['event'] = $eventObj;
            $renderData['group'] = $eventObj->get('group');
            return view('editevent', $renderData);
        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            echo $ex->getMessage();
        }
    }

    public function joinEvent(Request $request) {
        $current_user = ParseUser::getCurrentUser();

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);

        if ($request->method() == "POST" || $request->session()->get('lastAction') == 'joinevent')
        {
            if (!empty($current_user))
            {
                $code = $request->input('eventCode') ? : $request->session()->get('joinevent:inviteCode');
                $query = new ParseQuery("Events");
                try {
                    $query->equalTo('inviteCode', $code);
                    $query->includeKey('chatRoom');
                    $eventObj = $query->find();
                    if (count($eventObj) > 0)
                    {
                        $eventObj = $eventObj[0];
                        $relation = $eventObj->getRelation('members');
                        $relation->add($current_user);
                        $eventObj->save();
                        //add member to chatroom
                        $chatObj = $eventObj->get('chatRoom');
                        $relation = $chatObj->getRelation('members');
                        $relation->add($current_user);
                        $chatObj->save();
                        //clear last action
                        $request->session()->set('lastAction', '');
                        //redirect to chatroom
                        return redirect()->route('chat', ['roomId' => $chatObj->getObjectId()]);
                }
                    else
                    {
                        $renderData['errorMsg'] = "Sorry invite code '{$code}' is not valid.'";
                    }
                } catch (ParseException $ex) {
                    // The object was not retrieved successfully.
                    // error is a ParseException with an error code and message.
                    echo $ex->getMessage();
                }
            }
            else
            {
                $request->session()->set('lastAction', 'joinevent');
                $request->session()->set('joinevent:inviteCode', $request->input('inviteCode'));
                return redirect()->route('register');
            }
        }

        $renderData['navTitle'] = "Join Event";
        return view('joinevent', $renderData);
    }

    function generate_random_letters($length) {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }
}