@extends('partials.master')

@section('content')


    @include('components.header',[
        'title' => "Modifier  la vente « ".$vente->name." »",
        'back'   => [
            'label' => 'Liste des ventes',
            'url'   => route('ventes.index'),
        ],
    ])


    <div class="card">
    <div class="card-body">

        <!-- Message d'erreur -->
        <div id="error-message" class="alert alert-danger" style="display: none;"></div>

        <!-- Formulaire de vente -->
        <form action="{{ route('ventes.updateCustom', $vente->id) }}" method="POST" id="vente-form">
            @csrf
            @method('PUT')

            <!-- Liste des ventes -->
            <div data-repeater-list="vente">
                <div data-repeater-item>
                    <div class="row py-3">
                        <!-- Sélection du site -->
                        <div class="col-lg-3">
                        <div class="form-group">
                                <label class="form-label" for="site_id">Site</label>
                                <input type="text"    class="form-control" value=" {{ Auth::user()->site->name }}" readonly>
                                <input type="hidden" name="site_id" class="form-control" value="{{ Auth::user()->site->id }}">

                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="products_id">Produit</label>
                                {{-- <select class="form-select @error('product_id') is-invalid @enderror"
                                        name="product_id" readonly>
                                    <option value="" disabled selected>Sélectionnez un produit</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                                {{ $product->id == $vente->products_id ? "selected" : "" }}>
                                                {{ $product->name . " (" . $product->price . ")" }}
                                        </option>
                                    @endforeach
                                </select> --}}

                                <input type="text" class="form-control" value=" {{ $vente->product->name }}" readonly>
                                <input type="hidden" name="products_id" class="form-control" value="{{ $vente->products_id }}">

                                @error('products_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Prix unitaire -->
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="form-label" for="price">Prix Unitaire</label>
                                <div class="form-control-wrap">
                                    <input type="number"
                                            name="price"
                                            id="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ $vente->price }}"
                                            required
                                            oninput="total(this)">
                                    @error('price')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Quantité -->
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="form-label" for="quantity">Quantité</label>
                                <div class="form-control-wrap">
                                    <input type="number"
                                            name="quantity"
                                            id="quantity"
                                            min="0"
                                            class="form-control @error('quantity') is-invalid @enderror"
                                            value="{{ $vente->quantity }}"
                                            required
                                            oninput="total(this)">
                                    @error('quantity')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                    <span class="error text-danger" id="quantity-error" style="display: none;">Quantité insuffisante</span>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="form-group pt-4">
                <h4><label>Prix Total: <span id="total_price">{{ $vente->total_price }} FCFA</span></label></h4>
            </div>



            <!-- Bouton de soumission -->
            <div class="pt-3 text-center">
                <button type="submit" class="btn btn-primary" title="Mettre à jour la vente">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

<script>

    // $(document).ready(function() {
    //     $('select').each(function() {
    //         if (!$(this).hasClass('select2-hidden-accessible')) {
    //             $(this).select2();
    //         }
    //     });

    // });

    // document.addEventListener('DOMContentLoaded', function() {
    //     const productSelect = document.getElementById('product_id');
    //     const priceInput = document.getElementById('price');
    //     const quantityInput = document.getElementById('quantity');
    //     const totalPriceElement = document.getElementById('total_price');
    //     const errorMessage = document.getElementById('error-message');
    //     const form = document.getElementById('vente-form');

    //     productSelect.addEventListener('change', function() {
    //         const selectedOption = productSelect.options[productSelect.selectedIndex];
    //         const productId = selectedOption.value;

    //         fetch(`/products/${productId}/price`)
    //             .then(response => response.json())
    //             .then(data => {
    //                 priceInput.value = data.price;
    //                 updateTotalPrice();
    //             });
    //     });

    //     priceInput.addEventListener('input', updateTotalPrice);
    //     quantityInput.addEventListener('input', updateTotalPrice);

    //     function updateTotalPrice() {
    //         const price = parseFloat(priceInput.value) || 0;
    //         const quantity = parseInt(quantityInput.value) || 0;
    //         const totalPrice = price * quantity;
    //         totalPriceElement.innerText = totalPrice.toFixed(2) + ' FCFA';
    //     }

    //     form.addEventListener('submit', function(event) {
    //         event.preventDefault(); // Prevent default form submission

    //         const formData = new FormData(form);

    //         fetch('{{ route("ventes.update", $vente->id) }}', {
    //             method: 'POST',
    //             body: formData,
    //             headers: {
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //                 'Accept': 'application/json'
    //             }
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.error) {
    //                 errorMessage.style.display = 'block';
    //                 errorMessage.innerText = data.error;
    //             } else {
    //                 window.location.href = '{{ route("ventes.index") }}';
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //             errorMessage.style.display = 'block';
    //             errorMessage.innerText = 'Une erreur est survenue. Veuillez réessayer.';
    //         });
    //     });
    // });

</script>




@endsection

@section('scripts')

    {{-- <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script> --}}
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        function total(element){

            var price = document.getElementById('price').value ?? 0
            var quantity = document.getElementById('quantity').value ?? 0

            var total = parseInt(price) * parseInt(quantity);
            document.getElementById('total_price').innerHTML = total + " F CFA"
        }
    </script>

@endsection
