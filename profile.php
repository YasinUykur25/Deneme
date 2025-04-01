<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: yeni2.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profil / CV</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #141E30, #243B55);
            height: 100vh;
            font-family: 'Rubik', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .cv-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            border-radius: 20px;
            padding: 40px;
            width: 450px;
            text-align: left;
            animation: fadeIn 0.8s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .cv-box h2 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #00ffe1;
        }

        .cv-box h3 {
            margin-bottom: 20px;
            color: #ccc;
        }

        .cv-box ul {
            padding-left: 20px;
        }

        .cv-box ul li {
            margin-bottom: 10px;
        }

        .cv-box .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="cv-box">
    <h2>Yasin Uykur</h2>
    <h3>Full Stack Adayı / Öğrenci</h3>

    <ul>
        <li><strong>📍 Okul:</strong> Şehit Ömer Halisdemir Mesleki ve Teknik Anadolu Lisesi</li>
        <li><strong>🧑‍💻 Tecrübe:</strong> Galatasaray Üniversitesi Bilgi İşlem (9 ay)</li>
        <li><strong>🧠 Bildiği Diller:</strong> C#, HTML, CSS, Python, PHP (öğreniyor)</li>
        <li><strong>📁 Proje:</strong> PHP Giriş Sistemi</li>
        <li><strong>📫 Mail:</strong> yasinuykur5@gmail.com</li>
        <li><strong>📱 Telefon:</strong> 0542 765 33 79</li>
    </ul>

    <div class="footer">
        Hazırlayan: <?= htmlspecialchars($_SESSION["username"]) ?> | Tüm hakları saklıdır © <?= date('Y') ?>
    </div>
</div>

</body>
</html>
