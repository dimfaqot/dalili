<?php

function db($tabel, $db = null)
{
    if ($db == null || $db == getenv('db_used')) {
        $db = \Config\Database::connect();
    } else {
        $db = \Config\Database::connect(strtolower(str_replace(" ", "_", $db)));
    }
    $db = $db->table($tabel);

    return $db;
}

function url()
{
    $url = service('uri');
    $res = $url->getPath();
    $exp = explode("/", $res);

    return $exp[2];
}

function menus()
{
    $menus = [
        ['menu' => "Dashboard", "url" => "home"],
        ['menu' => "Paket", "url" => "paket"],
        ['menu' => "Pelanggan", "url" => "pelanggan"]
    ];

    return $menus;
}

function menu()
{
    $res = [];
    foreach (menus() as $i) {
        if ($i['url'] == url()) {
            $res = $i;
        }
    }

    if (count($res) == 0) {
        if (session('id')) {
            gagal('', "Menu tidak ditemukan");
        } else {
            gagal('home', "Menu tidak ditemukan");
        }
    }

    return $res;
}


function clear($text)
{
    $text = trim($text);
    $text = htmlspecialchars($text);
    return $text;
}
function gagal($url, $pesan)
{
    session()->setFlashdata('gagal', $pesan);
    header("Location: " . $url);
    die;
}

function sukses($url, $pesan)
{
    session()->setFlashdata('sukses', $pesan);
    header("Location: " . $url);
    die;
}

function angka($angka)
{
    return number_format($angka, 0, '.', '.');
}

function upper_first($text)
{
    // $text = clear($text);
    $exp = explode(" ", $text);

    $val = [];
    foreach ($exp as $i) {
        $lower = strtolower($i);
        $val[] = ucfirst($lower);
    }

    return implode(" ", $val);
}


function rp_to_int($rp)
{
    $r = str_replace(",", "", str_replace(".", "", $rp));
    return (int)$r;
}

function bulan($req = null)
{
    $bulan = [
        ["eng" => "January", 'romawi' => 'I', 'bulan' => 'Januari', 'angka' => '01', 'satuan' => 1],
        ["eng" => "February", 'romawi' => 'II', 'bulan' => 'Februari', 'angka' => '02', 'satuan' => 2],
        ["eng" => "March", 'romawi' => 'III', 'bulan' => 'Maret', 'angka' => '03', 'satuan' => 3],
        ["eng" => "April", 'romawi' => 'IV', 'bulan' => 'April', 'angka' => '04', 'satuan' => 4],
        ["eng" => "Mai", 'romawi' => 'V', 'bulan' => 'Mei', 'angka' => '05', 'satuan' => 5],
        ["eng" => "June", 'romawi' => 'VI', 'bulan' => 'Juni', 'angka' => '06', 'satuan' => 6],
        ["eng" => "July", 'romawi' => 'VII', 'bulan' => 'Juli', 'angka' => '07', 'satuan' => 7],
        ["eng" => "August", 'romawi' => 'VIII', 'bulan' => 'Agustus', 'angka' => '08', 'satuan' => 8],
        ["eng" => "September", 'romawi' => 'IX', 'bulan' => 'September', 'angka' => '09', 'satuan' => 9],
        ["eng" => "October", 'romawi' => 'X', 'bulan' => 'Oktober', 'angka' => '10', 'satuan' => 10],
        ["eng" => "November", 'romawi' => 'XI', 'bulan' => 'November', 'angka' => '11', 'satuan' => 11],
        ["eng" => "December", 'romawi' => 'XII', 'bulan' => 'Desember', 'angka' => '12', 'satuan' => 12]
    ];

    $res = $bulan;
    foreach ($bulan as $i) {
        if ($i['bulan'] == $req) {
            $res = $i;
        } elseif ($i['angka'] == $req) {
            $res = $i;
        } elseif ($i['satuan'] == $req) {
            $res = $i;
        } elseif ($i['romawi'] == $req) {
            $res = $i;
        }
    }
    return $res;
}

function tahuns()
{
    $res = [2019, 2020, 2021, 2022, 2023, 2024, 2025];

    $db = db('pelanggan');
    $q = $db->orderBy('mulai_langganan', 'ASC')->get()->getRowArray();

    if ($q) {
        if ($q['mulai_langganan'] > 0) {
            $tahun = (int)date('Y', $q['mulai_langganan']);
            $res = range($tahun, (int)date('Y'));
        }
    }

    return $res;
}

function metode()
{
    $res = ['Cash', 'Transfer', 'Toko'];

    return $res;
}

function sukses_js($pesan, $data = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
{
    $data = [
        'status' => '200',
        'message' => $pesan,
        'data' => $data,
        'data2' => $data2,
        'data3' => $data3,
        'data4' => $data4,
        'data5' => $data5
    ];

    echo json_encode($data);
    die;
}

function gagal_js($pesan, $data = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
{
    $res = [
        'status' => '400',
        'message' =>  $pesan,
        'data' => $data,
        'data2' => $data2,
        'data3' => $data3,
        'data4' => $data4,
        'data5' => $data5
    ];

    echo json_encode($res);
    die;
}

function settings($req = null)
{
    $db = db('settings');
    $q = $db->orderBy('setting', 'ASC')->get()->getResultArray();

    if ($req == null) {
        return $q;
    } else {
        foreach ($q as $i) {
            if ($i['setting'] == $req) {
                return $i['value'];
            }
        }
    }
}

function rangkuman($order = null)
{

    $db = db('pelanggan');
    $pelanggan = $db->orderBy('nama', 'ASC')->get()->getResultArray();

    $db = db('pembayaran');

    $users = [];
    foreach ($pelanggan as $i) {

        if ($i['status'] == 0 && $i['mulai_langganan'] == 0 && $order == null) {
            continue;
        }
        $tahun = range((int)date('Y', $i['mulai_langganan']), (int)date("Y"));

        if ($i['status'] == 0) {
            if ($i['mulai_langganan'] == 0) {
                $tahun = [(int)date('Y')];
            } else {
                $tahun = range((int)date('Y', $i['mulai_langganan']), (int)date("Y", $i['akhir_langganan']));
            }
        }
        $i['tahun'] = $tahun;
        $users[] = $i;
    }

    $data = [];

    foreach ($users as $i) {

        $q = $db->where('pelanggan_id', $i['id'])->orderBy('periode', 'ASC')->get()->getResultArray();

        $lunas = [];
        foreach ($q as $l) {
            $lunas[] = date('n Y', $l['periode']);
        }

        $total = 0;
        $temp = [];
        foreach ($i['tahun'] as $t) {
            for ($x = 1; $x < 13; $x++) {
                if ($t == date('Y', $i['mulai_langganan']) && $x < (int)date('n', $i['mulai_langganan'])) {
                    continue;
                } elseif ($t == date('Y') && $x > (int)date('n')) {
                    continue;
                } elseif ($i['status'] == 0 && $t == date('Y') && $x > (int)date('n', $i['akhir_langganan'])) {
                    continue;
                } else {
                    if (in_array($x . " " . $t, $lunas)) {
                        $temp[] = ['periode' => bulan($x)['bulan'] . " " . $t, 'ket' => "L"];
                    } else {
                        $temp[] = ['periode' => bulan($x)['bulan'] . " " . $t, 'ket' => "H"];
                        $total++;
                    }
                }
            }
        }

        $data[] = ['identitas' => $i, 'total' => $total, 'data' => $temp];
    }

    return $data;
}
