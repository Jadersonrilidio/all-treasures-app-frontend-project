@extends('layouts.app')

@section('content')

    <register-component
        route-login="{{ route('login.login') }}"
        csrf_token="{{ @csrf_token() }}"
    >
    </register-component>
    
@endsection
