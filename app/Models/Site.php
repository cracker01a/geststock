<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relationships
     */

    public function users(){
        return $this->hasMany(User::class, 'sites_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'products_id' , 'id');
    }

    public function achat()
    {
        return $this->hasMany(Achat::class, 'sites_id' , 'id');
    }

    public function vente()
    {
        return $this->hasMany(Vente::class, 'sites_id' , 'id');
    }
    
}
