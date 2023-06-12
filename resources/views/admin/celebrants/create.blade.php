@extends('layouts.admin')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Створення іменинника</h3>
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


    <form action="{{route('admin.celebrants.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputFile">Фото</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="photoFile" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                    </div>
                </div>
            </div>



            <div class="form-group">
                <label for="lastname">Прізвище</label>
                <input class="form-control" id="lastname" name="lastname" placeholder="Прізвище">
            </div>

            <div class="form-group">
                <label for="firstname">Ім'я</label>
                <input class="form-control" id="firstname" name="firstname" placeholder="Ім'я">
            </div>

            <div class="form-group">
                <label for="middlename">По-батькові</label>
                <input class="form-control" id="middlename" name="middlename" placeholder="По-батькові">
            </div>

            <div class="form-group">
                <label>Дата народження</label>
                <div class="input-group date" id="birthday" data-target-input="nearest">
                    <input type="text" name="birthday" class="form-control datetimepicker-input"
                        data-target="#birthday">
                    <div class="input-group-append" data-target="#birthday" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>



            <div class="form-group">
                <label for="position">Роль</label>
                <select id="position" name="position" class="form-control custom-select">
                    <option></option>
                    @foreach($celebrant_positions as $position)
                    <option>{{$position}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Створити</button>
            </div>
    </form>
</div>
@endsection

@section('custom-script')
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
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
    });
</script>
@endsection