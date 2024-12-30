<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namamakmal = $_POST['namamakmal'];
    $picmakmal = $_POST['picmakmal'];
    $modul = $_POST['modul'];
    $pengajarmodul = $_POST['pengajarmodul'];
    
    $query = "INSERT INTO makmal_tpp (namamakmal, picmakmal, modul, pengajarmodul) 
              VALUES ('$namamakmal', '$picmakmal', '$modul', '$pengajarmodul')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Makmal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
h2{
    margin-right: 39rem;
    margin-bottom: 10px;
}
.ic i {
    font-size: 1.5rem;
}
.form-group {
    margin-bottom: 15px;
}
input[type="text"] {
    width: 30rem;
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    transition: border-color 0.3s;
}
input[type="text"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
</style>
</head>
<body>
    <div class="container">
    <div class="card fade-in">

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div class="ic">
        <i class="fas fa-info-circle"></i>
        </div>
                <h2>Tambah Makmal TPP</h2>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="namamakmal" placeholder="Nama Makmal" required>
                </div>
                <div class="form-group">
                    <input type="text" name="picmakmal" placeholder="PIC Makmal" required>
                </div>
                <div class="form-group">
                    <input type="text" name="modul" placeholder="Pilih Makmal Komputer TPP" required>
                </div>
                <div class="form-group">
                    <input type="text" name="pengajarmodul" placeholder="Pengajar Modul" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Makmal</button>
            </form>    
    </div>

    </div>
</body>
</html>