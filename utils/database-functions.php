<?php
require "connection.php";

// ambil data dari database
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($rows, $row);
    }
    return $rows;
}

// tambah artikel
function add($data, $adminId)
{
    global $conn;

    // ambil data dari tiap elemen dalam form
    $articleId = uniqid("article-");
    $title = htmlspecialchars($data["title"]);
    $content = $data["content"];
    $status = $data["status"];
    $createdAt = date('d-m-Y');
    $updatedAt = $createdAt;

    // upload gambar
    $image = upload();
    if (!$image) return false;

    // query insert data
    $query = "INSERT INTO tb_article
     VALUES
     ('$articleId', '$image', '$title','$content','$status','$createdAt','$updatedAt', $adminId)
     ";
    mysqli_query($conn, $query);


    return mysqli_affected_rows($conn);
}

// hapus artikel
function delete($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_article WHERE article_id = '$id'");

    return mysqli_affected_rows($conn);
}

// ubah artikel
function update($data)
{
    global $conn;

    // ambil data dari tiap elemen dalam form
    $articleId = $data['article_id'];
    $title = htmlspecialchars($data["title"]);
    $content = $data["content"];
    $status = $data["status"];
    $updatedAt = date('d-m-Y');
    $oldImage = $data["old_image"];

    //cek apakah user pilih gambar baru atau tidak
    if ($_FILES['image']['error'] === 4) {
        $image = $oldImage;
    } else {
        $image = upload();
    }

    // query insert data
    $query = "UPDATE tb_article SET
     title = '$title',
     content = '$content',
     status = '$status',
     updated_at = '$updatedAt',
     image = '$image'
     WHERE article_id = '$articleId' ";
    mysqli_query($conn, $query);


    return mysqli_affected_rows($conn);
}

// upload gambar
function upload()
{
    $imageName = $_FILES['image']['name'];
    $imageSize = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmpName = $_FILES['image']['tmp_name'];

    //cek apakah ada gambar yang diupload.
    if ($error === 4) { //nilai 4 artinya tidak ada file yang dimasukkan
        echo "<script>
        alert('Pilih gambar terlebih dahulu!');
        </script>";
        return false;
    }

    $validImageExtension = ['jpg', 'png', 'jpeg'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));

    if (!in_array($imageExtension, $validImageExtension)) {
        echo "<script>
        alert('yang anda upload bukan gambar');
        </script>";
        return false;
    }

    if ($imageSize > 1000000) {
        echo "<script>
        alert('Ukuran Gambar terlalu besar');
        </script>";
        return false;
    }

    $newImageName = uniqid();
    $newImageName .= '.';
    $newImageName .= $imageExtension;

    move_uploaded_file($tmpName, '../image/' . $newImageName);

    return $newImageName;
}
