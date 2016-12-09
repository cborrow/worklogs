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
<!--<form action="/stores/store" method="post">
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
</form>-->

<!--<form action="/statuses/store" method="post">
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
</form>-->

<ul class="floating-box-25 alt-color-list">
    <h4 class="title-alt">Statuses</h4>
    <p class="alt-text">Double click a name or single click a color to change</p>
    @foreach($statuses as $status)
    <li><input type="color" class="color-block" value="{{ $status->color }}" style="background-color: {{ $status->color }};" rel="{{ $status->id }}" />
        <span class="status-name" rel="{{ $status->id }}">{{ $status->name }}</span>
        @if($status->id > 1)
        <span class="right"><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
        @endif
    </li>
    @endforeach
    <li class="non-colored-background">
        <input type="text" class="slim-textbox" name="status-name" placeholder="Type a new status name" />
        <input type="button" class="slim-button normal" id="add-status" name="save-status" value="Add" />
    </li>
</ul>

<script type="text/javascript" src="{{ asset('js/settings.js') }}"></script>
<script type="text/javascript">
setActivePage('#settings');
</script>
@stop
