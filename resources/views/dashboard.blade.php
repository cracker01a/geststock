@extends('partials.master')

@section('content')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Dashboard</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <!-- <ul class="nk-block-tools g-3">
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span class="d-none d-md-inline">Last</span> 30 Days</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>Last 30 Days</span></a></li>
                                                            <li><a href="#"><span>Last 6 Months</span></a></li>
                                                            <li><a href="#"><span>Last 1 Years</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em class="icon ni ni-reports"></em><span>Reports</span></a></li>
                                        </ul> -->
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="card">
                                    <div class="nk-ecwg nk-ecwg6">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h6 class="title">Revenus Total</h6>
                                                </div>
                                            </div>
                                            <div class="data">
                                                <div class="data-group">
                                                    <div class="amount">{{ $totalRevenue }} Fcfa</div>
                                                    <div class="nk-ecwg6-ck">
                                                        <canvas class="ecommerce-line-chart-s3" id="todayOrders"></canvas>
                                                    </div>
                                                </div>
                                                <div class="info"><span class="change up text-danger"><em class="icon ni ni-arrow-long-up"></em>4.63%</span><span> vs. last week</span></div>
                                            </div>
                                        </div><!-- .card-inner -->
                                    </div><!-- .nk-ecwg -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-xxl-3 col-sm-6">
                                <div class="card">
                                    <div class="nk-ecwg nk-ecwg6">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h6 class="title">Prix Total des Ventes</h6>
                                                </div>
                                            </div>
                                            <div class="data">
                                                <div class="data-group">
                                                    <div class="amount">{{ $totalSales }} Fcfa</div>
                                                    <div class="nk-ecwg6-ck">
                                                        <canvas class="ecommerce-line-chart-s3" id="todayRevenue"></canvas>
                                                    </div>
                                                </div>
                                                <div class="info"><span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>2.34%</span><span> vs. last week</span></div>
                                            </div>
                                        </div><!-- .card-inner -->
                                    </div><!-- .nk-ecwg -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-xxl-3 col-sm-6">
                                <div class="card">
                                    <div class="nk-ecwg nk-ecwg6">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h6 class="title"> Ventes  </h6>
                                                </div>
                                            </div>
                                            <div class="data">
                                                <div class="data-group">
                                                    <div class="amount">{{ $todaySalesCount }}</div>
                                                    <div class="nk-ecwg6-ck">
                                                        <canvas class="ecommerce-line-chart-s3" id="todayCustomers"></canvas>
                                                    </div>
                                                </div>
                                                <div class="info"><span class="change up text-danger"><em class="icon ni ni-arrow-long-up"></em>4.63%</span><span> ventes effectués Aujourd'hui</span></div>
                                            </div>
                                        </div><!-- .card-inner -->
                                    </div><!-- .nk-ecwg -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-xxl-3 col-sm-6">
                                <div class="card">
                                    <div class="nk-ecwg nk-ecwg6">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h6 class="title">Revenus journalier</h6>
                                                </div>
                                            </div>
                                            <div class="data">
                                                <div class="data-group">
                                                    <div class="amount">{{ number_format($todayRevenue, 2) }} Fcfa</div>
                                                    <div class="nk-ecwg6-ck">
                                                        <canvas class="ecommerce-line-chart-s3" id="todayVisitors"></canvas>
                                                    </div>
                                                </div>
                                                <div class="info"><span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>2.34%</span><span> vs. last week</span></div>
                                            </div>
                                        </div><!-- .card-inner -->
                                    </div><!-- .nk-ecwg -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <!-- <div class="col-xxl-6">
                                <div class="card card-full">
                                    <div class="nk-ecwg nk-ecwg8 h-100">
                                        <div class="card-inner">
                                            <div class="card-title-group mb-3">
                                                <div class="card-title">
                                                    <h6 class="title">Sales Statistics</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown">Weekly</a>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <ul >
                                                <li>
                                                    <div class="title">
                                                        <span class="dot dot-lg sq" data-bg="#6576ff"></span>
                                                        <span>Total Sales</span>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="nk-ecwg8-ck">
                                                <canvas class="ecommerce-line-chart-s4" id="salesStatistics"></canvas>
                                            </div>
                                            <div class="chart-label-group ps-5">
                                                <div class="chart-label">Start Date</div>
                                                <div class="chart-label">End Date</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <script>
                                var ctx = document.getElementById('salesStatistics').getContext('2d');
                                var salesData = @json($salesData);

                                var labels = salesData.map(function(item) {
                                    return item.date;
                                });

                                var totalSalesData = salesData.map(function(item) {
                                    return item.total_sales;
                                });

                                var chart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Total Sales',
                                            backgroundColor: '#6576ff',
                                            borderColor: '#6576ff',
                                            data: totalSalesData,
                                            fill: false,
                                            borderWidth: 2,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                title: {
                                                    display: true,
                                                    text: 'Total Sales (Fcfa)',
                                                },
                                                ticks: {
                                                    callback: function(value) {
                                                        return value >= 1000000 ? (value / 1000000) + 'M' : value >= 100000 ? (value / 1000) + 'K' : value;
                                                    },
                                                    // Customize the tick values
                                                    stepSize: 100000, // Adjust step size as needed
                                                }
                                            },
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Dates',
                                                }
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        return context.dataset.label + ': ' + context.raw.toLocaleString() + ' Fcfa';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>

