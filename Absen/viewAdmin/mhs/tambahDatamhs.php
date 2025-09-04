<!doctype html>
<?php 
    
    include "../header.php";
    $target_dir = "../uploads/";

    if (isset($_POST['submit'])) {
      $nama           = $_POST['nama'];
      $nipd           = $_POST['nipd'];
      $tanggal_lahir  = $_POST['tanggal_lahir'];
      $alamat         = $_POST['alamat'];
        
      // handle gambar
      $fileName = basename($_FILES["PhotoProfile"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      $target_file = $target_dir . $nama . "." .$imageFileType;

      // check if file is an actual image
      $check = getimagesize($_FILES["PhotoProfile"]["tmp_name"]);
      if ($check !== false) {
        $uploadOK = 1;
      }else{
        echo "file yang di upload bukan berupa gambar";
        $uploadOK = 0;
      }

      //check file size
      if ($_FILES["PhotoProfile"]["size"] > 5000000) {
      echo "Maaf, File Terlalu Besar.";
      $uploadOK = 0;
      }

      // allow certain file formats
      if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        echo "Maaf, Hanya jpg, jpeg, png & gif format yang diperbolehkan.";
        $uploadOK = 0;
      }

      // prosess upload
      if ($uploadOK == 0) {
        echo "Maaf, File Terlalu Besar.";
      }else if  ($uploadOK == 1) {
        if (move_uploaded_file($_FILES["PhotoProfile"]["tmp_name"], $target_file)) {
            $photoProfile = $nama.".".$imageFileType;
            $sql = "INSERT INTO mhs (NamaMhs,NIPD,TanggalLahir,Alamat,kelas_id,PhotoProfile) VALUES ('$nama','$nipd',
            '$tanggal_lahir','$alamat','$kelas','$photoProfile')";
        }else{
            echo "Maaf, Terjadi kesalahan ketika upload Photo Anda";
        }
      } 
      // $sql = "INSERT INTO mhs (namaMhs,NIPD,tanggalLahir,uploadProfile,alamat) VALUES('$nama','$nipd','$tanggal_lahir','$photoProfile','$alamat')";

      if ($conn->query($sql) === TRUE) {
          $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                  Data berhasil di Tambah!
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

    function buildOptions($table, $idField, $nameField) {
      global $conn;
      $options = "";
      $query   = "SELECT $idField, $nameField FROM $table";
      $res = $conn->query($query);
      while ($r = $res->fetch_assoc()) {
        $options .= "<option value='".$r[$idField]."'>".$r[$nameField]."</option>";
      }
      return $options;
    }
?>

      <!-- Header dengan Logout -->
      <div class="header">
        <h4>Tambah Data Mahasiswa ASE10</h4>
      </div>

        <div class="content" style="margin-top: 70px;">
            <form action="" method="POST" class="border p-4 rounded shadow" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="" class="form-label">Nama</label>
                <input type="text" for="" name="nama" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">NIPD</label>
                <input type="text" for="" name="nipd" class="form-control" maxlength="12" required>
              </div>
             
              <div class="mb-3">
                <label for="" class="form-label">Kelas</label>
                <select name="id_kelas" class="form-control" required>
                  <option value="">-- Pilih Kelas --</option>
                  <?= buildOptions("kelas", "id", "nama_kelas"); ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">Tanggal Lahir</label>
                <input type="date" for="" name="tanggal_lahir" class="form-control" max="2006-12-31" required>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">Photo Profile</label>
                <input type="file" for="" name="PhotoProfile" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">Alamat</label>
                <textarea name="alamat" id="" col="3" class="form-control" required></textarea>
              </div>

              <div class="row">
                <div class="col-8"></div> <!-- Div kosong di sebelah kiri -->
                <div class="col-4 text-end"> <!-- Div berisi tombol di sebelah kanan -->
                    <button type="submit" class="btn btn-primary mb-3" name="submit">Tambah Data</button>
                    <button type="button" class="btn btn-secondary mb-3" onclick="window.history.back()">Kembali</button>
                </div>
              </div>
            </form>
        </div>

    <?php include "../footer.php"; ?>
