<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'price'
    ];

    public $sortable = ['id', 'name', 'price'];

    protected $hidden = [];
    public $timestamps = false;

    public function invoiceDetail() {
        return $this->hasOne(InvoiceDetails::class, 'product_id', 'id');
    }
}
