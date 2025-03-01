<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id_berita = $_GET['id'];
} else {
    die("Error. No Id Selected!");
}
?>
<html>

<head>
    <title>Berita Lengkap</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <a href="index.php">Halaman Depan</a>
        <a href="arsip_berita.php">Arsip Berita</a>
        <a href="input_berita.php">Input Berita</a>
        <div class="dropdown">
            <a href="#  " class="dropbtn">Kategori Berita</a>
            <div class="dropdown-content">
                <a href="#">Berita Olahraga</a>
                <a href="#">Berita Umum</a>
                <a href="#">Berita Teknologi</a>
                <a href="#">Berita Politik</a>
            </div>
        </div>
    </header>
    <div class="container">

        <div class="info">
            <h2>Berita Lengkap</h2>
        </div>
        <?php
        // Menggunakan prepared statement untuk keamanan
        $query = "SELECT A.id_berita, B.nm_kategori, A.judul, A.isi, A.pengirim, A.tanggal
                FROM berita A 
                JOIN kategori B ON A.kategori = B.id_kategori 
                WHERE A.id_berita = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_berita);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $hasil = mysqli_fetch_assoc($result);
            $kategori = stripslashes($hasil['nm_kategori']);
            $judul = stripslashes($hasil['judul']);
            $isi = nl2br(stripslashes($hasil['isi']));
            $pengirim = stripslashes($hasil['pengirim']);
            $tanggal = stripslashes($hasil['tanggal']);

            // Tampilkan berita
            echo "<font size='5' color='lightskyblue'>$judul</font><br>";
            echo "<small>Berita dikirimkan oleh <b>$pengirim</b> pada tanggal <b>$tanggal</b> dalam kategori <b>$kategori</b></small>";
            echo "<p>$isi</p>";
        } else {
            echo "<p>Berita tidak ditemukan.</p>";
        }

        mysqli_stmt_close($stmt);
        ?>
    </div>

</body>

</html>