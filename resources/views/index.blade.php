@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="navbar" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">ZohoCRM Test API</span>
            <div><router-link to="/accounts" class="btn btn-outline-primary">Accounts</router-link></div>
            <div><router-link to="/deals" class="btn btn-outline-primary">Deals</router-link></div>
        </div>
    </nav>
</div>
    {{-- <div><router-link to="/accounts">Accounts</router-link></div>
    <div><router-link to="/deals">Deals</router-link></div> --}}
<app-component></app-component>
@endsection
