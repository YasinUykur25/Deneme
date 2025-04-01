<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
require_once "db.php";

$bilgi = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (empty($email)) {
        $bilgi = "❗ E-posta boş olamaz!";
    } else {
        $sorgu = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $sorgu->execute([$email]);

        if ($sorgu->rowCount() > 0) {
            $kullanici = $sorgu->fetch();
            $token = bin2hex(random_bytes(50)); // güvenli rastgele token

            // Token'ı veritabanına kaydet
            $update = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
            $update->execute([$token, $email]);

            // Mail gönderme
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'yasinuykur5@gmail.com';
                $mail->Password = 'bmptujgpjsebxsza'; // uygulama şifresi
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('yasinuykur5@gmail.com', 'Yasin\'in Sistemi');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Şifre Sıfırlama Linki';
                $mail->Body = "Merhaba <b>{$kullanici['username']}</b>,<br><br>" .
                              "Şifrenizi sıfırlamak için aşağıdaki bağlantıya tıklayın:<br>" .
                              "<a href='http://localhost/deneme/sifre_yenile.php?token=$token'>Şifreyi Sıfırla</a><br><br>" .
                              "Eğer bu talep size ait değilse, bu mesajı yok sayabilirsiniz.";

                $mail->send();
                $bilgi = "✅ Şifre sıfırlama bağlantısı e-posta adresine gönderildi!";
            } catch (Exception $e) {
                $bilgi = "❌ Mail gönderilemedi. Hata: {$mail->ErrorInfo}";
            }
        } else {
            $bilgi = "❌ Bu e-posta adresi sistemde kayıtlı değil.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Şifremi Unuttum</title>
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
            to {
                opacity: 1;
            }
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

        input:focus {
            background-color: rgba(255, 255, 255, 0.2);
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
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        .message {
            margin-top: 15px;
            color: #6affb5;
            font-weight: bold;
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
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Şifremi Unuttum</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Kayıtlı E-Posta Adresi" required>
        <button type="submit">Şifre Sıfırlama Maili Gönder</button>
    </form>

    <?php if (!empty($bilgi)): ?>
        <div class="message"><?= $bilgi ?></div>
    <?php endif; ?>

    <a class="link" href="yeni2.php">← Giriş Sayfasına Dön</a>
</div>

</body>
</html>
