<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekalkulasiHppStokController extends MyController
{
    public $title = 'Rekalkulasi HPP dan Stok';

    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'pagename' => 'Menu Utama Rekalkulasi HPP dan Stok',
        ];

        
        return view('rekalkulasihppstok.index', compact('title', 'data'));
    }
}
