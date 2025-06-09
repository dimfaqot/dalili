<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $db = db('pelanggan');
        $pelanggan = $db->orderBy('nama', 'ASC')->get()->getResultArray();


        return view('home', ['judul' => "Dashboard", "pelanggan" => $pelanggan, 'data' => rangkuman()]);
    }
}
