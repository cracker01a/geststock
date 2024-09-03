{{--
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
                                        <input type="text"
                                                class="form-control"
                                                value=" {{ Auth::user()->site->name }}"
                                                readonly>
                                        <input type="hidden"
                                                name="site_id"
                                                class="form-control"
                                                value="{{ Auth::user()->site->id }}"
                                                readonly>

                                    </div>
                                </div>

                                <!-- Sélection du produit -->
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="form-label" for="product_id">Produit</label>
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

                                <!-- Groupe -->
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="form-label" for="groupe_ventes_id">Groupe</label>
                                        <select class="form-select  @error('groupe_ventes_id') is-invalid @enderror"
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
                                            <input type="number"
                                                    name="price"
                                                    id="price"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    step="0.01"
                                                    required>
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
                                                    step="1"
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    required>
                                            @error('quantity')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                            <span class="quantity-error text-danger" style="display: none;"></span>
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

                    <div class="form-group pt-2">
                        <h6>
                            <label>
                                Prix Total: <span id="total_price">0.00 FCFA</span>
                            </label>
                        </h6>
                    </div>

                    <!-- Ajouter une vente -->
                    <div class="pt-3">
                        <button type="button"
                                class="btn btn-icon btn-md btn-warning"
                                title="Ajouter un produit"
                                data-repeater-create
                                onclick="add_new_achats()">
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

            // document.addEventListener('DOMContentLoaded', function() {
            //     const productSelect = document.getElementById('product_id');
            //     const priceInput = document.getElementById('price');
            //     const quantityInput = document.getElementById('quantity');
            //     const totalPriceElement = document.getElementById('total_price');
            //     const errorMessage = document.getElementById('error-message');

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

            //     document.getElementById('vente-form').addEventListener('submit', function(event) {
            //         event.preventDefault();
            //         const formData = new FormData(this);

            //         fetch('{{ route("ventes.store") }}', {
            //             method: 'POST',
            //             body: formData,
            //             headers: {
            //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
            //         });
            //     });
            // });

            // document.addEventListener('DOMContentLoaded', function () {

            //     const form = document.getElementById('create-form');

            //     form.addEventListener('input', function (event) {
            //         if (event.target && event.target.name === 'vente[0][quantity]') {
            //             const quantityInput = event.target;
            //             const productSelect = quantityInput.closest('[data-repeater-item]').querySelector('select[name="vente[0][product_id]"]');
            //             const selectedOption = productSelect.options[productSelect.selectedIndex];
            //             const productId = selectedOption ? selectedOption.value : null;
            //             let quantityError = quantityInput.closest('.form-group').querySelector('.quantity-error');

            //             // Si le span d'erreur n'existe pas, le créer
            //             if (!quantityError) {
            //                 quantityError = document.createElement('span');
            //                 quantityError.classList.add('quantity-error', 'text-danger');
            //                 quantityError.style.display = 'none';
            //                 quantityInput.parentNode.appendChild(quantityError);
            //             }

            //             if (productId) {

            //                 var route = '{{ route("product.quantity" , ":id" ) }}'
            //                     route = route.replace(":id",productId)

            //                     fetch(route, {
            //                         method: 'GET',
            //                     })
            //                     .then(response => response.json())
            //                     .then(data => {
            //                         const availableStock = data.quantity;
            //                         if (quantityInput.value > availableStock) {
            //                             console.log('Route générée :', route);
            //                             quantityError.textContent = `Quantité insuffisante. Disponible : ${availableStock}`;
            //                             quantityError.style.display = 'block';
            //                         } else {
            //                             quantityError.style.display = 'none';
            //                         }
            //                     })
            //                     .catch((error) => {
            //                         console.log(error)
            //                     });

            //             }
            //         }
            //     });

            // });

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

            repeater_bloc(["#create-form"])

        </script>

    @endsection
--}}






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
            <form action="{{ route('ventes.store') }}" method="POST" id="create-form">
                @csrf

                <div class="form-group pt-2 text-end">
                    <h6>
                        <label class="bg-primary p-2 text-white">
                            Prix Total: <span id="total_general">0.00 FCFA</span>
                        </label>
                    </h6>
                </div>

                <div data-repeater-list="vente">
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
                                    <select class="form-select @error('product_id') is-invalid @enderror"
                                            name="product_id"
                                            onchange="get_price_unit(this)">
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
                                        <input type="number"
                                                class="form-control @error('achat.*.unit_price') is-invalid @enderror"
                                                id="unit_price"
                                                name="achat[0][unit_price]"
                                                placeholder="Ex : 5000"
                                                oninput="total(this)">
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
                                        <input type="number"
                                                min="0"
                                                step="1"
                                                class="form-control @error('achat.*.quantity') is-invalid @enderror"
                                                id="quantity" name="achat[0][quantity]"
                                                placeholder="Ex : 10"
                                                oninput="total(this)">
                                        @error('achat.*.quantity')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="groupe_ventes_id">Choisissez le groupe</label>
                                    <select class="form-select
                                            @error('groupe_ventes_id') is-invalid @enderror"
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

                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="date_achat">Total</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control @error('achat.*.total_vente') is-invalid @enderror"
                                                id="total_vente"
                                                name="achat[0][total_vente]"
                                                readonly>
                                        @error('achat.*.total_vente')
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

        var total_general = 0;

        function total(element){

            var parentRow = $(element).closest('.row');
            var unitPrice = parentRow.find('input[name*="[unit_price]"]').val() ?? 0;
            var quantity = parentRow.find('input[name*="[quantity]"]').val() ?? 0;
            var total = unitPrice * quantity;
            parentRow.find('input[name*="[total_vente]"]').val(total);
            total_general = parseInt(total_general) + parseInt(total)
            // console.log(total_general)
            $('#total_general').html(total_general+" F CFA")
        }

        function get_price_unit(element){

            var product_id = $(element).val()
            var route = "{{ route('product.price' , ':id') }}"
                route = route.replace(':id' , product_id)

            $.ajax({
                type: "GET",
                url: route,
                success: function(data) {

                    var parentRow = $(element).closest('.row');
                    parentRow.find('input[name*="[unit_price]"]').val(data.price);
                    total(element)

                },
                error: function(err){
                    console.log(err)
                }
            });

        }

    </script>

@endsection
