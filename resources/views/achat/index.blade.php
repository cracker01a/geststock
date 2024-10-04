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


    <table class="nowrap nk-tb-list is-separate table"
            data-auto-responsive="true"
            id="achat_table">

        <thead>
            <tr class="nk-tb-item nk-tb-head">
                <th class="nk-tb-col tb-col-sm"><span>N°</span></th>
                <th class="nk-tb-col tb-col-sm"><span>Num</span></th>
                <th class="nk-tb-col tb-col-sm"><span>Name</span></th>
                <th class="nk-tb-col"><span>Prix Unitaire</span></th>
                <th class="nk-tb-col"><span>Quantité</span></th>
                <th class="nk-tb-col"><span>Prix Total</span></th>
                <th class="nk-tb-col"><span>Date</span></th>
                <th class="nk-tb-col"><span>Utilisateur</span></th>
                <th class="nk-tb-col"><span>Actif</span></th>
                <th class="nk-tb-col nk-tb-col-tools">Actions</th>
            </tr>
        </thead>

        <tbody></tbody>

    </table>


@endsection

@section('scripts')

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

@endsection
