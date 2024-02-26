<form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="form-group">
            <label for="exampleInputFile">Фото</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="photoFile" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="lastname">Прізвище</label>
            <input class="form-control" value="{{ $user->lastname ?? '' }}" id="lastname" name="lastname"
                placeholder="Прізвище">
        </div>

        <div class="form-group">
            <label for="name">Ім'я</label>
            <input class="form-control" value="{{ $user->name ?? '' }}" id="name" name="name"
                placeholder="Ім'я">
        </div>

        <div class="form-group">
            <label for="middlename">По-батькові</label>
            <input class="form-control" value="{{ $user->middlename ?? '' }}" id="middlename" name="middlename"
                placeholder="По-батькові">
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" value="{{ $user->email ?? '' }}" id="email" name="email"
                placeholder="E-mail">
        </div>

        <div class="form-group">
            <label for="company">Компанія</label>
            <select id="company" name="company_id" class="form-control select2bs4" style="width: 100%;">
                <option></option>
                @foreach ($companies as $company)
                    @if (!empty($user) && $user->company_id == $company->id)
                        <option value="{{ $company->id ?? '' }}" selected>{{ $company->name ?? '' }}</option>
                    @else
                        <option value="{{ $company->id ?? '' }}">{{ $company->name ?? '' }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Зберегти зміни</button>
        </div>
</form>

@section('custom-script')
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

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