<!-- .col -->
                            <div class="col-xxl-3 col-md-6">
                                <div class="card card-full overflow-hidden">
                                    <div class="nk-ecwg nk-ecwg7 h-100">
                                        <div class="card-inner flex-grow-1">
                                            <div class="card-title-group mb-4">
                                                <div class="card-title">
                                                    <h6 class="title"> Statistics</h6>
                                                </div>
                                            </div>
                                            <div class="nk-ecwg7-ck">
                                                <canvas  id="orderStatistics"></canvas>
                                            </div>
                                            <ul class="nk-ecwg7-legends">
                                                <li>
                                                    <div class="title">
                                                        <span class="dot dot-lg sq" data-bg="#816bff"></span>
                                                        <span>Ventes</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">
                                                        <span class="dot dot-lg sq" data-bg="#13c9f2"></span>
                                                        <span>Achats</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">
                                                        <span class="dot dot-lg sq" data-bg="#ff82b7"></span>
                                                        <span>Bénéfices</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div><!-- .card-inner -->
                                    </div>
                                </div><!-- .card -->
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                var ctx = document.getElementById('orderStatistics').getContext('2d');
                                var myDoughnutChart = new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: ['Ventes', 'Achats', 'Bénéfices'],
                                        datasets: [{
                                            data: [{{ $pourcentageVentes }}, {{ $pourcentageAchats }}, {{ $pourcentageBenefices }}],
                                            backgroundColor: ['#816bff', '#13c9f2', '#ff82b7'],
                                            borderColor: ['#816bff', '#13c9f2', '#ff82b7'],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        legend: {
                                            display: false
                                        }
                                    }
                                });
                            </script>
<!-- .col -->
                            <div class="col-xxl-3 col-md-6">
                                <div class="card h-100">
                                    <div class="card-inner">
                                        <div class="card-title-group mb-2">
                                            <div class="card-title">
                                                <h6 class="title">Bilan Statistics</h6>
                                            </div>
                                        </div>
                                        <ul class="nk-store-statistics">
                                            <li class="item">
                                                <div class="info">
                                                    <div class="title">Nombre de sites</div>
                                                    <div class="count">{{ $totalSites }}</div>
                                                </div>
                                                <em class="icon bg-primary-dim ni ni-bag"></em>
                                            </li>
                                            <li class="item">
                                                <div class="info">
                                                    <div class="title">Nombre de vendeurs</div>
                                                    <div class="count">{{ $totalVendors }}</div>
                                                </div>
                                                <em class="icon bg-info-dim ni ni-users"></em>
                                            </li>
                                            <li class="item">
                                                <div class="info">
                                                    <div class="title">Nbre total des produits</div>
                                                    <div class="count">{{ $totalProducts }}</div>
                                                </div>
                                                <em class="icon bg-pink-dim ni ni-box"></em>
                                            </li>
                                            <li class="item">
                                                <div class="info">
                                                    <div class="title">Gestionnaire de produits</div>
                                                    <div class="count">{{ $totalProductManagers }}</div>
                                                </div>
                                                <em class="icon bg-purple-dim ni ni-server"></em>
                                            </li>
                                            <!-- Nouvelle section pour le produit le plus vendu -->
                                            <li class="item">
                                                <div class="info">
                                                    <div class="title"> Produit le plus vendu</div>
                                                    <div class="count">
                                                        @if($product)
                                                            {{ $product->name }} ({{ $mostSoldProduct->total_quantity }})
                                                        @else
                                                            No product sold
                                                        @endif
                                                    </div>
                                                </div>
                                                <em class="icon bg-success-dim ni ni-star"></em>
                                            </li>
                                        </ul>
                                    </div><!-- .card-inner -->
                                </div><!-- .card -->
                            </div>
<!-- .col -->
                            <div class="col-xxl-8">
                                <div class="card card-full">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Ventes Récentes</h6>
                                            </div>
                                        </div>
                                        <div class="nk-tb-list mt-n2">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span>Numéro de Vente</span></div>
                                                <div class="nk-tb-col tb-col-sm"><span>Vendeur</span></div>
                                                <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                                <div class="nk-tb-col"><span>Prix</span></div>
                                                <div class="nk-tb-col"><span>Status</span></div>
                                            </div>

                                            @foreach($ventes as $vente)
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span class="tb-lead"><a href="#">#{{ $vente->numero_vente }}</a></span>
                                                </div>
                                                <div class="nk-tb-col tb-col-sm">
                                                    <div class="user-card">
                                                        <div class="user-avatar sm bg-purple-dim">
                                                            <span>{{ strtoupper(substr($vente->user->firstname, 0, 1)) . strtoupper(substr($vente->user->lastname, 0, 1)) }}</span>
                                                        </div>
                                                        <div class="user-name">
                                                            <span class="tb-lead">{{ $vente->user->firstname }} {{ $vente->user->lastname }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">{{ $vente->created_at->format('d/m/Y') }}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="tb-sub tb-amount">{{ number_format($vente->price, 2) }} <span>Fcfa</span></span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="badge badge-dot badge-dot-xs bg-{{ $vente->status == 'Paid' ? 'success' : ($vente->status == 'Cancelled' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($vente->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div><!-- .card-inner -->
                                </div><!-- .card -->
                            </div>

                            
                        </div><!-- .row -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  

@endsection