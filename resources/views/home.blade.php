@extends('layouts.app')

@section('content')

    <home-component username="{{ $name }}" userid={{ $id }}></home-component>

@endsection
