<?= $this->extend('templates/logged') ?>

<?= $this->section('content') ?>
<form class="mt-3">
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" class="form-control" placeholder="Nama">
    </div>
    <div class="mb-3">
        <label class="form-label">Paket</label>
        <input type="text" class="form-control" placeholder="Paket">
    </div>
    <div class="mb-3">
        <label class="form-label">Periode</label>
        <input type="text" class="form-control" placeholder="Periode">
    </div>
    <div class="mb-5">
        <label class="form-label">Total</label>
        <input type="text" class="form-control" placeholder="Total">
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Buat Tagihan</button>
    </div>
</form>

<?= $this->endSection() ?>