<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Objects\Enums\SessionKeys;
use Socialite;

class LoginController extends Controller
{
    /**
     * Show the view to login via Twitch to User
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginView() {
        return view('auth.login');
    }

    public function twitchAuthRedirect() {
        return Socialite::with('twitch')
                        ->setScopes(
                            [
                                'user_read',
                                'channel_subscriptions',
                                'user_subscriptions',
                                'user:read:email',
                                'bits:read'
                            ]
                        )
                        ->redirect();
    }

    public function twitchAuthCallback() {
        $oauthResponse = Socialite::with('twitch')->user();

        $user = $oauthResponse->user;

        request()->session()->put(
            SessionKeys::USER_INFO,
            (object)[
                'id' => $user["id"],
                'loginName' => $user["login"],
                'displayName' => $user["display_name"],
                'type' => $user["type"],
                'broadCasterType' => $user["broadcaster_type"],
                'description' => $user["description"],
                'profileImageURL' => $user["profile_image_url"],
                'offlineImageURL' => $user["offline_image_url"],
                'viewCount' => $user["view_count"],
                'email' => isset($user["email"]) ? $user["email"] : "",
                'oauthToken' => $oauthResponse->token
            ]
        );

        return redirect(route('showHomePage'));
    }

    /**
     * Logout user
     */
    public function logout() {
        request()->session()->remove(SessionKeys::USER_INFO);
        return redirect(route('showLoginView'));
    }
}
