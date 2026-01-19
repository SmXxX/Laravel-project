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

    /**
     * Get the user that owns the client profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all repairs for this client through their cars.
     */
    public function repairs()
    {
        return Repair::whereIn('car_id', $this->cars()->pluck('id'));
    }
}
