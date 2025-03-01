    <?php
    include "koneksi.php";
    ?>
    <html>
    <head>
        <title>Index Berita</title>
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

        <!-- <div class="iklan">
            <img src="https://plus.unsplash.com/premium_photo-1707080369554-359143c6aa0b?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8bmV3c3xlbnwwfHwwfHx8MA%3D%3D" alt="">
        </div> -->

        <div class="container">

            <div class="info">
                <h2>Halaman Depan ~ Lima Berita Terbaru</h2>
            </div>

            <?php
            $query = "SELECT A.id_berita, B.nm_kategori, A.judul, A.headline, A.pengirim, A.tanggal
                    FROM berita A 
                    JOIN kategori B ON A.kategori = B.id_kategori
                    ORDER BY A.id_berita DESC LIMIT 5";

            $sql = mysqli_query($conn, $query);

            if ($sql) {
                while ($hasil = mysqli_fetch_assoc($sql)) {
                    $id_berita = $hasil['id_berita'];
                    $kategori = stripslashes($hasil['nm_kategori']);
                    $judul = stripslashes($hasil['judul']);
                    $headline = nl2br(stripslashes($hasil['headline']));
                    $pengirim = stripslashes($hasil['pengirim']);
                    $tanggal = stripslashes($hasil['tanggal']);
                    
                    // Tampilkan berita 
                    echo "<font size='4'><a href='berita_lengkap.php?id=$id_berita'>$judul</a></font><br>";
                    echo "<small>Berita dikirimkan oleh <b>$pengirim</b> pada tanggal <b>$tanggal</b> dalam kategori <b>$kategori</b></small>";
                    echo "<p>$headline</p>";
                    echo "<hr>";
                }
            } else {
                echo "<p>Tidak ada berita terbaru.</p>";
            }
            ?>
        </div>

    </body>
    </html>
