<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class achat extends Model
{
    use HasFactory;
   

    protected $table = 'achats'; 
    protected $primaryKey = 'id'; 

   
    protected $fillable = [
        'site_id', 'product_id', 'quantity', 'users_id', 'unit_price', 'total_price','numero_achat', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    // Calcule automatiquement le prix total
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;

        // Vérifier si unit_price est défini avant de calculer total_price
        if (isset($this->attributes['unit_price'])) {
            $this->attributes['total_price'] = $this->attributes['unit_price'] * $value;
        }
    }

    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = $value;

        // Vérifier si quantity est défini avant de calculer total_price
        if (isset($this->attributes['quantity'])) {
            $this->attributes['total_price'] = $value * $this->attributes['quantity'];
        }
    }
    
}
