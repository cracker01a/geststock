@extends('partials.master')

@section('content')

    @if (Auth::user()->status == 'super_admin' || Auth::user()->status == 'admin')
        @include('components.header', [
            'title' => 'Liste des ventes',
        ])
    @else
        @include('components.header' , [
            'title'     => 'Liste des ventes',
            'btn'   => [
                'label' => 'Effectuer une vente',
                'url'   => route('ventes.create'),
            ],
        ])
    @endif

    <table class="datatable-init nowrap nk-tb-list is-separate" data-auto-responsive="false">

    <thead>
        <tr class="nk-tb-item nk-tb-head">
            <th class="nk-tb-col tb-col-sm"><span>Produit</span></th>
            <th class="nk-tb-col"><span>Site</span></th>
            <th class="nk-tb-col"><span>Quantité</span></th>
            <th class="nk-tb-col"><span>Prix Unitaire</span></th>
            <th class="nk-tb-col"><span>Prix Total</span></th>
            <th class="nk-tb-col"><span>Status</span></th>
            <th class="nk-tb-col"><span></span></th>
            <th class="nk-tb-col"><span>Date de Vente</span></th>
            <th class="nk-tb-col nk-tb-col-tools">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventes as $vente)
            <tr class="nk-tb-item">
                <td class="nk-tb-col tb-col-sm">
                    <span class="tb-product">
                        <span class="title">{{ $vente->product->name }}</span>
                    </span>
                </td>
                <td class="nk-tb-col">
                    <span class="tb-lead">{{ $vente->site->name }}</span>
                </td>
                <td class="nk-tb-col">
                    <span class="tb-sub">{{ $vente->quantity }}</span>
                </td>
                <td class="nk-tb-col">
                    <span class="tb-sub">{{ number_format($vente->price, 0, '', ' ') }} F CFA</span>
                </td>
                <td class="nk-tb-col">
                    <span class="tb-sub">{{ number_format($vente->total_price, 0, '', ' ') }} F CFA</span>
                </td>
                <td class="nk-tb-col">
                    @if ($vente->status === 'validée')
                        <span class="dot bg-success d-sm-none"></span>
                        <span class="badge badge-sm badge-dot has-bg bg-success d-none d-sm-inline-flex">Complété</span>
                    @else
                        <span class="dot bg-warning d-sm-none"></span>
                        <span class="badge badge-sm badge-dot has-bg bg-warning d-none d-sm-inline-flex">En Attente</span>
                    @endif
                </td>
                <td class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-1 my-n1">
                        <li class="me-n1">
                           
                            <a href="#" class="btn btn-icon" data-bs-toggle="modal" data-bs-target="#modal-{{ $vente->id }}">
                                <em class="icon ni ni-eye"></em>
                            </a>
                        </li>
                       
                    </ul>
                </td>
                <td class="nk-tb-col">
                    <span class="tb-sub">{{ $vente->vente_date }}</span>
                </td>
                <td class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-1 my-n1">
                        <li class="me-n1">
                             <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                    <em class="icon ni ni-more-h"></em>
                                </a>


                                        <!-- Action Valider -->
                                        @if ($vente->status === 'non validée')
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                            <li>
                                                <a href="{{ route('ventes.enabled', $vente->id) }}">
                                                    <em class="icon ni ni-activity-round"></em>
                                                    <span>Valider</span>
                                                </a>
                                            </li>
                                        @endif

                                        <!-- Action Modifier -->
                                        @if ($vente->status === 'non validée')
                                            <li>
                                                <a href="{{ route('ventes.edit', $vente->id) }}">
                                                    <em class="icon ni ni-edit"></em>
                                                    <span>Modifier</span>
                                                </a>
                                            </li>
                                        @endif

                                        <!-- Action Supprimer -->
                                        @if ($vente->status === 'non validée')
                                            <li>
                                                <form action="{{ route('ventes.delete', $vente->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn" >
                                                        <em class="icon ni ni-trash"></em>
                                                        <span>Supprimer</span>
                                                    </button>
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
            <!-- Modal pour afficher les détails -->
            <div class="modal fade" id="modal-{{ $vente->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $vente->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel{{ $vente->id }}">Détails de la vente</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Produit :</strong> {{ $vente->product->name }}</p>
                            <p><strong>Site :</strong> {{ $vente->site->name }}</p>
                            <p><strong>Quantité :</strong> {{ $vente->quantity }}</p>
                            <p><strong>Prix unitaire :</strong> {{ number_format($vente->price, 0, '', ' ') }} F CFA</p>
                            <p><strong>Montant total :</strong> {{ number_format($vente->total_price, 0, '', ' ') }} F CFA</p>
                            <p><strong>Date de vente :</strong> {{ $vente->vente_date }}</p>
                            <p><strong>Status :</strong> {{ $vente->status === 'validée' ? 'Complété' : 'En Attente' }}</p>
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
