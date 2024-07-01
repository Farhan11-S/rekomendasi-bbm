<?php

require_once "PengajuanSurat/index.php";

$isSearched = isset($_GET['id']);
$id = $isSearched ? $_GET['id'] : null;
$result = false;

if ($isSearched) {
    $result = $pengajuanSurat->fetchByIDInput($id);
    $jenisUsaha = $pengajuanSurat->fetchJenisUsahaByID($result['jenis_usaha_id']);
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Dinas Pertanian dan Pangan Kabupaten Kudus</title>
</head>

<style>
    .red .nav-item .active,
    .red .nav-item .active:hover {
        background-color: red;
    }
</style>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/kab-kudus.png" width="50" height="50" class="d-inline-block align-top" alt="">
                <span>Dinas Pertanian dan Pangan Kabupaten Kudus</span>
            </a>

            <button class="btn my-2 my-sm-2 text-white" style="background-color: red;" type="button"><a href="login-admin.php" class="text-white">
                    Login
                </a></button>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="syarat-box mt-4">
                    <p>Syarat Pengajuan & Syarat Rekomendasi BBM</p>
                    <ul>
                        <li>Mengisi formulir</li>
                        <li>Foto surat keterangan domisili tempat usaha dari kepala desa</li>
                        <li>Foto KTP</li>
                        <li>Foto mesin/alat penggerak</li>
                    </ul>

                    <p>Syarat Perpanjangan Surat</p>
                    <ul>
                        <li>Foto surat keterangan bahwa yang bersangkutan masih hidup dari kepala desa</li>
                    </ul>

                    <center>
                        <span><b>HARAP CATAT NOMOR ID PERMOHONAN</b></span>
                        <br />
                        <span><b>UNTUK MELIHAT PROGRES SURAT</b></span>
                    </center>
                </div>
            </div>
            <div class="col-sm">
                <div class="syarat-box mt-4">
                    <img src="assets/joglo.png" width="400" height="300" />
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div>
                <ul class="nav justify-content-center nav-pills my-2 red">
                    <li class="nav-item">
                        <a class="nav-link active rounded-0" aria-current="page" href="#">Lacak Proses Surat</a>
                    </li>
                    <li class="nav-item bg-light">
                        <a class="nav-link text-dark rounded-0" href="form.php">Ajukan Permohonan</a>
                    </li>
                </ul>
            </div>
            <form class="form my-2">
                <input class="form-control mr-sm-2" type="text" placeholder="Masukkan ID Surat yang ingin di Lacak" aria-label="Search" name="id">
                <div class="width-100 text-center">
                    <button class="btn my-2 my-sm-2 mx-auto text-white" style="background-color: red;" type="submit">Search</button>

                    <?php if ($isSearched) : ?>
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" colspan="4">Surat yang Diajukan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!$result) : ?>
                                    <tr>
                                        <td scope="row" class="">Data Tidak Ditemukan</td>
                                    </tr>
                                <?php else : ?>
                                    <tr>
                                        <td scope="row" class="">ID Surat</td>
                                        <td><?php echo $result['id_input'] ?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row" class="">Nama</td>
                                        <td><?php echo $result['nama_lengkap'] ?? '' ?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">NIK</td>
                                        <td><?php echo $result['nik'] ?? '' ?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Alamat Usaha</td>
                                        <td><?php echo $result['alamat_spbu'] ?? '' ?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Jenis Usaha</td>
                                        <td><?php echo $jenisUsaha['jenis_usaha'] ?? '' ?> - <?php echo $jenisUsaha['jenis_alat'] ?? '' ?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Nama Usaha</td>
                                        <td><?php echo $result['nama_usaha'] ?? '' ?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Status Pengajuan</td>
                                        <?= ($result['pengajuan_surat']['status'] == 'Aktif' ? '<td style="background-color: green; color:white">' : '<td style="background-color: red; color: white">') . $result['pengajuan_surat']['status'] . '</td>' ?>
                                    </tr>
                                    <tr>
                                        <td scope="row">Catatan</td>
                                        <td><?php echo $result['pengajuan_surat']['note'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>


                    <?php endif; ?>
                </div>
            </form>
            <?php if (!empty($result) && $result['pengajuan_surat']['status'] == 'Tidak Berlaku') : ?>
                <form action="form-perpanjangan.php" method="post" class="width-100 text-center mb-5">
                    <button type="submit" class="btn btn-success mx-auto" name="redirect" value="<?= $id ?>">Perpanjang Surat</button>
                </form>
            <?php endif; ?>
            <?php if (!empty($result) && $result['pengajuan_surat']['status'] == 'Aktif') : ?>
                <form action="printable.php" method="post" class="width-100 text-center mb-5">
                    <input type="hidden" name="id_input" value="<?= $result['id_input'] ?>">
                    <input type="hidden" name="nama_lengkap" value="<?= $result['nama_lengkap'] ?>">
                    <input type="hidden" name="nik" value="<?= $result['nik'] ?>">
                    <input type="hidden" name="alamat" value="<?= $result['alamat'] ?>">
                    <input type="hidden" name="alamat_spbu" value="<?= $result['alamat_spbu'] ?>">
                    <input type="hidden" name="jenis_usaha" value="<?= $jenisUsaha['jenis_usaha'] ?? '' ?>">
                    <input type="hidden" name="jenis_alat" value="<?= $jenisUsaha['jenis_alat'] ?? '' ?>">
                    <input type="hidden" name="nama_usaha" value="<?= $result['nama_usaha'] ?>">
                    <input type="hidden" name="volume_bbm_harian" value="<?= $result['volume_bbm_harian'] ?>">
                    <input type="hidden" name="nomor_induk_spbu" value="<?= $result['nomor_induk_spbu'] ?>">
                    <input type="hidden" name="created_at" value="<?= $result['created_at'] ?>">
                    <button type="submit" class="btn btn-success mx-auto" name="redirect" value="<?= $id ?>">Cetak Rekomendasi Surat</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</body>

</html>