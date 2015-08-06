@extends('layouts.login')
@section('content')
<form method="POST" action="{{ action('Admin\AuthController@postLogin') }}">
    {!! csrf_field() !!}
    <div class="form">
        <div class="form-line">
            <input class="form-line-text" type="email" id="email" name="email" value="{{ old('email') }}" />
            <label class="form-line-label" for="email">Email</label>
        </div>
        <div class="form-line">
            <input class="form-line-text" type="password" id="password" name="password" />
            <label class="form-line-label" for="password">Hasło</label>
        </div>
        <div class="form-line">
            <button type="submit" class="form-line-button standard">
                <i class="icon fa fa-sign-in"></i>
                Zaloguj się
            </button>
        </div>
    </div>
</form>
@endsection