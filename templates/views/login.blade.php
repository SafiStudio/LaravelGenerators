@extends('layouts.login')
@section('content')
    <form method="POST" action="{{ action('Admin\AuthController@postLogin') }}">
        {!! csrf_field() !!}
        <div class="form">
            <div class="form-line login-line">
                <i class="fa fa-user"></i>
                <input class="form-line-text" type="email" id="email" name="email" value="{{ old('email') }}" />
            </div>
            <div class="form-line login-line">
                <i class="fa fa-key"></i>
                <input class="form-line-text" type="password" id="password" name="password" />
            </div>
            <div class="form-line">
                <button type="submit" class="form-line-button standard">
                    <i class="icon fa fa-sign-in"></i>
                    Zaloguj się
                </button>
            </div>
        </div>
    </form>
    <script>
        $(window).load(function(){
            $('.card').addClass('loaded');
            $('form').submit(function(){
                $('.card').removeClass('loaded');
            });
        });
    </script>
@endsection