@extends('partials.master')

@section('styles')

    <link rel="stylesheet" type="text/css" href="{!! asset('/assets/css/tables/datatable/buttons.bootstrap4.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/assets/css/tables/datatable/dataTables.bootstrap4.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/assets/css/tables/datatable/responsive.bootstrap4.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/assets/css/tables/datatable/rowGroup.bootstrap4.min.css') !!}">

@endsection

@section('content')

    @if (Auth::user()->status == 'super_admin' || Auth::user()->status == 'admin')
        @include('components.header' , [
            'title'     => 'Liste des produits',
        ])
    @else
        @include('components.header' , [
            'title'     => 'Liste des produits',
            'btn'   => [
                'label' => 'Ajouter',
                'url'   => route('product.create'),
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

    <table class="nowrap nk-tb-list is-separate table"
            {{-- data-auto-responsive="false" --}}
            id="product_table">
        <thead>
            <tr class="nk-tb-item nk-tb-head">
                <th class="nk-tb-col tb-col-sm"><span>N°</span></th>
                <th class="nk-tb-col tb-col-sm"><span>Nom</span></th>
                <th class="nk-tb-col"><span>Prix</span></th>
                <th class="nk-tb-col"><span>Qte</span></th>
                <th class="nk-tb-col"><span>Par</span></th>
                <th class="nk-tb-col"><span>Date creation</span></th>
                <th class="nk-tb-col"><span>Actif</span></th>
                <th class="nk-tb-col nk-tb-col-tools">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>

            {{-- @foreach ($products as $key => $product)

                <tr class="nk-tb-item">
                    <td class="nk-tb-col tb-col-sm">
                        <span class="tb-product">
                            <span class="title">
                                {{ $product->name }}
                            </span>
                        </span>
                    </td>
                    <td class="nk-tb-col">
                        <span class="tb-lead">
                            {{ number_format( $product->price , 0 , '' , ' ') }} F CFA
                        </span>
                    </td>
                    <td class="nk-tb-col">
                        <span class="tb-lead">
                            {{ $product->quantity }}
                        </span>
                    </td>
                    <td class="nk-tb-col">
                        <span class="tb-sub">
                            {{ $product->users->lastname.' '.$product->users->firstname }}
                        </span>
                    </td>
                    <td class="nk-tb-col">
                        <span class="tb-sub">
                            {{ $product->created_at }}
                        </span>
                    </td>
                    <td class="nk-tb-col">

                        @if ($product->isActive)
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
                                                <a href="{{ route('product.edit' , $product) }}">
                                                    <em class="icon ni ni-edit"></em>
                                                    <span>Modifier</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('product.enabled' , $product->id) }}">
                                                    <em class="icon ni ni-activity-round"></em>
                                                    <span>
                                                        {{ $product->isActive ? 'Désactiver' : 'Activer' }}
                                                    </span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>

            @endforeach --}}

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

    @include('product.js.index')
    <script>
        $(document).ready(function() {
            // search_product()
        });
        function search_product(){
            // var sites_id = $('#sites_id').val()
            // var route = "{{ route('product.index').'?site=:sites_id' }}"
            //     route = route.replace(":sites_id" , sites_id)
            //     console.log(route)
            // window.location.href = route
        }
    </script>

@endsection
