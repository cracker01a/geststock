@extends('partials.master')

@section('styles')

    <link rel="stylesheet" type="text/css" href="{!! asset('/assets/css/tables/datatable/buttons.bootstrap4.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/assets/css/tables/datatable/dataTables.bootstrap4.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/assets/css/tables/datatable/responsive.bootstrap4.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/assets/css/tables/datatable/rowGroup.bootstrap4.min.css') !!}">

@endsection

@section('content')

@if (Auth::user()->status == 'super_admin' || Auth::user()->status == 'admin')
    @include('components.header', [
        'title' => 'Liste des achats',
    ])
@else
    @include('components.header', [
        'title' => 'Liste des achats',
        'btn'   => [
            'label' => 'Ajouter',
            'url'   => route('achat.create'),
        ],
    ])
@endif

<div class="d-flex justify-content-center">
        <div class="col-lg-3">
            <div class="form-group text-center">
                <label class="form-label" for="sites_id">Filtrer par site</label>
                <select class="form-select js-select2 @error('sites_id') is-invalid @enderror"
                        name="sites_id"
                        id="sites_id"
                        data-search="on"
                        data-placeholder="Choisissez le site"
                        onchange="load_table()">
                        
                    @if (Auth::user()->status == 'super_admin' || Auth::user()->status == 'admin')

                        <option value="all">TOUT</option>
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
    </div>


