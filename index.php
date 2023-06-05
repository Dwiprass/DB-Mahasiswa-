<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "akademik";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { // cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nim = "";
$nama = "";
$alamat = "";
$fakultas = "";
$tanggal_lahir = "";
$jenis_kelamin = "";
$email = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from mahasiswa where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil Hapus Data";
    } else {
        $error = "Gagal Hapus Data";
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
    $tanggal_lahir = $r1['tanggal_lahir'];
    $jenis_kelamin = $r1['jenis_kelamin'];
    $email = $r1['email'];

    if ($nim == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { //untuk create
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $fakultas = $_POST['fakultas'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $email = $_POST['email'];

    if ($nim && $nama && $alamat && $fakultas && $tanggal_lahir && $jenis_kelamin && $email) {
        if ($op == 'edit') { //untuk update
            $sql1 = "update mahasiswa set nim = '$nim', nama ='$nama',alamat ='$alamat',fakultas = '$fakultas',tanggal_lahir = '$tanggal_lahir',jenis_kelamin = '$jenis_kelamin',email = '$email' where id = '$id' ";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data Berhasil Diupdate";
            } else {
                $error = "Data Gagal Diupdate";
            }
        } else { //untuk insert

            $sql3 = "SELECT * FROM mahasiswa where nim='$nim'";
            $validasi = mysqli_query($koneksi, $sql3);



            if ($validasi->num_rows > 0) {
                $error = "Data Dengan NIM : " . $nim . " Sudah Ada";
            } else {
                $sql1 = "INSERT INTO mahasiswa (nim, nama, alamat, fakultas, tanggal_lahir, jenis_kelamin, email) VALUES ('$nim', '$nama', '$alamat', '$fakultas', '$tanggal_lahir', '$jenis_kelamin', '$email')";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses = "Berhasil Menambahkan Data";
                } else {
                    $error = "Gagal Menambahkan Data";
                }
            }

        }

    } else {
        $error = "Silahkan masukan semua data";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    
</head>

</html>

<body>
    <div class="mx-auto">
        <!-- untuk memasukan data-->
        <div class="card">
            <div class="card-header text-white text-center bg-secondary">
                MASUKAN DATA MAHASISWA
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                    header("refresh:2;url=index.php"); //2 : detik
                    ?>
                <?php endif; ?>
                <?php if ($sukses): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                    header("refresh:2;url=index.php");
                    ?>
                <?php endif; ?>

                <form autocomplete="off" action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label label-nim">Nim</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label label-nama">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label label-alamat">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fakultas" class="col-sm-2 col-form-label label-fakultas">Fakultas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="fakultas" id="fakultas">
                                <option value="">- Pilih Fakultas -</option>
                                <option value="sistem_informasi" <?php if ($fakultas == "sistem_informasi")
                                    echo "selected" ?>>Sistem Informasi</option>
                                    <option value="ekonomi_dan_bisnis" <?php if ($fakultas == "ekonomi_dan_bisnis")
                                    echo "selected" ?>>Ekonomi dan Bisnis</option>
                                    <option value="ilmu_sosial_dan_politik" <?php if ($fakultas == "ilmu_sosial_dan_politik")
                                    echo "selected" ?>>Ilmu Sosial dan Politik</option>
                                    <option value="kedokteran" <?php if ($fakultas == "kedokteran")
                                    echo "selected" ?>>
                                        Kedokteran</option>
                                    <option value="hukum" <?php if ($fakultas == "hukum")
                                    echo "selected" ?>>Hukum</option>
                                    <option value="teknik_sipil" <?php if ($fakultas == "teknik_sipil")
                                    echo "selected" ?>>
                                        Teknik Sipil</option>
                                    <option value="pariwisata" <?php if ($fakultas == "pariwisata")
                                    echo "selected" ?>>
                                        Pariwisata</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tanggal_lahir" class="col-sm-2 col-form-label label-tanggal_lahir">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    value="<?php echo $tanggal_lahir ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label label-jenis_kelamin">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                                value="<?php echo $jenis_kelamin ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label label-email">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email"
                                value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data-->
        <div class="card">
            <div class="card-header text-center text-white bg-secondary">
                DATA MAHASISWA
            </div>
            <div class="card-body">
                <form autocomplete="off" action="" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword"
                            placeholder="Cari NIM atau Nama Mahasiswa">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Email</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $keyword = $_GET['keyword'] ?? '';
                        $sql2 = "SELECT * FROM mahasiswa WHERE nim LIKE '%$keyword%' OR nama LIKE '%$keyword%' ORDER BY id DESC";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $nim = $r2['nim'];
                            $nama = $r2['nama'];
                            $alamat = $r2['alamat'];
                            $fakultas = $r2['fakultas'];
                            $tanggal_lahir = $r2['tanggal_lahir'];
                            $jenis_kelamin = $r2['jenis_kelamin'];
                            $email = $r2['email'];
                            ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $urut++ ?>
                                </th>
                                <td scope="row">
                                    <?php echo $nim ?>
                                </td>
                                <td scope="row">
                                    <?php echo $nama ?>
                                </td>
                                <td scope="row">
                                    <?php echo $alamat ?>
                                </td>
                                <td scope="row">
                                    <?php echo $fakultas ?>
                                </td>
                                <td scope="row">
                                    <?php echo $tanggal_lahir ?>
                                </td>
                                <td scope="row">
                                    <?php echo $jenis_kelamin ?>
                                </td>
                                <td scope="row">
                                    <?php echo $email ?>
                                </td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button"
                                            class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>"
                                        onclick="return confirm('Yakin Hapus Data?')"><button type="button"
                                            class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>