<?php
session_start();
include 'config.php';

// Örnek haberler (gerçek bir projede veritabanından çekilir)
$haberler = [
    [
        'baslik' => 'Dolar/TL Yeni Rekor Seviyeye Ulaştı',
        'ozet' => 'Dolar/TL kuru, küresel piyasalardaki gelişmeler ve yurt içi faktörlerin etkisiyle yeni bir rekor seviyeye ulaştı.',
        'tarih' => '2024-03-20',
        'resim' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=500'
    ],
    [
        'baslik' => 'Merkez Bankası Faiz Kararını Açıkladı',
        'ozet' => 'Türkiye Cumhuriyet Merkez Bankası (TCMB), politika faizini piyasa beklentileri doğrultusunda değiştirmedi.',
        'tarih' => '2024-03-19',
        'resim' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?w=500'
    ],
    [
        'baslik' => 'Euro Bölgesi Ekonomisinde Toparlanma İşaretleri',
        'ozet' => 'Euro Bölgesi ekonomisi, son çeyrekte beklentilerin üzerinde büyüme kaydetti. Bu gelişme, Euro\'nun değer kazanmasına neden oldu.',
        'tarih' => '2024-03-18',
        'resim' => 'https://images.unsplash.com/photo-1509023464722-18d996393ca8?w=500'
    ],
    [
        'baslik' => 'Altın Fiyatları Yükselişte',
        'ozet' => 'Küresel belirsizlikler ve jeopolitik riskler nedeniyle altın fiyatları yükseliş trendini sürdürüyor.',
        'tarih' => '2024-03-17',
        'resim' => 'https://images.unsplash.com/photo-1610375461246-83df859d849d?w=500'
    ]
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finans Haberleri - Döviz Sitesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        .news-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            height: 100%;
        }
        .news-card:hover {
            transform: translateY(-5px);
        }
        .news-image {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .news-date {
            color: #6c757d;
            font-size: 0.9rem;
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
                        <a class="nav-link active" href="haberler.php">Haberler</a>
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
        <h2 class="text-center mb-4">Finans Haberleri</h2>
        <div class="row">
            <?php foreach($haberler as $haber): ?>
            <div class="col-md-6 mb-4">
                <div class="card news-card">
                    <img src="<?php echo $haber['resim']; ?>" class="card-img-top news-image" alt="<?php echo $haber['baslik']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $haber['baslik']; ?></h5>
                        <p class="news-date mb-2"><?php echo date('d.m.Y', strtotime($haber['tarih'])); ?></p>
                        <p class="card-text"><?php echo $haber['ozet']; ?></p>
                        <a href="#" class="btn btn-primary">Devamını Oku</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 