@extends('layouts.admin')

@section('content')
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
            </div>
        @endif
        <div class="card-header">
            <h3 class="card-title">Таблиця іменинників</h3>
        </div>
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <a class="btn btn-primary btn-sm float-right" href="{{ route('admin.celebrants.create') }}"
                            align="right">
                            Додати іменинника
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <form action="{{ route('admin.celebrants.index') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control float-right mb-3" name="search">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" class="form-control mb-3" value="Пошук">
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" aria-sort="ascending">id</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1">Фото
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1">
                                        Прізвище
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1">Ім'я
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1">
                                        По-батькові</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" style="width: 100px;">
                                        Дата
                                        народження</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1">Посада
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1">
                                        Інструменти</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($celebrants as $celebrant)
                                    <tr class="odd">
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $celebrant->id }}</td>
                                        <td><img src="{{ $celebrant->photo }}" style="height:30px;" alt=""></td>
                                        <td>{{ $celebrant->lastname }}</td>
                                        <td>{{ $celebrant->firstname }}</td>
                                        <td>{{ $celebrant->middlename }}</td>
                                        <td>{{ $celebrant->birthday }}</td>
                                        <td>{{ $celebrant->position }}</td>
                                        <td class="project-actions d-flex justify-content-center">
                                            <a class="btn btn-primary btn-sm"
                                                style="width:33px; height:30px; margin:4px 4px;"
                                                href="{{ route('admin.celebrants.show', $celebrant->id) }}">
                                                <i class="fas fa-eye">
                                                </i>
                                            </a>
                                            <a class="btn btn-info btn-sm" style="width:33px; height:30px; margin:4px 4px;"
                                                href="{{ route('admin.celebrants.edit', $celebrant->id) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            <form method="post"
                                                action="{{ route('admin.celebrants.destroy', $celebrant->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn destroy-btn btn-danger btn-sm"
                                                    style="width:33px; height:30px; margin:4px 4px;"><i
                                                        class="fas fa-trash">
                                                    </i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">id</th>
                                    <th rowspan="1" colspan="1">Фото</th>
                                    <th rowspan="1" colspan="1">Прізвище</th>
                                    <th rowspan="1" colspan="1">Ім'я</th>
                                    <th rowspan="1" colspan="1">По-батькові</th>
                                    <th rowspan="1" colspan="1">Дата народження</th>
                                    <th rowspan="1" colspan="1">Роль</th>
                                    <th rowspan="1" colspan="1">Інструменти</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        {{ $celebrants->withQueryString()->links('admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
