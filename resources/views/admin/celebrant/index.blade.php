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
                <div>
                    <label>
                        Пошук:
                        <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example1">
                    </label>
                    <a class="btn btn-primary btn-sm float-right" href="{{ route('admin.celebrant.create') }}"
                        align="right">
                        Додати іменинника
                    </a>
                </div>
                <div class=" row">
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
                                        colspan="1">Дата
                                        народження</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1">Роль
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($celebrants as $celebrant)
                                    <tr class="odd">
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $celebrant->id }}</td>
                                        <td>
                                            @if (!$celebrant->photo)
                                                <img src="{{ asset('adminlte/dist/img/avatar.png') }}" style="height:30px;"
                                                    alt="">
                                            @else
                                                <img src="{{ asset(Storage::url($celebrant->photo)) }}" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $celebrant->lastname }}</td>
                                        <td>{{ $celebrant->firstname }}</td>
                                        <td>{{ $celebrant->middlename }}</td>
                                        <td>{{ $celebrant->birthday }}</td>
                                        <td>{{ $celebrant->position }}</td>
                                        <td class="project-actions text-right">
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('admin.celebrant.show', $celebrant->id) }}">
                                                <i class="fas fa-eye">
                                                </i>
                                            </a>
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('admin.celebrant.edit', $celebrant->id) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            <form method="post"
                                                action="{{ route('admin.celebrant.destroy', $celebrant->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"><i
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
                                    <th rowspan="1" colspan="1"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                            Показано від 1 до 20 із 57 записів</div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                            <ul class="pagination">
                                <li class="paginate_button page-item previous disabled" id="example1_previous"><a
                                        href="#" aria-controls="example1" data-dt-idx="0" tabindex="0"
                                        class="page-link">Попередній</a>
                                </li>
                                <li class="paginate_button page-item active"><a href="#" aria-controls="example1"
                                        data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                        data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                        data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                        data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                        data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                        data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
                                <li class="paginate_button page-item next" id="example1_next"><a href="#"
                                        aria-controls="example1" data-dt-idx="7" tabindex="0"
                                        class="page-link">Наступний</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- TODO: create pagination -->
        <!-- {{ $celebrants->links() }} -->
    @endsection
