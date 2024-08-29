@extends('partials.master')

@section('content')


@include('components.header', [
    'title' => "Modification de l'achat « ".$achat->designation." »",
    'back'   => [
        'label' => 'Liste des achats',
        'url'   => route('achat.index'),
    ],
])

<div class="card">
    <div class="card-body">
        <form action="{{ route('achat.update', $achat) }}" method="POST" id="update-form">
            @csrf
            @method('PUT')

            <div class="row py-3">
                <!-- <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="site_id">Choisissez le site</label>
                        <select class="form-control @error('site_id') is-invalid @enderror" id="site_id" name="site_id">
                            <option value="" disabled selected>-- Sélectionnez un site --</option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}" {{ $site->id == $achat->site_id ? 'selected' : '' }}>
                                    {{ $site->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('site_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div> -->
                
                        <!-- <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="site_id">Site</label>
                                
                                
                                <input type="text"    class="form-control" value=" {{ Auth::user()->site->name }}">
                              
                              
                                <input type="hidden" name="site_id" class="form-control" value="{{ Auth::user()->site->id }} " readonly>

                            </div>
                        </div> -->


                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="product_id">Choisissez le produit</label>
                        <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                            <option value="" disabled selected>-- Sélectionnez un produit --</option>
                            @foreach ($products as $product)
                                    {{ $product->name }}
                                    
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-5">
                <div class="form-group">
                    <label class="form-label" for="groupe_achats_id">Choisissez le groupe</label>
                    <select class="form-select  @error('groupe_achats_id') is-invalid @enderror"
                            {{-- id="groupe_achats_id" --}}
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

            </div>
           
            <div class="row py-3">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="unit_price">Prix Unitaire</label>
                        <input type="number"
                            class="form-control @error('unit_price') is-invalid @enderror"
                            id="unit_price"
                            name="unit_price"
                            value="{{ old('unit_price', $achat->unit_price) }}"
                            placeholder="Ex : 5000"
                            step="0.01">
                        @error('unit_price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="quantity">Quantité</label>
                        <input type="number"
                            class="form-control @error('quantity') is-invalid @enderror"
                            id="quantity"
                            name="quantity"
                            value="{{ old('quantity', $achat->quantity) }}"
                            placeholder="Ex : 10"
                            min="1">
                        @error('quantity')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-3 text-center">
                <button type="submit"
                        class="btn btn-md btn-primary"
                        title="Modifier un achat">
                    Modifier
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')

    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>

@endsection
