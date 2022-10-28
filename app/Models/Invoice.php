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
    protected $hidden = [
        'user_id'
    ];
    public $timestamps = false;
    

    public function users() {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

    public function items() {
        return $this->hasMany(InvoiceDetails::class, 'invoice_id', 'id');
    }
}
