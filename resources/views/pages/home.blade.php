@extends('layouts.app', ["currentPageKey" => \App\Objects\Enums\PageKeys::HOME])

@section('meta_description')
    Set Channel for Streamlabs assignment
@endsection

@section('title')
    Set Channel
@endsection

@section('top_navigation')
    @include('components.navigation.logged_in_user_navigation')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="input-group">
                <input
                        type="text"
                        class="form-control channel-name"
                        title="Enter Channel Name"
                        placeholder="Please enter a channel name"
                        data-load-channels-url="{{ route("getChannelsTable") }}"
                >
            </div>
        </div>
    </div>
    <br>
    <div class="channels-table-div">
        @include('pages.partials.channel_listing')
    </div>
@endsection
