<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('location: login.php');
}

require '../utils/database-functions.php';

$articles = query("SELECT * FROM tb_article");
$articles = array_reverse($articles);
$adminId = $_SESSION['admin'];
$adminData = query("SELECT * FROM tb_admin WHERE admin_id = '$adminId'")[0];

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
    <?php include 'template/navbar-admin.php'; ?>
    <main class="main-admin container py-3 px-5">
        <div class="container-fluid shadow-sm px-5 py-3 my-3 bg-white d-flex align-items-center rounded">
            <h1 class="m-0">Selamat Datang, <?= $adminData["name"] ?>!</h1>
        </div>
        <section class="container-fluid shadow-sm px-5 py-3 my-3 bg-white rounded">
            <h2 class="mb-4">Manajemen Artikel</h2>
            <div class="d-flex my-3">
                <a class="btn btn-primary me-auto" href="add.php" role="button">Tambah Data</a>
            </div>
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col" class="align-middle">NO</th>
                        <th scope="col" class="align-middle">GAMBAR</th>
                        <th scope="col" class="align-middle">JUDUL</th>
                        <th scope="col" class="align-middle">TANGGAL DIBUAT</th>
                        <th scope="col" class="align-middle">TANGGAL DIUBAH</th>
                        <th scope="col" class="align-middle">STATUS</th>
                        <th scope="col" class="align-middle">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($articles as $article) : ?>
                        <tr>
                            <th scope="row" class="align-middle"><?php echo $i; ?></th>
                            <td class="align-middle"><img src="../image/<?= $article["image"] ?>" width="50px" alt=""></td>
                            <td class="align-middle"><?= $article["title"] ?></td>
                            <td class="align-middle"><?= $article["created_at"] ?></td>
                            <td class="align-middle"><?= $article["updated_at"] ?></td>
                            <td class="align-middle"><?= $article["status"] ?></td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-primary" href="update.php?id=<?= $article["article_id"] ?>" role="button">Ubah</a>
                                    <a class="btn btn-primary" href="delete.php?id=<?= $article["article_id"] ?>" onclick="return confirm('yakin?');" role="button">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    <?php include '../template/footer.php' ?>
    <script src="../scripts/bootstrap.bundle.js"></script>
</body>

</html>