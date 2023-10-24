@extends('layouts.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Редагування привітання від Компанії</h3>
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

        <form
            action="{{ route('admin.celebrants.greetingsCompany.update', [$greetingsCompany->celebrant_id, $greetingsCompany->id]) }}"
            method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="message_company">Привітання</label>
                    <textarea class="form-control" id="message_company" name="message_company" rows="3" placeholder="Привітання...">{{ $greetingsCompany->message_company }}</textarea>
                </div>

                <div class="form-group">
                    <label for="name_company">Назва Компанії</label>
                    <input class="form-control" id="name_company" name="name_company"
                        value="{{ $greetingsCompany->name_company }}" placeholder="Назва Компанії">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Зберегти</button>
                </div>
        </form>
    </div>
@endsection
