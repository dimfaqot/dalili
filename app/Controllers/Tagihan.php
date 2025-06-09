<?php

namespace App\Controllers;

class Tagihan extends BaseController
{
    public function index(): string
    {
        return view('tagihan', ['judul' => "Tagihan"]);
    }
}
