<?php

use Illuminate\Support\Str;


if (!function_exists('generateUniqueNumber')) {
    function generateUniqueNumber($prefix, $model, $column)
    {
        do {
            $letters = strtoupper(Str::random(4)); // Générer 4 lettres
            $numbers = mt_rand(1000, 9999); // Générer 4 chiffres
            $number = $prefix . $letters . $numbers;
        } while ($model::where($column, $number)->exists());

        return $number;
    }
}