@extends('layouts.admin')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Створення іменинника</h3>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @include('admin.celebrants.celebrant_form')
</div>
@endsection