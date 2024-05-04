<?php

require_once "Auth/index.php";
require_once "PengajuanSurat/index.php";

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
  if($pengajuanSurat->updateStatus($_POST['id'], $_POST['status'], $_POST['note'], $_SESSION['user_session'])) {
    header("location: dashboard.php");
  }
}

$result = $pengajuanSurat->fetchAll();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">

  <title>Admin Dashboard</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/dashboard/">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- Custom styles for this template -->
</head>

<style>
  body {
    font-size: .875rem;
  }

  .feather {
    width: 16px;
    height: 16px;
    vertical-align: text-bottom;
  }

  /*
 * Sidebar
 */

  .sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    /* Behind the navbar */
    padding: 48px 0 0;
    /* Height of navbar */
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
  }

  .sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: .5rem;
    overflow-x: hidden;
    overflow-y: auto;
    /* Scrollable contents if viewport is shorter than content. */
  }

  @supports ((position: -webkit-sticky) or (position: sticky)) {
    .sidebar-sticky {
      position: -webkit-sticky;
      position: sticky;
    }
  }

  .sidebar .nav-link {
    font-weight: 500;
    color: #333;
  }

  .sidebar .nav-link .feather {
    margin-right: 4px;
    color: #999;
  }

  .sidebar .nav-link.active {
    color: #007bff;
  }

  .sidebar .nav-link:hover .feather,
  .sidebar .nav-link.active .feather {
    color: inherit;
  }

  .sidebar-heading {
    font-size: .75rem;
    text-transform: uppercase;
  }

  /*
 * Content
 */

  [role="main"] {
    padding-top: 48px;
    /* Space for fixed navbar */
  }

  /*
 * Navbar
 */

  .navbar-brand {
    padding-top: .75rem;
    padding-bottom: .75rem;
    font-size: 1rem;
    background-color: rgba(0, 0, 0, .25);
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
  }

  .navbar .form-control {
    padding: .75rem 1rem;
    border-width: 0;
    border-radius: 0;
  }

  .form-control-dark {
    color: #fff;
    background-color: rgba(255, 255, 255, .1);
    border-color: rgba(255, 255, 255, .1);
  }

  .form-control-dark:focus {
    border-color: transparent;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
  }
</style>

<body>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Admin Dashboard</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <form action="" method="post">
          <button class="nav-link bg-dark btn-flat" type="submit" name="signout">Sign out</button>
        </form>
      </li>
    </ul>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">
                <span data-feather="home"></span>
                Pengajuan Surat <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file"></span>
                Perpanjangan Surat
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Pengajuan Surat</h1>
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

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
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
                      <td scope="row" class="">ID Surat</td>
                      <td id="id_input"></td>
                    </tr>
                    <tr>
                      <td scope="row" class="">Nama</td>
                      <td id="nama_lengkap"></td>
                    </tr>
                    <tr>
                      <td scope="row">NIK</td>
                      <td id="nik"></td>
                    </tr>
                    <tr>
                      <td scope="row">Alamat Usaha</td>
                      <td id="alamat_usaha"></td>
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
                      <td scope="row">Status Pengajuan</td>
                      <td id="status"></td>
                    </tr>
                  </tbody>
                </table>
                <div id="form_update">
                  <form action="" method="post" class="p-3">
                    <label for="note">Catatan</label>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" id="note" name="note" aria-describedby="basic-addon3" placeholder="Masukkan catatan (required)" required>
                    </div>
                    <input type="hidden" name="id" id="hidden_id" value="">
                    <button type="submit" class="btn btn-success" name="status" value="Diterima">Terima</button>
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
    const result = <?php echo json_encode($result) ?>

    function openModal(index) {
      const curr_data = result[index]
      $('#myModalLabel').text(curr_data.id_input)
      $('#id_input').text(curr_data.id_input)
      $('#nama_lengkap').text(curr_data.nama_lengkap)
      $('#nik').text(curr_data.nik)
      $('#alamat_usaha').text(curr_data.alamat_usaha)
      $('#jenis_usaha').text(curr_data.jenis_usaha)
      $('#nama_usaha').text(curr_data.nama_usaha)
      $('#status').text(curr_data.status)
      $('#hidden_id').val(curr_data.id)
      if (curr_data.status !== 'Menunggu Konfirmasi') $('#form_update').hide()
      $('#myModal').modal('show')
    }
  </script>
</body>

</html>