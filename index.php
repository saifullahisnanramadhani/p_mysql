<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_pratikum';

$link = mysqli_connect($host, $username, $password, $database);

if (!$link) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Fungsi untuk mencari data berdasarkan nama pada tabel t_dosen
function searchDosen($keyword)
{
    global $link;
    $query = "SELECT * FROM t_dosen WHERE namaDosen LIKE '%$keyword%'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
    return $result;
}

// Fungsi untuk mencari data berdasarkan nama pada tabel t_mahasiswa
function searchMahasiswa($keyword)
{
    global $link;
    $query = "SELECT * FROM t_mahasiswa WHERE namaMhs LIKE '%$keyword%'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
    return $result;
}

// Fungsi untuk mencari data berdasarkan nama pada tabel t_matakuliah
function searchMatakuliah($keyword)
{
    global $link;
    $query = "SELECT * FROM t_matakuliah WHERE namaMK LIKE '%$keyword%'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
    return $result;
}

// Fungsi untuk memperbarui data dosen
function updateDosen($id, $namaDosen, $noHP) {
    global $link;
    $query = "UPDATE t_dosen SET namaDosen='$namaDosen', noHP='$noHP' WHERE idDosen='$id'";
    return mysqli_query($link, $query);
}

// Fungsi untuk memperbarui data mahasiswa
function updateMahasiswa($npm, $namaMhs, $prodi, $alamat, $noHP) {
    global $link;
    $query = "UPDATE t_mahasiswa SET namaMhs='$namaMhs', prodi='$prodi', alamat='$alamat', noHP='$noHP' WHERE npm='$npm'";
    return mysqli_query($link, $query);
}

// Fungsi untuk memperbarui data matakuliah
function updateMatakuliah($kodeMK, $namaMK, $sks, $jam) {
    global $link;
    $query = "UPDATE t_matakuliah SET namaMK='$namaMK', sks='$sks', jam='$jam' WHERE kodeMK='$kodeMK'";
    return mysqli_query($link, $query);
}

// Mengecek apakah form pencarian telah di-submit
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $resultDosen = searchDosen($keyword);
    $resultMahasiswa = searchMahasiswa($keyword);
    $resultMatakuliah = searchMatakuliah($keyword);
} else {
    // Jika form pencarian tidak di-submit, tampilkan semua data
    $resultDosen = mysqli_query($link, "SELECT * FROM t_dosen");
    $resultMahasiswa = mysqli_query($link, "SELECT * FROM t_mahasiswa");
    $resultMatakuliah = mysqli_query($link, "SELECT * FROM t_matakuliah");
}

