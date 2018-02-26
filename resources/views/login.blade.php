<!-- extending layouts/default -->
@extends('layouts.default')

@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <form method="GET" action="/login">
            <button class="button-primary">Login with Google</button>
        </form>  
    </div>
</div>
@stop