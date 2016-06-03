@extends('master')

@section('header')
<h4 class="title">Settings</h4>
@stop

@section('content')
@if(count($errors))
    <ul>
    @foreach($errors->all() as $error)
        <li class="error">{{ $error }}</li>
    @endforeach
    </ul>
@endif
<form action="/stores/store" method="post">
{{ csrf_field() }}
<p>
    <h4>Stores</h4>
    <ul class="list-small">
        @foreach($stores as $store)
            <li>{{ $store->name }} <a class="right" href="/stores/delete/{{ $store->id }}">Delete</a></li>
        @endforeach
    </ul>
</p>
<p>
    <input class="small-input" type="text" name="name" placeholder="Store Kwikimart" />
    <input class="button" type="submit" name="add-store" value="Add" />
</p>
</form>

<form action="/statuses/store" method="post">
{{ csrf_field() }}
<p>
    <h4>Statuses</h4>
    <ul class="list-small">
        @foreach($statuses as $status)
            <li>{{ $status->name }} <a class="right" href="/status/delete/{{ $status->id }}">Delete</a></li>
        @endforeach
    </ul>
</p>
<p>
    <input class="small-input" type="text" name="name" placeholder="My vaguley descriptive status" />
    <input class="button" type="submit" name="add-status" value="Add" />
</p>
</form>

@stop
