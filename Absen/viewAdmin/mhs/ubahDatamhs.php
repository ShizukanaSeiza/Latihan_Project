<!doctype html>
<?php include "../header.php"; ?>
<?php 

    $target_dir = "../uploads/";

    // Ambil ID mahasiswa yang akan diubah
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM mhs WHERE id = '$id'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
    }

    if (isset($_POST['update'])) {
        $nama           = $_POST['nama'];
        $nipd           = $_POST['nipd'];
        $tanggal_lahir  = $_POST['tanggal_lahir'];
        $alamat         = $_POST['alamat'];
        $kelas_id       = $_POST['kelas_id'];

        $updateFoto = ""; // default

        if (!empty($_FILES["PhotoProfile"]["name"])) {
            $fileName = basename($_FILES['PhotoProfile']['name']);
            $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $target_dir = $target_dir . $nama . "." .$imageFileType;
            $uploadOK = 1;
        

        // // handle gambar
        // $fileName = basename($_FILES["PhotoProfile"]["name"]);
        // $uploadOk = 1;
        // $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        // $target_file = $target_dir . $nama . "." .$imageFileType;

        // check if file is an actual image
        $check = getimagesize($_FILES["PhotoProfile"]["tmp_name"]);
        if ($check === false) {
            echo "file yang di upload bukan berupa gambar";
            $uploadOK = 0;
        }

         // File size check
      if ($_FILES["PhotoProfile"]["size"] > 500000) {
        echo "Maaf, File Terlalu Besar.";
        $uploadOK = 0;
        }
  
        // Formats check
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
          echo "Maaf, Hanya jpg, jpeg, png & gif format yang diperbolehkan.";
          $uploadOK = 0;
        }
  
        // prosess upload
        if  ($uploadOK == 1) {
          if (move_uploaded_file($_FILES["PhotoProfile"]["tmp_name"], $target_file)) {
              $photoProfile = $nama.".".$imageFileType;
              $updateFoto = ", PhotoProfile='$photoProfile'";
              //   $sql = "UPDATE mhs SET NamaMhs='$nama',NIPD='$nipd',TanggalLahir='$tanggal_lahir',Alamat='$alamat',PhotoProfile='$photoProfile',kelas_id='$kelas_id' WHERE id='$id'";
          }else{
              echo "Maaf, Terjadi kesalahan ketika upload Photo Anda";
          }
        } 
    }
        // SQL update (gambar hanya ikut jika ada upload)
        $sql = "UPDATE mhs SET
                    NamaMhs='$nama',
                    NIPD='$nipd',
                    TanggalLahir='$tanggal_lahir',
                    Alamat='$alamat',
                    kelas_id='$kelas_id'
                    $updateFoto
                WHERE id='$id'";

        // $sql = "UPDATE mhs SET namaMhs='$nama', NIPD='$nipd', tanggalLahir='$tanggal_lahir', alamat='$alamat' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    Data berhasil Di ubah!
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  </div>";
            $conn->close();
            header("Location: tampilDatamhs.php");
            exit();
        } else {
            $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    Error: ".$sql." - " . $conn->error . "
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  </div>";
            $conn->close();
            header("Location: tampilDatamhs.php");
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
                <label for="" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="<?php echo $row['NamaMhs']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">NIPD</label>
                <input type="text" name="nipd" class="form-control" maxlength="12" value="<?php echo $row['NIPD']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Kelas</label>
                <select name="kelas_id" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <?php
                    $kelas = $conn->query("SELECT * FROM kelas");
                    while ($k = $kelas->fetch_assoc()) {
                        $selected = ($k['id'] == $row['kelas_id']) ? 'selected' : '';
                        echo "<option value='{$k['id']}' $selected>{$k['nama_kelas']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $row['TanggalLahir']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" required><?php echo $row['Alamat']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Photo Profile</label>
                <img id="imagePreview" src="../uploads/<?php echo $row['PhotoProfile']; ?>" alt="Profile Preview" style="width: 150px; height:
                150px; object-fit: cover; display: block; margin-bottom: 10px;">
                <input name="PhotoProfile" type="file" required> 
            </div>
            <button type="submit" class="btn btn-warning" name="update">Update Data</button>
        </form>
    </div>

   <?php include "../footer.php"; ?>