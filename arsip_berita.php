<?php
include "koneksi.php";
?>
<html>

<head>
    <title>Arsip Berita</title>
    <link rel="stylesheet" href="style.css">
    <script language="javascript">
        function tanya() {
            if (confirm("Apakah Anda yakin akan menghapus berita ini ?")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
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

        <div class="info">
            <h2>Arsip Berita</h2>
        </div>
        <ol>
            <?php
            // Menggunakan prepared statement untuk keamanan
            $query = "SELECT A.id_berita, B.nm_kategori, A.judul, A.pengirim, A.tanggal
                  FROM berita A
                  JOIN kategori B ON A.kategori = B.id_kategori
                  ORDER BY A.id_berita DESC";

            $sql = mysqli_query($conn, $query);

            if ($sql && mysqli_num_rows($sql) > 0) {
                while ($hasil = mysqli_fetch_assoc($sql)) {
                    $id_berita = $hasil['id_berita'];
                    $kategori = stripslashes($hasil['nm_kategori']);
                    $judul = stripslashes($hasil['judul']);
                    $pengirim = stripslashes($hasil['pengirim']);
                    $tanggal = stripslashes($hasil['tanggal']);

                    // Tampilkan arsip berita
                    echo "<li><a href='berita_lengkap.php?id=$id_berita'>$judul</a><br>";
                    echo "<small>Berita dikirimkan oleh <b>$pengirim</b> pada tanggal <b>$tanggal</b> dalam kategori <b>$kategori</b><br>";
                    echo "<b>Action : </b><a href='edit_berita.php?id=$id_berita'>Edit</a> | ";
                    echo "<a href='delete_berita.php?id=$id_berita' onClick='return tanya()'>Delete</a>";
                    echo "</small></li><br><br>";
                }
            } else {
                echo "<p>Tidak ada arsip berita.</p>";
            }
            ?>
        </ol>
    </div>
</body>

</html>