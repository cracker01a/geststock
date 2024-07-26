@extends('partials.master')

@section('content')

                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">listes des sites</h3>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li>
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-right">
                                                                    <em class="icon ni ni-search"></em>
                                                                </div>
                                                                <input type="text" class="form-control" id="default-04" placeholder="Quick search by id">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle dropdown-indicator btn btn-outline-light btn-white" data-bs-toggle="dropdown">Status</a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><span>New Items</span></a></li>
                                                                        <li><a href="#"><span>Featured</span></a></li>
                                                                        <li><a href="#"><span>Out of Stock</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="nk-block-tools-opt">
                                                            <a href="#" data-target="addProduct" class="toggle btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                                                            <a href="#" data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Ajouter un site</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card">
                                        <div class="card-inner-group">
                                            <div class="card-inner p-0">
                                                <div class="nk-tb-list">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <div class="nk-tb-col tb-col-sm"><span>Nom</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span>Adresse</span></div>
                                                        <div class="nk-tb-col"><span>Statut</span></div>
                                                        <div class="nk-tb-col"><span>Action</span></div>
                                                    </div><!-- .nk-tb-item -->
                                                    
                                                    @foreach ($sites as $site)
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <span class="tb-product">
                                                                <span class="title">{{ $site->name }}</span>
                                                            </span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <span class="tb-sub">{{ $site->address }}</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <div class="status-indicator">
                                                                <!-- Actif -->
                                                                <div class="status-item {{ $site->status === 'actif' ? 'active' : '' }}" title="Actif">
                                                                    <span class="icon ni ni-check-circle"></span>
                                                                </div>
                                                                <!-- Inactif -->
                                                                <div class="status-item {{ $site->status === 'inactif' ? 'inactive' : '' }}" title="Inactif">
                                                                    <span class="icon ni ni-ban"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <select class="form-control form-control-sm" onchange="updateStatus({{ $site->id }}, this.value)">
                                                                <option value="actif" {{ $site->status === 'actif' ? 'selected' : '' }}>Activer</option>
                                                                <option value="inactif" {{ $site->status === 'inactif' ? 'selected' : '' }}>Désactiver</option>
                                                            </select>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-md">
                                                            <ul class="nk-tb-actions gx-1 my-n1">
                                                                <li class="me-n1">
                                                                    <div class="dropdown">
                                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li><a href="{{ route('sites.edit', $site->id) }}"><em class="icon ni ni-edit"></em><span>Edit Site</span></a></li>
                                                                                <li>
                                                                                    <form action="{{ route('sites.destroy', $site->id) }}" method="POST">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" class="dropdown-item"><em class="icon ni ni-trash"></em><span>Remove Site</span></button>
                                                                                    </form>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div><!-- .nk-tb-item -->
                                                    @endforeach
                                                    
                                                </div><!-- .nk-tb-list -->
                                            </div>
                                            <div class="card-inner">
                                                <div class="nk-block-between-md g-3">
                                                    <div class="g">
                                                        {{ $sites->links() }}
                                                    </div>
                                                </div><!-- .nk-block-between -->
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                           
<!-- .nk-block -->
                                <div class="nk-add-product toggle-slide toggle-slide-right" data-content="addProduct" data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true" data-simplebar>
                                    <form action="{{ route('sites.store') }}" method="POST">
                                        @csrf
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h5 class="nk-block-title">Nouveau site</h5>
                                                <div class="nk-block-des">
                                                    <p>Ajouter les informations du nouveau site.</p>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head -->
                                        <div class="nk-block">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name">Nom du site</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="name" name="name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address">Adresse du site</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="address" name="address" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="status">Statut du Site</label>
                                                        <div class="form-control-wrap">
                                                            <select class="form-control" id="status" name="status" required>
                                                                <option value="actif">Activer le site</option>
                                                                <option value="inactif">Désactiver le site</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Ajouter</span></button>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block -->
                                    </form>
                                </div>

                           

                            </div>
                        </div>
                    </div>
                </div>     
                                <script>
                                     function updateStatus(siteId, status) {
                                            fetch(`/sites/${siteId}`, {
                                                method: 'PUT',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({ status: status })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    location.reload();
                                                } else {
                                                    alert('Erreur lors de la mise à jour du statut');
                                                }
                                            })
                                            .catch(error => console.error('Error:', error));
                                        }

                                        function updateStatus(id, status) {
                                            fetch(`/sites/${id}/status`, {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({ status: status })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    location.reload();
                                                } else {
                                                    alert('Erreur lors de la mise à jour du statut');
                                                }
                                            })
                                            .catch(error => console.error('Error:', error));
                                        }
                                   

                                </script>     
                                                    <style>
                                                        .status-indicator {
                                                                        display: flex;
                                                                        align-items: center;
                                                                    }

                                                                    .status-item {
                                                                        width: 20px;
                                                                        height: 20px;
                                                                        border-radius: 50%;
                                                                        display: flex;
                                                                        align-items: center;
                                                                        justify-content: center;
                                                                        margin-right: 10px;
                                                                        font-size: 16px;
                                                                        cursor: pointer;
                                                                    }

                                                                    .status-item.active {
                                                                        background-color: green;
                                                                        color: white;
                                                                    }

                                                                    .status-item.inactive {
                                                                        background-color: red;
                                                                        color: white;
                                                                    }

                                                                    .status-item span {
                                                                        color: inherit; /* inherits color from the parent */
                                                                    }

                                                    </style>
@endsection