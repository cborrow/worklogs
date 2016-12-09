@extends('master')

@section('header')
<h4 class="title">Editing job {{ $job->workorder }}</h4>
@stop

@section('content')
<div class="container floating-box-95 no-top-pad">
    @if(count($errors))
        <ul>
        @foreach($errors->all() as $error)
            <li class="error">{{ $error }}</li>
        @endforeach
        </ul>
    @endif
    <form action="{{ url('/edit/' . $job->id) }}" method="post">
    {{ csrf_field() }}
    <p>
        <label>Workorder</label>
        <input class="medium-input" type="text" name="workorder" value="{{ $job->workorder }}" required />
    </p>
    <p>
        <label>Customer</label>
        <input class="medium-input" type="text" name="customer" value="{{ $job->customer }}" required />
    </p>
    <p>
        <label>Phone #</label>
        <input class="medium-input" type="text" name="phone" value="{{ $job->phone }}" />
    </p>
    <p>
        <label>Status</label>
        <select class="medium-input" name="status">
            @foreach(\App\Status::all() as $status)
            @if($job->status_id == $status->id)
                <option value="{{ $status->id }}" selected="selected">{{ $status->name }}</option>
            @else
                <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endif
            @endforeach
        </select>
    </p>
    <!--<p>
        <label>Store</label>
        <select class="medium-input" name="store">
            <option>Store #001</option>
            <option>Store #002</option>
            <option>Store #003</option>
        </select>
    </p>-->
    <p>
        <label>Device</label>
        <input class="medium-input" type="text" name="device" value="{{ $job->device }}" />
    </p>
    <p>
        <label>Password</label>
        <input class="medium-input" type="text" name="password" value="{{ $job->password }}" />
    </p>
    <p>
        <label>Comes with</label>
        @if($job->has_power_adapter == true)
            <input type="checkbox" name="power_adapter" checked /> Power adapter
        @else
            <input type="checkbox" name="power_adapter" /> Power adapter
        @endif

        @if($job->has_carrying_case == true)
            <input type="checkbox" name="carrying_case" checked/> Carrying case
        @else
            <input type="checkbox" name="carrying_case"/> Carrying case
        @endif
    </p>
    <p>
        <label>Notes</label>
        <textarea class="large-input" name="notes" required>{{ $job->notes }}</textarea>
    </p>
    <p class="buttons-wide">
        <input class="button normal" type="submit" name="submit" value="Save" />
        <input class="button" type="submit" name="cancel" value="Cancel" />
    </p>
    </form>
</div>
<script type="text/javascript">
setActivePage('#jobs');
</script>
@stop
