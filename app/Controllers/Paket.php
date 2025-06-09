<?php

namespace App\Controllers;


class Paket extends BaseController
{
    public function index(): string
    {
        $db = db(menu()['url']);
        $data = $db->orderBy('updated_at', 'DESC')->get()->getResultArray();
        return view('paket', ['judul' => "Paket", 'data' => $data]);
    }

    public function add()
    {
        $paket = upper_first(clear($this->request->getVar('paket')));
        $harga = rp_to_int(clear($this->request->getVar('harga')));

        $db = db(menu()['url']);

        $q = $db->where('paket', $paket)->get()->getRowArray();

        if ($q) {
            gagal(base_url(menu()['url']), "Paket sudah ada");
        }
        $data = [
            'paket' => $paket,
            'harga' => $harga,
            'petugas' => (session('id') ? session('id') : ""),
            'created_at' => time(),
            'updated_at' => time()
        ];


        if ($db->insert($data)) {
            sukses(base_url(menu()['url']), "Berhasil");
        } else {
            gagal(base_url(menu()['url']), "Gagal");
        }
    }
    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $paket = upper_first(clear($this->request->getVar('paket')));
        $harga = rp_to_int(clear($this->request->getVar('harga')));

        $db = db(menu()['url']);

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal(base_url(menu()['url']), "Id tidak ditemukan");
        }

        $exist = $db->whereNotIn('id', [$id])->where('paket', $paket)->get()->getRowArray();

        if ($exist) {
            gagal(base_url(menu()['url']), "Paket sudah ada");
        }



        $q['paket'] = $paket;
        $q['harga'] = $harga;
        $q['petugas'] = (session('id') ? session('id') : "");
        $q['updated_at'] = time();

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses(base_url(menu()['url']), "Berhasil");
        } else {
            gagal(base_url(menu()['url']), "Gagal");
        }
    }
}
