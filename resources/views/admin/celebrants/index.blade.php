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
            <div id="celebrants_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <a class="btn btn-primary btn-sm float-right" href="{{ route('admin.celebrants.create') }}"
                            align="right">
                            Додати іменинника
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="celebrants" class="table table-bordered table-hover dataTable dtr-inline"
                            aria-describedby="celebrants_info">
                            <thead>
                                <tr>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1">id</th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1">Фото
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1">
                                        Прізвище
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1">Ім'я
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1">
                                        По-батькові</th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1" style="width: 100px;">
                                        Дата
                                        народження</th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1">
                                        Компанія</th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1">Роль
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
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
                                        <td>{{ $celebrant->company->name ?? 'Не визначено' }}</td>
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
                                    <th rowspan="1" colspan="1">Компанія</th>
                                    <th rowspan="1" colspan="1">Роль</th>
                                    <th rowspan="1" colspan="1">Інструменти</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
