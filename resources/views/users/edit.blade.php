@extends('partials.master')

@section('content')

@include('components.header', [
    'title' => "Modification de l'utilisateur « ".$user->firstname." »",
    'back'   => [
        'label' => 'Liste des utilisateurs',
        'url'   => route('users.index'),
    ],
])

<div class="card">
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row py-3">
                <!-- Prénom -->
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label" for="firstname">Prénom</label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname', $user->firstname) }}" placeholder="Ex : Jean">
                        @error('firstname')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Nom -->
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label" for="lastname">Nom</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}" placeholder="Ex : Dupont">
                        @error('lastname')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Ex : email@example.com">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Statut -->
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label" for="status">Statut</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="" disabled selected>-- Sélectionnez un statut --</option>
                            <option value="admin" {{ old('status', $user->status) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super_admin" {{ old('status', $user->status) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                        @error('status')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Actif -->
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label" for="isActive">Actif</label>
                        <select class="form-control @error('isActive') is-invalid @enderror" id="isActive" name="isActive">
                            <option value="1" {{ old('isActive', $user->isActive) == '1' ? 'selected' : '' }}>Oui</option>
                            <option value="0" {{ old('isActive', $user->isActive) == '0' ? 'selected' : '' }}>Non</option>
                        </select>
                        @error('isActive')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-3 text-center">
                <button type="submit" class="btn btn-md btn-primary" title="Mettre à jour l'utilisateur">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script src="./assets/js/libs/datatable-btns.js?ver=3.2.3"></script>
@endsection
