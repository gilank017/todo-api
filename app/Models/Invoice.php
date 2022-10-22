<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $fillable = [
        'invoice_id',
        'user_id',
        'date',
        'status'
    ];
    protected $hidden = [];
    public $timestamps = false;
    

    public function users() {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }
}
