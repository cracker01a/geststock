@extends('partials.master')

@section('content')

    @include('components.header' , [
        'title'     => 'Liste des utilisateurs',
        'btn'   => [
            'label' => 'ajouter des utilisateurs',
            'url'   => route('users.create'),
        ],
    ])


    <table class="datatable-init nowrap nk-tb-list is-separate" data-auto-responsive="false">
        <thead>
            <tr class="nk-tb-item nk-tb-head">
                <th class="nk-tb-col tb-col-sm"><span>Prénom</span></th>
                <th class="nk-tb-col"><span>Nom</span></th>
                <th class="nk-tb-col"><span>Statut</span></th>
                <th class="nk-tb-col"><span>Email</span></th>
                <th class="nk-tb-col"><span>Site</span></th>
                <th class="nk-tb-col"><span>Active</span></th>
                <th class="nk-tb-col nk-tb-col-tools">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="nk-tb-item">
                    <td class="nk-tb-col tb-col-sm">
                        <span class="tb-product">
                            <span class="title">{{ $user->firstname }}</span>
                        </span>
                    </td>
                    <td class="nk-tb-col">
                        <span class="tb-lead">{{ $user->lastname }}</span>
                    </td>
                    <td class="nk-tb-col">
                        <span class="tb-sub">{{ $user->status }}</span>
                    </td>
                    <td class="nk-tb-col">
                        <span class="tb-sub">{{ $user->email }}</span>
                    </td>
                    <td class="nk-tb-col">
                        <span class="tb-sub">{{ $user->site ? $user->site->name : "---"}}</span>
                    </td>
                    <td class="nk-tb-col">
                        <span class="tb-sub">{{ $user->isActive ? 'Oui' : 'Non' }}</span>
                    </td>
                    <td class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li class="me-n1">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                        <em class="icon ni ni-more-h"></em>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <!-- Action Modifier -->
                                            <li>
                                                <a href="{{ route('users.edit', $user->id) }}">
                                                    <em class="icon ni ni-edit"></em>
                                                    <span>Modifier</span>
                                                </a>
                                            </li>

                                            <!-- Action Supprimer -->
                                            <li>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn">
                                                        <em class="icon ni ni-trash"></em>
                                                        <span>Supprimer</span>
                                                    </button>
                                                </form>
                                            </li>
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


</div>


@endsection

@section('scripts')

    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>

@endsection
