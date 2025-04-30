<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'country', 'status'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeSearch(Builder $query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', "%$search%");
        }
        return $query;
    }
}
