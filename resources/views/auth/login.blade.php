@extends('layouts.app')

@section('content')
<style>
html,body {
    background: rgb(85,76,232);
    background: linear-gradient(9deg, rgba(85,76,232,1) 0%, rgba(116,116,255,1) 35%, rgba(220,249,255,1) 100%);
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('auth.login_card')
        </div>
    </div>
</div>
@endsection
