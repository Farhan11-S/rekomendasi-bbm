<html>

<head>
    <title> Download Surat </title>
    <style type="text/css">
        body {
            font-family: sans-serif;
            background-color: #ccc
        }

        .rangkasurat {
            width: 850px;
            margin: 0 auto;
            background-color: #fff;
            height: 1100px;
            padding: 46px;
        }

        .kop {
            border-bottom: 5px solid #000;
            padding: 2px;
            border-spacing: 0 10px;
            width: 100%;
        }

        .tengah {
            text-align: center;
            line-height: 2px;
        }

        p,
        td {
            font-size: 14px;
        }

        .dasar-hukum td {
            vertical-align: top;
        }

        .user-info td:first-child {
            width: 128px;
        }

        .user-info td:nth-child(2) {
            width: 12px;
        }
    </style>
    <style type="text/css" media="print">
        @page {
            size: auto;
            /* auto is the initial value */
            margin: 0;
            /* this affects the margin in the printer settings */
        }
    </style>
</head>

<body onload="window.print()">
    <div class="rangkasurat">
        <table class="kop">
            <tr>
                <td style="width: 96px;"> <img src="assets/kab-kudus.png" width="128px" style="vertical-align: top;"> </td>
                <td class="tengah">
                    <p>PEMERINTAH KABUPATEN KUDUS</p>
                    <p style="font-size: 18px">DINAS PERTANIAN DAN PANGAN</p>
                    <p>Jl. Mejobo Nomor 32 Kudus Kode Pos 59319</p>
                    <p>Telp. (0291) 431024 Fax. (0291) 431024</p>
                    <p>Email: dinaspertanian@kuduskab.go.id</p>
                    <p>Website: http://dispertan.kuduskab.go.id</p>
                </td>
            </tr>
        </table>
        <div class="body-surat" style="width: 85%; margin: 10px auto;">
            <div style="text-align:center; line-height: 2px;">
                <p style="text-decoration: underline;">SURAT REKOMENDASI PEMBELIAN BBM TERTENTU (MINYAK SOLAR)</p>
                <p>Nomor : <?= $_POST['id_input'] ?></p>
            </div>

            <div style="margin-top: 18px;">
                <p>Dasar Hukum : </p>
                <table class="dasar-hukum">
                    <tr>
                        <td>1. </td>
                        <td>Undang Undang Nomor 22 Tahun 2001 tentang Minyak dan Gas Bumi</td>
                    </tr>
                    <tr>
                        <td>2. </td>
                        <td>Undang Undang Nomor 23 Tahun 2014 tentang Pemerintah Daerah</td>
                    </tr>
                    <tr>
                        <td>3. </td>
                        <td>Peraturan Presiden Nomor 191 Tahu 2014 tentang Penyediaan, Pendistribusian dan Harga JUal Eceran Bhahan Bakar Minyak</td>
                    </tr>
                    <tr>
                        <td>4. </td>
                        <td>Peraturan Kepala Badan Pengatur Hilir Minyakdan Gas Bumi Republik Indonesia Nomor 2 Tahun 2023 tentang Penerbitan Surat Rekomendasi Untuk Pembelian Jenis Bahan Bakar Minyak Tertentu dan Jenis Bahan Bakar Minyak Khusus Penugasan</td>
                    </tr>
                </table>
            </div>

            <div style="margin-top: 18px;">
                <p>Dengan ini memberikan rekomendasi kepada : </p>
                <table class="user-info" style="border-spacing: 0">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?= $_POST['nama_lengkap'] ?></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td><?= $_POST['nik'] ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Usaha</td>
                        <td>:</td>
                        <td><?= $_POST['alamat'] ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Usaha</td>
                        <td>:</td>
                        <td><?= $_POST['jenis_usaha'] ?> - <?= $_POST['jenis_alat'] ?></td>
                    </tr>
                    <tr>
                        <td>Nama Usaha</td>
                        <td>:</td>
                        <td><?= $_POST['nama_usaha'] ?></td>
                    </tr>
                </table>
            </div>

            <div style="margin-top: 18px;">
                <p>Berdasarkan hasil Verifikasi, Diberikan Jenis BBM Tertentu Jenis Minyak Solar</p>
                <table class="user-info" style="border-spacing: 0">
                    <tr>
                        <td>Sejumlah</td>
                        <td>:</td>
                        <td><?= $_POST['volume_bbm_harian'] ?> Liter Per hari</td>
                    </tr>
                    <tr>
                        <td>Alamat SPBU</td>
                        <td>:</td>
                        <td><?= $_POST['alamat_spbu'] ?></td>
                    </tr>
                    <tr>
                        <td>No. Induk SPBU</td>
                        <td>:</td>
                        <td><?= $_POST['nomor_induk_spbu'] ?></td>
                    </tr>
                </table>
            </div>

            <div style="margin-top: 18px;">
                <p>Dasar Hukum : </p>
                <table class="dasar-hukum">
                    <tr>
                        <td>5. </td>
                        <?php
                        $date = date_create($_POST['created_at']);
                        $dateExpired = date_create($_POST['created_at']);
                        date_add($dateExpired, date_interval_create_from_date_string("90 days"));
                        $formatter = new IntlDateFormatter('id', IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM);
                        $formatter->setPattern('d MMMM YYYY');
                        ?>
                        <td>Masa Berlaku Surat Rekomendasi <?= $formatter->format($date); ?> s/d <?= $formatter->format($dateExpired); ?></td>
                    </tr>
                    <tr>
                        <td>6. </td>
                        <td>Penggunaan Surat Rekomendasi menjadi tanggung jawab mutlak pemohon, dan apabila penggunaan tidak sebagaimana mestinya maka akan secara otomatis surat rekomendasi ini tidak berlaku dan akan diproses sesuai ketentuan dan peraturan perundang-undangan yang berlaku.</td>
                    </tr>
                </table>
            </div>

            <div style="margin-top: 18px;">
                <table>
                    <tr style="text-align: center;">
                        <td style="width: 65%;"></td>
                        <td></td>
                        <td>KEPALA DINAS PERTANIAN DAN PANGAN</td>
                    </tr>
                    <tr style="height: 100px">
                        <td style="width: 65%;"></td>
                        <td></td>
                        <td><img style="margin-left: 28px;" src="assets/TTE dipertan.png" alt="tte dipertan" height="186"></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="width: 65%;"></td>
                        <td></td>
                        <td>
                            <p>Ir. DIDIK TRI PRASETYO</p>
                            <p>NIP : 196611271996031002</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>