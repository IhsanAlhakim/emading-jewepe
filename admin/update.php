<?php
session_start();

// Cek apakah sudah login
if (!isset($_SESSION["login"])) {
    header("location: login.php");
}

require "../utils/database-functions.php";

// Ambil data dari URL
$id = $_GET["id"];

// Ambil data artikel dari database sesuai id
$article = query("SELECT * FROM tb_article WHERE article_id = '$id'")[0];

// Cek apakah tombol submit sudah ditekan
if (isset($_POST["submit"])) {

    // Cek apakah data berhasil diupdate
    if (update($_POST) > 0) {
        echo "
        <script>
            alert('data berhasil diubah!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal diubah!');
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
    <?php include "template/navbar-admin.php" ?>

    <main class="main-admin container py-3 px-5">
        <section class="container-fluid shadow-sm px-5 py-5 my-3 bg-white rounded">
            <h1 class="mb-4">Ubah Artikel</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="article_id" value="<?= $article["article_id"]; ?>">
                <input type="hidden" name="old_image" value="<?= $article["image"]; ?>">
                <div class="mb-3">
                    <label for="title" class="form-label h6">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= $article["title"] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label h6" for="image">Gambar</label>
                    <div>
                        <img src="../image/<?= $article["image"] ?>" class="img-thumbnail mb-3" alt="gambar" width="200px">
                    </div>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label h6">Isi Artikel</label>
                    <textarea class="form-control" id="content" name="content" rows="3" value="" required><?= $article["content"] ?></textarea>
                </div>
                <div class="mb-3">
                    <?php if ($article["status"] == "published") { ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="publish" value="published" checked required>
                            <label class="form-check-label" for="publish">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="draft" value="drafted">
                            <label class="form-check-label" for="draft">Draft</label>
                        </div>
                    <?php } else { ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="publish" value="published" required>
                            <label class="form-check-label" for="publish">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="draft" value="drafted" checked>
                            <label class="form-check-label" for="draft">Draft</label>
                        </div>
                    <?php } ?>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Ubah Artikel</button>
            </form>
        </section>

    </main>
    <?php include "../template/footer.php"; ?>
    <script src="../scripts/bootstrap.bundle.js"></script>
    <script>
        // Menambahkan text editor
        $("#content").summernote({
            placeholder: "Isi artikel disini",
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