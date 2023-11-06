<div class="card">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
    </div>
    @endif
    <div class="card-header">
        <h3 class="card-title">Варіанти подарунків</h3>
    </div>
    <tbody>
        <div class="row">
            @foreach ($gifts as $gift)
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>{{$gift['title'] }}</p>
                    </div>
                    <div class="icon text-center">
                        <img src="{{ $gift['picture'] }}" alt="{{ $gift['title'] }}">
                    </div>
                    <a href="{{$gift['link'] }}" target="_blank" rel="noreferrer noopener"
                        class="small-box-footer">Більше <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </tbody>
</div>
<style>
    .inner p {
        line-height: 1.2;
        max-height: 3.6em;
        min-height: 3.6em;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
    }

    .card {
        flex: 1;
        margin: 10px;
    }

    .icon img {
        max-height: 130px;
    }
</style>