<table class="datatable-init nowrap nk-tb-list is-separate" data-auto-responsive="false">
    <thead>
        <tr class="nk-tb-item nk-tb-head">
            <th class="nk-tb-col tb-col-sm"><span>Name</span></th>
            <th class="nk-tb-col"><span>Prix Unitaire</span></th>
            <th class="nk-tb-col"><span>Quantité</span></th>
            <th class="nk-tb-col"><span>Prix Total</span></th>
            <th class="nk-tb-col"><span>Utilisateur</span></th>
            <th class="nk-tb-col"><span>Actif</span></th>
            <th class="nk-tb-col"><span></span></th>
            <th class="nk-tb-col nk-tb-col-tools">Actions</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($achats as $achat)

            <tr class="nk-tb-item">
                <td class="nk-tb-col tb-col-sm">
                    <span class="tb-product">
                        <span class="title">
                        {{ $achat->product->name }}
                        </span>
                    </span>
                </td>
                <td class="nk-tb-col">
                    <span class="tb-lead">
                        {{ number_format($achat->unit_price, 0, '', ' ') }} F CFA
                    </span>
                </td>
                <td class="nk-tb-col">
                    <span class="tb-sub">
                        {{ $achat->quantity }}
                    </span>
                </td>
                <td class="nk-tb-col">
                    <span class="tb-lead">
                        {{ number_format($achat->unit_price * $achat->quantity, 0, '', ' ') }} F CFA
                    </span>
                </td>

                <td class="nk-tb-col">
                    <span class="tb-sub">
                        @if($achat->user)
                            {{ $achat->user->lastname . ' ' . $achat->user->firstname }}
                        @else
                            Utilisateur non trouvé
                        @endif
                    </span>
                </td>
                <td class="nk-tb-col">

                @if ($achat->status)
                    <span class="dot bg-success d-sm-none"></span>
                    <span class="badge badge-sm badge-dot has-bg bg-success d-none d-sm-inline-flex">validé</span>
                @else
                    <span class="dot bg-danger d-sm-none"></span>
                    <span class="badge badge-sm badge-dot has-bg bg-danger d-none d-sm-inline-flex">Non validé</span>
                @endif

                </td>
                <td class="nk-tb-col nk-tb-col-tools">
                    <li class="me-n1">
                        <a href="#" class="btn btn-icon" data-bs-toggle="modal" data-bs-target="#modal-{{ $achat->id }}">
                            <em class="icon ni ni-eye"></em>
                        </a>
                    </li>
                </td>
                <td class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-1 my-n1">
                        <li class="me-n1">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                    <em class="icon ni ni-more-h"></em>
                                </a>
                                @if ($achat->status)
                                            <!-- Si l'achat est validé, afficher l'option pour le désactiver -->

                                        @else
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <!-- Option Modifier -->


                                                <!-- Option Valider / Non Valider -->

                                                    <li>
                                                        <a href="{{ route('achat.edit', $achat) }}">
                                                            <em class="icon ni ni-edit"></em>
                                                            <span>Modifier</span>
                                                        </a>
                                                    </li>
                                                    <!-- Si l'achat n'est pas validé, afficher l'option pour le valider -->
                                                    <li>
                                                        <a href="{{ route('achat.enabled', $achat->id) }}">
                                                            <em class="icon ni ni-activity-round"></em>
                                                            <span>Valider</span>
                                                        </a>
                                                    </li>
                                                    <!-- Option Supprimer (Visible uniquement si non validé) -->
                                                    <li>
                                                        <a href="{{ route('achat.delete', $achat->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $achat->id }}').submit();">
                                                            <em class="icon ni ni-trash"></em>
                                                            <span>Supprimer</span>
                                                        </a>
                                                        <form id="delete-form-{{ $achat->id }}" action="{{ route('achat.delete', $achat->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </li>
                                @endif
                                            </ul>
                                        </div>
                            </div>
                        </li>
                    </ul>
                </td>

            </tr>

            <div class="modal fade" id="modal-{{ $achat->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $achat->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel{{ $achat->id }}">Détails de l'achat</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Produit :</strong> {{ $achat->product->name }}</p>
                            <p><strong>Prix unitaire :</strong> {{ number_format($achat->unit_price, 0, '', ' ') }} F CFA</p>
                            <p><strong>Quantité :</strong> {{ $achat->quantity }}</p>
                            <p><strong>Montant total :</strong> {{ number_format($achat->unit_price * $achat->quantity, 0, '', ' ') }} F CFA</p>
                            <p><strong>Utilisateur :</strong> {{ $achat->user ? $achat->user->lastname . ' ' . $achat->user->firstname : 'Utilisateur non trouvé' }}</p>
                            <p><strong>Status :</strong> {{ $achat->status ? 'Validé' : 'Non validé' }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </tbody>
</table>


@endsection

@section('scripts')

    {{-- <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script> --}}

    <script src="{!! asset('/assets/js/tables/datatable/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('/assets/js/tables/datatable/datatables.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('/assets/js/tables/datatable/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! asset('/assets/js/tables/datatable/responsive.bootstrap4.js') !!}"></script>

    <script src="{!! asset('/assets/js/tables/datatable/datatables.buttons.min.js') !!}"></script>
    <script src="{!! asset('/assets/js/tables/datatable/buttons.html5.min.js') !!}"></script>
    <script src="{!! asset('/assets/js/tables/datatable/buttons.print.min.js') !!}"></script>
    <script src="{!! asset('/assets/js/tables/datatable/dataTables.rowGroup.min.js') !!}"></script>

    <script src="{!! asset('/assets/js/tables/datatable/jszip.min.js') !!}"></script>
    <script src="{!! asset('/assets/js/tables/datatable/pdfmake.min.js') !!}"></script>
    <script src="{!! asset('/assets/js/tables/datatable/vfs_fonts.js') !!}"></script>
    <script src="{!! asset('/assets/js/tables/datatable/datatables.checkboxes.min.js') !!}"></script>

    @include('achat.js.index')
    <script>
        $(document).ready(function() {
            // search_product()
        });
        function search_achat(){
            // var sites_id = $('#sites_id').val()
            // var route = "{{ route('achat.index').'?site=:sites_id' }}"
            //     route = route.replace(":sites_id" , sites_id)
            //     console.log(route)
            // window.location.href = route
        }
    </script>

@endsection
