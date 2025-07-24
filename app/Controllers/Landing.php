<?php

namespace App\Controllers;

class Landing extends BaseController
{
    public function index(): string
    {
        echo "<h1 style='text-align:center'>Time Over</h1>";
        // $csvData = [];
        // $filePath = WRITEPATH . 'data_dalili.csv';

        // if (($handle = fopen($filePath, 'r')) !== false) {
        //     while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        //         $csvData[] = $data;
        //     }
        //     fclose($handle);
        // }

        // $db      = \Config\Database::connect();
        // $dbpelanggan = $db->table('pelanggan2');
        // $dbpaket = db('paket');
        // $dbpembayaran = db('pembayaran2');

        // $alamat = "Candi Kidul";
        // $val = [];

        // foreach ($csvData as $k => $i) {
        //     if ($k > 373) {
        //         $imp = clear($i[0]) . ";" . clear($i[1]);
        //         $temp = explode(";", $imp);
        //         // dd($temp);
        //         $nama = clear(str_replace($alamat, "", str_replace(strtolower($alamat), "", $temp[1])));
        //         $nama = clear(str_replace("Bp", "Pak", str_replace("Ibu", "Bu", str_replace("Mbh", "Mbah", $nama))));
        //         $mulai_langganan = strtotime(str_replace('/', '-', $temp[2]));

        //         $b = $temp[3] . $temp[4];

        //         $biaya = str_replace("IDR ", "", clear($b));
        //         $harga = (int)$biaya;
        //         $paket = $dbpaket->where('harga', $harga)->get()->getRowArray();

        //         if (!$paket) {
        //             dd('Gagagl ', $i);
        //         }


        //         $metode = "Belum";
        //         if ($temp[5] !== "") {
        //             $metode = "Transfer";
        //         } elseif ($temp[6] !== "") {
        //             $metode = "Cash";
        //         } elseif ($temp[7] !== "") {
        //             $metode = "Toko";
        //         }

        //         $ket = $temp[10];

        //         $data = [
        //             'nama' => upper_first($nama),
        //             'mulai_langganan' => $mulai_langganan,
        //             'paket' => $paket['paket'],
        //             'harga' => $paket['harga'],
        //             'alamat' => $alamat,
        //             'ket' => $ket,
        //             'status' => 1,
        //             'petugas' => "AT",
        //             'created_at' => time(),
        //             'updated_at' => time(),
        //             'akhir_langganan' => 0
        //         ];

        //         if (strpos(strtolower($temp[1]), strtolower($alamat)) !== false) {
        //             $val[] = ['data' => $data, 'metode' => $metode];
        //         }

        //         $dbpelanggan->insert($data);
        //         $pelanggan_id = $db->insertID();



        //         if ($metode !== "Belum") {
        //             $lunas = [
        //                 'pelanggan_id' => $pelanggan_id,
        //                 'tgl' => time(),
        //                 'nama' => $nama,
        //                 'paket' => $paket['paket'],
        //                 'harga' => $paket['harga'],
        //                 'periode' => strtotime("01/07/2025"),
        //                 'petugas' => "AT",
        //                 'created_at' => time(),
        //                 'updated_at' => time(),
        //                 'metode' => $metode
        //             ];

        //             $dbpembayaran->insert($lunas);
        //         }
        //     }
        // }


        // foreach ($val as $i) {

        //     $dbpelanggan->insert($i['data']);
        //     $pelanggan_id = $db->insertID();



        //     if ($i['metode'] !== "Belum") {
        //         $lunas = [
        //             'pelanggan_id' => $pelanggan_id,
        //             'tgl' => time(),
        //             'nama' => $i['data']['nama'],
        //             'paket' => $i['data']['paket'],
        //             'harga' => $i['data']['harga'],
        //             'periode' => strtotime("01/07/2025"),
        //             'petugas' => "AT",
        //             'created_at' => time(),
        //             'updated_at' => time(),
        //             'metode' => $i['metode']
        //         ];

        //         $dbpembayaran->insert($lunas);
        //     }
        // }

        // dd(count($val));


        // $db = db('pelanggan2');
        // $q = $db->orderBy('alamat', 'ASC')->orderBy('nama', 'ASC')->get()->getResultArray();

        // $db = db('pelanggan');
        // foreach ($q as $i) {
        //     unset($i['id']);
        //     $db->insert($i);
        // }

        // $db = db('options');
        // foreach (alamat() as $i) {
        //     $data = [
        //         'jenis' => 'Alamat',
        //         'value' => $i
        //     ];

        //     $db->insert($data);
        // }
        return view('landing', ['judul' => "DALILI NET"]);
    }

    public function print()
    {
        return view('print', ['judul' => "PRINT"]);
    }
}
