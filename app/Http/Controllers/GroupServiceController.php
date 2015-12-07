<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseClient;
use Parse\ParseFile;
use Parse\ParseObject;
use Symfony\Component\Yaml\Exception\ParseException;

class GroupServiceController extends Controller {

    public function eventsByWeek(Request $request, $week) {
        $current_user = ParseUser::getCurrentUser();

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
                $tm = strtotime($week);
                $dt->setTimestamp($tm);
                $dtend = clone($dt);
                $dtend->add(new \DateInterval('P7D'));
                $query->greaterThanOrEqualTo('date', $dt);
                $query->lessThanOrEqualTo('date', $dtend);

                $query->addAscending('date');
                $events = $query->find();

                foreach($events as $event)
                {
                    $temp[$event->get('date')->format('Y-m-d')][] = [
                        'group' => ['objectId' => $group->getObjectId(), 'name' => $group->get('name')],
                        'event'=> ['objectId' => $event->getObjectId(),
                            'createdAt' => $event->getCreatedAt()->format('Y-m-d H:i:s'),
                            'name' => $event->get('name'),
                            'date' => $event->get('date')->format('Y-m-d H:i:s'),
                            'inviteCode' => $event->get('inviteCode'),
                            'invites' => $event->get('invites')]];

                }
            }

            $ret = [
                'status' => "success",
                'data' => [
                    'events' => $temp
                ]
            ];

            return response()->json($ret);

        } catch (ParseException $ex) {
            $ret = [
                'status' => 'fail',
                'error' => $ex->getMessage()
            ];
            return response()->json($ret);
        }
    }

    public function eventsByDay(Request $request, $day) {
        $current_user = ParseUser::getCurrentUser();

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
                        'group' => ['objectId' => $group->getObjectId(), 'name' => $group->get('name')],
                        'event'=> ['objectId' => $event->getObjectId(),
                        'createdAt' => $event->getCreatedAt()->format('Y-m-d H:i:s'),
                        'name' => $event->get('name'),
                        'date' => $event->get('date')->format('Y-m-d H:i:s'),
                        'inviteCode' => $event->get('inviteCode'),
                        'invites' => $event->get('invites')]];

                }
            }
            $ret = [
                'status' => "success",
                'data' => [
                    'events' => $temp
                ]
            ];

            return response()->json($ret);

        } catch (ParseException $ex) {
            $ret = [
                'status' => 'fail',
                'error' => $ex->getMessage()
            ];
            return response()->json($ret);
        }
    }

    public function Events(Request $request) {
        $current_user = ParseUser::getCurrentUser();

        try {

            $query = ParseUser::query();
            $current_user = $query->get($current_user->getObjectId());

            $query = new ParseQuery("Groups");
            //$query->equalTo('user', $current_user);
            $query->equalTo('members', $current_user);
            $groups = $query->find();
            $dGroups = array();
            foreach($groups as $group)
            {
                $temp = array();
                $relation = $group->getRelation("events");
                $query = $relation->getQuery();
                $query->addAscending('date');
                $events = $query->find();
                foreach($events as $event)
                {
                    $temp = ['objectId' => $event->getObjectId(),
                        'createdAt' => $event->getCreatedAt()->format('Y-m-d H:i:s'),
                        'name' => $event->get('name'),
                        'date' => $event->get('date')->format('Y-m-d H:i:s'),
                        'inviteCode' => $event->get('inviteCode'),
                        'invites' => $event->get('invites')];

                    $dGroups[$event->get('date')->format('Y-m-d')][] = $temp;
                    $dtemp = [
                        'name' => $event->get('name'),
                        'id' => $event->getObjectId(),
                    ];
                    $ddEvents[$event->get('date')->format('Y-m-d')]['dayEvents'][] = $dtemp;
                    $ddEvents[$event->get('date')->format('Y-m-d')]['number'] = !empty($ddEvents[$event->get('date')->format('Y-m-d')]['number']) ? $ddEvents[$event->get('date')->format('Y-m-d')]['number'] + 1 : 1;
                    $ddEvents[$event->get('date')->format('Y-m-d')]['badgeClass'] = "badge-warning";
                    $ddEvents[$event->get('date')->format('Y-m-d')]['url'] = route('calendarDayView', ['day' => $event->get('date')->format('Y-m-d')]);
                }
            }
            ksort($dGroups);
            $ret = [
                'status' => "success",
                'data' => [
                    'events' => $dGroups,
                    'dsEvents' => $ddEvents
                ]
            ];

            return response()->json($ret);

        } catch (ParseException $ex) {
            $ret = [
                'status' => 'fail',
                'error' => $ex->getMessage()
            ];
            return response()->json($ret);
        }

    }
}