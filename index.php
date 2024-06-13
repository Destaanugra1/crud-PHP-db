<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "akademik";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
  die("Koneksi gagal: " . mysqli_connect_error());
}
$nim = "";
$nama = "";
$alamat = "";
$fakultas = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
} 
if($op == 'delete') {
  $id = $_GET['id'];
  $sql1 = "delete from mahasiswa where id = '$id'";
  $q1 = mysqli_query($koneksi, $sql1);
  if ($q1) {
    $sukses = "Data berhasil dihapus";
  } else {
    $error = "Data gagal dihapus";
  }
}
if ($op == 'edit') {
  $id = $_GET['id'];
  $sql1 = "select * from mahasiswa where id = '$id'";
  $q1 = mysqli_query($koneksi, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $nim = $r1['nim'];
  $nama = $r1['nama'];
  $alamat = $r1['alamat'];
  $fakultas = $r1['fakultas'];
  if ($nim == '') {
    $error = "Data tidak ditemukan";
  }
}
if (isset($_POST['simpan'])) { //untuk create
  if (isset($_POST['nim'])) {
    $nim = $_POST['nim'];
  }
  if (isset($_POST['nama'])) {
    $nama = $_POST['nama'];
  }
  if (isset($_POST['alamat'])) {
    $alamat = $_POST['alamat'];
  }
  if (isset($_POST['fakultas'])) {
    $fakultas = $_POST['fakultas'];
  }
  
  if ($nim && $nama && $alamat && $fakultas) {
    if ($op == 'edit') {
      $sql1 = "update mahasiswa set nim = '$nim', nama = '$nama', alamat = '$alamat', fakultas = '$fakultas' where id = '$id'";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error = "Data gagal diupdate";
      }
    } else {
      $sql1 = "insert into mahasiswa (nim, nama, alamat, fakultas) values ('$nim', '$nama', '$alamat', '$fakultas')";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Berhasil memasukkan data baru";
      } else {
        $error = "Gagal memasukkan data";
      }
    }
  } else {
    $error = "Silakan lengkapi data";
  }  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
    .mx-auto {
        width: 800px;
    }

    .card {
        margin-top: 10px;
    }
</style>
</head>
<body class="">
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php"); // 5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                    </div>
                    <label for="nama" class="col-sm-2 col-form-label">NAMA</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                    </div>
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                    </div>
                    <div class="mb-3 mt-3 row">
                      <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                      <div class="col-sm-10">
                        <select class="form-control mt-3" name="fakultas" id="fakultas">
                          <option selected>Pilih Fakultas</option>
                          <option value="Teknik Informatika" <?php if ($fakultas == "Teknik Informatika") echo "selected" ?>>Fakultas Ilmu Komputer</option>
                          <option value="Sistem Informasi"  <?php if ($fakultas == "Sistem Informasi") echo "selected" ?>>Sistem Informasi</option>
                          <option value="Fisika"  <?php if ($fakultas == "Fisika") echo "selected" ?>>Fisika</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12">
                      <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                  </div>
                  <!-- <div>
                    <p>&copy;Copyrigt by Desta 2024</p>
                  </div> -->
                </form>
                <!-- output data -->
                <div class="card">
                  <div class="card-header text-white bg-secondary">
                    Data Mahasiswa
                  </div>
                  <div class="card-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">NIM</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Alamat</th>
                          <th scope="col">Fakultas</th>
                          <th scope="col">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $sql2 = "select * from mahasiswa order by id desc";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                          $id = $r2['id'];
                          $nim = $r2['nim'];
                          $nama = $r2['nama'];
                          $alamat = $r2['alamat'];
                          $fakultas = $r2['fakultas'];
                        ?>
                        <tr>
                          <th scope="row"><?php echo $urut++ ?></th>
                          <td><?php echo $nim ?></td>
                          <td><?php echo $nama ?></td>
                          <td><?php echo $alamat ?></td>
                          <td><?php echo $fakultas ?></td>
                          <td>
                            <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                            <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button  type="button" class="btn btn-danger">Delete</button></a>
                          </td>
                        </tr>
                        <?php 
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
    </div>
    <footer class="text-center bg-dark">
      <div>
        <p class="text-primary mt-1">&copy;Copyrigt by Desta 2024</p>
      </div>
    </footer>
</body>
</html>