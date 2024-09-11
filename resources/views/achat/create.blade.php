@extends('partials.master')

@section('content')

    @include('components.header',[
        'title' => "Ajouter de nouveaux achats",
        'back'   => [
            'label' => 'Liste des achats',
            'url'   => route('achat.index'),
        ],
    ])

    <div class="card">
    <div class="card-body">
        <form action="{{ route('achat.store') }}" method="POST" id="create-form">
            @csrf

            <div data-repeater-list="achat">
                <div data-repeater-item>
                    <div class="row py-3">

                        <div class="col-lg-5">
                            <div class="form-group">

                                <label class="form-label" for="site_id">Site</label>
                                <input type="text" class="form-control" value=" {{ Auth::user()->site->name }}" readonly>
                                <input type="hidden" name="site_id" class="form-control" value="{{ Auth::user()->site->id }} " readonly>

                            </div>
                        </div>


                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="product_id">Choisissez le produit</label>
                                <select class="form-select @error('product_id') is-invalid @enderror" name="product_id">
                                    <option value="" disabled selected>Sélectionnez un produit</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name . " (" . $product->price . ")" }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="unit_price">Prix Unitaire</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control @error('achat.*.unit_price') is-invalid @enderror" id="unit_price" name="achat[0][unit_price]" placeholder="Ex : 5000">
                                    @error('achat.*.unit_price')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="quantity">Quantité</label>
                                <div class="form-control-wrap">
                                    <input type="number" min="0"  step="1" class="form-control @error('achat.*.quantity') is-invalid @enderror" id="quantity" name="achat[0][quantity]" placeholder="Ex : 10">
                                    @error('achat.*.quantity')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="date_achat">Date d'achat</label>
                                <div class="form-control-wrap">
                                    <input type="date" class="form-control @error('achat.*.date_achat') is-invalid @enderror" id="date_achat" name="achat[0][date_achat]" placeholder="Ex : 10">
                                    @error('achat.*.date_achat')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="groupe_achats_id">Choisissez le groupe</label>
                                <select class="form-select
                                        @error('groupe_achats_id') is-invalid @enderror"
                                        name="groupe_achats_id">
                                    <option value="" disabled selected> Sélectionnez un groupe </option>
                                    @foreach ($groupes as $groupe)
                                        <option value="{{ $groupe->id }}">{{ $groupe->name }}</option>
                                    @endforeach
                                </select>
                                @error('groupe_achats_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-2 d-flex align-items-end">
                            <button type="button" class="btn btn-icon btn-md btn-danger" title="Retirer un achat" data-repeater-delete>
                                <em class="icon ni ni-minus"></em>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-3">
                <button type="button"
                        class="btn btn-icon btn-md btn-warning"
                        title="Ajouter un achat"
                        data-repeater-create
                        onclick="add_new_achats()">
                    <em class="icon ni ni-plus"></em>
                </button>
            </div>

            <div class="pt-3 text-center">
                <button type="submit" class="btn btn-md btn-primary" title="Ajouter un achat">
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
            $('select').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2();
                }
            });

        });

        function add_new_achats(){
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
