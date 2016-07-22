@extends('master')

@section('header')
<h4 class="title">Create a new job</h4>
@stop

@section('content')
<div class="container floating-box-95 no-top-pad">
    <form action="/add" method="post">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <p>
        <label>Workorder</label>
        <input class="medium-input" type="text" name="workorder" placeholder="1234" />
    </p>
    <p>
        <label>Customer</label>
        <input class="medium-input" type="text" name="customer" placeholder="Sir John Herrignton" />
    </p>
    <p>
        <label>Phone #</label>
        <input class="medium-input" type="text" name="phone" placeholder="(757) 555-0123" />
    </p>
    <p>
        <label>Status</label>
        <select class="medium-input" name="status">
            <option>In Progress</option>
            <option>Parts Ordered</option>
            <option>Waiting on Callback</option>
            <option>Waiting on Pickup</option>
        </select>
    </p>
    <p>
        <label>Store</label>
        <select class="medium-input" name="store">
            <option>Store #001</option>
            <option>Store #002</option>
            <option>Store #003</option>
        </select>
    </p>
    <p>
        <label>Device</label>
        <input class="medium-input" type="text" name="device" placeholder="ABCDEF0123456789" />
    </p>
    <p>
        <label>Password</label>
        <input class="medium-input" type="text" name="password" placeholder="Password123" />
    </p>
    <p>
        <label>Comes with</label>
        <input type="checkbox" name="power_adapter" /> Power adapter
        <input type="checkbox" name="carrying_case" /> Carrying case
    </p>
    <p>
        <label>Notes</label>
        <textarea class="large-input" name="notes"></textarea>
    </p>
    <p class="buttons-wide">
        <input class="button normal" type="submit" name="submit" value="Save" />
        <input class="button" type="submit" name="cancel" value="Cancel" />
    </p>
    </form>
</div>
@stop
