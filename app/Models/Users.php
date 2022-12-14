<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'username',
        'address'
    ];
    protected $primaryKey = 'id';
    protected $hidden = [];
    public $timestamps = false;

    public function invoice() {
        return $this->hasOne(Invoice::class , 'user_id', 'id');
    }
}
