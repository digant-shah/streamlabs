<?php

function getTwitchClientID() {
    return config("services.twitch.client_id");
}

function getTwitchAPIURL() {
    return config("services.twitch.api_url");
}

function isAppDebuggable() {
    return config('app.debug');
}

function getOAuthToken() {
    return request()->session()->get(\App\Objects\Enums\SessionKeys::USER_INFO)->oauthToken;
}

function getDisplayName() {
    return request()->session()->get(\App\Objects\Enums\SessionKeys::USER_INFO)->displayName;
}

function getTwitchAuthAPIURL() {
    return config('services.twitch.auth_api_url');
}

function getTwitchClientSecret() {
    return config('services.twitch.client_secret');
}

function getTwitchHubLeaseSeconds() {
    return config('services.twitch.hub_lease_seconds');
}

function getKeyForSigningWebhookMessage() {
    return hash_hmac("sha256", "twitch_key", getTwitchClientSecret());
}