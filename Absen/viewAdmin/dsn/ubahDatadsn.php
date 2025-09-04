<!doctype html>
<?php include "../header.php"; ?>

<?php 
    $target_dir = "../uploads/";

    // Ambil ID mahasiswa yang akan diubah
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM dosen WHERE id = '$id'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        // var_dump($row);die();
    }

    if (isset($_POST['update'])) {
        $nama           = $_POST['nama'];
        $nid            = $_POST['nid'];
        $alamat         = $_POST['alamat'];
        $matkul         = $_POST['matkul'];


        $sql = "UPDATE dosen SET nama='$nama', nid='$nid', alamat='$alamat', mataKuliah='$matkul', WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    Data berhasil Di ubah!
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  </div>";
            $conn->close();
            header("Location: tampilDatadsn.php");
            exit();
        } else {
            $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    Error: ".$sql." - " . $conn->error . "
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  </div>";
            $conn->close();
            header("Location: tampilDatadsn.php");
            exit();
        }
    }

?>

    <div class="header">
        <h4>Ubah Data Mahasiswa ASE10</h4>
    </div>

    <div class="content" style="margin-top: 70px;">
        <form method="POST" class="border p-4 rounded shadow" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="form-label">Nama </label>
                <input type="text" name="nama" class="form-control" value="<?php echo $row['NamaDosen']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">NID</label>
                <input type="text" name="nid" class="form-control" maxlength="12" value="<?php echo $row['NID']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" required><?php echo $row['Alamat']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Mata Kuliah</label>
                <textarea name="matkul" class="form-control" required><?php echo $row['MataKuliah']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-warning" name="update">Update Data</button>
        </form>
    </div>
 
   <?php include "../footer.php"; ?>