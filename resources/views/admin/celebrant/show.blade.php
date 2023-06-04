@extends('layouts.admin')

@section('content')

<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            @if(!$celebrant->photo)
            <img class="profile-user-img img-fluid img-circle" src="{{asset('adminlte/dist/img/avatar.png')}}"
                alt="User profile picture">
            @else
            <img class="profile-user-img img-fluid img-circle" src="{{asset(Storage::url($celebrant->photo))}}"
                alt="User profile picture">
            @endif
        </div>
        <h3 class="profile-username text-center">{{$celebrant->lastname}} {{$celebrant->firstname}}
            {{$celebrant->middlename}}
        </h3>

        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Дата народження</b> <a class="float-right">{{$celebrant->birthday}}</a>
            </li>
            <li class="list-group-item">
                <b>Роль</b> <a class="float-right">{{$celebrant->position}}</a>
            </li>

        </ul>
    </div>

</div>
@endsection