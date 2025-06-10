<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul; ?></title>

    <link rel="icon" type="image/png" href="<?= base_url('logo.png'); ?>" sizes="16x16">

    <link href="<?= base_url(); ?>fontawesome/css/all.css" rel="stylesheet">
    <script src="<?= base_url(); ?>jquery.js"></script>
    <link rel="stylesheet" href="<?= base_url('bootstrap'); ?>/css/bootstrap.min.css">
    <script src="<?= base_url('bootstrap'); ?>/js/bootstrap.bundle.min.js"></script>
    <script>
        const message = (message) => {
            let html = `<div class="d-flex justify-content-center">
            <div class="border rounded px-4 pb-1" style="color: #939393;background-color:#fff">${message}</div>
        </div>`;

            $(".body_message").html(html);
            setTimeout(() => {
                $(".body_message").html("");
            }, 1000);

        }

        async function post(url = '', data = {}) {
            const response = await fetch("<?= base_url(); ?>" + url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
            return response.json(); // parses JSON response into native JavaScript objects
        }

        const time_php_to_js = (date, order = undefined) => {
            let d = new Date(date * 1000);
            let month = (d.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0, sehingga harus ditambah 1
            let day = d.getDate().toString().padStart(2, '0');
            let year = d.getFullYear();
            let hours = d.getHours().toString().padStart(2, '0'); // Format jam (dua digit)
            let minutes = d.getMinutes().toString().padStart(2, '0')

            let res = `${day}/${month}/${year}`;
            if (order !== undefined) {
                if (order == "d") {
                    res = day;
                }
                if (order === "jm") {
                    res = `${hours}:${minutes}`; // Format jam:menit
                }
                if (order === "Y-m-d") {
                    res = `${year}-${month}-${day}`; // Format jam:menit
                }

            }
            return res;
        }



        function angka(a, prefix) {
            let angka = a.toString();
            let isNegative = angka[0] === '-'; // Check if the number is negative
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            // Add negative sign back if the number is negative
            if (isNegative) {
                rupiah = '-' + rupiah;
            }

            return prefix == undefined ? rupiah : (rupiah ? (isNegative ? '-Rp. ' : 'Rp. ') + rupiah : '');
        }
    </script>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-dark navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <div class="navbar-brand"><?= $judul; ?></div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mt-1" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php foreach (menus() as $i): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= (url() == $i['url'] ? "active" : ""); ?>" href="<?= base_url($i['url']); ?>"><?= $i['menu']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?= $this->renderSection('content') ?>
    </div>

    <!-- modal update -->
    <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Update Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal_update">

                </div>
            </div>
        </div>
    </div>

    <!-- modal konfirmasi -->
    <div class="modal fade" id="confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-body text-center modal_confirm bg-dark">

                </div>
            </div>
        </div>
    </div>

    <div class="fixed-bottom pb-5 body_message" style="z-index: 999999;"></div>
    <script>
        let myModal = document.getElementById("update");
        let modal = bootstrap.Modal.getOrCreateInstance(myModal);

        let myConfirm = document.getElementById("confirm");
        let mdlConfirm = bootstrap.Modal.getOrCreateInstance(myConfirm);
        // mdlConfirm.show();

        $(document).on('keyup', '.cari', function(e) {
            e.preventDefault();
            let value = $(this).val().toLowerCase();
            $('.tabel_search tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });

        });

        $(document).on('keyup', '.angka', function(e) {
            e.preventDefault();
            let val = $(this).val();

            $(this).val(angka(val));
        });

        <?php if (session()->getFlashdata('gagal')) : ?>
            let msg = "<?= session()->getFlashdata('gagal'); ?>";
            message(msg);
        <?php endif; ?>
        <?php if (session()->getFlashdata('sukses')) : ?>
            let msg = "<?= session()->getFlashdata('sukses'); ?>";
            message(msg);
        <?php endif; ?>
    </script>
</body>

</html>