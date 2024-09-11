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

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="sites_id">Choisissez le site</label>
                                    <select class="form-select  @error('sites_id') is-invalid @enderror"
                                            name="sites_id">

                                            @if (Auth::user()->status == 'super_admin' || Auth::user()->status == 'admin')

                                                <option value="" disabled selected> Sélectionnez un site </option>
                                                @foreach ($sites as $site)
                                                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                @endforeach

                                            @else

                                                <option value="{{ Auth::user()->site->id }}">
                                                    {{ Auth::user()->site->name }}
                                                </option>

                                            @endif

                                    </select>
                                    @error('sites_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
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

                            <div class="col-lg-3">
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

                            <div class="col-lg-1 d-flex align-items-end">
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
                            data-repeater-create
                            onclick="add_new_product()">
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

        $(document).ready(function() {
            // Initialisation de Select2 pour les éléments existants
            $('select').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2();
                }
            });

        });

        function add_new_product(){
            setTimeout(function() {
                $('select').each(function() {
                    if (!$(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2();
                    }
                });
            }, 100);
        }
    </script>

@endsection
