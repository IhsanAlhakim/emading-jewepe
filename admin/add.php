<?php
session_start();

// Cek apakah sudah login 
if (!isset($_SESSION["login"])) {
    header("location: login.php");
}

require "../utils/database-functions.php";

// Cek apakah tombol submit sudah ditekan
if (isset($_POST["submit"])) {

    // Cek apakah data berhasil ditambahkan
    if (add($_POST, $_SESSION["admin"]) > 0) {
        echo "
        <script>
            alert('data berhasil ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
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
    <script type="text/javascript" src="../scripts/jquery-3.7.1.min.js"></script>
    <link href="../styles/summernote-lite.min.css" rel="stylesheet">
    <script src="../scripts/summernote-lite.min.js"></script>
</head>

<body>
    <?php include "template/navbar-admin.php"; ?>
    <main class="main-admin container py-3 px-5">
        <section class="container-fluid shadow-sm px-5 py-5 my-3 bg-white rounded">
            <h1 class="mb-4">Tambah Artikel</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label h6">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label class="form-label h6" for="image">Gambar</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label h6">Isi Artikel</label>
                    <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="publish" value="published" required>
                        <label class="form-check-label" for="publish">Publish</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="draft" value="drafted">
                        <label class="form-check-label" for="draft">Draft</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Tambah Data</button>
            </form>
        </section>
    </main>
    <?php include "../template/footer.php"; ?>
    <script src="../scripts/bootstrap.bundle.js"></script>
    <script>
        // Menambahkan text editor
        $("#content").summernote({
            placeholder: "Isi Artikel Disini",
            tabsize: 2,
            height: 200,
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
                ["insert", ["link", "picture", "video"]],
                ["view", ["fullscreen", "codeview", "help"]]
            ]
        });
    </script>
</body>

</html>