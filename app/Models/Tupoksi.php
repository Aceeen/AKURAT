<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tupoksi extends Model
{
    protected $table = 'tupoksi';

    protected $fillable = ['user_id', 'nama_tupoksi', 'tahun'];

    // TAMBAHKAN INI:
    public function berkasKinerja()
    {
        return $this->hasMany(BerkasKinerja::class, 'tupoksi_id');
    }

    public function kriteria()
    {
        return $this->hasMany(KriteriaTupoksi::class, 'tupoksi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
