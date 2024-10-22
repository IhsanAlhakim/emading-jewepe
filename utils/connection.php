<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "db_jewepe";

// Melakukan koneksi ke database db_jewepe
$conn = mysqli_connect($hostname, $username, $password, $dbname);

if ($conn) {
    echo
    "<script>  
     console.log('Database Connected'); 
     </script>";
} else {
    echo
    "<script>
    console.log('Connection failed');
    </script>";
}
