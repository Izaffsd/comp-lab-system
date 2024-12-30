<?php
require_once 'config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM makmal_tpp WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Keterangan Makmal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="card fade-in">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2><i class="fas fa-info-circle"></i> Keterangan</h2>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="info-section">
                <div class="info-group">
                    <h3>Makmal TPP:</h3>
                    <p><?php echo $row['namamakmal']; ?></p>
                </div>
                <div class="info-group">
                    <h3>Nama Makmal:</h3>
                    <p><?php echo $row['picmakmal']; ?></p>
                </div>
                <div class="info-group">
                    <h3>PIC Makmal:</h3>
                    <p><?php echo $row['modul']; ?></p>
                </div>
                <div class="info-group">
                    <h3>Pengajar Modul:</h3>
                    <p><?php echo $row['pengajarmodul']; ?></p>
                </div>
                <div class="action-buttons">
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Kemas kini
                    </a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" 
                       onclick="return confirm('Adakah anda pasti untuk membuang rekod ini?')">
                        <i class="fas fa-trash"></i> Buang
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
