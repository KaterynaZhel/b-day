@section('content')
<div class="card">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
    </div>
    @endif
    <div class="card-header">
        <h3 class="card-title">Таблиця привітань від Компанії</h3>
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
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Текст
                                    вітання</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Назва
                                    Компанії</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Дата
                                    публікації</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($greetingsCompany as $greeting)
                            <tr class="odd">
                                <td class="dtr-control sorting_1" tabindex="0">{{ $greeting->id }}</td>
                                <td>{{ $greeting->message_company }}</td>
                                <td>{{ $greeting->name_company }}</td>
                                <td>{{ $greeting->publish_at }}</td>
                                <td class="project-actions d-flex justify-content-center">
                                    <form method="post" action="#">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn destroy-btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection