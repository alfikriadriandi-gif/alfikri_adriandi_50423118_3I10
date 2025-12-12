<?php
include 'koneksi.php';

//  mengambil entri diary
$query = "SELECT * FROM diary ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);

// success messages
$success_message = '';
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case '1':
            $success_message = 'Asikk quotes baruu! ';
            break;
        case '2':
            $success_message = 'Cieee update! ✨';
            break;
        case '3':
            $success_message = 'Yahhh diapuss :( 🗑️';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Alfikri - Tempat curcol</title>
    <meta name="description" content="Tempat curhat dadakan">
    
    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
    
    <!-- huruf -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📝</text></svg>">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1>Blog Alfikri Adriandi</h1>
                <p>Misuh misuh Alfikri Adriandi</p>
            </div>
        </header>
        
        <!-- Action Bar -->
        <div class="action-bar">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Cari Quotes... (Ctrl+K)">
            </div>
            <a href="tambah.php" class="btn">
                <i class="fas fa-plus"></i>
                Tambah Entri Baru
            </a>
        </div>

        <!-- Success Message -->
        <?php if ($success_message): ?>
        <div id="success-message" style="
            background: linear-gradient(135deg, #f02525ff 0%, #1313daff 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px -5px rgba(222, 41, 41, 0.9);
            animation: slideIn 0.5s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        ">
            <i class="fas fa-check-circle"></i>
            <span><?php echo $success_message; ?></span>
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('success-message');
                if (msg) msg.style.display = 'none';
            }, 5000);
        </script>
        <?php endif; ?>

        <!-- Emot pendukung -->
        <div class="entries-grid" id="entriesGrid">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): 
                    $mood_icons = [
                        'senang' => '😊',
                        'sedih' => '😢',
                        'marah' => '😠',
                        'antusias' => '🤩',
                        'lelah' => '😴',
                        'bingung' => '😕',
                        'tenang' => '😌',
                        'energik' => '💪',
                        'bangga' => '👑',
                        'inspiratif' => '💡'
                    ];
                    $mood_icon = $mood_icons[$row['mood']] ?? '😊';
                    $formatted_date = date('d M Y', strtotime($row['tanggal']));
                    $full_date = date('l, d F Y H:i', strtotime($row['tanggal']));
                ?>
                    <div class="entry-card" data-mood="<?php echo $row['mood']; ?>">
                        <div class="entry-header">
                            <h2 class="entry-judul"><?php echo htmlspecialchars($row['judul']); ?></h2>
                            <span class="entry-tanggal" title="<?php echo $full_date; ?>">
                                <i class="far fa-calendar"></i> <?php echo $formatted_date; ?>
                            </span>
                        </div>
                        
                        <div class="entry-isi">
                            <?php echo nl2br(htmlspecialchars($row['isi'])); ?>
                        </div>
                        
                        <div class="entry-footer">
                            <div class="mood-badge">
                                <span class="mood-icon"><?php echo $mood_icon; ?></span>
                                <?php echo ucfirst($row['mood']); ?>
                            </div>
                            
                            <div class="entry-actions">
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-small btn-success" title="Edit entri">
                                    <i class="fas fa-edit"></i>
                                    <span class="action-text">Edit</span>
                                </a>
                                <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-small btn-danger" title="Hapus entri" onclick="return confirm('Bener nih?')">
                                    <i class="fas fa-trash"></i>
                                    <span class="action-text">Hapus</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h2>Belum ada entri diary</h2>
                    <p>Kata kata hari ininya abangggg"</p>
                    <a href="tambah.php" class="btn" style="margin-top: 1.5rem;">
                        <i class="fas fa-plus"></i>
                        Tulis Entri Pertama
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Footer -->
        <footer class="footer">
            <p>
                <i class="fas fa-heart" style="color: #c00909ff;"></i> 
                &copy; <?php echo date('Y'); ?> Blog Pribadi. 
                Dibuat dengan HTML, PHP, dan MySQL
            </p>
            <p style="margin-top: 0.5rem; font-size: 0.9rem; opacity: 0.8;">
                <i class="fas fa-keyboard"></i> Tips: Gunakan Ctrl+K untuk mencari
            </p>
        </footer>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>
</body>
</html>

<?php
mysqli_close($koneksi);
?>