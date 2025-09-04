<!doctype html>
<?php 
    
    include "../header.php";

    if (isset($_POST['submit'])) {
      $NamaDosen   = $_POST['NamaDosen'];
      $nid         = $_POST['nid'];
      $MataKuliah  = $_POST['MataKuliah'];
      $alamat      = $_POST['alamat'];
      

    
    //   // handle gambar
    //   $fileName = basename($_FILES["photoProfile"]["name"]);
    //   $uploadOk = 1;
    //   $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    //   $target_file = $target_dir . $nama . "." .$imageFileType;

    //   // check if file is an actual image
    //   $check = getimagesize($_FILES["photoProfile"]["tmp_name"]);
    //   if ($check !== false) {
    //     $uploadOK = 1;
    //   }else{
    //     echo "file yang di upload bukan berupa gambar";
    //     $uploadOK = 0;
    //   }

    //   //check file size
    //   if ($_FILES["photoProfile"]["size"] > 500000) {
    //   echo "Maaf, File Terlalu Besar.";
    //   $uploadOK = 0;
    //   }

    //   // allow certain file formats
    //   if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
    //     echo "Maaf, Hanya jpg, jpeg, png & gif format yang diperbolehkan.";
    //     $uploadOK = 0;
    //   }

    //   // prosess upload
    //   if  ($uploadOK == 1) {
    //     if (move_uploaded_file($_FILES["photoProfile"]["tmp_name"], $target_file)) {
    //         $photoProfile = $nama.".".$imageFileType;
    //         $sql = "INSERT INTO mhs (namaMhs,NIPD,tanggalLahir,alamat) VALUES ('$nama','$nipd','$tanggal_lahir','$alamat')";
    //     }else{
    //         echo "Maaf, Terjadi kesalahan ketika upload Photo Anda";
    //     }
    //   } 

      $sql = "INSERT INTO dosen (NamaDosen,nid,MataKuliah,alamat) VALUES('$NamaDosen','$nid','$MataKuliah','$alamat')";

      if ($conn->query($sql) === TRUE) {
          $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                  Data berhasil di Tambah!
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
        <h4>Tambah Data Dosen</h4>
      </div>

        <div class="content" style="margin-top: 70px;">
            <form action="" method="POST" class="border p-4 rounded shadow" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="" class="form-label">Nama Dosen</label>
                <input type="text" for="" name="NamaDosen" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">NID</label>
                <input type="text" for="" name="nid" class="form-control" maxlength="12" required>
              </div>
             
              <div class="mb-3">
                <label for="" class="form-label">Mata Kuliah</label>
                <select name="id_matkul" class="form-control" required>
                  <option value="">-- Pilih Matkul --</option>
                  <?= buildOptions("matkul", "id", "nama"); ?>
                </select>
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
