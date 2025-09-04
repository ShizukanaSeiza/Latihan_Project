<!DOCTYPE html>
<?php

session_start();
include "../koneksi.php"; // file koneksi database
$alert = 0;

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM auth WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $alert = 0;
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../viewAdmin/mhs/tampilDatamhs.php");
            exit();
        }else{
            $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'> Password salah! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            <div>";
            $conn->close();
            header("Location: login.php");
            exit();
        }
    }else{
      $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'> User tidak ditemukan ! <button type='button' class='btn-bs-dismiss='alert' aria-label='Close'></button>";
      $conn->close();
      header("Location: login.php");
      exit();
    }
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin ASE</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        body {
            background-image : url(../IMG/Furina.jpg);
            background-size : cover; 
            background-repeat : no-repeat;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justipy-content: center;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            padding: 1rem;
            border-top-left-radius: 1rem;
            border-bottom-left-radius: 1rem;
        }
        .btn-primary {
            background-color: #007cff;
            border: noen;
        }
        .btn-primary-hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    
<div class="container login-container">
    
    <div class="card w-75 d-flex flex-row">
        <div class="col-md-5 sidebar d-flex flex-column justify-content-center align-items-center">
            <h2 class="mb-4">Admin ASE</h2>
            <p>Silahkan login untuk masuk ke dashboard</p>
        </div>
        <div class="col-md-7 p-5">
            <h3 class="mb-4">Login</h3>

            <?php
            if ($alert == 1) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'> Password Salah! <button 
                type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button></div>";
            }elseif($alert == 2) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'> User tidak ditemukan ! <button 
                type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button></div>";
            }
            ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="submit" value="submit">Masuk</button>
                <div class="mt-3">
                    <a href="registrasi.php">Belum punya akun? Registrasi di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>