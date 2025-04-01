<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sorgu = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $sorgu->execute([$username, $hashedPassword, $email]);

    header("Location: yeni2.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hesap Oluştur</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #480104, #000000);
            height: 100vh;
            font-family: 'Rubik', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .form-container {
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
            to {
                opacity: 1;
            }
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 26px;
        }

        .form-container input {
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

        .form-container input:focus {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .form-container button {
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
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .form-container button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        .link {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .link:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Hesap Oluştur</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
        <input type="password" name="password" placeholder="Şifre" required>
        <input type="email" name="email" placeholder="E-Posta" required>
        <button type="submit">Kayıt Ol</button>
    </form>
    <a class="link" href="yeni2.php">Zaten hesabın var mı? Giriş Yap</a>
</div>

</body>
</html>
