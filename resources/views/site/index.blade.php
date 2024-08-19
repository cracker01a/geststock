@extends('partials.master')

@section('content')


    @include('components.header' , [
        'title'     => 'Liste des sites',
        'btn'   => [
            'label' => 'Ajouter',
            'url'   => route('site.create'),
        ],
    ])

    <table class="datatable-init nowrap nk-tb-list is-separate" data-auto-responsive="false">
        <thead>
            <tr class="nk-tb-item nk-tb-head">
                <th class="nk-tb-col tb-col-sm"><span>Nom</span></th>
                {{-- <th class="nk-tb-col"><span>Par</span></th> --}}
                <th class="nk-tb-col"><span>Date creation</span></th>
                <th class="nk-tb-col"><span>Actif</span></th>
                <th class="nk-tb-col nk-tb-col-tools">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($sites as $key => $site)

                <tr class="nk-tb-item">
                    <td class="nk-tb-col tb-col-sm">
                        <span class="tb-product">
                            <span class="title">
                                {{ $site->name }}
                            </span>
                        </span>
                    </td>
                    {{-- <td class="nk-tb-col">
                        <span class="tb-sub">
                            {{ $site->users->lastname.' '.$site->users->firstname }}
                        </span>
                    </td> --}}
                    <td class="nk-tb-col">
                        <span class="tb-sub">
                            {{ $site->created_at }}
                        </span>
                    </td>
                    <td class="nk-tb-col">

                        @if ($site->isActive)
                            <span class="dot bg-success d-sm-none"></span>
                            <span class="badge badge-sm badge-dot has-bg bg-success d-none d-sm-inline-flex">Active</span>
                        @else
                            <span class="dot bg-danger d-sm-none"></span>
                            <span class="badge badge-sm badge-dot has-bg bg-danger d-none d-sm-inline-flex">Désactivé</span>
                        @endif

                    </td>

                    <td class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li class="me-n1">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">

                                            <li>
                                                <a href="{{ route('site.edit' , $site) }}">
                                                    <em class="icon ni ni-edit"></em>
                                                    <span>Modifier</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('site.enabled' , $site->id) }}">
                                                    <em class="icon ni ni-activity-round"></em>
                                                    <span>
                                                        {{ $site->isActive ? 'Désactiver' : 'Activer' }}
                                                    </span>
                                                </a>
                                            </li>

                                            {{-- <li>
                                                <a href="#">
                                                    <em class="icon ni ni-trash"></em>
                                                    <span>Supprimer</span>
                                                </a>
                                            </li> --}}

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
