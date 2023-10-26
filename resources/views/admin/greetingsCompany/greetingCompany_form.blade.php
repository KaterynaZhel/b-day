@if (!empty($greetingsCompany))
    <form
        action="{{ route('admin.celebrants.greetingsCompany.update', [$greetingsCompany->celebrant_id, $greetingsCompany->id]) }}"
        method="POST" enctype="multipart/form-data">
        @method('PUT')
    @else
    <form action="{{ route('admin.celebrants.greetingsCompany.store', $celebrant_id) }}" method="POST"
        enctype="multipart/form-data">
@endif
@csrf

<div class="card-body">
    <div class="form-group">
        <label for="message_company">Привітання</label>
        <textarea class="form-control" id="message_company" name="message_company" rows="3">{{ $greetingsCompany->message_company ?? '' }}</textarea>
    </div>

    <div class="card-footer">
        @if (!empty($greetingsCompany))
            <button type="submit" class="btn btn-primary">Зберегти зміни</button>
        @else
            <button type="submit" class="btn btn-primary">Створити</button>
        @endif
    </div>
</div>
</form>
