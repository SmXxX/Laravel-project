<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
    ];


    public function scopeFilter($query, array $filters){
        if($filters['search'] ?? false){
            $query->where('name', 'like', '%' . request('search') . '%')
            ->orWhere('phone_number', 'like', '%' . request('search') . '%');
        }
    }
    
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
