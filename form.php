<?php
require_once "PengajuanSurat/index.php";

$t = time();
$date = date("d-m-Y", $t);
$id = $pengajuanSurat->generateID();
$jenisUsaha = $pengajuanSurat->fetchAllJenisUsaha();

function imageHandler($field)
{
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES[$field]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES[$field]["tmp_name"]);
    $uploadOk = $check;
    $uploadOk = !file_exists($target_file);
    $uploadOk = $_FILES[$field]["size"] > 500000;
    $uploadOk = !($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif");

    if (!$uploadOk) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (!move_uploaded_file($_FILES[$field]["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
        } else {
            return basename($_FILES[$field]["name"]);
        }
    }

    return false;
}


if (isset($_POST['kirim'])) {

    $fotoMesin = imageHandler("foto_mesin");
    $fotoKTP = imageHandler("foto_ktp");
    $fotoDomisili = imageHandler("foto_domisili");

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
        'tipe' => $_POST['tipe'],
        'merk' => $_POST['merk'],
        'foto_mesin' => $fotoMesin,
        'foto_ktp' => $fotoKTP,
        'foto_domisili' => $fotoDomisili,
    ])) {
        header("location: index.php");
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

                <form method="post" id="mainform" enctype="multipart/form-data">
                    <div class="row">
                        <div class='col-md-6'>
                            <?php if (isset($error)) : ?>

                                <div class="error">

                                    <?php echo $error ?>

                                </div>

                            <?php endif; ?>
                            <div class="form-group has-feedback" align="left">
                                <label>1) Tanggal Input <p style="color: red; display: inline-block;">*</p></label>
                                <input type="text" name="tanggal" value="<?php echo $date ?>" disabled>
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>2) No ID Permohonan <p style="color: red; display: inline-block;">*</p></label>
                                <input name="id_input" required type="text" class="form-control" placeholder="Masukkan Nomor ID Permohonan" value="<?php echo  $id ?>" disabled>
                                <input name="id_input" required type="hidden" class="form-control" placeholder="Masukkan Nomor ID Permohonan" value="<?php echo $id ?>">
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>3) NIK <p style="color: red; display: inline-block;">*</p></label>
                                <input name="nik" required type="text" class="form-control" placeholder="NIK wajib diisi">
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>4) Nama Lengkap <p style="color: red; display: inline-block;">*</p></label>
                                <input name="nama_lengkap" required type="text" class="form-control" placeholder="Masukkan Nama Lengkap">
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>5) Alamat <p style="color: red; display: inline-block;">*</p></label>
                                <input name="alamat" required type="text" class="form-control" placeholder="Masukkan Alamat">
                            </div>

                            <div class="form-group has-feedback" align="left">
                                <label>6) No. HP <p style="color: red; display: inline-block;">*</p></label>
                                <input name="no_hp" required type="text" class="form-control" placeholder="Masukkan No. HP">
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group" align="left">
                                <label>7) Jenis BBM <p style="color: red; display: inline-block;">*</p></label>
                                <select id="jenis_bbm" class="form-control" name="jenis_bbm" style="width: 45%;" required>
                                    <option value="">Pilih </option>
                                    <option value="Minyak Tanah">Minyak Tanah</option>
                                    <option value="Bensin (Gasoline) RON 88">Bensin (Gasoline) RON 88</option>
                                    <option value="Minyak Solar">Minyak Solar</option>
                                </select>


                            </div>
                            <div class="form-group has-feedback" align="left">
                                <label>8) Alokasi Volume BBM (liter / hari) <p style="color: red; display: inline-block;">*</p></label>
                                <input name="volume_bbm_harian" type="text" class="form-control" placeholder="Tuliskan angka & huruf, contoh : 25 (dua puluh lima)" required>
                            </div>
                            <div style="margin: 20px 0px">
                                <h4><b>9) BBM tersebut akan kami pergunakan untuk : </b> </h4>
                            </div>
                            <div class='row'>

                                <div align="left" class='form-group' style="margin-left: 17px;">
                                    <label>a) Pilih Jenis Usaha <p style="color: red; display: inline-block;">*</p>
                                    </label>
                                    <select id="jenis_usaha" class="form-control" onchange="populate(this.value,'jenis_alat')" required>
                                        <option value=''>Pilih</option>
                                        <?php
                                        foreach ($jenisUsaha['jenis_usaha'] as $value) {
                                            echo "<option value='$value'>$value</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div align="left" class='form-group' style="margin-left: 17px;">
                                    <label>b) Pilih Nama/Jenis Alat <p style="color: red; display: inline-block;">*</p>
                                    </label>
                                    <select name='jenis_usaha_id' class='form-control' id='jenis_alat' disabled required></select>
                                </div>
                                <div align="left" class='form-group' style="margin-left: 17px;">
                                    <label>c) Nama Usaha <p style="color: red; display: inline-block;">*</p></label>
                                    <input name="nama_usaha" type="text" class="form-control" placeholder="Isikan alat yg digunakan...." required>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label>10) Nomor Induk SPBU <p style="color: red; display: inline-block;">*</p></label>
                            <input name="nomor_induk_spbu" type="text" class="form-control" placeholder="Isikan Nomor Induk SPBU" required>
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label>11) Alamat SPBU <p style="color: red; display: inline-block;">*</p></label>
                            <input name="alamat_spbu" type="text" class="form-control" placeholder="Isikan Alamat SPBU">
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label>12) Merk <p style="color: red; display: inline-block;">*</p></label>
                            <input name="merk" type="text" class="form-control" placeholder="Isikan Merk" required>
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label>13) Tipe <p style="color: red; display: inline-block;">*</p></label>
                            <input name="tipe" type="text" class="form-control" placeholder="Isikan Tipe" required>
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label>14) Nomor Rangka Mesin <p style="color: red; display: inline-block;">*</p></label>
                            <input name="nomor_rangka_mesin" type="text" class="form-control" placeholder="Isikan Nomor Rangka Mesin" required>
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label class="form-label">15) Foto Mesin/Alat Penggerak <p style="color: red; display: inline-block;">*</p></label>
                            <input type="file" class="form-control" name="foto_mesin" required />
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label class="form-label">16) Foto KTP <p style="color: red; display: inline-block;">*</p>
                            </label>
                            <input type="file" class="form-control" name="foto_ktp" required />
                        </div>

                        <div class="form-group has-feedback" align="left" style="margin-left: 17px;">
                            <label class="form-label">17) Foto Keterangan Domisili Tempat Usaha dari Kepala Desa <p style="color: red; display: inline-block;">*</p></label>
                            <input type="file" class="form-control" name="foto_domisili" required />
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>

    <script>
        const jenisAlat = <?php echo json_encode($jenisUsaha['jenis_alat']) ?>

        $.fn.isValid = function() {
            return this[0].reportValidity()
        }

        function populate(jenisUsaha) {
            const select = document.getElementById('jenis_alat');

            const tmp = jenisAlat
                .filter((v) => v.jenis_usaha === jenisUsaha)
                .map((v) => `<option value='${v.id}'>${v.jenis_alat}</option>`)

            select.disabled = false
            select.innerHTML = `<option value=''>Pilih</option>` + tmp.join()
        }

        function validateForm() {
            if ($("#mainform").isValid()) {
                $("#myModal").modal('show')
            }
        }
    </script>
</body>

</html>