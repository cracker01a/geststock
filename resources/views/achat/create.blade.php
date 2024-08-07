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
                                <label class="form-label" for="site_id">Choisissez le site</label>
                                <select class="form-control @error('site_id') is-invalid @enderror" id="site_id" name="site_id">
                                    <option value="" disabled selected>-- Sélectionnez un site --</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                    @endforeach
                                </select>
                                @error('site_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="product_id">Choisissez le produit</label>
                                <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                                    <option value="" disabled selected>-- Sélectionnez un produit --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
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

                        

                        <div class="col-lg-2 d-flex align-items-end">
                            <button type="button" class="btn btn-icon btn-md btn-danger" title="Retirer un achat" data-repeater-delete>
                                <em class="icon ni ni-minus"></em>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-3">
                <button type="button" class="btn btn-icon btn-md btn-warning" title="Ajouter un achat" data-repeater-create>
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
    </script>

@endsection
