<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });
    }
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function inStock()
    {
        return $this->hasMany(Stock::class)->where('type','in');
    }
    public function outStock()
    {
        return $this->hasMany(Stock::class)->where('type','out');
    }
}
