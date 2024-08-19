@extends('partials.master')

@section('content')


    @include('components.header',[
        'title' => "Modification du produit « ".$product->name." »",
        'back'   => [
            'label' => 'Liste des produits',
            'url'   => route('product.index'),
        ],
    ])

    <div class="card">
        <div class="card-body">

            <form action="{{ route('product.update' , $product) }}" method="POST" id="create-form">

                @csrf
                @method('PUT')


                <div class="row py-3">

                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-label" for="sites_id">Choisissez le site</label>
                            <select class="form-select js-select2 @error('sites_id') is-invalid @enderror"
                                    data-search="on"
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

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="name">Nom</label>
                            <div class="form-control-wrap">
                                <input type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name"
                                        name="name"
                                        value="{{ $product->name }}"
                                        placeholder="Ex : Lampe">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="price">Prix</label>
                            <div class="form-control-wrap">
                                <input type="number"
                                        class="form-control @error('price') is-invalid @enderror"
                                        id="price"
                                        name="price"
                                        value="{{ $product->price }}"
                                        placeholder="Ex : 5 000">
                                @error('price')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="pt-3 text-center">
                    <button type="submit"
                            class="btn btn-md btn-primary"
                            title="Modifier un produit">
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
