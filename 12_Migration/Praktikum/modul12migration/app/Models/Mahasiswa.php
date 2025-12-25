<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model 
{ 
    protected $table = 'mahasiswas'; 
 
    protected $fillable = [ 
        'nim', 
        'nama_lengkap', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'alamat', 
        'fakultas', 
        'jurusan', 
    ]; 
} 

