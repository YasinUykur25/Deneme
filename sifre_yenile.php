<?php
require_once "db.php";

$bilgi = "";

// 1. Token var mı kontrol et
if (!isset($_GET["token"])) {
    die("Geçersiz bağlantı.");
}

$token = $_GET["token"];

// 2. Token geçerli mi kontrol et
$sorgu = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
$sorgu->execute([$token]);

if ($sorgu->rowCount() === 0) {
    die("Token geçersiz veya süresi dolmuş.");
}

// 3. Form gönderildiyse şifreleri al ve kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yeniSifre = $_POST["new_password"];
    $tekrarSifre = $_POST["confirm_password"];

    if ($yeniSifre !== $tekrarSifre) {
        $bilgi = "❗ Şifreler eşleşmiyor.";
    } elseif (strlen($yeniSifre) < 6) {
        $bilgi = "❗ Şifre en az 6 karakter olmalı.";
    } else {
        $hashliSifre = password_hash($yeniSifre, PASSWORD_DEFAULT);

        // Şifreyi güncelle, token'ı sıfırla
        $guncelle = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
        $guncelle->execute([$hashliSifre, $token]);

        $bilgi = "✅ Şifren başarıyla güncellendi! <a href='yeni2.php'>Giriş Yap</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Şifreyi Yenile</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap');
        body {
            background: linear-gradient(to right, #480104, #000000);
            height: 100vh;
            font-family: 'Rubik', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            margin: 0;
        }
        .form-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            border-radius: 20px;
            padding: 40px;
            width: 400px;
            text-align: center;
            animation: fadeIn 0.8s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease;
        }

        button:hover {
            transform: scale(1.05);
        }

        .message {
            margin-top: 15px;
            font-weight: bold;
            color: #6affb5;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            color: white;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Yeni Şifre Belirle</h2>
    <form method="POST">
        <input type="password" name="new_password" placeholder="Yeni Şifre" required>
        <input type="password" name="confirm_password" placeholder="Yeni Şifre (Tekrar)" required>
        <button type="submit">Şifreyi Güncelle</button>
    </form>

    <?php if (!empty($bilgi)): ?>
        <div class="message"><?= $bilgi ?></div>
    <?php endif; ?>
</div>

</body>
</html>
