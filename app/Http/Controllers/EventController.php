<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;

class EventController extends SiteController {

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

        $query = new ParseQuery("Groups");
        try {
            $group = $query->get($gid);

            //--save start
            if ($request->getMethod() == "POST")
            {
                $eventName = $request->input('name');
                $eventDate = $request->input('eventDate');
                $invites = $request->input('invites') ? : $request->session()->get('newgroup:invites');

                //$time = $eventDate;
                //$eventDate = date('m-d-Y', $time);
                $eventDate = new \DateTime();
                $eventObj = new ParseObject('Events');
                $eventObj->set('name', $eventName);
                $eventObj->set('date', $eventDate);
                $eventObj->set('inviteCode', $this->generate_random_letters(6));

                if (empty($invites)) {
                    $invites = [];
                }
                $eventObj->setArray('invites', $invites);

                try {
                    $eventObj->save();
                    $grelation = $group->getRelation('events');
                    $grelation->add($eventObj);
                    $group->save();
                    return redirect()->route('editEvent', ['id' => $eventObj->getObjectId()]);
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
        try {
            $eventObj = $query->get($eventId);
            $renderData = $this->getRenderData($request);
            $renderData['user'] = $current_user;
            $renderData['navTitle'] = $eventObj->get('name');
            $renderData['navBack'] = route('home');
            $renderData['event'] = $eventObj;
            return view('editevent', $renderData);
        } catch (ParseException $ex) {
            // The object was not retrieved successfully.
            // error is a ParseException with an error code and message.
            echo $ex->getMessage();
        }
    }

    public function joinEvent(Request $request) {
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
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