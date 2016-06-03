@extends('master')

@section('header')
<a href="/add" class="button normal">Create</a>
<span class="right semi-bold">
    <label>Filter Jobs</lable>
    <select name="job_filter">
        <option>All</option>
        <option>Closed</option>
        <option>In Progress</option>
        <option>Parts on order</option>
        <option>Waiting on callback</option>
        <option>Waiting on pickup</option>
    </select>
</span>
@stop

@section('content')
<table cellspacing="0" cellpadding="0">
    <thead>
        <td class="col-10">Workorder</td>
        <td class="col-20">Customer</td>
        <td class="col-25">Status</td>
        <td class="col-25">Last Update</td>
        <td class="col-15"></td>
    </thead>
    <tbody>
        @foreach ($jobs as $job)
        <tr>
            <td>{{ $job->workorder }}</td>
            <td>{{ $job->customer }}</td>
            <td><span class="status {{ \App\Job::getStatusClass($job->status_id) }}"><a href="javascript:changeJobStatus('{{ $job->id }}');">{{ \App\Job::getStatusName($job->status_id) }}</a></span></td>
            <td>{{ $job->updated_at }}</td>
            <td><span class="rounded-button">
                <a href="javascript:showPassword('{{ $job->password }}');" title="Show Password"><i class="fa fa-key" aria-hidden="true"></i></a>
                <a href="#" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <a href="#" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                <a href="#" title="Close"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
            </span></td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
