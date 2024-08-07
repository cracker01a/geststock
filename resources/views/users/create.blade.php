@extends('partials.master')

@section('content')

    @include('components.header',[
        'title' => "Ajouter un utilisateur",
        'back'   => [
            'label' => 'Liste des Utilisateurs',
            'url'   => route('users.index'),
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST" id="create-form">
                @csrf

                <div data-repeater-list="user">
                    <div data-repeater-item>
                        <div class="row py-3">
                            <!-- Prénom -->
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="firstname">Prénom</label>
                                    <input type="text" class="form-control @error('user.*.firstname') is-invalid @enderror" id="firstname" name="user[0][firstname]" placeholder="Ex : Jean" value="{{ old('user.0.firstname') }}">
                                    @error('user.*.firstname')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nom -->
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="lastname">Nom</label>
                                    <input type="text" class="form-control @error('user.*.lastname') is-invalid @enderror" id="lastname" name="user[0][lastname]" placeholder="Ex : Dupont" value="{{ old('user.0.lastname') }}">
                                    @error('user.*.lastname')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control @error('user.*.email') is-invalid @enderror" id="email" name="user[0][email]" placeholder="Ex : email@example.com" value="{{ old('user.0.email') }}">
                                    @error('user.*.email')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Statut -->
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="status">Statut</label>
                                    <select class="form-control @error('user.*.status') is-invalid @enderror" id="status" name="user[0][status]">
                                        <option value="" disabled selected>-- Sélectionnez un statut --</option>
                                        <option value="admin" {{ old('user.0.status') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="super_admin" {{ old('user.0.status') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    </select>
                                    @error('user.*.status')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Actif -->
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="isActive">Actif</label>
                                    <select class="form-control @error('user.*.isActive') is-invalid @enderror" id="isActive" name="user[0][isActive]">
                                        <option value="1" {{ old('user.0.isActive') == '1' ? 'selected' : '' }}>Oui</option>
                                        <option value="0" {{ old('user.0.isActive') == '0' ? 'selected' : '' }}>Non</option>
                                    </select>
                                    @error('user.*.isActive')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-2 d-flex align-items-end">
                                <button type="button" class="btn btn-icon btn-md btn-danger" title="Retirer un utilisateur" data-repeater-delete>
                                    <em class="icon ni ni-minus"></em>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-3">
                    <button type="button" class="btn btn-icon btn-md btn-warning" title="Ajouter un utilisateur" data-repeater-create>
                        <em class="icon ni ni-plus"></em>
                    </button>
                </div>

                <div class="pt-3 text-center">
                    <button type="submit" class="btn btn-md btn-primary" title="Ajouter un utilisateur">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>
    <script src="./assets/js/repeater/jquery.repeater.min.js"></script>

    <script>
        repeater_bloc(["#create-form"])
    </script>
@endsection
