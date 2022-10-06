@extends('layouts.app')

@section('content')

<div class="container">
    <div class="justify-content-center" style="text-align:center;padding-top:50px">

        <div style="color:gray; font-size:3.5em; font-family:arial; padding-top:120px">
            <p>Page Not Found</p>
            <p>404</p>
        </div>
    </div>

</div>

{{-- <div class="container">
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
                                <a clas="" href="{{ route('register') }}">Register</a>
                            </li>
                        </ul>
                    @endguest

                    @auth
                        <ul class="">
                            <li class="">
                                <a clas="" href="{{ route('home') }}">Home</a>
                            </li>
                        </ul>
                    @endauth

                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection