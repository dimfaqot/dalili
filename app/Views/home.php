<?php

// dd(password_hash('123456', PASSWORD_DEFAULT));
$id = (session('id') ? session('id') : 1);
$db = db('admin');
$q = $db->where('id', $id)->get()->getRowArray();
?>
<?= $this->extend('templates/logged') ?>

<?= $this->section('content') ?>
<div class="content"></div>

<!-- modal detail -->
<div class="modal fade" id="detail_belum_bayar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal_detail">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Data Belum Bayar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="body_belum_bayar"></div>

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
    let data = [];

    let content = () => {
        post("home/rangkuman", {
            id: 0
        }).then(res => {
            data = res.data.data;
            let html = '';

            html += `<div class="d-flex justify-content-center gap-2 my-3">
    <a href="<?= base_url('pelanggan'); ?>" class="card text-bg-primary border border-primary" style="--bs-border-opacity: 0.5;min-width: 10rem;text-decoration:none">
        <div class="card-body text-center">
            <h2 class="card-title">${angka(res.data.pelanggan.length)}</h2>
            <p class="card-text">Pelanggan</p>
        </div>
    </a>
    <a href="" class="card text-bg-primary border border-primary btn_belum_bayar" style="--bs-border-opacity: 0.5;min-width: 10rem;text-decoration:none">
        <div class="card-body text-center">
            <h2 class="card-title">${angka(res.data.total_tagihan)}</h2>
            <p class="card-text">Tagihan</p>
        </div>
    </a>

</div>
<div class="d-flex justify-content-center gap-2 mb-3">
    <a href="" class="card text-bg-primary border border-primary tunggakan" style="--bs-border-opacity: 0.5;min-width: 10rem;text-decoration:none">
        <div class="card-body text-center">
            <h4 class="card-title">${angka(res.data.total_belum_bayar)}</h4>
            <p class="card-text">Tunggakan</p>
        </div>
    </a>
    <a href="" class="card text-bg-primary border border-primary" data-bs-toggle="modal" data-bs-target="#laporan" style="--bs-border-opacity: 0.5;min-width: 10rem;text-decoration:none">
        <div class="card-body text-center">
            <h2 class="card-title"><i class="fa-solid fa-file-lines"></i></h2>
            <p class="card-text">Laporan Bulanan</p>
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

</div>`;
            $(".content").html(html);
        })
    }

    content();

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

    let data_belum_bayar = (alamat) => {
        let html = `<div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control add_alamat on_modal" data-order="add" value="${alamat}" placeholder="Alamat" required readonly>
                    </div>
                    <h6 class="total_belum_bayar"></h6>
  <input type="text" class="form-control form-control-sm cari_tagihan mb-3" placeholder="Cari">`;

        let total = 0;
        data.forEach((e, i) => {
            if (e.identitas.alamat == alamat) {
                total += (e.identitas.harga * e.total);
                html += `<div class="accordion accordion-flush target_search" data-target="${e.identitas.nama}" id="accordion${e.identitas.id}">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush${e.identitas.id}">
                            <button class="accordion-button collapsed ${(e.total==0?"bg-secondary opacity-50":"")}" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne${e.identitas.id}" aria-expanded="false" aria-controls="flush-collapseOne${e.identitas.id}">
                                ${e.identitas.nama}
                            </button>
                        </h2>
                        <div id="flush-collapseOne${e.identitas.id}" class="accordion-collapse collapse" aria-labelledby="flush${e.identitas.id}" data-bs-parent="#accordion${e.identitas.id}">
                            <div class="d-grid my-3">
                                <button class="btn btn-primary btn_whatsapp" data-i="${i}"><i class="fa-brands fa-whatsapp"></i></a> Kirim Tagihan | ${angka(e.identitas.harga * e.total)}</button>
                            </div>
                            <table class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Periode</th>
                                        <th class="text-center">Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                e.data.forEach((x, k) => {
                    if (x['ket'] == "H") {
                        html += `<tr>
                                                <td class="text-center">${k+1}</td>
                                                <td>${x.periode}</td>
                                                <td class="text-end">${angka(e.identitas.harga)}</td>
                                            </tr>`;
                    }

                })

                html += `</tbody>
                            </table>
                        </div>
                    </div>
                </div>`;
            }

        })
        let res = {
            total,
            html
        };
        return res;
    }
    $(document).on('click', '.btn_belum_bayar', function(e) {
        e.preventDefault();
        let alamat = "<?= options('alamat')[0]; ?>";

        let res = data_belum_bayar(alamat);
        $(".body_belum_bayar").html(res.html);


        let myModal = document.getElementById("detail_belum_bayar");
        let modal = bootstrap.Modal.getOrCreateInstance(myModal);

        modal.show();

        $(".total_belum_bayar").text("Total: " + angka(res.total));

    });

    $(document).on('click', '.on_modal', function(e) {
        e.preventDefault();
        let order = $(this).data("order");
        let html = "";
        html += `<div class="modal-body text-center">
                    <div class="my-2 bg-info p-2 rounded" style="position: relative;">
                        <span class="text_main" style="font-size: small;">Alamat</span>
                        <input type="text" data-order="${order}" class="mb-2 form-control alamat_on_modal" placeholder="Cari alamat...">
                        <div class="data_on_modal">
                           
                        </div>
                    </div>
                </div>`;

        $(".body_on_modal").html(html);
        mdlOnModal.show();
    });

    $(document).on('keyup', '.alamat_on_modal', function(e) {
        e.preventDefault();
        let val = $(this).val();
        let order = $(this).data("order");

        post("pelanggan/alamat", {
            val
        }).then(res => {
            let html = `<div class="d-flex justify-content-center flex-column"><div>`;
            if (res.data.length == 0) {
                html += '<div>Data tidak ditemukan!.</div>';
            } else {
                res.data.forEach((e, i) => {
                    html += `<div class="py-1 select_on_modal" data-to_class="${order}_alamat" style="text-align: left;cursor:pointer;border-bottom:1px solid white">${e}</div>`;
                })

            }
            html += `</div></div>`;
            $(".data_on_modal").html(html);
        })
    });
    $(document).on('click', '.select_on_modal', function(e) {
        e.preventDefault();
        let val = $(this).text();
        let to_class = $(this).data("to_class");

        $("." + to_class).val(val);

        $(".data_on_modal").html("");
        $(".body_on_modal").html("");
        mdlOnModal.hide();

        let res = data_belum_bayar(val);
        $(".body_belum_bayar").html(res.html);


        let myModal = document.getElementById("detail_belum_bayar");
        let modal = bootstrap.Modal.getOrCreateInstance(myModal);

        modal.show();

        $(".total_belum_bayar").text("Total: " + angka(res.total));

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

    let tunggakan = {};
    $(document).on('click', '.tunggakan', function(e) {
        e.preventDefault();


        let alamat = <?= json_encode(options('alamat')); ?>;
        let lunas = [];
        let tagihan = [];

        alamat.forEach(e => {

            let lunas_uang = 0;
            let lunas_jml = 0;

            let tagihan_uang = 0;
            let tagihan_jml = 0;
            let tf = 0;
            let tk = 0;
            let cs = 0;

            data.forEach(d => {
                if (d.identitas.alamat == e) {
                    d.data.forEach(v => {
                        if (v.ket == "L") {
                            lunas_uang += parseInt(d.identitas.harga);
                            lunas_jml++;
                            if (v.metode == "Toko") {
                                tk += parseInt(d.identitas.harga);
                            } else if (v.metode == "Transfer") {
                                tf += parseInt(d.identitas.harga);
                            } else if (v.metode == "Cash") {
                                cs += parseInt(d.identitas.harga);
                            }
                        } else {
                            tagihan_uang += parseInt(d.identitas.harga);
                            tagihan_jml++;
                        }

                    })
                }
            })

            lunas.push({
                jml: lunas_jml,
                uang: lunas_uang,
                alamat: e,
                tf,
                tk,
                cs
            });
            tagihan.push({
                jml: tagihan_jml,
                uang: tagihan_uang,
                alamat: e
            });
        })

        tunggakan = {
            lunas,
            tagihan
        }


        let html = `<div class="modal-header">
                    <h1 class="modal-title fs-5">Tunggakan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">`;
        html += `<ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active menu_tunggakan" data-order="lunas" aria-current="page" href="#">Lunas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu_tunggakan" data-order="tagihan" aria-current="page" href="#">Tagihan</a>
                </li>
               
                </ul>`;
        html += `<div class="list_tunggakan">`;

        html += list_tunggakan('lunas');

        html += `</div></div>`;

        $(".body_general").html(html);

        mdlGeneral.show();

    });

    let list_tunggakan = (order) => {

        let html = '';
        html += `<table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Jml</th>
                        <th scope="col">Uang</th>`;
        if (order == "lunas") {
            html += `<th scope="col">Cs</th>
                    <th scope="col">Tf</th>
                    <th scope="col">Tk</th>`;

        }
        html += `</tr>
                    </thead>
                    <tbody>`;
        let jml = 0;
        let uang = 0;
        let cs = 0;
        let tf = 0;
        let tk = 0;
        tunggakan[order].forEach((e, i) => {
            jml += parseInt(e.jml);
            uang += parseInt(e.uang);
            if (order == "lunas") {
                cs += parseInt(e.cs);
                tf += parseInt(e.tf);
                tk += parseInt(e.tk);
            }
            html += `<tr>
                        <td>${(i+1)}</td>
                        <td>${e.alamat}</td>
                        <td class="text-end">${angka(e.jml)}</td>
                        <td class="text-end">${angka(e.uang)}</td>`;

            if (order == "lunas") {
                html += `<td class="text-end">${angka(e.cs)}</td>
                        <td class="text-end">${angka(e.tf)}</td>
                        <td class="text-end">${angka(e.tk)}</td>`;
            }
            html += `</tr>`;
        })

        html += `<tr>
                        <th class="text-center" colspan="2">TOTAL</th>
                        <th class="text-end">${angka(jml)}</th>
                        <th class="text-end">${angka(uang)}</th>`;
        if (order == "lunas") {
            html += `<th class="text-end">${angka(cs)}</th>
                    <th class="text-end">${angka(tf)}</th>
                    <th class="text-end">${angka(tk)}</th>`;

        }
        html += `</tr>`;


        html += `</tbody>
                </table>`;

        return html;
    }

    $(document).on('click', '.menu_tunggakan', function(e) {
        e.preventDefault();
        let order = $(this).data("order");
        $(".menu_tunggakan").removeClass("active");
        $(this).addClass("active");
        $(".list_tunggakan").html(list_tunggakan(order));

    });
</script>
<?= $this->endSection() ?>