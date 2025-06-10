<?= $this->extend('templates/logged') ?>

<?= $this->section('content') ?>
<div class="d-flex my-3 gap-3">
    <div class="w-100"><input type="text" class="form-control search" placeholder="Cari"></div>
    <div class="flex-shrink-1"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah</button></div>

</div>

<?php foreach ($data as $i): ?>
    <div class="card mb-3 target_search" data-target="<?= $i['identitas']['nama']; ?>">
        <div class="card-body border">
            <div class="d-flex justify-content-between">
                <div>
                    <h4><i class="fa-solid fa-circle <?= ($i['total'] > 0 ? "text-warning" : ($i['identitas']['status'] == 1 ? "text-success" : "text-danger")); ?>"></i> <?= $i['identitas']['nama']; ?></h4>
                    <small class="<?= ($i['identitas']['status'] == 0 ? "text-danger" : "text-success"); ?>"><?= $i['identitas']['paket']; ?> | <?= ($i['identitas']['status'] == 1 ? date("d/m/Y", $i['identitas']['mulai_langganan']) : date("d/m/Y", $i['identitas']['mulai_langganan']) . ' - ' . date("d/m/Y", $i['identitas']['akhir_langganan'])); ?></small>
                </div>
                <div>
                    <div><a href="" class="update" data-id="<?= $i['identitas']['id']; ?>" style="text-decoration: none;"><i class="fa-solid fa-pen-to-square"></i> Update <i class="fa-solid fa-chevron-right"></i></a></div>
                    <div><a href="" class="text-success tagihan" data-id="<?= $i['identitas']['id']; ?>" style="text-decoration: none;"><i class="fa-solid fa-receipt"></i> Tagihan <i class="fa-solid fa-chevron-right"></i></a></div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<!-- modal add -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tambah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mt-3" method="post" action="<?= base_url(menu()['url'] . '/add'); ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hp</label>
                        <input type="text" class="form-control" name="hp" placeholder="Hp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                    </div>
                    <select class="form-select mb-3" name="paket">
                        <?php foreach ($paket as $i): ?>
                            <option value="<?= $i['paket']; ?>"><?= $i['paket']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal tagihan -->
<div class="modal fade" id="tagihan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 nama_pelanggan" id="exampleModalLabel">Tagihan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal_tagihan">

            </div>
        </div>
    </div>
</div>


