<?php
include 'koneksi.php';

// cek id
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// konfirmasi dat
$query = "SELECT judul FROM diary WHERE id = $id";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $judul = $row['judul'];
    
    // hapus diary
    $delete_query = "DELETE FROM diary WHERE id = $id";
    
    if (mysqli_query($koneksi, $delete_query)) {
        header("Location: index.php?success=3");
        exit();
    } else {
        $error = "Terjadi kesalahan: " . mysqli_error($koneksi);
    }
} else {
    header("Location: index.php");
    exit();
}

mysqli_close($koneksi);
