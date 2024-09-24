<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;

    // Define the fillable fields to allow mass assignment
    protected $fillable = ['country_id', 'amount'];

    // Relationship with the Country model
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
