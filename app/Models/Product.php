<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relationships
     */

    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function achat()
    {
        return $this->hasMany(Achat::class, 'products_id' , 'id');
    }

    public function site(){
        return $this->belongsTo(Site::class, 'sites_id');
    }

}
