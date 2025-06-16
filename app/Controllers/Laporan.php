<?php

namespace App\Controllers;


class Laporan extends BaseController
{
    public function index($bulan, $tahun)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pembayaran');

        $builder->where("MONTH(FROM_UNIXTIME(tgl))", $bulan);
        $builder->where("YEAR(FROM_UNIXTIME(tgl))", $tahun);

        $data = $builder->get()->getResultArray();
        dd($data);
        $set = [
            'mode' => 'utf-8',
            'format' => [210, 330],
            'orientation' => 'P',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5
        ];

        $mpdf = new \Mpdf\Mpdf($set);

        $judul = "LAPORAN KEUANGAN BULAN " . strtoupper(bulan($bulan)['bulan']) . " TAHUN " . $tahun;

        $html = view('laporan', ['judul' => $judul, 'tahun' => $tahun, 'bulan' => bulan($bulan)['bulan'], 'data' => $data]); // view('pdf_template') mengacu pada file view yang akan dirender menjadi PDF

        // Setel konten HTML ke mPDF
        $mpdf->WriteHTML($html);

        // Output PDF ke browser
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($judul . '.pdf', 'I');
    }
}
