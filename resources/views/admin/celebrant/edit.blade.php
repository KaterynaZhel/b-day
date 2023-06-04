@extends('layouts.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Редагування іменинника</h3>
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

        <form action="{{ route('admin.celebrant.update', $celebrant->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" value="{{ $celebrant->photo }}" class="custom-file-input" name="photo"
                                id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lastname">Прізвище</label>
                    <input class="form-control" value="{{ $celebrant->lastname }}" id="lastname" name="lastname"
                        placeholder="Прізвище">
                </div>

                <div class="form-group">
                    <label for="firstname">Ім'я</label>
                    <input class="form-control" value="{{ $celebrant->firstname }}" id="firstname" name="firstname"
                        placeholder="Ім'я">
                </div>

                <div class="form-group">
                    <label for="middlename">По-батькові</label>
                    <input class="form-control" value="{{ $celebrant->middlename }}" id="middlename" name="middlename"
                        placeholder="По-батькові">
                </div>

                <div class="form-group">
                    <label>Дата народження</label>
                    <div class="input-group date" id="birthday" data-target-input="nearest">
                        <input type="text" value="{{ $celebrant->birthday }}" name="birthday"
                            class="form-control datetimepicker-input" data-target="#birthday">
                        <div class="input-group-append" data-target="#birthday" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="position">Посада</label>
                    <input class="form-control" value="{{ $celebrant->position }}" id="position" name="position"
                        placeholder="Посада">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Редагувати</button>
                </div>
        </form>
    </div>
@endsection
