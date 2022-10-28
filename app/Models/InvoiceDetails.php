<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';
    // protected $primaryKey = 'invoice_id';
    public $incrementing = false;
    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
    ];
    protected $hidden = [
        // 'invoice_id',
        // 'product_id'
    ];
    public $timestamps = false;

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Products:: class, 'product_id', 'id');
    }
}
