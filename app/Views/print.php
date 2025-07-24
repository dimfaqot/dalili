<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak Struk</title>
    <style>
        body {
            font-family: monospace;
            font-size: 14px;
            width: 250px;
        }

        .center {
            text-align: center;
        }

        .btn {
            margin-top: 20px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div id="struk">
        <div class="center">
            <h3>TOKO MAJU JAYA</h3>
            <p>Jl. Merdeka No. 123</p>
            <p>Kasir: Budi</p>
            <p>==============================</p>
        </div>
        <p>1x Kopi Hitam ............ Rp10.000</p>
        <p>2x Roti Bakar ............ Rp20.000</p>
        <p>------------------------------</p>
        <p>Total .................... Rp30.000</p>
        <p>Bayar .................... Rp50.000</p>
        <p>Kembali .................. Rp20.000</p>
        <div class="center">
            <p>Terima Kasih!</p>
        </div>
    </div>

    <button class="btn" onclick="connectAndPrint()">Cetak via Bluetooth</button>

    <script src="https://cdn.jsdelivr.net/npm/bluetooth-print-js@1.0/index.min.js"></script>
    <script>
        async function connectAndPrint() {
            const printer = new PrintPlugin("58mm");
            printer.connectToPrint({
                onReady: async (print) => {
                    await print.writeText("TOKO MAJU JAYA", {
                        align: "center",
                        bold: true
                    });
                    await print.writeText("Jl. Merdeka No. 123", {
                        align: "center"
                    });
                    await print.writeText("Kasir: Budi", {
                        align: "center"
                    });
                    await print.writeText("==============================");
                    await print.writeText("1x Kopi Hitam ............ Rp10.000");
                    await print.writeText("2x Roti Bakar ............ Rp20.000");
                    await print.writeText("------------------------------");
                    await print.writeText("Total .................... Rp30.000");
                    await print.writeText("Bayar .................... Rp50.000");
                    await print.writeText("Kembali .................. Rp20.000");
                    await print.writeText("Terima Kasih!", {
                        align: "center"
                    });
                },
                onFailed: (message) => {
                    alert("Gagal koneksi ke printer: " + message);
                },
            });
        }
    </script>
</body>

</html>