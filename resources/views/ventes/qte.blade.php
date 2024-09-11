@extends('partials.master')

@section('content')

    @include('components.header',[
        'title' => " Quantity Products",
        'back'   => [
            'label' => 'liste des ventes',
            'url'   => route('ventes.index'),
        ],
    ])

<style>
    .blink-red {
  animation: blink 1s linear infinite;
  border: 4px solid red;
  padding: 5px; 
  display: inline-block; 
}

@keyframes blink {
  50% {
    opacity: 0;
  }
}
</style>
    <table class="nowrap nk-tb-list is-separate" id="vente_table">
    <thead>
        <tr class="nk-tb-item nk-tb-head">
            <th class="nk-tb-col tb-col-sm"><span>Produit</span></th>
            {{-- <th class="nk-tb-col"><span>Site</span></th> --}}
            <th class="nk-tb-col"><span>Prix</span></th>
            <th class="nk-tb-col"><span>Quantité</span></th>
            
            <th class="nk-tb-col"><span>MS</span></th>
            <th class="nk-tb-col"><span>Site</span></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr class="nk-tb-item">
                <td class="nk-tb-col tb-col-sm">{{ $product->name }}</td>
                <td class="nk-tb-col">{{ $product->price }}</td>
                <td class="nk-tb-col">{{ $product->quantity }}</td>
                
                <td class="nk-tb-col">
                    @if ($product->quantity <= 10)
                        <span class="blink-red" style="border: 2px solid red;">
                            Veuillez recharger le stock de ce produit sur le site 
                            @foreach ($sites as $site)
                                @if ($product->site_id == $site->id)
                                    {{ $site->name }}
                                @endif
                            @endforeach
                        </span>
                    @endif
                </td>
                <td class="nk-tb-col">{{ $product->site ? $product->site->name : 'Site non trouvé'  }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


    @endsection

@section('scripts')

    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>
    <script src="./assets/js/repeater/jquery.repeater.min.js"></script>

    <script>
        repeater_bloc(["#create-form"])
    </script>

@endsection
