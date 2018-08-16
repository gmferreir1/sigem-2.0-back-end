@extends('register::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('register.name') !!}
    </p>
@stop
