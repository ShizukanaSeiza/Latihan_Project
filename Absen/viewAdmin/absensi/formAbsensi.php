<?php
include "../header.php";
include "../koneksi.php";

//Handle simpan absensi 
if (isset($_POST['simpan'])) {
    $id_kelas = $_POST['id_kelas'];
    $id_matkul = $_POST['id_matkul'];
    $semester = $_POST['semester'];
    $pertemuan = $_POST['pertemuan'];
    $tanggal = date['Y-m-d'];

    foreach ($_POST['status'] as $id_mhs => $status) {
        $ket = $_POS['keterangan'][$id_mhs];
        $sql = "INSERT INTO absensi (id_mahasiswa, id_kelas, id_matkul, semester, pertemuan_ke, status, keterangan, tanggal)
        VALUES ('$id_mhs', '$id_kelas', '$id_matkul', '$semester', '$pertemuan', '$status', '$ket', '$tanggal')";  
        $conn->query($sql);
        $sukses = true;
    }

    if ($sukses === TRUE) {
        $_SESSION['alert'] ="<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                  Absensi berhasil di simpan!
                                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
        $conn->close();
        header("Location: formAbsensi.php");
        exit();
    }else {
        $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                  Error: ".$sql." - " . $conn->error . "
                                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
        $conn->close();
        header("Location: formAbsensi.php");
        exit();
    }
}
?>

<div class="header">
    <h4>Form Absensi Mahasiswa</h4>
</div>

<div class="content" style="margin-top: 70px">
    <?php
        if (isset($_SESSION['alert'])) {
            echo $_SESSION['alert']; // Display the alert message
            unset($_SESSION['alert']); // Remove messege after displaying
        }
    ?>
<form method="POST">
    <div class="row mb-3">
        <div class="col-md-3">
            <label>Kelas</label>
            <select name="id_kelas" class="form-control" required>
                <option value="">-- Pilih --</option>
                <?php
                $kelas = $conn->query("SELECT * FROM kelas");
                while ($k =$kelas->fetch_assoc()) {
                    $selected = (isset($_POST['id_kelas']) && $_POST['id_kelas'] == $k['id']) ? 'selected' : '';
                    echo "<option value='{$k['id']}' $selected>{$k['nama_kelas']}</option>";
                }
                ?>
            </select>
        </div>
    </div>
</form>
</div>