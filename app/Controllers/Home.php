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
    public function delete()
    {
        $tabel = clear($this->request->getVar('tabel'));
        $id = clear($this->request->getVar('id'));

        $db = db($tabel);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js("Id tidak ada");
        }

        $db->where('id', $id);
        if ($db->delete()) {
            sukses_js('Sukses');
        } else {
            gagal_js('Gagal');
        }
    }
}
