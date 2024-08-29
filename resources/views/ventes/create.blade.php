@extends('partials.master')

@section('content')

    @include('components.header',[
        'title' => "Effectuer une nouvelle vente",
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
        <form action="{{ route('ventes.store') }}" method="POST" id="create-form">
            @csrf

            <!-- Liste des ventes -->
            <div data-repeater-list="vente">
                <div data-repeater-item>
                    <div class="row py-3">
                        <!-- Sélection du site -->
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="form-label" for="site_id">Site</label>
                                
                                
                                <input type="text"    class="form-control" value=" {{ Auth::user()->site->name }}" readonly>
                              
                              
                                <input type="hidden" name="site_id" class="form-control" value="{{ Auth::user()->site->id }} " readonly>

                            </div>
                        </div>


                        <!-- Sélection du produit -->
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="form-label" for="product_id">Produit</label>
                                <div class="form-control-wrap">
                                    <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
                                        <option value="" disabled selected>-- Sélectionnez un produit --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="form-label" for="groupe_ventes_id">Choisissez le groupe</label>
                                <select class="form-select  @error('groupe_ventes_id') is-invalid @enderror"
                                        {{-- id="groupe_ventes_id" --}}
                                        name="groupe_ventes_id">
                                    <option value="" disabled selected> Sélectionnez un groupe </option>
                                    @foreach ($groupes as $groupe)
                                        <option value="{{ $groupe->id }}">{{ $groupe->name }}</option>
                                    @endforeach
                                </select>
                                @error('groupe_ventes_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Prix unitaire -->
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="form-label" for="price">Prix Unitaire</label>
                                <div class="form-control-wrap">
                                    <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" step="0.01" required>
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
                                    <input type="number" name="quantity" id="quantity"  min="0" step="1"  class="form-control @error('quantity') is-invalid @enderror" required>
                                    @error('quantity')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                    <span class="quantity-error text-danger" style="display: none;"></span>
                                </div>
                            </div>
                        </div>
                       

                        <div class="col-lg-1 d-flex align-items-end">
                            <button type="button" class="btn btn-icon btn-md btn-danger" title="Retirer un produit" data-repeater-delete>
                                <em class="icon ni ni-plus ni-minus"></em>
                            </button>
                        </div>
                        <div class="form-group pt-2">
                            <h6><label>Prix Total: <span id="total_price">0.00 FCFA</span></label></h6>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const productSelect = document.getElementById('product_id');
                    const priceInput = document.getElementById('price');
                    const quantityInput = document.getElementById('quantity');
                    const totalPriceElement = document.getElementById('total_price');
                    const errorMessage = document.getElementById('error-message');

                    productSelect.addEventListener('change', function() {
                        const selectedOption = productSelect.options[productSelect.selectedIndex];
                        const productId = selectedOption.value;

                        fetch(`/products/${productId}/price`)
                            .then(response => response.json())
                            .then(data => {
                                priceInput.value = data.price;
                                updateTotalPrice();
                            });
                    });

                    priceInput.addEventListener('input', updateTotalPrice);
                    quantityInput.addEventListener('input', updateTotalPrice);

                    function updateTotalPrice() {
                        const price = parseFloat(priceInput.value) || 0;
                        const quantity = parseInt(quantityInput.value) || 0;
                        const totalPrice = price * quantity;
                        totalPriceElement.innerText = totalPrice.toFixed(2) + ' FCFA';
                    }

                    document.getElementById('vente-form').addEventListener('submit', function(event) {
                        event.preventDefault();
                        const formData = new FormData(this);

                        fetch('{{ route("ventes.store") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                errorMessage.style.display = 'block';
                                errorMessage.innerText = data.error;
                            } else {
                                window.location.href = '{{ route("ventes.index") }}';
                            }
                        });
                    });
                });

                



                document.addEventListener('DOMContentLoaded', function () {

                    const form = document.getElementById('create-form');

                    form.addEventListener('input', function (event) {
                        if (event.target && event.target.name === 'vente[0][quantity]') {
                            const quantityInput = event.target;
                            const productSelect = quantityInput.closest('[data-repeater-item]').querySelector('select[name="vente[0][product_id]"]');
                            const selectedOption = productSelect.options[productSelect.selectedIndex];
                            const productId = selectedOption ? selectedOption.value : null;
                            let quantityError = quantityInput.closest('.form-group').querySelector('.quantity-error');

                            // Si le span d'erreur n'existe pas, le créer
                            if (!quantityError) {
                                quantityError = document.createElement('span');
                                quantityError.classList.add('quantity-error', 'text-danger');
                                quantityError.style.display = 'none';
                                quantityInput.parentNode.appendChild(quantityError);
                            }

                            if (productId) {

                                /*
                                    fetch(`/products/${productId}/quantity`)
                                        .then(response => response.json())
                                        .then(data => {
                                            const availableStock = data.quantity;
                                            if (quantityInput.value > availableStock) {
                                                console.log('Hello')
                                                quantityError.textContent = `Quantité insuffisante. Disponible : ${availableStock}`;
                                                quantityError.style.display = 'block';
                                            } else {
                                                quantityError.style.display = 'none';
                                            }
                                        });
                                */

                                var route = '{{ route("products.quantity" , ":id" ) }}'
                                    route = route.replace(":id",productId)
                                    
                                    fetch(route, {
                                        method: 'GET',
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        const availableStock = data.quantity;
                                        if (quantityInput.value > availableStock) {
                                            console.log('Route générée :', route);
                                            quantityError.textContent = `Quantité insuffisante. Disponible : ${availableStock}`;
                                            quantityError.style.display = 'block';
                                        } else {
                                            quantityError.style.display = 'none';
                                        }
                                    })
                                    .catch((error) => {
                                        console.log(error)
                                    });

                            }
                        }
                    });
                });
            </script>



            <!-- Ajouter une vente -->
            <div class="pt-3">
                <button type="button" class="btn btn-icon btn-md btn-warning" title="Ajouter un produit" data-repeater-create>
                    <em class="icon ni ni-plus ni-plus"></em>
                </button>
            </div>

            <!-- Bouton de soumission -->
            <div class="pt-3 text-center">
                <button type="submit" class="btn btn-primary" title="Créer une vente">
                    Enregistrer la vente
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