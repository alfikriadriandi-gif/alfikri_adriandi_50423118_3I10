<?php
include 'koneksi.php';

// Cid parameter
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query = "SELECT * FROM diary WHERE id = $id";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $mood = mysqli_real_escape_string($koneksi, $_POST['mood']);
    
    // Validation
    if (empty($judul) || empty($isi) || empty($mood)) {
        $error = 'Semua field harus diisi!';
    } else {
        $query = "UPDATE diary SET judul='$judul', isi='$isi', mood='$mood' WHERE id=$id";
        
        if (mysqli_query($koneksi, $query)) {
            header("Location: index.php?success=2");
            exit();
        } else {
            $error = "Terjadi kesalahan: " . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entri - Blog Pribadi</title>
    
    <!-- Style -->
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
                <h1>Edit Entri</h1>
                <p>Kasi kata katanya dongg</p>
                <div style="margin-top: 1rem; font-size: 0.9rem; opacity: 0.9;">
                    <i class="far fa-calendar"></i> 
                    Dibuat: <?php echo date('d M Y H:i', strtotime($row['tanggal'])); ?>
                </div>
            </div>
        </header>
        
        <!-- Form Container -->
        <div class="form-container">
            <?php if($error): ?>
                <div class="error-message" style="
                    background: linear-gradient(135deg, #530fc7ff 0%, #f23030ff 100%);
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: 12px;
                    margin-bottom: 2rem;
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
                    animation: slideIn 0.5s ease;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    border-left: 4px solid #dc2626;
                ">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span><?php echo $error; ?></span>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="editForm">
                <div class="form-group">
                    <label for="judul">
                        <i class="fas fa-heading"></i> Judul Entri
                    </label>
                    <input type="text" id="judul" name="judul" 
                           value="<?php echo htmlspecialchars($row['judul']); ?>"
                           required
                           maxlength="255">
                    <div class="char-counter" style="text-align: right; color: #0351ecff; font-size: 0.85rem; margin-top: 0.5rem;">
                        <span id="judulCounter"><?php echo strlen($row['judul']); ?></span>/255 karakter
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="isi">
                        <i class="fas fa-edit"></i> Cerita Anda
                    </label>
                    <textarea id="isi" name="isi" required><?php echo htmlspecialchars($row['isi']); ?></textarea>
                    <div class="char-counter" style="text-align: right; color: #f11313ff; font-size: 0.85rem; margin-top: 0.5rem;">
                        <span id="isiCounter"><?php echo strlen($row['isi']); ?></span> karakter
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="mood">
                        <i class="fas fa-smile"></i> Mood Hari Ini
                    </label>
                    <select id="mood" name="mood" required>
                        <option value="senang" <?php echo ($row['mood'] == 'senang') ? 'selected' : ''; ?>>😊 Senang & Bahagia</option>
                        <option value="sedih" <?php echo ($row['mood'] == 'sedih') ? 'selected' : ''; ?>>😢 Sedih & Kecewa</option>
                        <option value="marah" <?php echo ($row['mood'] == 'marah') ? 'selected' : ''; ?>>😠 Marah & Frustasi</option>
                        <option value="antusias" <?php echo ($row['mood'] == 'antusias') ? 'selected' : ''; ?>>🤩 Antusias & Semangat</option>
                        <option value="lelah" <?php echo ($row['mood'] == 'lelah') ? 'selected' : ''; ?>>😴 Lelah & Capek</option>
                        <option value="bingung" <?php echo ($row['mood'] == 'bingung') ? 'selected' : ''; ?>>😕 Bingung & Ragu</option>
                        <option value="tenang" <?php echo ($row['mood'] == 'tenang') ? 'selected' : ''; ?>>😌 Tenang & Damai</option>
                        <option value="energik" <?php echo ($row['mood'] == 'energik') ? 'selected' : ''; ?>>💪 Energik & Produktif</option>
                        <option value="bangga" <?php echo ($row['mood'] == 'bangga') ? 'selected' : ''; ?>>👑 Bangga & Puas</option>
                        <option value="inspiratif" <?php echo ($row['mood'] == 'inspiratif') ? 'selected' : ''; ?>>💡 Inspiratif & Kreatif</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Perbarui Entri
                    </button>
                    <a href="index.php" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i>
                        Batal
                    </a>
                    <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" 
                       onclick="return confirm('Yakin ingin menghapus entri ini?')">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>
    <script>
        // Character counters
        const judulInput = document.getElementById('judul');
        const isiTextarea = document.getElementById('isi');
        const judulCounter = document.getElementById('judulCounter');
        const isiCounter = document.getElementById('isiCounter');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('editForm');

        function updateCounters() {
            judulCounter.textContent = judulInput.value.length;
            isiCounter.textContent = isiTextarea.value.length;
            
            // Update colors based on length
            if (judulInput.value.length > 200) {
                judulCounter.style.color = '#ef4444';
            } else if (judulInput.value.length > 150) {
                judulCounter.style.color = '#f59e0b';
            } else {
                judulCounter.style.color = '#6b7280';
            }
            
            if (isiTextarea.value.length > 1000) {
                isiCounter.style.color = '#ef4444';
            } else if (isiTextarea.value.length > 500) {
                isiCounter.style.color = '#f59e0b';
            } else {
                isiCounter.style.color = '#6b7280';
            }
        }

        judulInput.addEventListener('input', updateCounters);
        isiTextarea.addEventListener('input', updateCounters);

        // Form submission handler
        form.addEventListener('submit', function(e) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memperbarui...';
            submitBtn.disabled = true;
        });

        // Check for changes
        let originalData = {
            judul: judulInput.value,
            isi: isiTextarea.value,
            mood: document.getElementById('mood').value
        };

        form.addEventListener('input', function() {
            const currentData = {
                judul: judulInput.value,
                isi: isiTextarea.value,
                mood: document.getElementById('mood').value
            };
            
            const hasChanges = JSON.stringify(originalData) !== JSON.stringify(currentData);
            
            if (hasChanges) {
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Perbarui Entri *';
            } else {
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Perbarui Entri';
            }
        });
    </script>
</body>
</html>

<?php
mysqli_close($koneksi);
?>