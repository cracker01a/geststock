@extends('partials.master')

@section('content')

@if (Auth::user()->status == 'super_admin' || Auth::user()->status == 'admin')
    @include('components.header', [
        'title' => "Liste des groupes de ventes",
    ])
@else
    @include('components.header', [
        'title' => "Liste des groupes de ventes",
        'btn'   => [
            'label' => 'Ajouter',
            'url'   => route('ventes.groupe_ventes.create'),
        ],
    ])
@endif

<table class="datatable-init nowrap nk-tb-list is-separate" data-auto-responsive="false">
    <thead>
        <tr class="nk-tb-item nk-tb-head">
            <th class="nk-tb-col tb-col-sm"><span>N°</span></th>
            <th class="nk-tb-col tb-col-sm"><span>Name</span></th>
            <th class="nk-tb-col tb-col-sm"><span></span></th>
            <th class="nk-tb-col nk-tb-col-tools">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($group_ventes as $key => $groupe)
            <tr class="nk-tb-item">
                <td class="nk-tb-col tb-col-sm">
                    <span class="tb-product">
                        <span class="title">{{ ++$key }}</span>
                    </span>
                </td>

                <td class="nk-tb-col tb-col-sm">
                    <span class="tb-product">
                        <span class="title">{{ $groupe->name }}</span>
                    </span>
                </td>

                <td class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-1 my-n1">
                        <li class="me-n1">
                            @if ($groupe->vente->isNotEmpty()) <!-- Vérifie si le groupe a des ventes -->
                                <a href="#" class="btn btn-icon" data-bs-toggle="modal" data-bs-target="#modal-{{ $groupe->id }}">
                                    <em class="icon ni ni-eye"></em>
                                </a>
                            @endif
                        </li>
                    </ul>
                </td>

                <td class="nk-tb-col nk-tb-col-tools">

                    @if (Auth::user()->status == 'stock_manager')

                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li class="me-n1">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                        <em class="icon ni ni-more-h"></em>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <a href="{{ route('ventes.groupe_ventes.edit', $groupe) }}">
                                                    <em class="icon ni ni-edit"></em>
                                                    <span>Modifier</span>
                                                </a>
                                            </li>
                                            @if ($groupe->vente)
                                                <li>
                                                    <a href="{{ route('ventes.groupe_ventes.destroy', $groupe->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $groupe->id }}').submit();">
                                                        <em class="icon ni ni-trash"></em>
                                                        <span>Supprimer</span>
                                                    </a>
                                                    <form id="delete-form-{{ $groupe->id }}" action="{{ route('ventes.groupe_ventes.destroy', $groupe->id) }}" method="POST" style="display: none;">
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

                    @endif

                </td>
            </tr>

            <!-- Modal pour afficher les détails des ventes -->
            <div class="modal fade" id="modal-{{ $groupe->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $groupe->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel{{ $groupe->id }}">Détails des Ventes - {{ $groupe->name }}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="accordion" id="accordion-{{ $groupe->id }}">
                                @foreach ($groupe->vente as $vente)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $vente->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $vente->id }}" aria-expanded="true" aria-controls="collapse{{ $vente->id }}">
                                                {{ $vente->product->name }} <!-- Titre de la vente -->
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $vente->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $vente->id }}" data-bs-parent="#accordion-{{ $groupe->id }}">
                                            <div class="accordion-body p-3">
                                                <div><strong>Numéro de vente :</strong> {{ $vente->numero_vente }}</div>
                                                <div><strong>Date de vente :</strong> {{ $vente->date_vente }}</div>
                                                <div><strong>Prix unitaire :</strong> {{ number_format($vente->price, 0, '', ' ') }} F CFA</div>
                                                <div><strong>Quantité :</strong> {{ $vente->quantity }}</div>
                                                <div><strong>Montant total :</strong> {{ number_format($vente->total_price, 0, '', ' ') }} F CFA</div>
                                                <div><strong>Site :</strong> {{ $vente->site->name }}</div>
                                                <div><strong>Utilisateur :</strong> {{ $vente->user ? $vente->user->lastname . ' ' . $vente->user->firstname : 'Utilisateur non trouvé' }}</div>
                                                <div><strong>Statut :</strong> {{ $vente->status ? 'Validé' : 'Non validé' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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

    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>

@endsection
