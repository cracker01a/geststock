@extends('partials.master')

@section('content')


    @include('components.header',[
        'title' => "Ajouter un site",
        'back'   => [
            'label' => 'Liste des sites',
            'url'   => route('site.index'),
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('site.store') }}" method="POST" id="create-form">

                @csrf

                <div class="row" data-repeater-list="site">
                    <div class="col-lg-6 py-2" data-repeater-item>

                        <div class="row">

                            <div class="col-lg-11">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nom</label>
                                    <div class="form-control-wrap">
                                        <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                id="name"
                                                name="name"
                                                placeholder="Ex : Godomey">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 d-flex align-items-end">
                                <button type="button"
                                        class="btn btn-icon btn-md btn-danger"
                                        title="Retirer le site"
                                        data-repeater-delete>
                                    <em class="icon ni ni-plus ni-minus"></em>
                                </button>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="pt-3">
                    <button type="button"
                            class="btn btn-icon btn-md btn-warning"
                            title="Ajouter un site"
                            data-repeater-create>
                        <em class="icon ni ni-plus ni-plus"></em>
                    </button>
                </div>

                <div class="pt-3 text-center">
                    <button type="submit"
                            class="btn btn-md btn-primary">
                        Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>


@endsection

@section('scripts')

    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>
    <script src="./assets/js/repeater/jquery.repeater.min.js"></script>

    <script>
        repeater_bloc(["#create-form"])
    </script>

@endsection
