@extends('partials.master')

@section('content')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    @include('components.header',[
                        'title' => "Modification du site « ".$site->name." »",
                        'back'   => [
                            'label' => 'Liste des sites',
                            'url'   => route('site.index'),
                        ],
                    ])

                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('site.update' , $site) }}" method="POST" id="create-form">

                                @csrf
                                @method('PUT')


                                <div class="row py-3">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="name">Nom</label>
                                            <div class="form-control-wrap">
                                                <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="name"
                                                        name="name"
                                                        value="{{ $site->name }}"
                                                        placeholder="Ex : Lampe">
                                                @error('name')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="pt-3 text-center">
                                    <button type="submit"
                                            class="btn btn-md btn-primary">
                                        Modifier
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>

@endsection
