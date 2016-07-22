@extends('master')

@section('header')
<h4 class="title">A quick overview of jobs</h4>
@stop

@section('content')
<div class="floating-box-25">
    <ul>
        <h4>Open jobs by store</h4>
        @foreach($stores as $store)
        <li class="pad-10">{{ $store->name }} <span class="text-right large-numbers">{{ $store->getOpenJobCount() }}</span></li>
        @endforeach
    </ul>
</div>
<div class="floating-box-25">
    <ul>
        <h4>Recently updated jobs</h4>
        @foreach(\App\Job::recentlyUpdated(5) as $job)
        <li class="pad-10"><a href="/edit/{{ $job->id }}">{{ $job->customer }}</a> <span class="text-right">{{ date("j M, Y h:i A", $job->update_at) }}</span></li>
        @endforeach
    </ul>
</div>
@stop
