<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'achat_id', 'site_id', 'quantity', 'price', 'total_price', 'status', 'vente_date', 'numero_vente',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function achat()
    {
        return $this->belongsTo(Achat::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
