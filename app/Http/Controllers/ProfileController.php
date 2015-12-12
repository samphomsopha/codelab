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

class ProfileController extends SiteController
{

    public function showIndex(Request $request)
    {
        $current_user = ParseUser::getCurrentUser();
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        return view('profile', $renderData);
    }

    public function showEdit(Request $request)
    {
        $current_user = ParseUser::getCurrentUser();
        Html\Assets::addLink(Html\Link::Css('/vendor/dropzone/dropzone.css'));
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addLink(Html\Link::Script('//www.parsecdn.com/js/parse-1.6.7.min.js'));
        Html\Assets::addLink(Html\Link::Script('/vendor/dropzone/dropzone.js'));
        Html\Assets::addLink(Html\Link::Script(elixir('scripts/profileUploader.js')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $renderData['user'] = $current_user;
        return view('editprofile', $renderData);
    }

    public function save(Request $request)
    {
        $current_user = ParseUser::getCurrentUser();
        $name = $request->input('name');
        $assetId = $request->input('assetId');
        $current_user->set('name', $name);
        try
        {
            if (!empty($assetId))
            {
                $query = new ParseQuery("Assets");
                $asset = $query->get($assetId);
                if (!empty($asset))
                {
                    $current_user->set('image', $asset->get('file'));
                }
            }
            $current_user->save();
        }
        catch(\Exception $ex)
        {
            echo 'Failed to create new object, with error message: ' . $ex->getMessage();
        }

        return redirect()->route('profile');
    }
}