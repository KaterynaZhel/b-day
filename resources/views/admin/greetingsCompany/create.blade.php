@extends('layouts.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Створення привітання від Компанії</h3>
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

        <form action="{{ route('admin.celebrants.greetingsCompany.store', $celebrant_id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="message_company">Привітання</label>
                    <textarea class="form-control" id="message_company" name="message_company" rows="3"></textarea>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Зберегти</button>
                </div>
        </form>
    </div>
@endsection

@section('custom-script')
    <script>
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        //select2 autofocus
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>
@endsection
