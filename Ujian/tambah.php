<?php
include 'koneksi.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $mood = mysqli_real_escape_string($koneksi, $_POST['mood']);
    
    // Validasi
    if (empty($judul) || empty($isi) || empty($mood)) {
        $error = 'Semua field harus diisi!';
    } else {
        $query = "INSERT INTO diary (judul, isi, mood) VALUES ('$judul', '$isi', '$mood')";
        
        if (mysqli_query($koneksi, $query)) {
            header("Location: index.php?success=1");
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
    <title>Tambah Entri Baru - Blog Pribadi</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📝</text></svg>">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1>Tambah Entri Baru</h1>
                <p>Gimana Hari ini?</p>
            </div>
        </header>
        
        <!-- Form Container -->
        <div class="form-container">
            <?php if($error): ?>
                <div class="error-message" style="
                    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: 12px;
                    margin-bottom: 2rem;
                    box-shadow: 0 10px 25px -5px rgba(252, 251, 251, 0.91);
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
            
            <form method="POST" action="" id="diaryForm">
                <div class="form-group">
                    <label for="judul">
                        <i class="fas fa-heading"></i> Judul Entri
                    </label>
                    <input type="text" id="judul" name="judul" 
                           placeholder="Apa yang terjadi hari ini?" 
                           value="<?php echo isset($_POST['judul']) ? htmlspecialchars($_POST['judul']) : ''; ?>"
                           required
                           maxlength="255">
                    <div class="char-counter" style="text-align: right; color: #6b7280; font-size: 0.85rem; margin-top: 0.5rem;">
                        <span id="judulCounter">0</span>/255 karakter
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="isi">
                        <i class="fas fa-edit"></i> Cerita Anda
                    </label>
                    <textarea id="isi" name="isi" 
                              placeholder="Tuliskan pengalaman, pemikiran, atau perasaan Anda hari ini..."
                              required><?php echo isset($_POST['isi']) ? htmlspecialchars($_POST['isi']) : ''; ?></textarea>
                    <div class="char-counter" style="text-align: right; color: #6b7280; font-size: 0.85rem; margin-top: 0.5rem;">
                        <span id="isiCounter">0</span> karakter
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="mood">
                        <i class="fas fa-smile"></i> Mood Hari Ini
                    </label>
                    <select id="mood" name="mood" required>
                        <option value="">Pilih mood Anda...</option>
                        <option value="senang" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'senang') ? 'selected' : ''; ?>>😊 Senang & Bahagia</option>
                        <option value="sedih" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'sedih') ? 'selected' : ''; ?>>😢 Sedih & Kecewa</option>
                        <option value="marah" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'marah') ? 'selected' : ''; ?>>😠 Marah & Frustasi</option>
                        <option value="antusias" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'antusias') ? 'selected' : ''; ?>>🤩 Antusias & Semangat</option>
                        <option value="lelah" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'lelah') ? 'selected' : ''; ?>>😴 Lelah & Capek</option>
                        <option value="bingung" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'bingung') ? 'selected' : ''; ?>>😕 Bingung & Ragu</option>
                        <option value="tenang" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'tenang') ? 'selected' : ''; ?>>😌 Tenang & Damai</option>
                        <option value="energik" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'energik') ? 'selected' : ''; ?>>💪 Energik & Produktif</option>
                        <option value="bangga" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'bangga') ? 'selected' : ''; ?>>👑 Bangga & Puas</option>
                        <option value="inspiratif" <?php echo (isset($_POST['mood']) && $_POST['mood'] == 'inspiratif') ? 'selected' : ''; ?>>💡 Inspiratif & Kreatif</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Simpan Entri
                    </button>
                    <a href="index.php" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Beranda
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
        const form = document.getElementById('diaryForm');

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
        updateCounters();

        // Form submission handler
        form.addEventListener('submit', function(e) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
        });

        // Auto-save draft (optional)
        let draftTimer;
        function saveDraft() {
            const draft = {
                judul: judulInput.value,
                isi: isiTextarea.value,
                mood: document.getElementById('mood').value,
                timestamp: new Date().getTime()
            };
            localStorage.setItem('diaryDraft', JSON.stringify(draft));
        }

        judulInput.addEventListener('input', () => {
            clearTimeout(draftTimer);
            draftTimer = setTimeout(saveDraft, 1000);
        });

        isiTextarea.addEventListener('input', () => {
            clearTimeout(draftTimer);
            draftTimer = setTimeout(saveDraft, 1000);
        });

        // Load draft on page load
        window.addEventListener('load', function() {
            const draft = localStorage.getItem('diaryDraft');
            if (draft) {
                const draftData = JSON.parse(draft);
                // Only load if draft is less than 1 hour old
                if (new Date().getTime() - draftData.timestamp < 3600000) {
                    if (!confirm('Ada draft yang disimpan. Mau lanjutkan?')) {
                        localStorage.removeItem('diaryDraft');
                    } else {
                        judulInput.value = draftData.judul || '';
                        isiTextarea.value = draftData.isi || '';
                        document.getElementById('mood').value = draftData.mood || '';
                        updateCounters();
                    }
                } else {
                    localStorage.removeItem('diaryDraft');
                }
            }
        });

        // Clear draft on successful submission
        form.addEventListener('submit', function() {
            localStorage.removeItem('diaryDraft');
        });
    </script>
</body>
</html>