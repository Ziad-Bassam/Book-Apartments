<?php

namespace App\Models;

use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'user_id',
        'apartment_id',
        'start_date',
        'end_date',
        'total_price', 
        'paid_amount',
        'status',
        'payment_status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function apartment(){
        return $this->belongsTo(Apartment::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    
}
