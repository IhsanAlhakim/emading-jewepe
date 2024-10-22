<?php
require "connection.php";

// Ambil data dari database
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

// Tambah artikel
function add($data, $adminId)
{
    global $conn;

    // Ambil data dari tiap elemen dalam form dan buat id artikel baru
    $articleId = uniqid("article-");
    $title = htmlspecialchars($data["title"]);
    $content = $data["content"];
    $status = $data["status"];
    $createdAt = date("d-m-Y");
    $updatedAt = $createdAt;

    // Upload gambar
    $image = upload();
    if (!$image)
        return false;

    // Insert data ke database
    $query = "INSERT INTO tb_article
     VALUES
     ('$articleId', '$image', '$title','$content','$status','$createdAt','$updatedAt', $adminId)
     ";
    mysqli_query($conn, $query);


    return mysqli_affected_rows($conn);
}

// Hapus artikel
function delete($id)
{
    global $conn;

    $artikel = query("SELECT * FROM tb_article WHERE article_id = '$id'")[0];
    if (file_exists('../image/' . $artikel['image']) && $artikel['image']) {
        unlink('../image/' . $artikel['image']);
    }

    // Hapus artikel sesuai id yang dipilih
    mysqli_query($conn, "DELETE FROM tb_article WHERE article_id = '$id'");

    return mysqli_affected_rows($conn);
}

// Ubah artikel
function update($data)
{
    global $conn;

    // Ambil data dari tiap elemen dalam form
    $articleId = $data["article_id"];
    $title = htmlspecialchars($data["title"]);
    $content = $data["content"];
    $status = $data["status"];
    $updatedAt = date("d-m-Y");
    $oldImage = $data["old_image"];

    //Cek apakah user pilih gambar baru atau tidak
    if ($_FILES["image"]["error"] === 4) {
        $image = $oldImage;
    } else {
        $artikel = query("SELECT * FROM tb_article WHERE article_id = '$articleId'")[0];
        if (file_exists('../image/' . $artikel['image']) && $artikel['image']) {
            unlink('../image/' . $artikel['image']);
        }
        $image = upload();
    }

    // Update data di database
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

// Upload gambar
function upload()
{
    // Ambil info gambar yang diupload
    $imageName = $_FILES["image"]["name"];
    $imageSize = $_FILES["image"]["size"];
    $error = $_FILES["image"]["error"];
    $tmpName = $_FILES["image"]["tmp_name"];

    //Cek apakah ada gambar yang diupload.
    if ($error === 4) {
        echo "<script>
        alert('Pilih gambar terlebih dahulu!');
        </script>";
        return false;
    }

    // Ambil ekstensi gambar
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));

    // Cek gambar
    $validImageExtension = ["jpg", "png", "jpeg"];
    if (!in_array($imageExtension, $validImageExtension)) {
        echo "<script>
        alert('yang anda upload bukan gambar');
        </script>";
        return false;
    }

    // Cek ukuran gambar. Tidak boleh lebih dari 1mb
    if ($imageSize > 1000000) {
        echo "<script>
        alert('Ukuran Gambar terlalu besar');
        </script>";
        return false;
    }

    // Memasukan gambar ke komputer
    $newImageName = uniqid();
    $newImageName .= ".";
    $newImageName .= $imageExtension;
    move_uploaded_file($tmpName, "../image/" . $newImageName);

    return $newImageName;
}
