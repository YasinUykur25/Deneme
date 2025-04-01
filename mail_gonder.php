<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    // SMTP ayarları
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'yasinuykur5@gmail.com';   // Senin Gmail adresin
    $mail->Password   = 'bmptujgpjsebxsza';        // Uygulama şifren (boşluksuz yazıldı)
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Gönderici ve alıcı bilgileri
    $mail->setFrom('yasinuykur5@gmail.com', 'Yasin\'in Sistemi');
    $mail->addAddress('yasinuykur5@gmail.com'); // Kendine gönderiyorsun test için

    // Mail içeriği
    $mail->isHTML(true);
    $mail->Subject = '💥 Sistem Test Maili';
    $mail->Body    = 'Merhaba Yasin! Bu, PHP ile gönderilen test mailidir.<br><b>Her şey çalışıyor!</b> 🚀';

    $mail->send();
    echo '✅ Mail başarıyla gönderildi!';
} catch (Exception $e) {
    echo "❌ Mail gönderilemedi. Hata: {$mail->ErrorInfo}";
}
?>
