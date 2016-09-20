@extends('master')

@section('header')
<a href="/add" class="button normal" id="create-button">Create</a>
<input type="text" name="q" class="medium-input" placeholder="Start typing to search" />
<span class="right semi-bold">
    <label>Filter Jobs</lable>
    <select id="job_filter" name="job_filter">
        <option value="0">All</option>
        @foreach(\App\Status::all() as $s)
            @if($s->name == $status->name)
                <option selected="selected" value="{{ $s->id }}">{{ $s->name }}</option>
            @else
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endif
        @endforeach
    </select>
</span>
@stop

@section('content')
<div class="container floating-box-95 no-top-pad">
    <table cellspacing="0" cellpadding="0">
        <thead>
            <td>Workorder</td>
            <td>Customer</td>
            <td>Status</td>
            <td>Last Update</td>
            <td>Time Open</td>
            <td class="col-10"></td>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
            <tr rel="{{ $job->id }}">
                <td>{{ $job->workorder }}</td>
                <td>{{ $job->customer }}</td>
                <td><span class="status" style="background: {{ \App\Job::getStatusColor($job->status_id) }}; border: {{ \App\Job::getStatusColor($job->status_id) }} solid 1px;">
                    <a href="javascript:changeJobStatus('{{ $job->id }}');">{{ \App\Job::getStatusName($job->status_id) }}</a>
                </span></td>
                <td>{{ $job->updated_at }}</td>
                <td>{{ \App\Job::getTimeOpen($job->id) }}
                    <td><span class="rounded-button">
                        <a href="javascript:showPassword('{{ $job->password }}');" title="Show Password"><i class="fa fa-key" aria-hidden="true"></i></a>
                        <a href="{{ url('/edit/' . $job->id) }}" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <!--<a href="{{ url('/delete/' . $job->id) }}" title="Delete" rel="{{ $job->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>-->
                        <a href="#" title="Delete" rel="{{ $job->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        @if($job->status_id > 1)
                        <a href="{{ url('/close/' . $job->id) }}" title="Close" rel="{{ $job->id }}"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                        @endif
                    </span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pagination">
    @if($page == 0)
        <p>Page 1 of 1</p>
    @else
        <p>
            @if($page > 1)
                <a href="{{ url('/jobs/page/' . ($page - 1)) }}">&lt; Prev</a>
            @endif
            Page {{ $page }} of {{ $totalPages }}
            @if($page < $totalPages)
                <a href="{{ url('/jobs/page/' . ($page + 1)) }}">Next &gt;</a>
            @endif
        </p>
    @endif
</div>
@stop
