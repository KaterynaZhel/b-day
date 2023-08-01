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
        <h3 class="card-title">Таблиця найближчих іменинників</h3>
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

                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                    Прізвище
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Ім'я
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                    По-батькові</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    style="width: 100px;">
                                    Дата
                                    народження</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                    Компанія
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Дата
                                    привітання
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                    Профіль іменинника</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($celebrants as $celebrant)
                            <tr class="odd {{ $celebrant->isHasNewGreetingCompany() ? '' : 'bg-danger' }}">

                                <td class="dtr-control sorting_1" tabindex="0">{{ $celebrant->id }}</td>

                                <td>{{ $celebrant->lastname }}</td>
                                <td>{{ $celebrant->firstname }}</td>
                                <td>{{ $celebrant->middlename }}</td>
                                <td>{{ $celebrant->birthday }}</td>
                                @if(empty($celebrant->lastGreetingsCompany))
                                <td>{{$celebrant->isHasNewGreetingCompany() ? 'true' : 'false'}}</td>
                                <td></td>
                                @else
                                <td>{{$celebrant->lastGreetingsCompany->name_company }}</td>
                                <td>{{$celebrant->lastGreetingsCompany->publish_at }}</td>
                                @endif

                                <td class="project-actions d-flex justify-content-center">
                                    <a class="btn btn-primary btn-sm" style="width:33px; height:30px; margin:4px 4px;"
                                        href="{{ route('admin.celebrants.show', $celebrant->id) }}">
                                        <i class="fas fa-eye">
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">id</th>
                                <th rowspan="1" colspan="1">Прізвище</th>
                                <th rowspan="1" colspan="1">Ім'я</th>
                                <th rowspan="1" colspan="1">По-батькові</th>
                                <th rowspan="1" colspan="1">Дата народження</th>
                                <th rowspan="1" colspan="1">Компанія</th>
                                <th rowspan="1" colspan="1">Дата привітання</th>
                                <th rowspan="1" colspan="1">Профіль іменинника</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    {{ $celebrants->links('admin.pagination') }}
                </div>
            </div>
        </div>
    </div>
    @endsection