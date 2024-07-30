@extends('partials.master')

@section('content')

@include('components.header', [
    'title' => 'Liste des achats',
    'btn'   => [
        'label' => 'Ajouter',
        'url'   => route('achat.create'),
    ],
])

<table class="datatable-init nowrap nk-tb-list is-separate" data-auto-responsive="false">
    <thead>
        <tr class="nk-tb-item nk-tb-head">
            <th class="nk-tb-col tb-col-sm"><span>Nom</span></th>
            <th class="nk-tb-col"><span>Prix Unitaire</span></th>
            <th class="nk-tb-col"><span>Quantité</span></th>
            <th class="nk-tb-col"><span>Prix Total</span></th>
            
            <th class="nk-tb-col"><span>Utilisateur</span></th>
            <th class="nk-tb-col"><span>Actif</span></th>
            <th class="nk-tb-col nk-tb-col-tools">Actions</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($achats as $achat)

            <tr class="nk-tb-item">
                <td class="nk-tb-col tb-col-sm">
                    <span class="tb-product">
                        <span class="title">
                            {{ $achat->designation }}
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

        @endforeach
    </tbody>
</table>


@endsection

@section('scripts')

    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>

@endsection
