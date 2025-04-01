<?php
session_start();
session_destroy(); // Tüm oturumu sil
header("Location: yeni2.php"); // Giriş sayfasına geri dön
exit;
?>
