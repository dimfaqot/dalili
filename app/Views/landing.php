<?= $this->extend('templates/guest') ?>

<?= $this->section('content') ?>

<div class="container-center">
    <div class="card p-4 border border-primary" style="width: 90%;--bs-border-opacity: 0.5;">
        <div class="card-body">
            <h1 class="text-center">DALILI NET</h1>
            <h6 class="text-center mb-5">- TAGIHAN WIFI -</h6>

            <input class="form-control mb-3" type="text" placeholder="Username">
            <input class="form-control mb-5" type="password" placeholder="Password">
            <div class="d-grid">
                <button class="btn btn-primary">Login</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>