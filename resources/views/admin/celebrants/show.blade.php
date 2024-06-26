@extends('layouts.admin')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="{{ $celebrant->photo }}" alt="User profile picture">
        </div>
        <h3 class="profile-username text-center">{{ $celebrant->lastname }} {{ $celebrant->firstname }}
            {{ $celebrant->middlename }}
        </h3>

        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Дата народження</b> <a class="float-right">{{$celebrant->birthday}}</a>
            </li>
            <li class="list-group-item">
                <b>Компанія</b> <a class="float-right">{{$celebrant->company->name ?? 'Не визначено'}}</a>
            </li>
            <li class="list-group-item">
                <b>E-mail</b> <a class="float-right">{{$celebrant->email}}</a>
            </li>
            <li class="list-group-item">
                <b>Роль</b> <a class="float-right">{{$celebrant->position}}</a>
            </li>

            <li class="list-group-item">
                <b>Інтереси</b>
                <ul class="float-right">
                    @foreach($celebrant->hobbies as $key => $hobby)
                    <li style="display: inline;">
                        {{$hobby->name ?? ''}}{{ $key < count($celebrant->hobbies) - 1 ? ', ' : '' }}&nbsp;
                    </li>
                    @endforeach
                </ul>
            </li>

        </ul>
        <div class="row mb-3">
            <div class="col-sm-12">
                <a class="btn btn-primary btn-sm float-right"
                    href="{{ route('admin.celebrants.greetingsCompany.create', $celebrant->id) }}">
                    Залишити привітання
                </a>
            </div>
        </div>

        @include('includes.admin.showGreetingsCompany')

    </div>
    @endsection