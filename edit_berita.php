<?php
include "koneksi.php";

// Mengecek apakah id_berita ada di URL
if (isset($_GET['id'])) {
    $id_berita = $_GET['id'];
} else {
    die("Error. No Id Selected! ");
}

// Menggunakan prepared statements dengan mysqli
$query = "SELECT id_berita, kategori, judul, headline, isi, pengirim, tanggal FROM berita WHERE id_berita=?";
$stmt = mysqli_prepare($conn, $query);

// Mengecek apakah statement berhasil disiapkan
if ($stmt === false) {
    die("Query preparation failed: " . mysqli_error($conn));
}

// Mengikat parameter dan mengeksekusi query
mysqli_stmt_bind_param($stmt, 'i', $id_berita);  // 'i' menunjukkan tipe integer
mysqli_stmt_execute($stmt);

// Mengecek apakah eksekusi berhasil
$result = mysqli_stmt_get_result($stmt);
if ($row = mysqli_fetch_array($result)) {
    $id_berita = $row['id_berita'];
    $kategori = stripslashes($row['kategori']);
    $judul = stripslashes($row['judul']);
    $headline = stripslashes($row['headline']);
    $isi = stripslashes($row['isi']);
    $pengirim = stripslashes($row['pengirim']);
    $tanggal = stripslashes($row['tanggal']);
} else {
    die("Data tidak ditemukan");
}

// Proses edit berita jika form disubmit
if (isset($_POST['Edit'])) {
    $id_berita = $_POST['hidberita'];
    $judul = addslashes(strip_tags($_POST['judul']));
    $kategori = $_POST['kategori'];
    $headline = addslashes(strip_tags($_POST['headline']));
    $isi_berita = addslashes(strip_tags($_POST['isi']));
    $pengirim = addslashes(strip_tags($_POST['pengirim']));

    // Update berita dengan prepared statement
    $query_update = "UPDATE berita SET kategori=?, judul=?, headline=?, isi=?, pengirim=? WHERE id_berita=?";
    $stmt_update = mysqli_prepare($conn, $query_update);

    if ($stmt_update === false) {
        die("Query preparation failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_update, 'issssi', $kategori, $judul, $headline, $isi_berita, $pengirim, $id_berita);
    $exec_result = mysqli_stmt_execute($stmt_update);

    if ($exec_result) {
        echo "<h2><font color=blue>Berita telah berhasil diedit</font></h2>";
    } else {
        echo "<h2><font color=red>Berita gagal diedit</font></h2>";
    }
}
?>

<html>

<head>
    <title>Edit Berita</title>
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
        <FORM ACTION="" METHOD="POST" NAME="input">
            <table cellpadding="0" cellspacing="0" border="0" width="700">
                <tr>
                    <td colspan="2">
                        <div class="info">
                            <h2>Edit Berita</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="200">Judul Berita</td>
                    <td>: <input type="text" name="judul" size="30" value="<?= $judul ?>"></td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>:
                        <select name="kategori">
                            <?php
                            // Mengambil kategori dari database
                            $query = "SELECT id_kategori, nm_kategori FROM kategori ORDER BY nm_kategori";
                            $sql = mysqli_query($conn, $query);
                            while ($hasil = mysqli_fetch_array($sql)) {
                                $selected = ($hasil['id_kategori'] == $id_kategori) ? "selected" : "";
                                echo "<option value='{$hasil['id_kategori']}' $selected>{$hasil['nm_kategori']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Headline Berita</td>
                    <td>: <textarea name="headline" cols="50" rows="4"><?= $headline ?></textarea></td>
                </tr>
                <tr>
                    <td>Isi Berita</td>
                    <td>: <textarea name="isi" cols="50" rows="10"><?= $isi ?></textarea></td>
                </tr>
                <tr>
                    <td>Pengirim</td>
                    <td>: <input type="text" name="pengirim" size="20" value="<?= $pengirim ?>"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;&nbsp;<input type="hidden" name="hidberita" value="<?= $id_berita ?>">
                        <input type="submit" name="Edit" value="Edit Berita">&nbsp; <input type="reset" name="reset"
                            value="Cancel">
                    </td>
                </tr>
            </table>
        </FORM>
    </div>
</body>

</html>