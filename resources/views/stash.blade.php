@extends('layouts.app')

@section('content')

    <stash-component username="{{ $name }}" userid={{ $id }}></stash-component>

@endsection
