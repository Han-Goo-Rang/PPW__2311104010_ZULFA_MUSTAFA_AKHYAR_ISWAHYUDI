<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    //raw query insert
    public function index()
    {
        return 'Index untuk mahasiswa';
    }

    public function insertSql()
    {
        $result1 = DB::insert(" 
            INSERT INTO mahasiswas 
            (nim, nama_lengkap, tempat_lahir, tanggal_lahir, alamat, fakultas, 
            jurusan) 
            VALUES 
            ('20104065', 
            'Muhammad Nur Hamada', 
            'Bandung', 
            '2002-02-02', 
            'Jl. Contoh No. 123', 
            'Fakultas Informatika', 
            'Software Engineering')"
        );
        dump($result1);
    }

    public function insertQB() {
        $result2 = DB::table('mahasiswas')->insert([
             'nim'           => '20104070', 
            'nama_lengkap'  => 'Aulia Putri Ramadhani', 
            'tempat_lahir'  => 'Surabaya', 
            'tanggal_lahir' => '2003-05-14', 
            'alamat'        => 'Jl. Mawar No. 10', 
            'fakultas'      => 'Fakultas Teknik', 
            'jurusan'       => 'Teknik Informatika', 
        ]);
         dump($result2);
    }
    public function insertEloquent() {
         $mhs = Mahasiswa::create([ 
            'nim'           => '20104080', 
            'nama_lengkap'  => 'Rizky Ananda', 
            'tempat_lahir'  => 'Malang', 
            'tanggal_lahir' => '2002-09-12', 
            'alamat'        => 'Jl. Kenanga No. 7', 
            'fakultas'      => 'Fakultas Informatika', 
            'jurusan'       => 'Software Engineering', 
        ]); 
        dump($mhs);
    }
}