<script>
    let data = <?= json_encode($data); ?>;
    let paket = <?= json_encode($paket); ?>;
    let tahuns = <?= json_encode(tahuns()); ?>;
    let metode = <?= json_encode(metode()); ?>;

    let mdl_tagihan = document.getElementById("tagihan");
    let modal_tagihan = bootstrap.Modal.getOrCreateInstance(mdl_tagihan);


    function updateFormattedDate() {
        let hiddenInput = document.getElementById("hiddenDate");
        let displayInput = document.getElementById("tanggal");
        let date = new Date(hiddenInput.value);

        // Format ke DD/MM/YYYY
        let formatted = ("0" + date.getDate()).slice(-2) + "/" +
            ("0" + (date.getMonth() + 1)).slice(-2) + "/" +
            date.getFullYear();

        displayInput.value = formatted;
    }

    $(document).on('keyup', '.search', function(e) {
        e.preventDefault();
        let value = $(this).val().toLowerCase();
        $('.target_search').filter(function() {
            $(this).toggle($(this).data('target').toLowerCase().indexOf(value) > -1);
        });

    });
    $(document).on('click', '.update', function(e) {
        e.preventDefault();
        let id = $(this).data('id');

        let val = [];
        data.forEach(e => {
            if (e.identitas.id == id) {
                val = e.identitas;
            }
        });

        let html = `<form class="mt-3" method="post" action="<?= base_url(menu()['url'] . '/update'); ?>">
                        <input type="hidden" name="id" value="${val.id}">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" value="${val.nama}" placeholder="Nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hp</label>
                        <input type="text" class="form-control" name="hp" value="${val.hp}" placeholder="Hp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="${val.alamat}" placeholder="Alamat" required>
                    </div>
                      <div class="mb-3">
                        <label class="form-label">Paket</label>
                    <select class="form-select mb-3" name="paket">`;
        paket.forEach(e => {
            html += `<option value="${e.paket}" ${(val.paket==e.paket?"selected":"")}>${e.paket}</option>`;
        })

        html += `</select>`;
        if (val.mulai_langganan > 0) {
            html += `<div class="mb-3">
                    <label class="form-label">Mulai Langganan</label>
                    <input class="form-control" type="date" name="mulai_langganan" id="tanggal" value="${time_php_to_js(val.mulai_langganan,"Y-m-d")}" onchange="updateValue()">
                </div>
            <div>`;

        } else {
            html += `<input type="hidden" value="0" name="mulai_langganan">`;
        }
        if (val.akhir_langganan > 0) {
            html += `<div class="mb-3">
                    <label class="form-label">Akhir Langganan</label>
                    <input class="form-control" type="date" name="akhir_langganan" id="tanggal" value="${time_php_to_js(val.akhir_langganan,"Y-m-d")}" onchange="updateValue()">
                </div>
            <div>`;

        } else {
            html += `<input type="hidden" value="0" name="akhir_langganan">`;
        }

        html += `<div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" role="switch" ${(val.status==1 || val.status==2?"checked":"")}>
                        <label class="form-check-label">Aktif</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>`;

        $(".modal_update").html(html);
        modal.show();
    });

    const tagihan = (id, tahun = "<?= date('Y'); ?>") => {

        post("<?= menu()['url']; ?>/tagihan", {
            id,
            tahun
        }).then(res => {
            $(".nama_pelanggan").text(res.data2.nama);
            let html = `<select class="form-select mb-3 tahun" data-id="${id}">`;

            tahuns.forEach(e => {
                html += `<option value="${e}" ${(e==tahun?"selected":"")}>${e}</option>`;
            })

            html += `</select>`;

            if (res.data.length == 0) {
                html += `${res.message}`;
            } else {
                res.data.forEach((e, i) => {

                    html += `<div class="card mb-3">
                            <div class="card-body border">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5><i class="fa-solid fa-circle ${(e.metode==""?"text-danger":"text-success")}"></i> ${e.periode}</h5>
                                    </div>`;
                    if (e.metode == "") {
                        html += `<div>
                                        <a href="" class="btn_whatsapp" data-hp="${res.data2.hp}" data-nama="${res.data2.nama}" data-hp="${res.data2.hp}" data-periode="${e.periode}" data-paket="${res.data2.paket}" data-biaya="${res.data2.harga}" style="text-decoration: none;"><i class="fa-brands fa-whatsapp"></i> Tagihan</a>
                                    </div>`;
                    } else {
                        html += `<div style="font-size:small;">
                                       ${time_php_to_js(e.tgl)} - ${e.petugas}
                                    </div>`;

                    }


                    html += `</div>
    
                            </div>`;

                    if (e.id == "0") {
                        html += `<div class="bg-light">
                                <div class="d-flex justify-content-center pt-2" style="font-size:14px;">
                                    <div class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="metode${i}" value="" ${(e.metode==""?"checked":"")}>
                                            <label class="form-check-label">Belum</label>
                                        </div>`;
                        metode.forEach(m => {
                            html += `<div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="metode${i}" value="${m}" ${(e.metode==m?"checked":"")}>
                                                    <label class="form-check-label">${m}</label>
                                                </div>`;

                        })
                        html += `</div>
                                </div>`;
                        html += `<div class="d-grid">
                                                    <button class="btn btn-success btn_lunas" data-i="${i}" data-periode="${e.periode}" data-id="${e.pelanggan_id}" style="border-radius: 0px;">LUNAS</button>
                                                </div>`;
                    } else {
                        html += `<div class="bg-light text-center pb-1">
                                        <div>Metode <b><i>${e.metode}</i></b></div>
                                        <div><a style="text-decoration:none" class="badge text-bg-danger confirm" data-message="Yakin cancel pembayaran?" data-tabel="pembayaran" data-id="${e.id}">Cancel</a></div>
                                </div>`;
                    }


                    html += `</div>
                        </div>`;

                })
            }

            $(".modal_tagihan").html(html);

            modal_tagihan.show();
        })

    }

    $(document).on('click', '.tagihan', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        tagihan(id);
    });
    $(document).on('click', '.btn_lunas', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let periode = $(this).data('periode');
        let i = $(this).data('i');
        let metode = $('input[name="metode' + i + '"]:checked').val();

        post("<?= menu()['url']; ?>/lunas", {
            id,
            periode,
            metode
        }).then(res => {
            message(res.message);
            if (res.status == 200) {
                setTimeout(() => {
                    location.reload();
                }, 1200);
            } else {
                message(res.message);
            }
        })
    });
    $(document).on('change', '.tahun', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let tahun = $(this).val();
        tagihan(id, tahun);
    });

    $(document).on('click', '.btn_whatsapp', function(e) {
        e.preventDefault();
        let nama = $(this).data('nama');
        let paket = $(this).data('paket');
        let biaya = $(this).data('biaya');
        let periode = $(this).data('periode');
        let no_hp = "62";
        no_hp += $(this).data('hp').substring(1);


        let text = "_Assalamualaikum Wr. Wb._%0a";
        text += "Yth. *" + nama + '*%0a%0a';
        text += 'Kami dari DALILI NET menyampaikan bahwa Anda memiliki tagihan periode *' + periode + '* sebesar *Rp' + angka(biaya) + '*.%0a';
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
    $(document).on('click', '.confirm', function(e) {
        e.preventDefault();
        let message = $(this).data('message');
        let tabel = $(this).data('tabel');
        let id = $(this).data('id');

        let html = `<div class="text-light mt-5">${message}</div>
                    <div class="d-flex justify-content-center gap-2 mt-3 text-light">
                        <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button class="btn btn-sm btn-danger px-3 delete" data-tabel="${tabel}" data-id="${id}">Ya</button>
                    </div>`;

        $(".modal_confirm").html(html);
        mdlConfirm.show();
    });
    $(document).on('click', '.delete', function(e) {
        e.preventDefault();

        let tabel = $(this).data('tabel');
        let id = $(this).data('id');

        post("delete", {
            id,
            tabel
        }).then(res => {
            message(res.message);
            if (res.status == 200) {
                setTimeout(() => {
                    location.reload();
                }, 1200);
            } else {
                message(res.message);
            }
        })


    });
</script>

<?= $this->endSection() ?>