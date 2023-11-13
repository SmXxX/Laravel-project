<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $table = 'repairs';

    protected $fillable = [
        'car_id',
        'repair',
        'part',
        'kilometers',
        'work_cost',
        'part_cost',
    ];

    //Relationship with client
    public function car(){
        return $this->belongsTo(Car::class, 'car_id');
    }
}
