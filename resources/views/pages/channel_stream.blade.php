@extends('layouts.app', ["currentPageKey" => \App\Objects\Enums\PageKeys::CHANNEL_STREAM])

@section('meta_description')
    Channel Stream for Streamlabs assignment
@endsection

@section('meta_data')
    <meta name="channel_name" content="{{ $channelName }}">
    <meta name="channel_id" content="{{ $channelID }}">
@endsection

@section('title')
    Channel Stream
@endsection

@section('top_navigation')
    @include('components.navigation.logged_in_user_navigation')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10" id="twitch-embed"></div>
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-12">
                    <h4><b>Recent Events</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 recent-events">
                    @if(!$isSubscriptionSuccessful)
                        <span>
                            <p>Failed to subscribe to events</p>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection