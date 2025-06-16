<?php
// dd(password_hash('123456', PASSWORD_DEFAULT));
$total = 0;
$total_tagihan = 0;
foreach ($data as $i) {
    $total += $i['total'];
    $total_tagihan += ($i['total'] * $i['identitas']['harga']);
}

$id = (session('id') ? session('id') : 1);
$db = db('admin');
$q = $db->where('id', $id)->get()->getRowArray();
?>
<?= $this->extend('templates/logged') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-center gap-2 my-3">
    <a href="<?= base_url('pelanggan'); ?>" class="card text-bg-primary border border-primary" style="--bs-border-opacity: 0.5;min-width: 10rem;text-decoration:none">
        <div class="card-body text-center">
            <h2 class="card-title"><?= angka(count($pelanggan)); ?></h2>
            <p class="card-text">Total Pelanggan</p>
        </div>
    </a>
    <a href="" class="card text-bg-primary border border-primary" data-bs-toggle="modal" data-bs-target="#detail_belum_bayar" style="--bs-border-opacity: 0.5;min-width: 10rem;text-decoration:none">
        <div class="card-body text-center">
            <h2 class="card-title"><?= angka($total); ?></h2>
            <p class="card-text">Belum Bayar</p>
        </div>
    </a>

</div>
<div class="d-flex justify-content-center gap-2">
    <a href="" class="card text-bg-primary border border-primary" data-bs-toggle="modal" data-bs-target="#settings" style="--bs-border-opacity: 0.5;min-width: 10rem;text-decoration:none">
        <div class="card-body text-center">
            <h2 class="card-title"><i class="fa-solid fa-gear"></i></h2>
            <p class="card-text">Settings</p>
        </div>
    </a>
    <a href="" class="card text-bg-primary border border-primary" data-bs-toggle="modal" data-bs-target="#laporan" style="--bs-border-opacity: 0.5;min-width: 10rem;text-decoration:none">
        <div class="card-body text-center">
            <h2 class="card-title"><i class="fa-solid fa-file-lines"></i></h2>
            <p class="card-text">Laporan Bulanan</p>
        </div>
    </a>

</div>

<!-- modal detail -->
<div class="modal fade" id="detail_belum_bayar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal_detail">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Data Belum Bayar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>TOTAL: <?= angka($total_tagihan); ?></h6>

                <input type="text" class="form-control cari_tagihan mb-3" placeholder="Cari">
                <?php foreach ($data as $k => $i): ?>
                    <div class="accordion accordion-flush target_search" data-target="<?= $i['identitas']['nama']; ?>" id="accordion<?= $i['identitas']['id']; ?>">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush<?= $i['identitas']['id']; ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne<?= $i['identitas']['id']; ?>" aria-expanded="false" aria-controls="flush-collapseOne<?= $i['identitas']['id']; ?>">
                                    <?= $i['identitas']['nama']; ?>
                                </button>
                            </h2>
                            <div id="flush-collapseOne<?= $i['identitas']['id']; ?>" class="accordion-collapse collapse" aria-labelledby="flush<?= $i['identitas']['id']; ?>" data-bs-parent="#accordion<?= $i['identitas']['id']; ?>">
                                <div class="d-grid my-3">
                                    <button class="btn btn-primary btn_whatsapp" data-i="<?= $k; ?>"><i class="fa-brands fa-whatsapp"></i></a> Kirim Tagihan | <?= angka($i['identitas']['harga'] * $i['total']); ?></button>
                                </div>
                                <table class="table table-sm table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Periode</th>
                                            <th class="text-center">Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($i['data'] as $k => $d): ?>
                                            <?php if ($d['ket'] == "H"): ?>
                                                <tr>
                                                    <td class="text-center"><?= ($k + 1); ?></td>
                                                    <td><?= $d['periode']; ?></td>
                                                    <td class="text-end"><?= angka($i['identitas']['harga']); ?></td>
                                                </tr>

                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- modal laporan -->
<div class="modal fade" id="laporan" tabindex="-1" aria-labelledby="tes" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Laporan</h5>
                <div class="d-flex gap-2 mt-3">
                    <select class="form-select form-select-sm bulan">
                        <?php foreach (bulan() as $i): ?>
                            <option value="<?= $i['angka']; ?>" <?= ($i['angka'] == date('m') ? 'selected' : ''); ?>><?= $i['bulan']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="form-select form-select-sm tahun">
                        <?php foreach (tahuns() as $i): ?>
                            <option <?= ($i == date('Y') ? 'selected' : ''); ?> value="<?= $i; ?>"><?= $i; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-grid mt-3">
                    <button class="btn btn-primary laporan"><i class="fa-regular fa-file-pdf"></i> Download</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal settings -->
