<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';
    protected $fillable = [
        'client_id',
        'image',
        'plate',
        'brand',
        'model',
        'year',
        'color',
        'engine',
        'hp',
        'kw',
        'fuel',
        'vin_num',
        'additional_info'
    ];

    //Relationship with client
     public function client(){
         return $this->hasMany(Client::class);
     }

     //Relationship with repair
     public function repair(){
        return $this->hasMany(Repair::class);
    }
}
