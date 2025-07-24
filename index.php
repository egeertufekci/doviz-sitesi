<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Döviz Sitesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3');
            background-size: cover;
            color: white;
            padding: 100px 0;
        }
        .currency-card {
            transition: transform 0.3s;
        }
        .currency-card:hover {
            transform: translateY(-5px);
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

    <section class="hero-section text-center">
        <div class="container">
            <h1>Güncel Döviz Kurları</h1>
            <p class="lead">En güncel döviz kurlarını takip edin, hesaplamalar yapın!</p>
        </div>
    </section>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card currency-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">USD/TRY</h5>
                        <h3 class="text-primary">31.85 ₺</h3>
                        <p class="text-success">↑ %0.25</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card currency-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">EUR/TRY</h5>
                        <h3 class="text-primary">34.55 ₺</h3>
                        <p class="text-danger">↓ %0.15</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card currency-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">GBP/TRY</h5>
                        <h3 class="text-primary">40.25 ₺</h3>
                        <p class="text-success">↑ %0.10</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>DövizSitesi</h5>
                    <p>En güncel döviz kurları ve finansal bilgiler.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>İletişim</h5>
                    <p>Email: admin@dovizsite.com<br>Tel: +90 531 564 28 49</p> <p>+90 551 975 63 99 </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 