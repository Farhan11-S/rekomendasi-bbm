<?php
require_once "PengajuanSurat/index.php";

$t = time();
$date = date("d-m-Y", $t);
$id = $pengajuanSurat->generateID();

if (isset($_POST['kirim'])) {
    // Proses login user
    if ($pengajuanSurat->store([
        'id_input' => $_POST['id_input'],
        'nik' => $_POST['nik'],
        'nama_lengkap' => $_POST['nama_lengkap'],
        'alamat' => $_POST['alamat'],
        'no_hp' => $_POST['no_hp'],
        'jenis_bbm' => $_POST['jenis_bbm'],
        'volume_bbm_harian' => $_POST['volume_bbm_harian'],
        'jenis_usaha_id' => $_POST['jenis_usaha_id'],
        'nama_usaha' => $_POST['nama_usaha'],
        'nomor_induk_spbu' => $_POST['nomor_induk_spbu'],
        'alamat_spbu' => $_POST['alamat_spbu'],
        'nomor_rangka_mesin' => $_POST['nomor_rangka_mesin'],
        'foto_mesin' => $_POST['foto_mesin'],
        'foto_ktp' => $_POST['foto_ktp'],
        'foto_domisili' => $_POST['foto_domisili'],
    ])) {
        // header("location: index.php");
    } else {
        // Jika login gagal, ambil pesan error
        $error = $pengajuanSurat->getLastError();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi BBM</title>

    <!-- Theme style -->
    <link rel="stylesheet" href="adminLTE.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://taniku.kulonprogokab.go.id/assets/plugins/iCheck/square/blue.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class="register-box" style="width: 90%">
        <center>
            <div class="register-box-body">
                <div class="mb-5">
                    <b>
                        <font size="5" face="Arial">
                            Formulir Pembuatan Surat Rekomendasi
                            <br>
                            Pembelian BBM Online
                        </font>
                    </b>
                </div>

                <form method="post" id="mainform">
                    <div class="row">
                        <div class='col-md-6'>
                            <?php if (isset($error)) : ?>

                                <div class="error">

                                    <?php echo $error ?>

                                </div>

                            <?php endif; ?>
                            <div class="form-group has-feedback" align="left">
                                <label>1) Tanggal Input</label>
                                <input type="text" name="tanggal" value="<?php echo $date ?>" disabled>
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>2) No ID Permohonan</label>
                                <input name="id_input" required type="text" class="form-control" placeholder="Masukkan Nomor ID Permohonan" value="<?php echo  $id ?>" disabled>
                                <input name="id_input" required type="hidden" class="form-control" placeholder="Masukkan Nomor ID Permohonan" value="<?php echo $id ?>">
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>3) NIK </label>
                                <input name="nik" required type="text" class="form-control" placeholder="NIK wajib diisi">
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>4) Nama Lengkap</label>
                                <input name="nama_lengkap" required type="text" class="form-control" placeholder="Masukkan Nama Lengkap">
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>5) Alamat</label>
                                <input name="alamat" required type="text" class="form-control" placeholder="Masukkan Alamat">
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>6) No. HP</label>
                                <input name="no_hp" required type="text" class="form-control" placeholder="Masukkan No. HP">
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group" align="left">
                                <label>7) Jenis BBM</label>
                                <select id="jenis_bbm" class="form-control" name="jenis_bbm" style="width: 45%;">
                                    <option value="">Pilih </option>
                                    <option value="Minyak Tanah">Minyak Tanah</option>
                                    <option value="Bensin (Gasoline) RON 88">Bensin (Gasoline) RON 88</option>
                                    <option value="Minyak Solar">Minyak Solar</option>
                                </select>


                            </div>
                            <div class="form-group has-feedback" align="left">
                                <label>8) Alokasi Volume BBM (liter / hari) </label>
                                <input name="jumlah" type="text" class="form-control" placeholder="Tuliskan angka & huruf, contoh : 25 (dua puluh lima)">
                            </div>
                            <div style="margin: 20px 0px">
                                <h4><b>9) BBM tersebut akan kami pergunakan untuk : </b> </h4>
                            </div>
                            <div class='row'>

                                <div align="left" class='form-group' style="margin-left: 17px;">
                                    <label>a) Pilih Jenis Usaha</label>
                                    <select id="jenis_usaha" name="jenis_usaha" class="form-control" onchange="populate(this.id,'jenis_alat')">
                                        <option value=''>Pilih</option>
                                        <option value='Usaha Mikro'>Usaha Mikro</option>
                                        <option value='Usaha Pertanian'>Usaha Pertanian</option>
                                        <option value='Usaha Perikanan'>Usaha Perikanan</option>
                                        <option value='Pelayanan Umum'>Pelayanan Umum</option>
                                    </select>
                                </div>

                                <div align="left" class='form-group' style="margin-left: 17px;">
                                    <label>b) Pilih Nama/Jenis Alat</label>
                                    <select name='jenis_alat' class='form-control' id='jenis_alat'>
                                        <option value=''>Pilih</option>
                                        <option value='Mesin Perkakas'>Mesin Perkakas (usaha mikro)</option>
                                        <option value='Traktor'>Traktor (pertanian)</option>
                                        <option value='Genzet'>Genzet (pertanian)</option>
                                        <option value='Huller'>Huller (pertanian)</option>
                                        <option value='Mesin Tempel Perahu '>Mesin Tempel Perahu (perikanan)</option>
                                        <option value='Kincir'>Kincir (perikanan)</option>
                                        <option value='Sosial'>Sosial (pelayanan umum)</option>
                                        <option value='Kesehatan'>Kesehatan (pelayanan umum)</option>
                                    </select>
                                </div>

                                <div align="left" class='form-group' style="margin-left: 17px;">
                                    <label>c) Nama Usaha</label>
                                    <input name="nama_usaha" type="text" class="form-control" placeholder="Isikan alat yg digunakan....">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label>10) Nomor Induk SPBU</label>
                            <input name="nomor_induk_spbu" type="text" class="form-control" placeholder="Isikan Nomor Induk SPBU">
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label>11) Nomor Induk SPBU</label>
                            <input name="nomor_induk_spbu" type="text" class="form-control" placeholder="Isikan Nomor Induk SPBU">
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label>12) Alamat SPBU</label>
                            <input name="alamat_spbu" type="text" class="form-control" placeholder="Isikan Alamat SPBU">
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label>13) Nomor Rangka Mesin</label>
                            <input name="nomor_rangka_mesin" type="text" class="form-control" placeholder="Isikan Nomor Rangka Mesin">
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label class="form-label">14) Foto Mesin/Alat Penggerak</label>
                            <input type="file" class="form-control" name="foto_mesin" />
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label class="form-label">15) Foto KTP</label>
                            <input type="file" class="form-control" name="foto_ktp" />
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label class="form-label">16) Foto Keterangan Domisili Tempat Usaha dari Kepala Desa</label>
                            <input type="file" class="form-control" name="foto_domisili" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="checkbox icheck" style="text-align: justify;">
                                <font size="3" face="Arial">Data yang dimasukkan harus bisa dipertanggungjawabkan.
                                    <br> Silahkan periksa kembali data di atas, pastikan sudah diisi dengan baik dan
                                    benar !
                                </font>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-lg" onclick="validateForm()">
                                KIRIM PENGAJUAN
                            </button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Simpan Pengajuan Surat Rekomendasi</h4>
                                </div>
                                <div class="modal-body">
                                    HARAP CATAT NOMOR ID PERMOHONAN UNTUK MELIHAT PROGRES SURAT
                                    <br>
                                    ID : <?php echo $id ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        <font size="3" face="Arial">Close</font>
                                    </button>
                                    <button type="submit" class="btn btn-primary" name="kirim">
                                        <font size="3" face="Arial"><b>Simpan</b></font>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </center>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script>
        $.fn.isValid = function() {
            return this[0].reportValidity()
        }

        function validateForm() {
            console.log('babi', $("#mainform").isValid());
            if ($("#mainform").isValid()) {
                $("#myModal").modal('show')
            }
        }
    </script>
</body>

</html>