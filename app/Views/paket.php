<?= $this->extend('templates/logged') ?>

<?= $this->section('content') ?>
<div class="d-flex my-3 gap-3">
    <div class="w-100"><input type="text" class="form-control search" placeholder="Cari"></div>
    <div class="flex-shrink-1"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Tambah</button></div>

</div>

<?php foreach ($data as $i): ?>

    <div class="card mb-3 target_search" data-target="<?= $i['paket']; ?>">
        <div class="card-body border">
            <div class="d-flex justify-content-between">
                <div>
                    <h4><?= $i['paket']; ?></h4>
                    <div><?= angka($i['harga']); ?></div>
                </div>
                <div class="mt-2"><a href="" class="update" data-id="<?= $i['id']; ?>" style="text-decoration: none;">Update <i class="fa-solid fa-chevron-right"></i></a></div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<!-- modal add -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mt-3" method="post" action="<?= base_url(menu()['url'] . '/add'); ?>">
                    <div class="mb-3">
                        <label class="form-label">Paket</label>
                        <input type="text" class="form-control" name="paket" placeholder="Nama paket" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="text" class="form-control angka" name="harga" placeholder="Harga" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let data = <?= json_encode($data); ?>;

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
            if (e.id == id) {
                val = e;
            }
        });

        let html = `<form class="mt-3" method="post" action="<?= base_url(menu()['url'] . '/update'); ?>">
                        <input type="hidden" name="id" value="${val.id}">
                    <div class="mb-3">
                        <label class="form-label">Paket</label>
                        <input type="text" class="form-control" name="paket" value="${val.paket}" placeholder="Nama paket" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="text" class="form-control angka" name="harga" value="${angka(val.harga)}" placeholder="Harga" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>`;

        $(".modal_update").html(html);
        modal.show();
    });
</script>

<?= $this->endSection() ?>