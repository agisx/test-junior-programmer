<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    /**
     *
     * @var string
     */
    protected $table = 'produk';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_produk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_produk',
        'harga',
        'kategori_id',
        'status_id',
    ];

    /**
     * Atribut untuk mendapatkan kategori
     * 
     */
    public function kategori() : BelongsTo {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }

    /**
     * Atribut untuk mendapatkan status
     * 
     */
    public function status() : BelongsTo {
        return $this->belongsTo(Status::class, 'status_id', 'id_status');
    }
}
