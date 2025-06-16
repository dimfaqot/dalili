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
    public function update_profile()
    {
        $password_saat_ini = $this->request->getVar('password_saat_ini');
        $nama = upper_first(clear($this->request->getVar('nama')));
        $password_baru = $this->request->getVar('password_baru');
        $id = clear($this->request->getVar('id'));

        $db = db('admin');

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js("Id tidak ada");
        }

        if ($password_baru !== "") {
            if (!password_verify($password_saat_ini, $q['password'])) {
                gagal_js("Password saat ini salah");
            }

            $q['password_baru'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        $q['nama'] = $nama;

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses_js('Sukses');
        } else {
            gagal_js('Gagal');
        }
    }
    public function update_data()
    {

        $nama = upper_first(clear($this->request->getVar('nama')));
        $bank = strtoupper(clear($this->request->getVar('bank')));
        $norek = strtoupper(clear($this->request->getVar('norek')));
        $hp = strtoupper(clear($this->request->getVar('hp')));

        $db = db('settings');

        $q = $db->where('setting', 'nama')->get()->getRowArray();

        if (!$q) {
            gagal_js('Nama tidak ada');
        }

        $db->where('id', $q['id']);
        $q['value'] = $nama;
        if (!$db->update($q)) {
            gagal_js('Update nama gagal');
        }

        // ___

        $q = $db->where('setting', 'bank')->get()->getRowArray();

        if (!$q) {
            gagal_js('Bank tidak ada');
        }

        $db->where('id', $q['id']);
        $q['value'] = $bank;
        if (!$db->update($q)) {

            gagal_js('Update bank gagal');
        }

        // __

        $q = $db->where('setting', 'norek')->get()->getRowArray();

        if (!$q) {
            gagal_js('Norek tidak ada');
        }

        $db->where('id', $q['id']);
        $q['value'] = $norek;
        if (!$db->update($q)) {
            gagal_js('Update norek gagal');
        }

        // __

        $q = $db->where('setting', 'hp')->get()->getRowArray();

        if (!$q) {
            gagal_js('Hp tidak ada');
        }

        $db->where('id', $q['id']);
        $q['value'] = $hp;
        if (!$db->update($q)) {
            gagal_js('Update hp gagal');
        }

        sukses_js("Sukses");
    }
}
