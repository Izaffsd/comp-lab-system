<?php
session_start(); 
require_once 'config/database.php';

define('MESSAGE_SUCCESS', 'success');
define('MESSAGE_ERROR', 'error');
define('MESSAGE_WARNING', 'warning');
define('MESSAGE_INFO', 'info');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

$query = "SELECT * FROM makmal_tpp WHERE 
          namamakmal LIKE ? OR 
          picmakmal LIKE ? OR 
          modul LIKE ? OR 
          pengajarmodul LIKE ?
          ORDER BY $sort $order";

// prepare counter kalau kene SQL injection
$stmt = mysqli_prepare($conn, $query);
$searchParam = "%$search%";
mysqli_stmt_bind_param($stmt, "ssss", $searchParam, $searchParam, $searchParam, $searchParam);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$total_records = mysqli_num_rows($result);
$records_per_page = 5;
$total_pages = ceil($total_records / $records_per_page);

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

$query .= " LIMIT ?, ?";
$stmt = mysqli_prepare($conn, $query);
$searchParam = "%$search%";
mysqli_stmt_bind_param($stmt, "ssssii", $searchParam, $searchParam, $searchParam, $searchParam, $offset, $records_per_page);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pengurusan Makmal TPP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            animation: fadeOut 5s forwards;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }
        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card fade-in">
            <div class="header">
                <h1>
                    <i class="fas fa-laptop"></i>
                    Senarai Makmal TPP
                </h1>
                <div class="btn-group">
                    <a href="create.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Makmal</span>
                    </a>
                    <a href="logout.php" class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Log Keluar</span>
                    </a>
                </div>
            </div>

            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type'] ?? 'info'; ?>" role="alert">
                    <i class="fas <?php
                        switch($_SESSION['message_type'] ?? '') {
                            case MESSAGE_SUCCESS:
                                echo 'fa-check-circle';
                                break;
                            case MESSAGE_ERROR:
                                echo 'fa-exclamation-circle';
                                break;
                            case MESSAGE_WARNING:
                                echo 'fa-exclamation-triangle';
                                break;
                            default:
                                echo 'fa-info-circle';
                        }
                    ?>"></i>
                    <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari mengikut nama makmal, PIC, modul atau pengajar..." 
                           value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                </div>
            </div>

            <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <a href="?sort=namamakmal&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>&search=<?php echo urlencode($search); ?>">
                                    Nama Makmal
                                    <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th>PIC Makmal</th>
                            <th>Modul</th>
                            <th>Pengajar Modul</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="fade-in">
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['namamakmal']); ?></td>
                            <td><?php echo htmlspecialchars($row['picmakmal']); ?></td>
                            <td><?php echo htmlspecialchars($row['modul']); ?></td>
                            <td><?php echo htmlspecialchars($row['pengajarmodul']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-view" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete" 
                                       onclick="return confirm('Adakah anda pasti untuk padam maklumat ini?')" title="Padam">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Tiada rekod dijumpai.</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchValue = this.value;
                window.location.href = `index.php?search=${encodeURIComponent(searchValue)}`;
            }, 500);
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                clearTimeout(searchTimeout);
                const searchValue = this.value;
                window.location.href = `index.php?search=${encodeURIComponent(searchValue)}`;
            }
        });

        // auto sembunyikan selepas 7 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 7000);
        });
    });
    </script>
</body>
</html>