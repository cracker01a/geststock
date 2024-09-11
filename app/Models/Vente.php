<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vente extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'products_id', 'achats_id', 'sites_id', 'quantity', 'price', 'total_price', 'status', 'vente_date', 'numero_vente' , 'groupe_ventes_id' ,'users_id' ,
    // ];
    protected $guarded = ["id"];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

   

    public function site()
    {
        return $this->belongsTo(Site::class, 'sites_id');
    }
    public function groupeVente()
    {
        return $this->belongsTo(GroupeVente::class, 'groupe_ventes_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public static function getTotalSales()
    {
        return self::sum('total_price');
    }

    public static function getTotalRevenue()
    {
        return self::join('achats', 'ventes.products_id', '=', 'achats.products_id') // Jointure via products_id
                   ->select(DB::raw('SUM((ventes.price - achats.unit_price) * ventes.quantity) as total_revenue'))
                   ->value('total_revenue');
    }
    public function achat()
{
    return $this->belongsTo(Achat::class, 'products_id', 'id');
}
    


}
