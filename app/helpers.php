<?php

use Illuminate\Support\Str;

if (!function_exists('generateUniqueNumber')) {
    function generateUniqueNumber($prefix, $model, $column)
    {
        do {
            $number = $prefix . strtoupper(Str::random(8));
        } while ($model::where($column, $number)->exists());

        return $number;
    }
    
}