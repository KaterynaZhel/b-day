@if (!empty($celebrant))
<form action="{{route('admin.celebrants.update', $celebrant->id)}}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @else
    <form action="{{route('admin.celebrants.store') }}" method="POST" enctype="multipart/form-data">
        @endif
        @csrf

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
                <input class="form-control" value="{{ $celebrant->lastname ?? '' }}" id="lastname" name="lastname"
                    placeholder="Прізвище">
            </div>

            <div class="form-group">
                <label for="firstname">Ім'я</label>
                <input class="form-control" value="{{ $celebrant->firstname ?? ''}}" id="firstname" name="firstname"
                    placeholder="Ім'я">
            </div>

            <div class="form-group">
                <label for="middlename">По-батькові</label>
                <input class="form-control" value="{{ $celebrant->middlename ?? ''}}" id="middlename" name="middlename"
                    placeholder="По-батькові">
            </div>

            <div class="form-group">
                <label>Дата народження</label>
                <div class="input-group date" id="birthday" data-target-input="nearest">
                    <input type="text" value="{{ $celebrant->birthday ?? ''}}" name="birthday"
                        class="form-control datetimepicker-input" data-target="#birthday">
                    <div class="input-group-append" data-target="#birthday" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="company">Компанія</label>
                <select id="company" name="company_id" class="form-control select2bs4" style="width: 100%;">
                    <option></option>
                    @foreach($companies as $company)
                    @if(!empty($celebrant) && $celebrant->company_id == $company->id)

                    <option value="{{ $company->id ?? ''}}" selected>{{ $company->name ?? ''}}</option>
                    @else
                    <option value="{{ $company->id ?? ''}}">{{ $company->name ?? ''}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="position">Роль</label>
                <select id="position" name="position" class="form-control custom-select">
                    <option></option>
                    @foreach($celebrant_positions as $position)
                    @if(!empty($celebrant) && $celebrant->position==$position)
                    <option selected>{{$position ?? ''}}</option>
                    @else
                    <option>{{$position ?? ''}}</option>
                    @endif
                    @endforeach
                </select>

            </div>

            <div class="form-group">
                <label for="hobbies">Інтереси</label>

                <select id="hobbies" name="hobbies[]" class="form-control js-hobby-tags"" multiple=" multiple">

                    @foreach($hobbies as $hobby)

                    @if (!empty($celebrant) && $celebrant->hobbies->contains($hobby))
                    <option selected>{{$hobby->name ?? ''}}</option>
                    @else
                    <option>{{$hobby->name ?? ''}}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="card-footer">
                @if (!empty($celebrant))
                <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                @else
                <button type="submit" class="btn btn-primary">Створити</button>
                @endif
            </div>
    </form>

    @section('custom-script')
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function () {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            $(".js-hobby-tags").select2({
                tags: true
            });

            //Date picker
            $('input[name="birthday"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'), 10),
                autoApply: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
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