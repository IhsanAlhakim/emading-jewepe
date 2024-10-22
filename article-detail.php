<?php
require "utils/database-functions.php";

// Ambil data id dari URL
$id = $_GET["id"];

// Ambil data artikel dari database sesuai id
$article = query("SELECT * FROM tb_article WHERE article_id = '$id'")[0];
$adminId = $article["admin_id"];

// Ambil data admin pembuat artikel
$adminData = query("SELECT * FROM tb_admin WHERE admin_id = '$adminId'")[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/bootstrap.css">
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>
    <?php include 'template/navbar.php' ?>

    <main class="container py-1 main">
        <div class="container-fluid shadow-sm px-5 py-3 my-3 bg-white d-flex align-items-center rounded">
            <h2 class="m-0"><?= $article["title"] ?></h2>
        </div>
        <article class="container-fluid shadow-sm px-5 py-3 my-3 bg-white">
            <section class="article-info">
                <p><small class="text-body-secondary">Dibuat pada <?= $article["created_at"] ?> oleh <?= $adminData["name"] ?></small></p>
            </section>
            <img src="image/<?= $article["image"] ?>" class="rounded mx-auto d-block my-3 border" alt="" height="300px">
            <section class="content"> <?= $article["content"] ?></section>
            <section class="article-info">
                <p><small class="text-body-secondary">Terakhir diperbaharui pada <?= $article["updated_at"] ?></small></p>
            </section>
        </article>
    </main>

    <?php include "template/footer.php" ?>
    <script src="scripts/bootstrap.bundle.js"></script>
</body>

</html>