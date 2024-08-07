@extends('partials.master')

@section('content')

    @include('components.header' , [
        'title'     => 'Liste des ventes',
        'btn'   => [
            'label' => 'Effectuer une vente',
            'url'   => route('ventes.create'),
        ],
    ])


    <table class="datatable-init nowrap nk-tb-list is-separate" data-auto-responsive="false">
    
    <thead>
        <tr class="nk-tb-item nk-tb-head">
            <th class="nk-tb-col tb-col-sm"><span>Produit</span></th>
            <th class="nk-tb-col"><span>Site</span></th>
            <th class="nk-tb-col"><span>Quantité</span></th>
            <th class="nk-tb-col"><span>Prix Unitaire</span></th>
            <th class="nk-tb-col"><span>Prix Total</span></th>
            <th class="nk-tb-col"><span>Status</span></th>
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
        @endforeach
    </tbody>
</table>



@endsection

@section('scripts')

    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>

@endsection
