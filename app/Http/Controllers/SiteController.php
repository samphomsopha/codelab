<?php

namespace App\Http\Controllers;

use App\Library\Html;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseClient;

class SiteController extends Controller {

    public function __construct(Request $request)
    {
        session_start();
        ParseClient::initialize( config('parse.app_id'), config('parse.api_key'), config('parse.master_key'));
        //add default css and site js
        Html\Assets::addLink(Html\Link::Css('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600italic,600,700'));
        Html\Assets::addLink(Html\Link::Css('/vendor/bootstrap/3.3.5/css/bootstrap.min.css'));
        Html\Assets::addLink(Html\Link::Css('/vendor/responsive-calendar/0.9/css/responsive-calendar.css'));
        Html\Assets::addLink(Html\Link::Css('/vendor/font-awesome/4.4.0/css/font-awesome.min.css'));
        Html\Assets::addLink(Html\Link::Script('/vendor/jquery/1.11.1/jquery.min.js'));
        Html\Assets::addLink(Html\Link::Script('/vendor/bootstrap/3.3.5/js/bootstrap.min.js'));
        Html\Assets::addLink(Html\Link::Script('/vendor/responsive-calendar/0.9/js/responsive-calendar.min.js'));
    }

    public function getRenderData(Request $request)
    {
        $renderData = array(
            'assetstop' => Html\Assets::renderLinks("top"),
            'assets' => Html\Assets::renderLinks(),
            'metadata' => Html\Assets::renderMetaData(),
            'showComments' => false,
            'pageUrl' => $request->url()
        );
        return $renderData;
    }
}