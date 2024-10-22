<?php
require "../utils/database-functions.php";

// Ambil data id dari URL
$id = $_GET["id"];

// Cek apakah data berhasil dihapus
if (delete($id) > 0) {
    echo "
    <script>
        alert('data berhasil dihapus!');
        document.location.href = 'index.php';
    </script>
    ";
} else {
    echo "
    <script>
        alert('data gagal dihapus!');
        document.location.href = 'index.php';
    </script>
    ";
}
