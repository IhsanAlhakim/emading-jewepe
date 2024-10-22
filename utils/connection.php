<?php
$hostname = $_ENV["HOSTNAME"];
$username = $_ENV["USERNAME"];
$password = $_ENV["PASSWORD"];
$dbname = $_ENV["DATABASE"];

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
