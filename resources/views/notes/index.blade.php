@extends('master')

@section('header')
<a href="{{ url('add') }}" class="button normal" id="create-button">Create</a>
<input type="text" name="q" class="medium-input" placeholder="Start typing to search" />
<span class="right semi-bold">
    <label>Filter Jobs</label>
    <select id="job_filter" name="job_filter">
        <option value='0'>All</option>
        @foreach(\App\Status::all() as $status)
            <option value="{{ $status->id }}">{{ $status->name }}</option>
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
            <td>Created</td>
            <td>Last Update</td>
            <td>Time Open</td>
            <td class="col-10"></td>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
            <tr rel="{{ $job->id }}" class="job-item">
                <td>{{ $job->workorder }}</td>
				@if(\App\Job::customerHasAddNotes($job->customer))
					<td>{{ $job->customer }} <a href="{{ url('/customer/' . str_replace(' ', '_', $job->customer)) }}">Past Jobs</a></td>
				@else
					<td>{{ $job->customer }}</td>
				@endif
                <td><span class="status" style="background: {{ \App\Job::getStatusColor($job->status_id) }};">
                    <a href="javascript:changeJobStatus('{{ $job->id }}');">{{ \App\Job::getStatusName($job->status_id) }}</a>
                </span></td>
                <td>{{ $job->created_at }}</td>
                <td>{{ $job->updated_at }}</td>
                <!--<td>Unspecified time</td>-->
                <td>{{ \App\Job::getTimeOpen($job->id) }}
                <td><span class="rounded-button">
                    <a href="javascript:showPassword('{{ $job->password }}');" title="Show Password"><i class="fa fa-key" aria-hidden="true"></i></a>
                    <a href="{{ url('/edit/' . $job->id) }}" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <!--<a href="{{ url('/delete/' . $job->id) }}" title="Delete" rel="{{ $job->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>-->
                    <a href="#" title="Delete" rel="{{ $job->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    <a href="#" title="Close" rel="{{ $job->id }}"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
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
<script type="text/javascript">
setActivePage('#jobs');
</script>
@stop
