@extends('master')

@section('header')
<a href="/add" class="button normal" id="create-button">Create</a>
<input type="text" name="q" class="medium-input" placeholder="Start typing to search" />
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
<div class="container floating-box-95 no-top-pad">
    <table cellspacing="0" cellpadding="0">
        <thead>
            <td>Workorder</td>
            <td>Customer</td>
            <td>Store</td>
            <td>Status</td>
            <td>Last Update</td>
            <td class="col-10"></td>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
            <tr>
                <td>{{ $job->workorder }}</td>
                <td>{{ $job->customer }}</td>
                <td>{{ \App\Store::getName($job->store_id) }}</td>
                <td><span class="status" style="background: {{ \App\Job::getStatusColor($job->status_id) }}; border: {{ \App\Job::getStatusColor($job->status_id) }} solid 1px;">
                    <a href="javascript:changeJobStatus('{{ $job->id }}');">{{ \App\Job::getStatusName($job->status_id) }}</a>
                </span></td>
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
</div>
@stop
