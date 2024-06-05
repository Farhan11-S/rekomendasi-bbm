<?php
require_once "PerpanjanganSurat/index.php";

$t = time();
$date = date("d-m-Y", $t);
$jenisUsaha = $perpanjanganSurat->fetchAllJenisUsaha();

if (!isset($_POST['redirect'])) header("location: index.php");
$idRedirect = $_POST['redirect'];


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

    $fotoKeterangan = imageHandler("foto_keterangan");

    if ($perpanjanganSurat->store([
        'id_input' => $_POST['id_input'],
        'foto_keterangan' => $fotoKeterangan,
    ])) {
        header("location: index.php");
    } else {
        // Jika login gagal, ambil pesan error
        $error = $perpanjanganSurat->getLastError();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpanjangan Surat</title>

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
                            Formulir Perpanjangan Surat Rekomendasi
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

                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group has-feedback" align="left">
                            <label>1) Tanggal Input <p style="color: red; display: inline-block;">*</p></label>
                            <input type="text" name="tanggal" value="<?php echo $date ?>" disabled>
                        </div>

                        <div class="form-group has-feedback" align="left">
                            <label>2) No ID Permohonan <p style="color: red; display: inline-block;">*</p></label>
                            <input name="id_input" required type="text" class="form-control" placeholder="Masukkan Nomor ID Permohonan" value="<?= $idRedirect ?>" disabled>
                            <input name="id_input" hidden type="text" value="<?= $idRedirect ?>">
                            <input name="redirect" hidden type="text" value="<?= $idRedirect ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group has-feedback" align="left">
                            <label class="form-label">3) Foto surat keterangan bahwa yang bersangkutan masih hidup dari kepala desa <p style="color: red; display: inline-block;">*</p></label>
                            <input type="file" class="form-control" name="foto_keterangan" required />
                        </div>

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
                                    <h4 class="modal-title" id="myModalLabel">Simpan Pengajuan Perpanjangan Surat Rekomendasi</h4>
                                </div>
                                <div class="modal-body">
                                    HARAP CATAT NOMOR ID PERMOHONAN UNTUK MELIHAT PROGRES SURAT
                                    <br>
                                    ID : <?= $idRedirect ?>
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
            if ($("#mainform").isValid()) {
                $("#myModal").modal('show')
            }
        }
    </script>
</body>

</html>