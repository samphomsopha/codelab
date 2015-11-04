<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;

class HomeController extends SiteController {

    public function showIndex(Request $request) {

        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        return view('welcome', $renderData);
    }

    public function showHome(Request $request) {
        $current_user = ParseUser::getCurrentUser();
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        return view('home', $renderData);
    }
}