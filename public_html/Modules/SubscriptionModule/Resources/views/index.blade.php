@extends('subscriptionmodule::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('subscriptionmodule.name') !!}
    </p>
@endsection
