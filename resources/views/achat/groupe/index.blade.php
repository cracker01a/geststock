@extends('partials.master')

@section('content')

@include('components.header', [
    'title' => "Liste des groupes d'achats",
    'btn'   => [
        'label' => 'Ajouter',
        'url'   => route('achat.groupe.create'),
    ],
])

<table class="datatable-init nowrap nk-tb-list is-separate" data-auto-responsive="false">
    <thead>
        <tr class="nk-tb-item nk-tb-head">
            <th class="nk-tb-col tb-col-sm"><span>N°</span></th>
            <th class="nk-tb-col tb-col-sm"><span>Name</span></th>
            <th class="nk-tb-col nk-tb-col-tools">Actions</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($group_achats as $key => $groupe)

            <tr class="nk-tb-item">

                <td class="nk-tb-col tb-col-sm">
                    <span class="tb-product">
                        <span class="title">
                        {{ ++$key }}
                        </span>
                    </span>
                </td>

                <td class="nk-tb-col tb-col-sm">
                    <span class="tb-product">
                        <span class="title">
                        {{ $groupe->name }}
                        </span>
                    </span>
                </td>
                <td class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-1 my-n1">
                        <li class="me-n1">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                    <em class="icon ni ni-more-h"></em>
                                </a>
                                {{-- @if ($achat->status)
                                            <!-- Si l'achat est validé, afficher l'option pour le désactiver -->

                                @else



                                @endif --}}

                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <!-- Option Modifier -->


                                        <!-- Option Valider / Non Valider -->

                                        <li>
                                            <a href="{{ route('achat.groupe.edit', $groupe) }}">
                                                <em class="icon ni ni-edit"></em>
                                                <span>Modifier</span>
                                            </a>
                                        </li>
                                        <!-- Si l'achat n'est pas validé, afficher l'option pour le valider -->
                                        {{-- <li>
                                            <a href="{{ route('achat.enabled', $achat->id) }}">
                                                <em class="icon ni ni-activity-round"></em>
                                                <span>Valider</span>
                                            </a>
                                        </li> --}}
                                        <!-- Option Supprimer (Visible uniquement si non validé) -->
                                        @if ($groupe->achat)
                                            <li>
                                                <a href="{{ route('achat.groupe.delete', $groupe->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $groupe->id }}').submit();">
                                                    <em class="icon ni ni-trash"></em>
                                                    <span>Supprimer</span>
                                                </a>
                                                <form id="delete-form-{{ $groupe->id }}" action="{{ route('achat.groupe.delete', $groupe->id) }}" method="POST" style="display: none;">
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
