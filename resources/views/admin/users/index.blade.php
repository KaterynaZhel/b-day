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
            <h3 class="card-title">Таблиця менеджерів компаній</h3>
        </div>
        <div class="card-body">
            <div id="users_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="users" class="table table-bordered table-striped dataTable dtr-inline"
                            aria-describedby="users_info">
                            <thead>
                                <tr class="">
                                    <th class="sorting sorting_asc text-center" tabindex="0" aria-controls="users"
                                        rowspan="1" colspan="1" aria-sort="ascending">id менеджера
                                    </th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="users" rowspan="1"
                                        colspan="1">Прізвище та ім'я менеджера
                                    </th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="users" rowspan="1"
                                        colspan="1">Назва компанії
                                    </th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="users" rowspan="1"
                                        colspan="1">Посилання на сайт компанії
                                    </th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="users" rowspan="1"
                                        colspan="1">Дата реєстрації на сайті
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="users" rowspan="1" colspan="1">
                                        Інструменти
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="odd">
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $user->id }}</td>
                                        <td>{{ $user->lastname }}&nbsp{{ $user->name }}</td>
                                        <td>{{ $user->company->name ?? 'Не визначено' }}</td>
                                        <td>{{ $user->company->site ?? 'Не визначено' }}</td>
                                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td class="project-actions d-flex justify-content-center">
                                            <a class="btn btn-info btn-sm" style="width:33px; height:30px; margin:4px 4px;"
                                                href="{{ route('admin.users.edit', $user->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form method="post" action="{{ route('admin.users.destroy', $user->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn destroy-btn btn-danger btn-sm"
                                                    style="width:33px; height:30px; margin:4px 4px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center" rowspan="1" colspan="1">id менеджера</th>
                                    <th class="text-center" rowspan="1" colspan="1">Прізвище та ім'я менеджера</th>
                                    <th class="text-center" rowspan="1" colspan="1">Назва компанії</th>
                                    <th class="text-center" rowspan="1" colspan="1">Посилання на сайт компанії</th>
                                    <th class="text-center" rowspan="1" colspan="1">Дата реєстрації на сайті</th>
                                    <th class="text-center" rowspan="1" colspan="1">Інструменти</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
