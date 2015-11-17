<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseObject;
use Parse\ParseQuery;

class GroupController extends SiteController {

    public function newGroup(Request $request) {

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/newgroup.js')));
        $renderData = $this->getRenderData($request);
        return view('newgroup', $renderData);
    }

    public function processGroup(Request $request) {

        //if logged process otherwise go to login form
        $current_user = ParseUser::getCurrentUser();

        if (!empty($current_user)) {
            //process form
            $lastAction = $request->session()->get('lastAction');
            $groupName = $request->input('groupname') ? : $request->session()->get('newgroup:groupName');
            $invites = $request->input('invites') ? : $request->session()->get('newgroup:invites');

            $groupObj = new ParseObject('Groups');
            $groupObj->set('name', $groupName);
            $groupObj->set('user', $current_user);
            if (empty($invites)) {
                $invites = [];
            }
            $groupObj->setArray('invites', $invites);
            $groupObj->set('inviteCode', $this->generate_random_letters(6));
            try {
                $groupObj->save();
                $relation = $groupObj->getRelation('members');
                $relation->add($current_user);
                $groupObj->save();
                return redirect()->route('editgroup', ['id' => $groupObj->getObjectId()]);
            }
            catch (ParseException $ex) {
                // Execute any logic that should take place if the save fails.
                // error is a ParseException object with an error code and message.
                echo 'Failed to create new object, with error message: ' . $ex->getMessage();
            }
        } else {
            //save form show login
            $request->session()->set('lastAction', 'newgroup');
            $request->session()->set('newgroup:groupName', $request->input('groupname'));
            $request->session()->set('newgroup:invites', $request->input('invites'));
            return redirect()->route('register');
        }
    }

    public function joinGroup(Request $request) {

        $current_user = ParseUser::getCurrentUser();

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);

        if ($request->method() == "POST" || $request->session()->get('lastAction') == 'joingroup')
        {
            if (!empty($current_user))
            {
                $code = $request->input('inviteCode') ? : $request->session()->get('joingroup:inviteCode');
                $query = new ParseQuery("Groups");
                try {
                    $query->equalTo('inviteCode', $code);
                    $groupObj = $query->find();
                    if (count($groupObj) > 0)
                    {
                        $groupObj = $groupObj[0];
                        $relation = $groupObj->getRelation('members');
                        $relation->add($current_user);
                        $groupObj->save();

                        //add member to chatroom
                        $relation = $groupObj->getRelation("events");
                        $query = $relation->getQuery();
                        $events = $query->find();
                        foreach($events as $eventObj)
                        {
                            $chatObj = $eventObj->get('chatRoom');
                            $relation = $chatObj->getRelation('members');
                            $relation->add($current_user);
                            $chatObj->save();
                        }
                        //clear last action
                        $request->session()->set('lastAction', '');
                        //redirect to chatroom
                        return redirect()->route('groupView', ['id' => $groupObj->getObjectId()]);
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
                $request->session()->set('lastAction', 'joingroup');
                $request->session()->set('joingroup:inviteCode', $request->input('inviteCode'));
                return redirect()->route('register');
            }
        }

        $renderData['navTitle'] = 'Join Group';
        return view('joingroup', $renderData);
    }

    public function showGroup(Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        return view('group', $renderData);
    }

    public function showGroups(Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }
        $query = new ParseQuery("Groups");
        $query->equalTo('user', $current_user);
        $groups = $query->find();
        $dGroups = array();
        foreach($groups as $group)
        {
            $temp = array();
            $temp['group'] = $group;
            $temp['events'] = array();
            $relation = $group->getRelation("events");
            $query = $relation->getQuery();
            $events = $query->find();
            foreach($events as $event)
            {
                $temp['events'][] = $event;
            }

            $dGroups[$group->getObjectId()] = $temp;
        }

        //find events that this user maybe a member of
        /*$query = new ParseQuery("Events");
        $query ->equalTo('members', $current_user);
        $query->includeKey('group');
        $events = $query->find();

        foreach($events as $event)
        {
            // if user owns this group, don't add
            $tgroup = $event->get('group');
            if ($tgroup->get('user') != $current_user) {
                $temp = array_get($dGroups, $tgroup->getObjectId());
                if (empty($temp)) {
                    $temp['group'] = $tgroup;
                    $temp['events'] = array();
                }
                $temp['events'][] = $event;

                $dGroups[$tgroup->getObjectId()] = $temp;
            }
        }*/

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        $renderData['activeBarTab'] = "groups";
        $renderData['dGroups'] = $dGroups;

        return view('groups', $renderData);
    }

    public function showGroupView($groupid, Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $query = new ParseQuery("Groups");
        try {
            $group = $query->get($groupid);
            // get events
            $relation = $group->getRelation("events");
            $query = $relation->getQuery();
            $events = $query->find();

            $renderData = $this->getRenderData($request);
            $renderData['user'] = $current_user;
            $renderData['group'] = $group;
            $renderData['events'] = $events;
            $renderData['navTitle'] = $group->get('name');
            return view('groupview', $renderData);

        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            echo $ex->getMessage();
        }
    }

    public function editGroup($groupid, Request $request) {
        $current_user = ParseUser::getCurrentUser();
        if (!$current_user)
        {
            return redirect()->route('login');
        }
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $query = new ParseQuery("Groups");
        try {
            $group = $query->get($groupid);
            // The object was retrieved successfully.
            $renderData = $this->getRenderData($request);
            $renderData['user'] = $current_user;
            $renderData['group'] = $group;
            return view('editgroup', $renderData);

        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            echo $ex->getMessage();
        }

    }

    function generate_random_letters($length) {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }
}