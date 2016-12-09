@extends('master')

@section('header')
<h4 class="title">Viewing jobs for {{ $customer }}</h4>
@stop

@section('content')
<div class="container floating-box-95 no-top-pad">
    <table cellspacing="0" cellpadding="0">
        <thead>
            <td>Workorder</td>
            <td>Status</td>
            <td>Notes</td>
            <td>Last Update</td>
            <td>Time Open</td>
            <td class="col-10"></td>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
            <tr rel="{{ $job->id }}" class="job-item">
                <td>{{ $job->workorder }}</td>
                <td><span class="status" style="background: {{ \App\Job::getStatusColor($job->status_id) }}; border: {{ \App\Job::getStatusColor($job->status_id) }} solid 1px;">
                    <a href="javascript:changeJobStatus('{{ $job->id }}');">{{ \App\Job::getStatusName($job->status_id) }}</a>
                </span></td>
				<td>{{ substr($job->notes, 0, 50) }}
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
<script type="text/javascript">
setActivePage('#jobs');
</script>
@stop
