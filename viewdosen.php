<?php
// Memanggil file koneksi.php untuk membuat koneksi
include 'koneksi.php';

// Jalankan query untuk menampilkan semua data diurutkan ascending berdasarkan idDosen
$query = "SELECT * FROM t_dosen ORDER BY idDosen ASC";

// Mengeksekusi query dan menyimpan hasilnya dalam variabel $result
$result = mysqli_query($link, $query);

// Mengecek apakah query berhasil dieksekusi
if (!$result) {
    die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Dosen</title>
    <style>
        table {
            width: 840px;
            margin: auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Tabel Dosen</h1>
    <center><a href="input.php">Input Data</a></center>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Dosen</th>
            <th>No HP</th>
            <th>Pilihan</th>
        </tr>

        <?php
        // Hasil query akan disimpan dalam variabel $data dalam bentuk array
        // Kemudian dicetak dengan perulangan while
        while ($data = mysqli_fetch_assoc($result)) {
            // Mencetak / menampilkan data
            echo "<tr>";
            echo "<td>" . $data['idDosen'] . "</td>"; // Menampilkan data idDosen
            echo "<td>" . $data['namaDosen'] . "</td>"; // Menampilkan data namaDosen
            echo "<td>" . $data['noHP'] . "</td>"; // Menampilkan data noHP
            // Membuat link untuk mengedit dan menghapus data
            echo "<td>
                <a href='editdosen.php?idDosen=" . $data["idDosen"] . "'>Edit</a> /
                <a href='hapusdosen.php?idDosen=" . $data['idDosen'] . "' onclick='return confirm(\"Anda yakin akan menghapus data?\")'>Hapus</a>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>