<?php

// --- Konfigurasi Database ---
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_lilyflowrist'; // <-- PERUBAHAN DI SINI

// --- Membuat Koneksi ---
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// --- Cek Koneksi ---
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

?>