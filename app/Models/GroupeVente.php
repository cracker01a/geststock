<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupeVente extends Model
{
    use HasFactory;

    protected $table = 'groupe_ventes';
    protected $guarded = ['id'];

    public function vente()
    {
        return $this->hasMany(Vente::class, 'groupe_ventes_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function achats()
    {
        return $this->hasMany(Achat::class, 'groupe_achats_id'); 
    }
    public function site()
    {
        return $this->belongsTo(Site::class, 'sites_id');
    }
    public function ventes() 
    {
        return $this->hasMany(Vente::class, 'groupe_ventes_id', 'id');
    }
}
