<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphObject;
use Parse\ParseUser;
use Parse\ParseSession;

class LoginController extends SiteController {

    public function showLogin(Request $request) {
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $redirect_url = $request->getSchemeAndHttpHost().'/fblogin';
        $permissions = ['email'];
        $fb = new Facebook(['app_id' => config('facebook.app_id'), 'app_secret' => config('facebook.app_secret'), 'default_graph_version' => 'v2.2']);
        $helper = $fb->getRedirectLoginHelper();
        $renderData['fb_login_url'] = $helper->getLoginUrl($redirect_url, $permissions);
        return view('login', $renderData);
    }

    public function showRegister(Request $request) {
        Html\Assets::addLink(Html\Link::Css(elixir('css/default.css')));
        Html\Assets::addMetaTag(Html\Meta::Tag('description', ''));
        $renderData = $this->getRenderData($request);
        $redirect_url = $request->getSchemeAndHttpHost().'/fblogin';
        $permissions = ['email'];
        $fb = new Facebook(['app_id' => config('facebook.app_id'), 'app_secret' => config('facebook.app_secret'), 'default_graph_version' => 'v2.2']);
        $helper = $fb->getRedirectLoginHelper();
        $renderData['fb_login_url'] = $helper->getLoginUrl($redirect_url, $permissions);
        return view('register', $renderData);
    }

    public function processRegister(Request $request) {
        $user = new ParseUser();
        $user->set("username", $request->input('email'));
        $user->set("password", $request->input('password'));
        $user->set("email", $request->input('email'));
        $user->set("realEmail", $request->input('email'));
        $user->set("name", $request->input('name'));

        try {
            $user->signUp();
            return $this->determineRoute($request);
        } catch (ParseException $ex) {
            // Show the error message somewhere and let the user try again.
            echo "Error: " . $ex->getCode() . " " . $ex->getMessage();
        }
    }

    public function processLogin(Request $request) {
        try {
            $user = ParseUser::logIn($request->input('username'), $request->input('password'));
            // Do stuff after successful login.
            return $this->determineRoute($request);
        } catch (ParseException $error) {
            // The login failed. Check error to see why.
            echo $error->getMessage();
            die();
        }
    }

    public function processLogout(Request $request) {
        ParseUser::logOut();
        return redirect('/');
    }

    public function processFBLogin(Request $request) {
        $fb = new Facebook(['app_id' => config('facebook.app_id'), 'app_secret' => config('facebook.app_secret'), 'default_graph_version' => 'v2.2']);
        $redirect_url = $request->getSchemeAndHttpHost().'/fblogin';
        $code = $request->input('code');
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
            if (!$accessToken->isLongLived())
            {
                $oAuth2Client = $fb->getOAuth2Client();
                // Exchanges a short-lived access token for a long-lived one
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            }
            $fb->setDefaultAccessToken($accessToken);
            $response = $fb->get('/me?fields=id,name,email');
            $plainOldArray = $response->getDecodedBody();
            //if user exist sign them in otherwise sign them up
            $query = ParseUser::query();
            $query->equalTo("username", 'FB:'.$plainOldArray['id']);
            $results = $query->find();
            if (count($results) === 1) {
                $user = ParseUser::logIn('FB:'.$plainOldArray['id'], config('facebook.upwd'));
                $user->set('social', "facebook:" . $accessToken);
                return $this->determineRoute($request);
            } else {
                $user = new ParseUser();
                $user->set("username", 'FB:'.$plainOldArray['id']);
                $user->set("password", config('facebook.upwd'));
                $user->set("email", "FB_".$plainOldArray['email']);
                $user->set("name", $plainOldArray['name']);
                $user->set("realEmail", $plainOldArray['email']);
                $user->set("social", "facebook:" . $accessToken);
                try {
                    $user->signUp();
                    return $this->determineRoute($request);
                } catch (ParseException $ex) {
                    var_dump("Save Error");
                    // Show the error message somewhere and let the user try again.
                    echo "Error: " . $ex->getCode() . " " . $ex->getMessage();
                    var_dump($plainOldArray['email']);
                    var_dump($accessToken);
                    die();
                }
            }
        } catch(FacebookRequestException $ex) {
            // When Facebook returns an error
            echo "Error: " . $ex->getCode() . " " . $ex->getMessage();
            die();
        } catch(\Exception $ex) {
            // When validation fails or other local issues
            //var_dump($plainOldArray['email']);
            //var_dump($accessToken);
            echo "Error: " . $ex->getCode() . " " . $ex->getMessage();
            die();
        }
        if (!empty($accessToken)) {
            // Logged in.
            //$access_token = $helper->getAccessToken();
           echo "LOGGED IN";
            die();
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

    private function determineRoute(Request $request) {
        $last_action = $request->session()->get('lastAction');
        switch($last_action) {
            case "newgroup":
                return redirect()->route('processGroup');
                break;
            default:
                return redirect()->route('home');
        }
    }
}