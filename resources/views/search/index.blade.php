<div class="container floating-box-95 no-top-pad">

    @if(count($jobs) == 0)
    <h3 class="search-result-title">No results returned</h3>
    <a class="search-result-title" href="{{ url('/') }}">View open jobs</a>
    @else
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
            <tr>
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
                    <a href="{{ url('/delete/' . $job->id) }}" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    <a href="{{ url('/close/' . $job->id) }}" title="Close"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                </span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
<script type="text/javascript">
setActivePage('#jobs');
</script>
