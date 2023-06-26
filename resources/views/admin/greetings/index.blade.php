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
            <h3 class="card-title">Таблиця привітань від гостей</h3>
        </div>
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" aria-sort="ascending">id</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1">Текст вітання</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1">Ім'я гостя</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" style="width: 100px;">Дата залишення вітання</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($greetings as $greeting)
                                    <tr class="odd">
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $greeting->id }}</td>
                                        <td>{{ $greeting->name }}</td>
                                        <td>{{ $greeting->message }}</td>
                                        <td>{{ $greeting->created_at->format('Y-m-d') }}</td>
                                        <td class="project-actions text-right">
                                            <form method="post"
                                                action="{{ route('admin.greetings.destroy', $greeting->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn destroy-btn-greeting btn-danger btn-sm">
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
                                    <th rowspan="1" colspan="1">Текст вітання</th>
                                    <th rowspan="1" colspan="1">Ім'я гостя</th>
                                    <th rowspan="1" colspan="1">Дата залишення вітання</th>
                                    <th rowspan="1" colspan="1"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        {{ $greetings->links('admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
