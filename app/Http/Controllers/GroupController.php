<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseObject;

class GroupController extends SiteController {

    public function newGroup(Request $request) {

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        return view('newgroup', $renderData);
    }

    public function processGroup(Request $request) {
        $request->session()->set('lastAction', 'newgroup');
        if (!empty($request->input('groupname'))) {
            $request->session()->set('groupName', $request->input('groupname'));
        }
        
        //if logged process otherwise go to login form
        $current_user = ParseUser::getCurrentUser();

        if (!empty($current_user)) {
            //process form
            $lastAction = $request->session()->get('lastAction');
            $groupName = $request->session()->get('groupName');

            $groupObj = new ParseObject('Groups');
            $groupObj->set('name', $groupName);
            $groupObj->set('user', $current_user);
            try {
                $groupObj->save();
                return redirect()->route('home');
            }
            catch (ParseException $ex) {
                // Execute any logic that should take place if the save fails.
                // error is a ParseException object with an error code and message.
                echo 'Failed to create new object, with error message: ' . $ex->getMessage();
            }
        } else {
            //show login
            return redirect()->route('login');
        }
    }

    public function joinGroup(Request $request) {

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        return view('joingroup', $renderData);
    }
}