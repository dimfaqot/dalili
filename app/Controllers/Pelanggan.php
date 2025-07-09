<?php

namespace App\Controllers;


class Pelanggan extends BaseController
{
    public function index(): string
    {
        $db = db('paket');
        $paket = $db->orderBy('paket', 'ASC')->get()->getResultArray();
        $data = rangkuman(options('alamat')[0], 'full');

        return view(menu()['url'], ['judul' => "Pelanggan", 'data' => $data['data'], 'paket' => $paket]);
    }

    public function add()
    {
        $nama = upper_first(clear($this->request->getVar('nama')));
        $alamat = upper_first(clear($this->request->getVar('alamat')));
        $ket = upper_first(clear($this->request->getVar('ket')));
        $paket = upper_first(clear($this->request->getVar('paket')));
        $hp = clear($this->request->getVar('hp'));

        $db = db(menu()['url']);

        $q = $db->where('nama', $nama)->get()->getRowArray();

        if ($q) {
            gagal(base_url(menu()['url']), "Nama sudah ada");
        }
        $data = [
            'nama' => $nama,
            'alamat' => $alamat,
            'ket' => $ket,
            'paket' => $paket,
            'hp' => $hp,
            'petugas' => (session('id') ? session('id') : ""),
            'status' => 0,
            'mulai_langganan' => 0,
            'akhir_langganan' => 0,
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
        $nama = upper_first(clear($this->request->getVar('nama')));
        $alamat = upper_first(clear($this->request->getVar('alamat')));
        $ket = upper_first(clear($this->request->getVar('ket')));
        $paket = upper_first(clear($this->request->getVar('paket')));
        $status = (clear($this->request->getVar('status')) == "on" ? 1 : 0);
        $hp = clear($this->request->getVar('hp'));
        $mulai_langganan = strtotime(clear($this->request->getVar('mulai_langganan')));
        $akhir_langganan = strtotime(clear($this->request->getVar('akhir_langganan')));



        $db = db(menu()['url']);

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal(base_url(menu()['url']), "Id tidak ditemukan");
        }

        $exist = $db->whereNotIn('id', [$id])->where('nama', $nama)->get()->getRowArray();

        if ($exist) {
            gagal(base_url(menu()['url']), "Nama sudah ada");
        }

        $db_p = db('paket');
        $pkt = $db_p->where('paket', $paket)->get()->getRowArray();

        if (!$pkt) {
            gagal(base_url(menu()['url']), "Paket tidak ada");
        }


        $q['nama'] = $nama;
        $q['alamat'] = $alamat;
        $q['ket'] = $ket;
        $q['harga'] = $pkt['harga'];
        $q['paket'] = $paket;
        $q['status'] = $status;
        $q['hp'] = $hp;
        $q['petugas'] = (session('id') ? session('id') : "");
        $q['updated_at'] = time();

        if ($mulai_langganan != 0) {
            $q['mulai_langganan'] = $mulai_langganan;
        }
        if ($akhir_langganan != 0) {
            $q['akhir_langganan'] = $akhir_langganan;
        }

        if ($q['mulai_langganan'] == 0 && $status == 1) {
            $q['mulai_langganan'] = time();
        } elseif ($q['mulai_langganan'] > 0 && $status == 0 && $q['akhir_langganan'] == 0) {
            $q['akhir_langganan'] = time();
        }



        $db->where('id', $id);
        if ($db->update($q)) {
            sukses(base_url(menu()['url']), "Berhasil");
        } else {
            gagal(base_url(menu()['url']), "Gagal");
        }
    }

