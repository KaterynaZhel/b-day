@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Редагування компанії</h3>
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

        <form action="{{ route('admin.companies.update', $company->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="form-group">
                    <label for="name">Назва компанії</label>
                    <input class="form-control" value="{{ $company->name }}" id="name" name="name"
                        placeholder="Назва компанії">
                </div>

                <div class="form-group">
                    <label for="site">Сайт компанії</label>
                    <input class="form-control" value="{{ $company->site }}" id="site" name="site"
                        placeholder="Сайт компанії">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                </div>
        </form>
    </div>
@endsection
