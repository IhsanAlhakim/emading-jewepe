<?php
require 'utils/database-functions.php';

$articles = query("SELECT * FROM tb_article WHERE status = 'published'");
$articles = array_reverse($articles);

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
    <header class="header">
        <?php include 'template/navbar.php' ?>
        <div class=" hero h-100 px-4 text-center d-flex flex-column justify-content-center align-items-center">
            <h1 class="display-4 fw-bold">E-Mading JeWePe</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Sarana Informasi Untuk Peserta Didik Sekolah JeWePe</p>
            </div>
        </div>
    </header>

    <main class="main container px-3 py-3">
        <div class="container-fluid shadow-sm px-5 py-3 my-3 bg-white d-flex align-items-center rounded">
            <h2 class="m-0">Artikel</h2>
        </div>
        <?php $i = 1; ?>
        <?php foreach ($articles as $article) : ?>
            <div class="card mb-3 border border-0 shadow-sm">
                <a class="text-black link-underline link-underline-opacity-0" href="article-detail.php?id=<?= $article["article_id"] ?>">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="image/<?= $article["image"] ?>" class="rounded-start" style="height: 150px; width: 100%; object-fit:cover" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $article["title"] ?></h5>
                                <p class="card-text">
                                    <?php
                                    $content = $article["content"];
                                    $textContent =
                                        strip_tags(html_entity_decode($content));

                                    echo substr($textContent, 0, 80) . "...";
                                    ?>
                                </p>

                                <p class="card-text"><small class="text-body-secondary">Dibuat pada <?= $article["created_at"] ?></small></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>
    </main>
    <?php include 'template/footer.php' ?>
    <script src="scripts/bootstrap.bundle.js"></script>
</body>

</html>