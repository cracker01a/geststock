<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupeAchat extends Model
{
    use HasFactory;

    protected $table = 'groupe_achats';
    protected $guarded = ['id'];

    public function achat()
    {
        return $this->hasMany(Achat::class, 'groupe_achats_id' , 'id');
    }
}
