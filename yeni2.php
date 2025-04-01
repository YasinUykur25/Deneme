<?php
require_once "db.php";
session_start();
$hata = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $sorgu = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sorgu->execute([$username]);
    $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($kullanici && password_verify($password, $kullanici["password"])) {
        $_SESSION["username"] = $username;
        header("Location: profile.php");
        exit;
    } else {
        $hata = "Kullanıcı adı veya şifre yanlış!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(to right, #141E30, #243B55);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Rubik', sans-serif;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            border-radius: 20px;
            padding: 40px;
            width: 350px;
            color: white;
            text-align: center;
            animation: slideDown 0.8s ease forwards;
            transform: translateY(-100px);
            opacity: 0;
        }

        @keyframes slideDown {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-box h2 {
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: bold;
        }

        .login-box input {
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

        .password-wrapper {
            position: relative;
        }

        .password-wrapper span {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .login-box button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        .login-box .link {
            margin-top: 15px;
            display: block;
            font-size: 14px;
            color: #ccc;
        }

        .error {
            color: #ff6b6b;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Giriş Yap</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
        
        <div class="password-wrapper">
            <input type="password" name="password" id="password" placeholder="Şifre" required>
            <span onclick="togglePassword()">👁️</span>
        </div>

        <button type="submit">Giriş Yap</button>

        <?php if ($hata): ?>
            <div class="error"><?= $hata ?></div>
        <?php endif; ?>
		<a class="link" href="sifremi_unuttum.php">Şifremi mi unuttun?</a>

    </form>

    <a class="link" href="yeni.php">Hesabın yok mu? Kayıt Ol</a>
</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    password.type = password.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
