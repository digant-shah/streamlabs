@extends('layouts.app')

@section('meta_description')
    Login to StreamLabs assignment
@endsection

@section('title')
    Login
@endsection

@section('content')
    <div class="login-box text-center">
        <div class="holder">
            <button class="button login-button button--twitch" onclick="window.location.replace('{{ route("twitchAuthRedirect") }}')" >
                <i></i>Sign-in with Twitch
            </button>
        </div>
    </div>
@endsection