<div class="modal fade" id="settings" tabindex="-1" aria-labelledby="tes" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between border-bottom pb-1 mb-2">
                    <h5>Settings</h5>
                    <h5><a href="" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark text-danger"></i></a></h5>
                </div>
                <h6>Identitas</h6>
                <div class="mb-2">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control form-control-sm nama" value="<?= $q['nama']; ?>" placeholder="Nama">
                </div>
                <div class="mb-2">
                    <label class="form-label">Password Saai Ini</label>
                    <input type="password" class="form-control form-control-sm password_saat_ini" placeholder="Password saat ini">
                </div>
                <div class="mb-2">
                    <label class="form-label">Password Baru</label>
                    <input type="password" class="form-control form-control-sm password_baru" placeholder="Password baru">
                </div>
                <div class="mb-2">
                    <label class="form-label">Ulangi Password Baru</label>
                    <input type="password" class="form-control form-control-sm ulangi_password_baru" placeholder="Ulangi password baru">
                </div>

                <div class="d-grid"><button data-id="<?= $q['id']; ?>" class="btn btn-primary update_profile">Update Identitas</button></div>
                <hr>
                <h6>Pembayaran</h6>
                <div class="mb-2">
                    <label class="form-label">Nama Bank</label>
                    <input type="text" class="form-control form-control-sm bank" value="<?= settings('bank'); ?>" placeholder="Nama bank">
                </div>
                <div class="mb-2">
                    <label class="form-label">No. Rekening</label>
                    <input type="text" class="form-control form-control-sm norek" value="<?= settings('norek'); ?>" placeholder="Nomor rekening">
                </div>
                <div class="mb-2">
                    <label class="form-label">Nama Pemilik Rekeing</label>
                    <input type="text" class="form-control form-control-sm rek" value="<?= settings('nama'); ?>" placeholder="Pemilik rekening">
                </div>
                <div class="mb-2">
                    <label class="form-label">No. WA Admin</label>
                    <input type="text" class="form-control form-control-sm hp" value="<?= settings('hp'); ?>" placeholder="Nomor wa admin">
                </div>

                <div class="d-grid"><button class="btn btn-primary update_data">Update Data</button></div>
            </div>
        </div>
    </div>
</div>


<script>
    let data = <?= json_encode($data); ?>;


    $(document).on('keyup', '.cari_tagihan', function(e) {
        e.preventDefault();
        let value = $(this).val().toLowerCase();
        $('.target_search').filter(function() {
            $(this).toggle($(this).data('target').toLowerCase().indexOf(value) > -1);
        });

    });

    $(document).on('click', '.btn_whatsapp', function(e) {
        e.preventDefault();

        let i = $(this).data("i");
        let val = [];

        data.forEach((e, y) => {
            if (y == i) {
                val = e;
            }
        });


        let nama = val.identitas.nama;
        let paket = val.identitas.paket;
        let biaya = val.identitas.harga;
        let no_hp = "62";
        no_hp += val.identitas.hp.substring(1);


        let text = "_Assalamualaikum Wr. Wb._%0a";
        text += "Yth. *" + nama + '*%0a%0a';
        text += 'Kami dari DALILI NET menyampaikan bahwa Anda memiliki tagihan sebagai berikut:%0a%0a';
        text += '*No - Periode - Biaya*%0a';
        val.data.forEach((e, i) => {
            if (e.ket == "H") {
                text += (i + 1) + '. ' + ' ' + e.periode + ' - Rp' + angka(val.identitas.harga) + '%0a';
            }
        })

        text += '%0a*_TOTAL: Rp' + angka(val.identitas.harga * val.total) + '_*%0a%0a';
        text += 'Pembayaran dapat dilakukan dengan transfer ke rekening <?= settings("norek"); ?> Bank <?= settings('bank'); ?> atas nama *<?= settings('nama'); ?>*, atau cash.%0a%0a';
        text += '*_Pembayaran paling lambat tanggal 20 pada tiap bulan._*%0a%0a';

        text += "Demikian,%0a";
        text += "_Wassalamualaikum Wr. Wb._%0a%0a%0a";
        text += '';
        text += 'Admin';


        // let url = "https://api.whatsapp.com/send/?phone=" + no_hp + "&text=" + text;
        let url = "whatsapp://send/?phone=" + no_hp + "&text=" + text;

        location.href = url;
        // window.open(url);
    });
    $(document).on('click', '.laporan', function(e) {
        e.preventDefault();


        // let url = "https://api.whatsapp.com/send/?phone=" + no_hp + "&text=" + text;
        let url = "<?= base_url('laporan'); ?>/" + $(".bulan").val() + '/' + $(".tahun").val();
        window.open(url, "_blank");

    });
    $(document).on('click', '.update_profile', function(e) {
        e.preventDefault();
        let nama = $(".nama").val();
        let password_saat_ini = $(".password_saat_ini").val();
        let password_baru = $(".password_baru").val();
        let ulangi_password_baru = $(".ulangi_password_baru").val();
        let id = $(this).data('id');

        if (nama == "") {
            message("Nama harus diisi");
            return;
        }


        if (password_saat_ini !== "") {
            if (password_baru == "" || password_saat_ini == "" || ulangi_password_baru == "") {
                message("Semua data harus diisi");
                return;
            }
            if (password_baru !== ulangi_password_baru) {
                message("Ulangi password salah");
                return;
            }
        }
        if (password_baru !== "") {
            if (password_baru == "" || password_saat_ini == "" || ulangi_password_baru == "") {
                message("Semua data harus diisi");
                return;
            }
            if (password_baru !== ulangi_password_baru) {
                message("Ulangi password salah");
                return;
            }
        }
        if (ulangi_password_baru !== "") {
            if (password_baru == "" || password_saat_ini == "" || ulangi_password_baru == "") {
                message("Semua data harus diisi");
                return;
            }
            if (password_baru !== ulangi_password_baru) {
                message("Ulangi password salah");
                return;
            }
        }


        post("home/update_profile", {
            password_saat_ini,
            nama,
            password_baru,
            id
        }).then(res => {
            message(res.message);
        })

    });
    $(document).on('click', '.update_data', function(e) {
        e.preventDefault();
        let bank = $(".bank").val();
        let nama = $(".rek").val();
        let norek = $(".norek").val();
        let hp = $(".hp").val();


        if (bank == "" || nama == "" || norek == "" || hp == "") {
            message("Semua data harus diisi");
            return;
        }
        if (hp.charAt(0) != 0) {
            message("Format hp salah");
            return;
        }


        post("home/update_data", {
            bank,
            nama,
            norek,
            hp
        }).then(res => {
            message(res.message);
        })

    });
</script>
<?= $this->endSection() ?>