    public function tagihan()
    {
        $start = settings('start');
        $id = clear($this->request->getVar('id'));
        $tahun = (int)clear($this->request->getVar('tahun'));

        $db_pel = db('pelanggan');
        $pelanggan = $db_pel->where('id', $id)->get()->getRowArray();

        if (!$pelanggan) {
            gagal_js('Pelanggan tidak ditemukan');
        }

        $db_pem = db('pembayaran');
        $q = $db_pem->where('pelanggan_id', $id)->orderBy('periode', 'ASC')->get()->getResultArray();

        if ((int)$tahun > (int)date('Y')) {
            sukses_js("Data tidak ditemukan", [], $pelanggan);
        }


        if ($pelanggan['status'] == 1 && (int)$tahun < (int)date("Y", $start)) {
            sukses_js("Data tidak ditemukan", [], $pelanggan);
        } elseif ($pelanggan['status'] == 0) {
            if ((int)$tahun > (int)date("Y", $pelanggan['akhir_langganan']) || (int)$tahun < (int)date("Y", $start)) {
                sukses_js("Data tidak ditemukan", [], $pelanggan);
            }
        }


        $data = [];

        foreach (bulan() as $b) {

            if ($pelanggan['status'] == 1) {
                if ($tahun == date('Y', $start) && $b['satuan'] < (int)date('n', $start)) {
                    continue;
                } elseif ($tahun == date('Y') && $b['satuan'] > (int)date('n')) {
                    continue;
                }
            } elseif ($pelanggan['status'] == 0) {
                if ($tahun == date('Y', $start) && $b['satuan'] < (int)date('n', $start)) {
                    continue;
                } elseif ($tahun == date('Y') && $b['satuan'] > (int)date('n', $pelanggan['akhir_langganan'])) {
                    continue;
                }
            }

            $val = [];
            foreach ($q as $i) {
                if (date('m', $i['periode']) == $b['angka'] && date('Y', $i['periode']) == $tahun) {
                    $i['periode'] = $b['bulan'] . " " . date('Y', $i['periode']);
                    $val = $i;
                }
            }


            if (count($val) == 0) {
                $val = [
                    'id' => 0,
                    'pelanggan_id' => $id,
                    'tgl' => 0,
                    'nama' => $pelanggan['nama'],
                    'paket' => $pelanggan['paket'],
                    'harga' => $pelanggan['harga'],
                    'periode' => $b['bulan'] . " " . $tahun,
                    'createn_at' => 0,
                    'updated_at' => 0,
                    'petugas' => '',
                    'metode' => ''
                ];
            }
            $data[] = $val;
        }

        sukses_js("Sukses", $data, $pelanggan);
    }
    public function lunas()
    {
        $id = clear($this->request->getVar('id'));
        $periode = clear($this->request->getVar('periode'));
        $metode = clear($this->request->getVar('metode'));



        $db_pel = db('pelanggan');
        $pelanggan = $db_pel->where('id', $id)->get()->getRowArray();

        if (!$pelanggan) {
            gagal_js('Pelanggan tidak ditemukan');
        }

        $exp = explode(" ", $periode);
        $bulan = bulan($exp[0])['angka'];

        $time_periode = strtotime(end($exp) . "-" . $bulan . "-" . "01");

        $db_pem = db('pembayaran');
        $q = $db_pem->where('pelanggan_id', $id)->orderBy('periode', 'ASC')->get()->getResultArray();

        $data = [];

        foreach ($q as $i) {
            if (date('m', $i['periode']) == date('m', $time_periode) && date('Y', $i['periode']) == date('Y',  $time_periode)) {
                if ($metode == "") {
                    $db_pem->where('id', $i['id']);
                    if ($db_pem->delete()) {
                        sukses_js("Sukses");
                    } else {
                        gagal_js("Gagal");
                    }
                } else {
                    gagal_js("Pelanggan sudah membayar");
                }
            }
        }
        if (!$q && $metode == "") {
            gagal_js("Pilih metode bayar");
        }
        $data = [
            'pelanggan_id' => $id,
            'tgl' => time(),
            'nama' => $pelanggan['nama'],
            'paket' => $pelanggan['paket'],
            'harga' => $pelanggan['harga'],
            'periode' => $time_periode,
            'created_at' => time(),
            'updated_at' => time(),
            'petugas' => (session('id') ? session('id') : ""),
            'metode' => $metode
        ];

        if ($db_pem->insert($data)) {
            sukses_js("Sukses");
        } else {
            gagal_js("Gagal");
        }
    }

    public function alamat()
    {
        $val = clear($this->request->getVar('val'));

        $db = db('options');
        $q = $db->whereIn('jenis', ['Alamat'])->like('value', $val, 'both')->orderBy('value', 'ASC')->limit(10)->get()->getResultArray();

        $data = [];

        foreach ($q as $i) {
            $data[] = $i['value'];
        }


        sukses_js("Ok", $data);
    }

    public function pelanggan_by_alamat()
    {
        $alamat = clear($this->request->getVar('alamat'));

        $data = rangkuman($alamat)['data'];


        sukses_js("Ok", $data);
    }
}
