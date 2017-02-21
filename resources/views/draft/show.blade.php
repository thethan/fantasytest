@extends('layouts.bulma')

@section('content')
    <div class="container">
        <input id="league_id" style="display: none" value="{{ $leaue_id }}">
        <div id="app">
            <room></room>
        </div>
    </div>
@endsection