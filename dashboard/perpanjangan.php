<?php

require_once "../Auth/index.php";
require_once "../PerpanjanganSurat/index.php";

// Cek status login user
if (!$user->isLoggedIn()) {
  header("location: login-admin.php"); //redirect ke index
}

if (isset($_POST['signout'])) {
  if ($user->logout()) {
    header("location: index.php");
  }
}

if (isset($_POST['status'])) {
  if ($perpanjanganSurat->updateStatus($_POST['id'], $_POST['status'], $_POST['note'], $_SESSION['user_session'], $_POST['surat_rekomendasi_id'])) {
    header("location: dashboard");
  }
}

$result = $perpanjanganSurat->fetchAll();
$dataJenisUsaha = $perpanjanganSurat->fetchAllJenisUsaha();
?>
<!doctype html>
<html lang="en">

<?php include "template-header.html"  ?>

<body>
  <?php include "template-navbar.html"  ?>

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="/dashboard">
                <span data-feather="home"></span>
                Pengajuan Surat <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="/dashboard/perpanjangan.php">
                <span data-feather="file"></span>
                Perpanjangan Surat<span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Perpanjangan Surat</h1>
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

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col" colspan="4">Surat yang Diajukan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td scope="row">ID Surat</td>
                      <td id="id_input"></td>
                    </tr>
                    <tr>
                      <td scope="row">Nama</td>
                      <td id="nama_lengkap"></td>
                    </tr>
                    <tr>
                      <td scope="row">NIK</td>
                      <td id="nik"></td>
                    </tr>
                    <tr>
                      <td scope="row">Alamat Usaha</td>
                      <td id="alamat_spbu"></td>
                    </tr>
                    <tr>
                      <td scope="row">Jenis Usaha</td>
                      <td id="jenis_usaha"></td>
                    </tr>
                    <tr>
                      <td scope="row">Nama Usaha</td>
                      <td id="nama_usaha"></td>
                    </tr>
                    <tr>
                      <td scope="row">Status Perpanjangan</td>
                      <td id="status"></td>
                    </tr>
                  </tbody>
                </table>

                <table class="table table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col" colspan="4">Lampiran</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td scope="row">Keterangan </td>
                      <td><img id="foto_keterangan" class="img-fluid img-thumbnail"></td>
                    </tr>
                  </tbody>
                </table>
                <div id="form_update">
                  <form action="" method="post" class="p-3">
                    <label for="note">Catatan</label>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" id="note" name="note" aria-describedby="basic-addon3" placeholder="Masukkan catatan (required)" required>
                      <input type="text" hidden name="surat_rekomendasi_id" id="surat_rekomendasi_id">
                    </div>
                    <input type="hidden" name="id" id="hidden_id" value="">
                    <button type="submit" class="btn btn-success" name="status" value="Aktif">Terima</button>
                    <button type="submit" class="btn btn-danger" name="status" value="Ditolak">Tolak</button>
                  </form>
                </div>
              </div>
              <div class="modal-footer">
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
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
    feather.replace()
    const result = <?php echo json_encode($result) ?>;
    const dataJenisUsaha = <?php echo json_encode($dataJenisUsaha) ?>;

    function openModal(index) {
      const curr_data = result[index]

      const jenisAlat = dataJenisUsaha.jenis_alat.find((v) => v['id'] == curr_data.jenis_usaha_id)?.['jenis_alat'];
      const jenisUsaha = dataJenisUsaha.jenis_alat.find((v) => v['id'] == curr_data.jenis_usaha_id)?.['jenis_usaha'];
      $('#myModalLabel').text(curr_data.id_input)
      $('#id_input').text(curr_data.id_input)
      $('#surat_rekomendasi_id').val(curr_data.surat_rekomendasi_id)
      $('#nama_lengkap').text(curr_data.nama_lengkap)
      $('#nik').text(curr_data.nik)
      $('#alamat_spbu').text(curr_data.alamat_spbu)
      $('#jenis_usaha').text(`${jenisAlat ?? ''} - ${jenisUsaha ?? ''}`)
      $('#nama_usaha').text(curr_data.nama_usaha)
      $('#status').text(curr_data.status)
      $('#hidden_id').val(curr_data.id)
      $('#foto_keterangan').attr('src', '/uploads/' + curr_data.foto_keterangan)
      if (curr_data.status !== 'Menunggu Konfirmasi') $('#form_update').hide()
      $('#myModal').modal('show')
    }
  </script>
</body>

</html>