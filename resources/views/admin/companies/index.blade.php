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
            <h3 class="card-title">Таблиця компаній</h3>
        </div>
        <div class="card-body">
            <div id="celebrants_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <a class="btn btn-primary btn-sm float-right" href="{{ route('admin.companies.create') }}"
                            align="right">
                            Створити компанію
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
                                        colspan="1">Назва компанії</th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1">Сайт компанії</th>
                                    <th class="sorting" tabindex="0" aria-controls="celebrants" rowspan="1"
                                        colspan="1">Інструменти</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                    <tr class="odd">
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $company->id }}</td>
                                        <td>{{ $celebrant->name }}</td>
                                        <td>{{ $celebrant->site }}</td>
                                        <td class="project-actions d-flex justify-content-center">
                                            <a class="btn btn-info btn-sm" style="width:33px; height:30px; margin:4px 4px;"
                                                href="{{ route('admin.companies.edit', $company->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form method="post"
                                                action="{{ route('admin.companies.destroy', $company->id) }}">
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
                                    <th rowspan="1" colspan="1">id</th>
                                    <th rowspan="1" colspan="1">Назва компанії</th>
                                    <th rowspan="1" colspan="1">Сайт компанії</th>
                                    <th rowspan="1" colspan="1">Інструменти</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
