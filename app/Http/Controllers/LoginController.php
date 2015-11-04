<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSession;
use Facebook\GraphObject;

class LoginController extends SiteController {

    public function showLogin(Request $request) {
        FacebookSession::setDefaultApplication(config('facebook.app_id'), config('facebook.app_secret'));
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $redirect_url = $request->getSchemeAndHttpHost().'/fblogin';
        $permissions = ['email'];
        $helper = new FacebookRedirectLoginHelper($redirect_url, $permissions);
        $renderData['fb_login_url'] = $helper->getLoginUrl();
        return view('login', $renderData);
    }

    public function showRegister(Request $request) {
        FacebookSession::setDefaultApplication(config('facebook.app_id'), config('facebook.app_secret'));
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $redirect_url = $request->getSchemeAndHttpHost().'/fblogin';
        $permissions = ['email'];
        $helper = new FacebookRedirectLoginHelper($redirect_url, $permissions);
        $renderData['fb_login_url'] = $helper->getLoginUrl();
        return view('register', $renderData);
    }

    public function processFBLogin(Request $request) {
        FacebookSession::setDefaultApplication(config('facebook.app_id'), config('facebook.app_secret'));
        $redirect_url = $request->getSchemeAndHttpHost().'/fblogin';
        $code = $request->input('code');
        $helper = new FacebookRedirectLoginHelper($redirect_url);

        try {
            $session = $helper->getSessionFromRedirect();
            $accessToken = $session->getAccessToken();
        } catch(FacebookRequestException $ex) {
            // When Facebook returns an error
        } catch(\Exception $ex) {
            // When validation fails or other local issues
        }
        if (!empty($accessToken)) {
            // Logged in.
            //$access_token = $helper->getAccessToken();
           echo "LOGGED IN";
        } else {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
                exit();
            } else {
                return redirect()->route('login');
            }
        }
    }
}