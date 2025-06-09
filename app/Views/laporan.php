<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul; ?></title>

    <style>
        table,
        td,
        th {
            border: 0px solid #033d62;
            padding: 0px;
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }

        td {
            padding: 0px;
        }

        table {
            border-collapse: separate;
            border-spacing: 0px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        div {
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>

</head>

<body>
    <table style="width:100%;">
        <tr>
            <td style="font-size:14px;"><b>DALILI NET</b></td>
        </tr>
        <tr>
            <td style="font-size: 10px;font-style:italic">Alamat: Sungkul - Plumbungan - Karangmalang - Sragen - <?= settings('hp'); ?></td>
        </tr>
    </table>

    <br>
    <br>
    <br>
    <h3 style="text-align: center;"><?= $judul; ?></h3>

    <table style="margin-top: 10px;width:100%;">
        <tr>
            <th style="border: 1px solid grey;padding:2px">No.</th>
            <th style="border: 1px solid grey;padding:2px">Tgl</th>
            <th style="border: 1px solid grey;padding:2px">Nama</th>
            <th style="border: 1px solid grey;padding:2px">Paket</th>
            <th style="border: 1px solid grey;padding:2px">Metode</th>
            <th style="border: 1px solid grey;padding:2px">Admin</th>
            <th style="border: 1px solid grey;padding:2px">Biaya</th>

        </tr>
        <?php $total = 0; ?>
        <?php foreach ($data as $k => $i): ?>
            <?php $total += $i['harga']; ?>
            <tr>
                <td style="text-align:center;border: 1px solid grey;padding:4px"><?= ($k + 1); ?></td>
                <td style="text-align: center;border: 1px solid grey;padding:4px"><?= date('d/m', $i['tgl']); ?></td>
                <td style="border: 1px solid grey;padding:4px"><?= $i['nama']; ?></td>
                <td style="border: 1px solid grey;padding:4px"><?= $i['paket']; ?></td>
                <td style="border: 1px solid grey;padding:4px"><?= $i['metode']; ?></td>
                <td style="border: 1px solid grey;padding:4px"><?= $i['petugas']; ?></td>
                <td style="text-align: right; border: 1px solid grey;padding:4px"><?= angka($i['harga']); ?></td>
            </tr>

        <?php endforeach; ?>
        <tr>
            <th colspan="6" style="text-align:right;border: 1px solid grey;padding:4px">TOTAL</th>
            <th style="text-align:right;border: 1px solid grey;padding:4px"><?= angka($total); ?></th>
        </tr>
    </table>



</body>

</html>