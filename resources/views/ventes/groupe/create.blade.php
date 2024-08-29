@extends('partials.master')

@section('content')

    @include('components.header',[
        'title' => "Ajouter un groupe de vente",
        'back'   => [
            'label' => 'Liste des ventes',
            'url'   => route('groupe_ventes.create'),
        ],
    ])

    <div class="card">
        <div class="card-body">

            <form action="{{ route('groupe_ventes.store') }}" method="POST" id="create-form">

                @csrf

                <div class="row" data-repeater-list="groupe_vente">
                    <div class="col-lg-6 py-2" data-repeater-item>

                        <div class="row">

                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nom</label>
                                    <div class="form-control-wrap">
                                        <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                id="name"
                                                name="name"
                                                placeholder="Ex : Vente n1 12/02/2024">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 d-flex align-items-end">
                                <button type="button"
                                        class="btn btn-icon btn-md btn-danger"
                                        title="Retirer un groupe d'achat"
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
                            title="Ajouter un groupe d'achat"
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
