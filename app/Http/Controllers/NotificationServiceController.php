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

class NotificationServiceController extends Controller {

    public function alerts($cc = null) {
        $current_user = ParseUser::getCurrentUser();

        $query = new ParseQuery("Notifications");
        $query->equalTo("for", $current_user);
        $query->equalTo("read", false);

        $query->includeKey('by');
        $query->includeKey('message');
        try {
            $notifications = $query->find();
            $notes = array();
            foreach ($notifications as $notify)
            {
                if (!empty($notify->get('message')))
                {
                    if ($notify->get('message')->get('chatRoom')->getObjectId() == $cc)
                    {
                        $notify->set("read", true);
                        $notify->save();
                        continue;
                    }

                    $notes[] = [
                        'id' => $notify->getObjectId(),
                        'for' => $notify->get('for')->getObjectId(),
                        'from' => ['id' => $notify->get('by')->getObjectId(), 'name' => $notify->get('by')->get('name')],
                        'message' => $notify->get('message')->get('message')
                    ];
                }
            }
            $ret = [
                'status' => "success",
                'data' => [
                    'notifications' => $notes
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