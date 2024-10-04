@extends('partials.master')

@section('content')

    @include('components.header',[
        'title' => " Inventaires",
        'back'   => [
            'label' => 'liste des ventes',
            'url'   => route('ventes.index'),
        ],
    ])

<form method="GET" action="{{ route('inventaires.index2') }}">
    <div class="d-flex justify-content-center">
        <div class="col-lg-3">
            <div class="form-group text-center">
                <label class="form-label" for="sites_id">Filtrer par site</label>
                <select class="form-select js-select2 @error('sites_id') is-invalid @enderror"
                        name="sites_id"
                        id="sites_id"
                        data-search="on"
                        data-placeholder="Choisissez le site"
                        onchange="this.form.submit()">
                    
                    @if (Auth::user()->status == 'super_admin' || Auth::user()->status == 'admin')
                        <option value="all" {{ $sites_id == 'all' ? 'selected' : '' }}>TOUT</option>
                        @foreach ($sites as $site)
                            <option value="{{ $site->id }}" {{ $sites_id == $site->id ? 'selected' : '' }}>
                                {{ $site->name }}
                            </option>
                        @endforeach
                    @else
                        <option value="{{ Auth::user()->sites_id }}">
                            {{ Auth::user()->site->name }}
                        </option>
                    @endif
                </select>
                @error('sites_id')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</form>


 
<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
        </div>
    </div>
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <table class="datatable-init-export nowrap table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix d'achat</th>
                        <th>Quantité vendue</th>
                        <th>Quantité restante</th>
                        <th>Date d'achat</th>
                        <th>Recette</th>
                    </tr>
                </thead>
                <tbody>
                                @if($inventaire->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Aucun produit trouvé pour ce site.</td>
                    </tr>
                @else
                    @foreach ($inventaire as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ number_format($item->prix_achat, 2) }} fcfa</td>
                            <td>{{ $item->qte_vendue }}</td>
                            <td>{{ $item->qte_restante }}</td>
                            <td>{{ date('d-m-Y', strtotime($item->date_achat)) }}</td>
                            <td>{{ number_format($item->recette, 2) }} fcfa</td>
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>
    </div>
</div>




    @endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.0/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.print.min.js"></script>
    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>
    <script src="./assets/js/repeater/jquery.repeater.min.js"></script>

    

    <script>
            
            $(document).ready(function() {
            var table = $('.datatable-init-export').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: 'Copier'
                    },
                    {
                        extend: 'csv',
                        text: 'Exporter CSV'
                    },
                    {
                        extend: 'excel',
                        text: 'Exporter Excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'Exporter PDF'
                    },
                    {
                        extend: 'print',
                        text: 'Imprimer'
                    }
                ],
                responsive: true,
                paging: false, // Désactiver la pagination
                lengthMenu: [10, 25, 50, 100], // Options de pagination (conservées pour le contrôle de l'affichage)
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/French.json'
                }
            });
        });

    </script>

@endsection
