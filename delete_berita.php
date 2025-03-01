<?php
include "koneksi.php";

// Pastikan id_berita ada dalam URL
if (isset($_GET['id'])) {
    $id_berita = $_GET['id'];
} else {
    die("Error. No Id Selected! ");
}

// Proses hapus berita jika id_berita valid
if (!empty($id_berita) && $id_berita != "") {
    // Query untuk menghapus berita
    $query = "DELETE FROM berita WHERE id_berita = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_berita);

    // Eksekusi query
    if (mysqli_stmt_execute($stmt)) {
        echo "<h2><font color=blue>Berita telah berhasil dihapus</font></h2>";
        echo "Klik <a href='arsip_berita.php'>di sini</a> untuk kembali ke halaman arsip berita";
    } else {
        echo "<h2><font color=red>Berita gagal dihapus</font></h2>";
    }
} else {
    die("Access Denied");
}
?>
<html>

<head>
    <title>Delete Berita</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <a href="index.php">Halaman Depan</a>
        <a href="arsip_berita.php">Arsip Berita</a>
        <a href="input_berita.php">Input Berita</a>
        <div class="dropdown">
            <a href="#" class="dropbtn">Kategori Berita</a>
            <div class="dropdown-content">
                <a href="#">Berita Olahraga</a>
                <a href="#">Berita Umum</a>
                <a href="#">Berita Teknologi</a>
                <a href="#">Berita Politik</a>
            </div>
        </div>
    </header>
    <div class="container">
    </div>
</body>

</html>