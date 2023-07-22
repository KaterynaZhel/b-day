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
        <h3 class="card-title">Таблиця привітань від компаній</h3>
    </div>
    <div class="card-body">
        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                        aria-describedby="example1_info">
                        <thead>
                            <tr class="">
                                <th class="sorting sorting_asc text-center" tabindex="0" aria-controls="example1"
                                    rowspan="1" colspan="1" aria-sort="ascending">id іменинника</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1"
                                    colspan="1">
                                    Прізвище та ім'я іменинника</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1"
                                    colspan="1">Дата
                                    народження</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1"
                                    colspan="1">Назва
                                    компанії</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1"
                                    colspan="1">Дата
                                    публікації</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example1" rowspan="1"
                                    colspan="1">
                                    Профіль іменинника</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($greetingsCompany as $greeting)
                            <tr class="odd">
                                <td class="dtr-control sorting_1" tabindex="0">{{ $greeting->celebrant_id }}</td>
                                <td>{{ $greeting->celebrant->lastname }}&nbsp{{$greeting->celebrant->firstname }}</td>
                                <td>{{ $greeting->celebrant->birthday }}</td>
                                <td>{{ $greeting->name_company }}</td>
                                <td>{{ $greeting->publish_at }}</td>
                                <td class="project-actions d-flex justify-content-center">
                                    <a class="btn btn-primary btn-sm" style="width:33px; height:30px; margin:4px 4px;"
                                        href="{{ route('admin.celebrants.show', $greeting->celebrant_id) }}">
                                        <i class="fas fa-eye">
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" rowspan="1" colspan="1">id іменинника</th>
                                <th class="text-center" rowspan="1" colspan="1">Прізвище та ім'я іменинника</th>
                                <th class="text-center" rowspan="1" colspan="1">Дата народження</th>
                                <th class="text-center" rowspan="1" colspan="1">Назва компанії</th>
                                <th class="text-center" rowspan="1" colspan="1">Дата публікації</th>
                                <th class="text-center" rowspan="1" colspan="1">Профіль іменинника</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    {{ $greetingsCompany->links('admin.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection