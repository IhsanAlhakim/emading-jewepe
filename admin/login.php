<?php
session_start();

require "../utils/database-functions.php";

// Cek apakah cookie dari login sebelumnya ada
if (isset($_COOKIE["id"]) && isset($_COOKIE["username"])) {
    $id = $_COOKIE["id"];
    $username = $_COOKIE["username"];

    //Ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM tb_admin WHERE admin_id = $id");

    $row = mysqli_fetch_assoc($result);

    //Cek username
    if ($username === hash("sha256", $row["username"])) {
        $_SESSION["login"] = true;
        $_SESSION["admin"] = $row["admin_id"];
    }
}

// Cek apakah sudah login sebelumnya dalam satu sesi
if (isset($_SESSION["login"])) {
    header("location: index.php");
}

// Cek apakah tombol login sudah ditekan
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Mencari data admin sesuai username
    $result = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$username'");

    //Cek apakah ada data admin yang sesuai
    if (mysqli_num_rows($result) === 1) {

        //Cek password
        $row = mysqli_fetch_assoc($result);
        if ($password === $row["password"]) {
            $_SESSION["login"] = true;
            $_SESSION["admin"] = $row["admin_id"];

            // Cek remember me
            if (isset($_POST["remember"])) {
                setcookie("id", $row["admin_id"], time() + 60);
                setcookie("username", hash("sha256", $row["username"]), time() + 60);
            }

            header("location: index.php");
            exit;
        }
    }
    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/bootstrap.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>

<body>

    <section class="bg-primary p-3 p-md-4 p-xl-5 h-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <h3>Log In Admin</h3>
                                    </div>
                                    <?php if (isset($error)) { //Menampilkan pesan kesalahan jika username/password salah
                                    ?>
                                        <p style="color: red;">username / password salah</p>
                                    <?php } ?>
                                </div>
                            </div>
                            <form action="" method="post">
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="username" class="form-control" name="username" id="username" placeholder="Username" required>
                                            <label for="username" class="form-label">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                                            <label for="password" class="form-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
                                            <label class="form-check-label text-secondary" for="remember_me">
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn bsb-btn-2xl btn-primary" type="submit" name="login">Log In</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>