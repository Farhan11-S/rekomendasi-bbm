<?php

require_once "../Auth/index.php";
require_once "../PengajuanSurat/index.php";

// Cek status login user
if (!$user->isLoggedIn()) {
    header("location: ../login-admin.php"); //redirect ke index
}

if (isset($_POST['signout'])) {
    if ($user->logout()) {
        header("location: ../index.php");
    }
}

if (isset($_POST['status'])) {
    if ($pengajuanSurat->updateStatus($_POST['id'], $_POST['status'], $_POST['note'], $_SESSION['user_session'])) {
        header("location: ./validasi-surat.php");
    }
}

$result = $pengajuanSurat->fetchAllValidasi();
$dataJenisUsaha = $pengajuanSurat->fetchAllJenisUsaha();
?>
<!doctype html>
<html lang="en">

<?php include "template-header.html"  ?>

<style type="text/css">
.rangkasurat {
    margin: 0 auto;
    background-color: #fff;
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

<body>
    <?php include "template-navbar.html"  ?>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="./index.php">
                                <span data-feather="home"></span>
                                Validasi Surat <span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Validasi Surat</h1>
                </div>

                <div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID Surat</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $i => $row) {
                            ?>
                            <tr onclick="openModal(<?php echo $i ?>)">
                                <td><?php echo $i + 1 ?></td>
                                <td><?php echo $row['id_input'] ?></td>
                                <td><?php echo $row['nama_lengkap'] ?></td>
                                <td><?php echo $row['status'] ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Validasi Surat</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="rangkasurat">
                                    <table class="kop">
                                        <tr>
                                            <td style="width: 96px;"> <img src="../assets/kab-kudus.png" width="128px"
                                                    style="vertical-align: top;"> </td>
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
                                            <p style="text-decoration: underline;">SURAT REKOMENDASI PEMBELIAN BBM
                                                TERTENTU (MINYAK SOLAR)</p>
                                            <p>Nomor : <span id="id_input"></span></p>
                                        </div>

                                        <div style="margin-top: 18px;">
                                            <p>Dasar Hukum : </p>
                                            <table class="dasar-hukum">
                                                <tr>
                                                    <td>1. </td>
                                                    <td>Undang Undang Nomor 22 Tahun 2001 tentang Minyak dan Gas Bumi
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2. </td>
                                                    <td>Undang Undang Nomor 23 Tahun 2014 tentang Pemerintah Daerah</td>
                                                </tr>
                                                <tr>
                                                    <td>3. </td>
                                                    <td>Peraturan Presiden Nomor 191 Tahu 2014 tentang Penyediaan,
                                                        Pendistribusian dan Harga JUal Eceran Bhahan Bakar Minyak</td>
                                                </tr>
                                                <tr>
                                                    <td>4. </td>
                                                    <td>Peraturan Kepala Badan Pengatur Hilir Minyakdan Gas Bumi
                                                        Republik Indonesia Nomor 2 Tahun 2023 tentang Penerbitan Surat
                                                        Rekomendasi Untuk Pembelian Jenis Bahan Bakar Minyak Tertentu
                                                        dan Jenis Bahan Bakar Minyak Khusus Penugasan</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div style="margin-top: 18px;">
                                            <p>Dengan ini memberikan rekomendasi kepada : </p>
                                            <table class="user-info" style="border-spacing: 0">
                                                <tr>
                                                    <td>Nama</td>
                                                    <td>:</td>
                                                    <td id="nama_lengkap"></td>
                                                </tr>
                                                <tr>
                                                    <td>NIK</td>
                                                    <td>:</td>
                                                    <td id="nik"></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat Usaha</td>
                                                    <td>:</td>
                                                    <td id="alamat"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Usaha</td>
                                                    <td>:</td>
                                                    <td id="jenis_usaha"> - </td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Usaha</td>
                                                    <td>:</td>
                                                    <td id="nama_usaha"></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div style="margin-top: 18px;">
                                            <p>Berdasarkan hasil Verifikasi, Diberikan Jenis BBM Tertentu Jenis Minyak
                                                Solar</p>
                                            <table class="user-info" style="border-spacing: 0">
                                                <tr>
                                                    <td>Sejumlah</td>
                                                    <td>:</td>
                                                    <td id="volume_bbm_harian"></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat SPBU</td>
                                                    <td>:</td>
                                                    <td id="alamat_spbu"></td>
                                                </tr>
                                                <tr>
                                                    <td>No. Induk SPBU</td>
                                                    <td>:</td>
                                                    <td id="nomor_induk_spbu"></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div style="margin-top: 18px;">
                                            <p>Dasar Hukum : </p>
                                            <table class="dasar-hukum">
                                                <tr>
                                                    <td>5. </td>
                                                    <td id="date"></td>
                                                </tr>
                                                <tr>
                                                    <td>6. </td>
                                                    <td>Penggunaan Surat Rekomendasi menjadi tanggung jawab mutlak
                                                        pemohon, dan apabila penggunaan tidak sebagaimana mestinya maka
                                                        akan secara otomatis surat rekomendasi ini tidak berlaku dan
                                                        akan diproses sesuai ketentuan dan peraturan perundang-undangan
                                                        yang berlaku.</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="" method="post" class="p-3">
                                    <input type="hidden" name="id" id="hidden_id" value="">
                                    <input type="hidden" name="note" id="hidden_note" value="">
                                    <button type="submit" class="btn btn-success" value="Aktif" name="status">Validasi</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
    feather.replace()
    const result = <?php echo json_encode($result) ?>;
    const dataJenisUsaha = <?php echo json_encode($dataJenisUsaha) ?>;

    function openModal(index) {
        const curr_data = result[index]
        const date = curr_data.created_at

        const jenisAlat = dataJenisUsaha.jenis_alat.find((v) => v['id'] == curr_data.jenis_usaha_id)?. ['jenis_alat'];
        const jenisUsaha = dataJenisUsaha.jenis_alat.find((v) => v['id'] == curr_data.jenis_usaha_id)?. ['jenis_usaha'];
        $('#myModalLabel').text(curr_data.id_input)
        $('#id_input').text(curr_data.id_input)
        $('#nama_lengkap').text(curr_data.nama_lengkap)
        $('#nik').text(curr_data.nik)
        $('#alamat').text(curr_data.alamat)
        $('#alamat_spbu').text(curr_data.alamat_spbu)
        $('#volume_bbm_harian').text(curr_data.volume_bbm_harian + ' Liter Per hari')
        $('#nomor_induk_spbu').text(curr_data.nomor_induk_spbu)
        $('#jenis_usaha').text(`${jenisAlat ?? ''} - ${jenisUsaha ?? ''}`)
        $('#nama_usaha').text(curr_data.nama_usaha)
        $('#hidden_id').val(curr_data.id)
        $('#hidden_note').val(curr_data.note)
        $('#date').text(`Masa Berlaku Surat Rekomendasi ${date} s/d `)
        $('#myModal').modal('show')
    }
    </script>
</body>

</html>