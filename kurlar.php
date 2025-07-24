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
$usd_try = $kurlar['rates']['TRY'];
$eur_try = $kurlar['rates']['TRY'] / $kurlar['rates']['EUR'];
$gbp_try = $kurlar['rates']['TRY'] / $kurlar['rates']['GBP'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Döviz Kurları - Döviz Sitesi</title>
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
        .currency-card {
            transition: transform 0.3s;
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .currency-card:hover {
            transform: translateY(-5px);
        }
        .currency-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .trend-up {
            color: #28a745;
        }
        .trend-down {
            color: #dc3545;
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
                        <a class="nav-link active" href="kurlar.php">Döviz Kurları</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cevirici.php">Döviz Çevirici</a>
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
        <h2 class="text-center mb-4">Güncel Döviz Kurları</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card currency-card">
                    <div class="card-body text-center">
                        <i class="fas fa-dollar-sign currency-icon text-primary"></i>
                        <h4 class="card-title">USD/TRY</h4>
                        <h2 class="text-primary mb-3"><?php echo number_format($usd_try, 2); ?> ₺</h2>
                        <p class="trend-up mb-0">
                            <i class="fas fa-arrow-up me-2"></i>
                            %0.25 Artış
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card currency-card">
                    <div class="card-body text-center">
                        <i class="fas fa-euro-sign currency-icon text-primary"></i>
                        <h4 class="card-title">EUR/TRY</h4>
                        <h2 class="text-primary mb-3"><?php echo number_format($eur_try, 2); ?> ₺</h2>
                        <p class="trend-down mb-0">
                            <i class="fas fa-arrow-down me-2"></i>
                            %0.15 Düşüş
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card currency-card">
                    <div class="card-body text-center">
                        <i class="fas fa-pound-sign currency-icon text-primary"></i>
                        <h4 class="card-title">GBP/TRY</h4>
                        <h2 class="text-primary mb-3"><?php echo number_format($gbp_try, 2); ?> ₺</h2>
                        <p class="trend-up mb-0">
                            <i class="fas fa-arrow-up me-2"></i>
                            %0.10 Artış
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Döviz Kuru Grafiği</h5>
                        <canvas id="kurGrafigi"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafik verilerini oluştur
        const ctx = document.getElementById('kurGrafigi').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran'],
                datasets: [{
                    label: 'USD/TRY',
                    data: [29.5, 30.2, 31.1, 31.5, 31.8, <?php echo $usd_try; ?>],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },
                {
                    label: 'EUR/TRY',
                    data: [32.1, 32.8, 33.5, 34.0, 34.2, <?php echo $eur_try; ?>],
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                },
                {
                    label: 'GBP/TRY',
                    data: [37.5, 38.2, 39.0, 39.5, 39.8, <?php echo $gbp_try; ?>],
                    borderColor: 'rgb(54, 162, 235)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Son 6 Aylık Döviz Kuru Değişimi'
                    }
                }
            }
        });
    </script>
</body>
</html> 