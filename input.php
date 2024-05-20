<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Dosen</title>
    <style>
        h1 {
            text-align: center;
        }
        .container {
            width: 400px;
            margin: auto;
        }
        fieldset {
            border: 1px solid #ccc;
            padding: 20px;
        }
        label {
            display: inline-block;
            width: 100px;
        }
        input[type="text"] {
            width: calc(100% - 110px);
            padding: 5px;
        }
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin: 20px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Input Data</h1>
    <div class="container">
        <form id="form_dosen" action="input.php" method="post">
            <fieldset>
                <legend>Input Data Dosen</legend>
                <p>
                    <label for="namaDosen">Nama Dosen:</label>
                    <input type="text" name="namaDosen" id="namaDosen" required>
                </p>
                <p>
                    <label for="noHP">No HP:</label>
                    <input type="text" name="noHP" id="noHP" placeholder="Contoh: 081222333444" required>
                </p>
            </fieldset>
            <p>
                <input type="submit" name="input" value="Simpan">
            </p>
        </form>
    </div>

    <div class="message">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Variabel koneksi dengan database MySQL
            $host = "localhost";
            $user = "root";
            $passwd = ""; // Sesuaikan dengan password MySQL Anda
            $name = "db_pratikum";

            // Proses koneksi
            $link = mysqli_connect($host, $user, $passwd, $name);

            // Periksa koneksi, jika gagal akan menampilkan pesan error
            if (!$link) {
                die('<p class="error">Koneksi dengan database gagal: ' . mysqli_connect_errno() . ' - ' . mysqli_connect_error() . '</p>');
            }

            // Ambil data dari form
            $namaDosen = mysqli_real_escape_string($link, $_POST['namaDosen']);
            $noHP = mysqli_real_escape_string($link, $_POST['noHP']);

            // Query untuk menyimpan data dosen
            $query = "INSERT INTO t_dosen (namaDosen, noHP) VALUES ('$namaDosen', '$noHP')";

            // Eksekusi query
            if (mysqli_query($link, $query)) {
                echo '<p class="success">Data dosen berhasil disimpan.</p>';
            } else {
                echo '<p class="error">Terjadi kesalahan: ' . mysqli_error($link) . '</p>';
            }

            // Tutup koneksi
            mysqli_close($link);
        }
        ?>
    </div>
</body>
</html>