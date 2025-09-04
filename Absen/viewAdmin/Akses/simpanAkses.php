<?php 
session_start();
include "../../koneksi.php";

if (isset($_POST['id_role'])) {
    $id_role= $_POST['id_role'];
    $menuTerpilih = isset($_POST['menu']) ? $_POST['menu'] : [];

    // Hapus akses lama
    $conn->query("DELETE FROM rbac WHERE role_id = '$id_role'");

    // Simpen akses baru
    foreach ($menuTerpilih as $id_menu) {
        $conn->query("INSERT INTO rbac (role_id, menu_id) VALUES ('$id_role', '$id_menu')");
    }

    $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            Akses berhasil diperbarui!
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                          </div>";
}

header("Location: kelolaAkses.php");
exit();