@extends('layouts.app')

@section('content')

    <topic-component username="{{ $name }}" userid={{ $id }}></topic-component>

@endsection
