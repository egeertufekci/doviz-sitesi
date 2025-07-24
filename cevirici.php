<?php
session_start();
include 'config.php';

// API'den döviz kurlarını çek
function getDovizKurlari() {
    $api_url = "https://api.exchangerate-api.com/v4/latest/USD";
    $json_data = file_get_contents($api_url);
    return json_decode($json_data, true);
}

$kurlar = getDovizKurlari();
$sonuc = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $miktar = floatval($_POST['miktar']);
    $kaynak_doviz = $_POST['kaynak_doviz'];
    $hedef_doviz = $_POST['hedef_doviz'];
    
    // USD'ye çevir
    if ($kaynak_doviz != "USD") {
        $miktar = $miktar / $kurlar['rates'][$kaynak_doviz];
    }
    
    // Hedef dövize çevir
    if ($hedef_doviz != "USD") {
        $miktar = $miktar * $kurlar['rates'][$hedef_doviz];
    }
    
    $sonuc = number_format($miktar, 2);
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Döviz Çevirici - Döviz Sitesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        .converter-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .result-card {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">DövizSitesi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kurlar.php">Döviz Kurları</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="cevirici.php">Döviz Çevirici</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="haberler.php">Haberler</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="profil.php">Profilim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Çıkış Yap</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Giriş Yap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Kayıt Ol</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card converter-card">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Döviz Çevirici</h2>
                        <form method="POST" action="">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="miktar" class="form-label">Miktar</label>
                                    <input type="number" class="form-control" id="miktar" name="miktar" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="kaynak_doviz" class="form-label">Kaynak Döviz</label>
                                    <select class="form-select" id="kaynak_doviz" name="kaynak_doviz" required>
                                        <option value="USD">USD - Amerikan Doları</option>
                                        <option value="EUR">EUR - Euro</option>
                                        <option value="TRY">TRY - Türk Lirası</option>
                                        <option value="GBP">GBP - İngiliz Sterlini</option>
                                        <option value="JPY">JPY - Japon Yeni</option>
                                        <option value="CHF">CHF - İsviçre Frangı</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="hedef_doviz" class="form-label">Hedef Döviz</label>
                                    <select class="form-select" id="hedef_doviz" name="hedef_doviz" required>
                                        <option value="TRY">TRY - Türk Lirası</option>
                                        <option value="USD">USD - Amerikan Doları</option>
                                        <option value="EUR">EUR - Euro</option>
                                        <option value="GBP">GBP - İngiliz Sterlini</option>
                                        <option value="JPY">JPY - Japon Yeni</option>
                                        <option value="CHF">CHF - İsviçre Frangı</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Hesapla</button>
                            </div>
                        </form>

                        <?php if($sonuc !== null): ?>
                        <div class="card result-card mt-4">
                            <div class="card-body text-center">
                                <h3 class="mb-0">
                                    <?php echo $_POST['miktar'] . ' ' . $_POST['kaynak_doviz']; ?> = 
                                    <?php echo $sonuc . ' ' . $_POST['hedef_doviz']; ?>
                                </h3>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 