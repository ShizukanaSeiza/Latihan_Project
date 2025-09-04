<?php
session_start();
if (isset($_SESSION['alert'])){
    echo $_SESSION['alert'];
    unset($_SESSION['alert']);
  }
include "koneksi1.php";




// Ambil ID data yang akan diubah
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM daftar WHERE id ='$id'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
}

if (isset($_POST['update'])) {
    $nama          = $_POST['nama'];
    $ktp          = $_POST['ktp'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $tempat_lahir        = $_POST['tempat_lahir'];
    $pekerjaan        = $_POST['pekerjaan'];
    $minat        = $_POST['minat'];

    $sql = "UPDATE daftar SET Nama='$nama', KTP='$ktp', TanggalLahir='$tanggal_lahir', TempatLahir='$tempat_lahir', Pekerjaan='$pekerjaan', Minat='$minat' WHERE id='$id'";

    

    if ($conn->query($sql) === TRUE) {
        $_SESSION['alert']="<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Data berhasil diperbarui!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        $conn->close();
        header("Location:tampil.php");
    } else {
        $_SESSION['alert']="<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Error: " . $sql . "<br>" . $conn->error . "
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Ubah Data </title>
</head>
<body>
<h3 class="text-center">Ubah Data</h3>

<div class="container">
    <div class="row">
        <div class="col">
            <form method="POST" class="border p-4 rounded shadow" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $row['Nama']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">KTP</label>
                    <input type="text" name="ktp" class="form-control" maxlength="16" value="<?php echo $row['KTP']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $row['TanggalLahir']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Tempat lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="<?php echo $row['TempatLahir']; ?>" required>
                </div>
                <div class="mb-3">
                <label for=""  class="form-label">Pekerjaan</label>
                <select  class="form-control" name="matakuliah" id="" required>
           <option value="#" >PILIH</option>
           <option value="PNS" >PNS</option>
           <option value="WIRASWASTA" >WIRASWASTA</option>
           <option value="KARYAWAN BUMN">KARYAWAN BUMN</option>
           <option value="KARYAWAN SWASTA">KARYAWAN SWASTA</option>
           <option value="nPELAJAR">PELAJAR</option>
            </select>
            </div>
                <div class="mb-3">
                    <label for="" class="form-label">Minat</label>
                    <input type="text" name="minat" class="form-control" value="<?php echo $row['Minat']; ?>" required>
                </div>

                
                <button type="submit" class="btn btn-warning" name="update">Update Data</button>
                <button type="submit" class="btn btn-warning" name="update">Batalkan</button>
            </form>
        </div>
    </div>
</div>

<!--  -->
<!-- Optional JavaScript; choose one of the two! -->
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFY1zcl4A8nNtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" 
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Dk9DQ4B91+tQBZjsiW4ePtgfTxh3BNT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" 
        integrity="sha384-cVKIPhGhvGJZ4AOeLrU6GAfKTzlfcF0UJ1zR+EOz7qE0J2gGOJR0jxGq4t0Pp6ET" crossorigin="anonymous"></script>
</body>
</html>
