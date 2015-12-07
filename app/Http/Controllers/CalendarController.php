<?php

namespace App\Http\Controllers;
//use Mail;
use App\Library\Mail;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseQuery;

class CalendarController extends SiteController {

    public function showWeekView(Request $request, $date = null) {
        $current_user = ParseUser::getCurrentUser();
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Css(elixir('css/calendar.css')));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/calendarDay.js')));

        $dt = new \DateTime('now');
        if ($date)
        {
            $tm = strtotime($date);
            $dt->setTimestamp($tm);
        }
        else
        {
            $dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        }

        if ($dt->format('D') !== 'Sun')
        {
            switch($dt->format('D')) {
                case 'Sat':
                    $dt->sub(new \DateInterval('P6D'));
                    break;
                case 'Fri':
                    $dt->sub(new \DateInterval('P5D'));
                    break;
                case 'Thu':
                    $dt->sub(new \DateInterval('P4D'));
                    break;
                case 'Wed':
                    $dt->sub(new \DateInterval('P3D'));
                    break;
                case 'Tue':
                    $dt->sub(new \DateInterval('P2D'));
                    break;
                case 'Mon':
                    $dt->sub(new \DateInterval('P1D'));
                    break;
            }
        }

        $tmdt = clone($dt);
        $prevWeek = new \DateTime($dt->format('Y-m-d'));
        $nextWeek = new \DateTime($dt->format('Y-m-d'));
        $prevWeek->sub(new \DateInterval('P7D'));
        $nextWeek->add(new \DateInterval('P7D'));

        $week['dis'][] = $tmdt->format('d D');
        $week['dt'][] = $tmdt->format('Y-m-d');
        for ($i = 0; $i < 6; $i++)
        {
            $tmdt->add(new \DateInterval('P1D'));
            $week['dis'][] = $tmdt->format('d D');
            $week['dt'][] = $tmdt->format('Y-m-d');
        }

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

                $query->greaterThanOrEqualTo('date', $dt);
                $query->lessThanOrEqualTo('date', $nextWeek);

                $query->addAscending('date');
                $events = $query->find();

                foreach($events as $event)
                {
                    $temp[$event->get('date')->format('Y-m-d')][] = [
                        'group' => $group,
                        'event'=> $event];

                }
            }

        } catch (\Exception $e) {
            return print $e->getMessage();
        }

        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        $renderData['dt'] = $dt;
        $renderData['week'] = $week;
        $renderData['prevWeek'] = $prevWeek;
        $renderData['nextWeek'] = $nextWeek;
        $renderData['events'] = $temp;
        return view('calendarWeek', $renderData);
    }

    public function showDayView(Request $request, $day = null) {
        $current_user = ParseUser::getCurrentUser();
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Css(elixir('css/calendar.css')));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/calendarDay.js')));

        $dt = new \DateTime('now');
        //$dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        if ($day)
        {
            $tm = strtotime($day);
            $dt->setTimestamp($tm);
        }
        else
        {
            $dt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        }

        $prevDt = new \DateTime($dt->format('Y-m-d'));
        $nextDt = new \DateTime($dt->format('Y-m-d'));
        $prevDt->sub(new \DateInterval('P1D'));
        $nextDt->add(new \DateInterval('P1D'));

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

                /*$dt = new \DateTime('now');
                $tm = strtotime($day);
                $dt->setTimestamp($tm);*/

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
        $renderData['prevDt'] = $prevDt;
        $renderData['nextDt'] = $nextDt;
        $renderData['events'] = $temp;
        return view('calendarDay', $renderData);
    }

    public function showCalendar(Request $request, $date = null) {
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
}