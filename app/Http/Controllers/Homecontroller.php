<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class Homecontroller extends Controller
{
    public function  index() {
        return view('layouts.dash');
    }

    public function  index1() {

        
        $sites = Site::all(); // Récupère tous les sites de la base de données
        $sites = Site::paginate(9);
        return view('layouts.sites', compact('sites'));
    }
}
