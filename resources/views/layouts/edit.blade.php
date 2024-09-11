@extends('partials.master')

@section('content')

<div class="nk-block" style="margin-top: 50px;">
    <div class="card">
        <div class="card-inner">
            <h4 class="card-title">Edit Site</h4>
            <form action="{{ route('sites.update', $site->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $site->name }}" required>
                </div>
                <div class="form-group">
                    <label for="address">Adresse</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ $site->address }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Statut</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="actif" {{ $site->status == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ $site->status == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Site</button>
            </form>
        </div>
    </div>
</div>

@endsection