// Handle create, delete, dan update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $table = $_POST['table'];
        if ($table == 'dosen') {
            $namaDosen = $_POST['namaDosen'];
            $noHP = $_POST['noHP'];
            $query = "INSERT INTO t_dosen (namaDosen, noHP) VALUES ('$namaDosen', '$noHP')";
        } elseif ($table == 'mahasiswa') {
            $npm = $_POST['npm'];
            $namaMhs = $_POST['namaMhs'];
            $prodi = $_POST['prodi'];
            $alamat = $_POST['alamat'];
            $noHP = $_POST['noHP'];
            $query = "INSERT INTO t_mahasiswa (npm, namaMhs, prodi, alamat, noHP) VALUES ('$npm', '$namaMhs', '$prodi', '$alamat', '$noHP')";
        } elseif ($table == 'matakuliah') {
            $kodeMK = $_POST['kodeMK'];
            $namaMK = $_POST['namaMK'];
            $sks = $_POST['sks'];
            $jam = $_POST['jam'];
            $query = "INSERT INTO t_matakuliah (kodeMK, namaMK, sks, jam) VALUES ('$kodeMK', '$namaMK', '$sks', '$jam')";
        }
        mysqli_query($link, $query);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $table = $_POST['table'];
        if ($table == 'dosen') {
            $query = "DELETE FROM t_dosen WHERE idDosen='$id'";
        } elseif ($table == 'mahasiswa') {
            $query = "DELETE FROM t_mahasiswa WHERE npm='$id'";
        } elseif ($table == 'matakuliah') {
            $query = "DELETE FROM t_matakuliah WHERE kodeMK='$id'";
        }
        mysqli_query($link, $query);
    } elseif (isset($_POST['update'])) {
        $table = $_POST['table'];
        if ($table == 'dosen') {
            $id = $_POST['id'];
            $namaDosen = $_POST['namaDosen'];
            $noHP = $_POST['noHP'];
            updateDosen($id, $namaDosen, $noHP);
        } elseif ($table == 'mahasiswa') {
            $npm = $_POST['npm'];
            $namaMhs = $_POST['namaMhs'];
            $prodi = $_POST['prodi'];
            $alamat = $_POST['alamat'];
            $noHP = $_POST['noHP'];
            updateMahasiswa($npm, $namaMhs, $prodi, $alamat, $noHP);
        } elseif ($table == 'matakuliah') {
            $kodeMK = $_POST['kodeMK'];
            $namaMK = $_POST['namaMK'];
            $sks = $_POST['sks'];
            $jam = $_POST['jam'];
            updateMatakuliah($kodeMK, $namaMK, $sks, $jam);
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Mahasiswa, Dosen, Matakuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .search-bar {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .search-bar input[type="text"] {
            padding: 8px;
            width: 300px;
        }
        .search-bar input[type="submit"] {
            padding: 8px 16px;
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-bar input[type="submit"]:hover {
            background-color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: black;
            color: white;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .action-buttons input[type="submit"] {
            background-color: white;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .edit-form {
            background-color: #f2f2f2;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Cari Nama...">
                <input type="submit" value="Cari">
            </form>
        </div>

        <?php
        // Check if edit action is triggered
        if (isset($_GET['edit']) && isset($_GET['table'])) {
            $editTable = $_GET['table'];
            $editId = $_GET['id'];
            if ($editTable == 'dosen') {
                $editQuery = "SELECT * FROM t_dosen WHERE idDosen='$editId'";
            } elseif ($editTable == 'mahasiswa') {
                $editQuery = "SELECT * FROM t_mahasiswa WHERE npm='$editId'";
            } elseif ($editTable == 'matakuliah') {
                $
                $editQuery = "SELECT * FROM t_matakuliah WHERE kodeMK='$editId'";
            }

            $editResult = mysqli_query($link, $editQuery);
            $editData = mysqli_fetch_assoc($editResult);
        ?>

        <div class="edit-form">
            <h2>Edit Data</h2>
            <form method="POST" action="">
                <?php if ($editTable == 'dosen') { ?>
                    <input type="hidden" name="table" value="dosen">
                    <input type="hidden" name="id" value="<?php echo $editData['idDosen']; ?>">
                    <label>Nama Dosen:</label><br>
                    <input type="text" name="namaDosen" value="<?php echo $editData['namaDosen']; ?>" required><br>
                    <label>No HP:</label><br>
                    <input type="text" name="noHP" value="<?php echo $editData['noHP']; ?>" required><br>
                <?php } elseif ($editTable == 'mahasiswa') { ?>
                    <input type="hidden" name="table" value="mahasiswa">
                    <input type="hidden" name="id" value="<?php echo $editData['npm']; ?>">
                    <label>NPM:</label><br>
                    <input type="text" name="npm" value="<?php echo $editData['npm']; ?>" required readonly><br>
                    <label>Nama Mahasiswa:</label><br>
                    <input type="text" name="namaMhs" value="<?php echo $editData['namaMhs']; ?>" required><br>
                    <label>Prodi:</label><br>
                    <input type="text" name="prodi" value="<?php echo $editData['prodi']; ?>" required><br>
                    <label>Alamat:</label><br>
                    <input type="text" name="alamat" value="<?php echo $editData['alamat']; ?>" required><br>
                    <label>No HP:</label><br>
                    <input type="text" name="noHP" value="<?php echo $editData['noHP']; ?>" required><br>
                <?php } elseif ($editTable == 'matakuliah') { ?>
                    <input type="hidden" name="table" value="matakuliah">
                    <input type="hidden" name="id" value="<?php echo $editData['kodeMK']; ?>">
                    <label>Kode MK:</label><br>
                    <input type="text" name="kodeMK" value="<?php echo $editData['kodeMK']; ?>" required readonly><br>
                    <label>Nama MK:</label><br>
                    <input type="text" name="namaMK" value="<?php echo $editData['namaMK']; ?>" required><br>
                    <label>SKS:</label><br>
                    <input type="text" name="sks" value="<?php echo $editData['sks']; ?>" required><br>
                    <label>Jam:</label><br>
                    <input type="text" name="jam" value="<?php echo $editData['jam']; ?>" required><br>
                <?php } ?>
                <input type="submit" name="update" value="Update">
            </form>
        </div>

        <?php } ?>

        <h2>Data Dosen</h2>
        <table>
            <tr>
                <th>ID Dosen</th>
                <th>Nama Dosen</th>
                <th>No HP</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultDosen)) { ?>
                <tr>
                    <td><?php echo $row['idDosen']; ?></td>
                    <td><?php echo $row['namaDosen']; ?></td>
                    <td><?php echo $row['noHP']; ?></td>
                    <td class="action-buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $row['idDosen']; ?>">
                            <input type="hidden" name="table" value="dosen">
                            <input type="submit" name="delete" value="Hapus">
                        </form>
                        <form method="GET" action="">
                            <input type="hidden" name="id" value="<?php echo $row['idDosen']; ?>">
                            <input type="hidden" name="table" value="dosen">
                            <input type="submit" name="edit" value="Edit">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Data Mahasiswa</h2>
        <table>
            <tr>
                <th>NPM</th>
                <th>Nama Mahasiswa</th>
                <th>Prodi</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultMahasiswa)) { ?>
                <tr>
                    <td><?php echo $row['npm']; ?></td>
                    <td><?php echo $row['namaMhs']; ?></td>
                    <td><?php echo $row['prodi']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td><?php echo $row['noHP']; ?></td>
                    <td class="action-buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $row['npm']; ?>">
                            <input type="hidden" name="table" value="mahasiswa">
                            <input type="submit" name="delete" value="Hapus">
                        </form>
                        <form method="GET" action="">
                            <input type="hidden" name="id" value="<?php echo $row['npm']; ?>">
                            <input type="hidden" name="table" value="mahasiswa">
                            <input type="submit" name="edit" value="Edit">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Data Matakuliah</h2>
        <table>
            <tr>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>SKS</th>
                <th>Jam</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultMatakuliah)) { ?>
                <tr>
                    <td><?php echo $row['kodeMK']; ?></td>
                    <td><?php echo $row['namaMK']; ?></td>
                    <td><?php echo $row['sks']; ?></td>
                    <td><?php echo $row['jam']; ?></td>
                    <td class="action-buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $row['kodeMK']; ?>">
                            <input type="hidden" name="table" value="matakuliah">
                            <input type="submit" name="delete" value="Hapus">
                        </form>
                        <form method="GET" action="">
                            <input type="hidden" name="id" value="<?php echo $row['kodeMK']; ?>">
                            <input type="hidden" name="table" value="matakuliah">
                            <input type="submit" name="edit" value="Edit">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Tambah Data Baru</h2>
        <form method="POST" action="">
            <h3>Tambah Dosen</h3>
            <input type="hidden" name="table" value="dosen">
            <label>Nama Dosen:</label><br>
            <input type="text" name="namaDosen" required><br>
            <label>No HP:</label><br>
            <input type="text" name="noHP" required><br>
            <input type="submit" name="create" value="Tambah"><br><br>
        </form>

        <form method="POST" action="">
            <h3>Tambah Mahasiswa</h3>
            <input type="hidden" name="table" value="mahasiswa">
            <label>NPM:</label><br>
            <input type="text" name="npm" required><br>
            <label>Nama Mahasiswa:</label><br>
            <input type="text" name="namaMhs" required><br>
            <label>Prodi:</label><br>
            <input type="text" name="prodi" required><br>
            <label>Alamat:</label><br>
            <input type="text" name="alamat" required><br>
            <label>No HP:</label><br>
            <input type="text" name="noHP" required><br>
            <input type="submit" name="create" value="Tambah"><br><br>
        </form>

        <form method="POST" action="">
            <h3>Tambah Matakuliah</h3>
            <input type="hidden" name="table" value="matakuliah">
            <label>Kode MK:</label><br>
            <input type="text" name="kodeMK" required><br>
            <label>Nama MK:</label><br>
            <input type="text" name="namaMK" required><br>
            <label>SKS:</label><br>
            <input type="text" name="sks" required><br>
            <label>Jam:</label><br>
            <input type="text" name="jam" required><br>
            <input type="submit" name="create" value="Tambah"><br><br>
        </form>
    </div>
</body>
</html>
