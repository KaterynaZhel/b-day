@extends('layouts.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Редагування привітання від Компанії</h3>
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

        <form
            action="{{ route('admin.celebrants.greetingsCompany.update', [$greetingsCompany->celebrant_id, $greetingsCompany->id]) }}"
            method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="message_company">Привітання</label>
                    <textarea class="form-control" id="message_company" name="message_company" rows="3">{{ $greetingsCompany->message_company }}</textarea>
                </div>

                <div class="form-group">
                    <label for="company">Компанія</label>
                    <select id="company" name="company_id" class="form-control select2bs4" style="width: 100%;">
                        <option></option>
                        @foreach ($companies as $company)
                            @if ($company->company_id == $company->id)
                                <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
                            @else
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Зберегти</button>
                </div>
        </form>
    </div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            //select2 autofocus
            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });
        });
    </script>
@endsection
