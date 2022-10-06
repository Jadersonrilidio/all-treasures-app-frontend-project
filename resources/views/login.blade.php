@extends('layouts.app')

@section('content')

    <login-component
        form-action="{{ route('login.login') }}"
        csrf_token="{{ @csrf_token() }}">
    </login-component>

@endsection
