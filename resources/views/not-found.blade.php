@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Page Not Found') }}</div>

                <div class="card-body">

                    @guest
                        <ul class="">
                            <li class="">
                                <a clas="" href="{{ route('welcome') }}">Home</a>
                            </li>
                            <li class="">
                                <a clas="" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="">
                                <a clas="" href="{{route('welcome')}}/register">Register</a>
                            </li>
                        </ul>
                    @endguest

                    @auth
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    @endauth

                </div>
            </div>
        </div>
    </div>
</div>
@endsection