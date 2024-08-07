@extends('partials.master')

@section('content')

    @include('components.header',[
        'title' => "Ajouter de nouveaux produits",
        'back'   => [
            'label' => 'Liste des produits',
            'url'   => route('product.index'),
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('product.store') }}" method="POST" id="create-form">

                @csrf

                <div data-repeater-list="product">
                    <div data-repeater-item>

                        <div class="row py-3">

                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nom</label>
                                    <div class="form-control-wrap">
                                        <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                id="name"
                                                name="name"
                                                placeholder="Ex : Lampe">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="price">Prix</label>
                                    <div class="form-control-wrap">
                                        <input type="number"
                                                class="form-control @error('price') is-invalid @enderror"
                                                id="price"
                                                name="price"
                                                placeholder="Ex : 5 000">
                                        @error('price')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 d-flex align-items-end">
                                <button type="button"
                                        class="btn btn-icon btn-md btn-danger"
                                        title="Retirer un produit"
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
                            title="Ajouter un produit"
                            data-repeater-create>
                        <em class="icon ni ni-plus ni-plus"></em>
                    </button>
                </div>

                <div class="pt-3 text-center">
                    <button type="submit"
                            class="btn btn-md btn-primary"
                            title="Ajouter un produit">
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
