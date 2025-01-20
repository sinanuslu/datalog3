<?php
ob_start(); // Çıktıyı tamponlamayı başlatın

// Dosyanın sunucudaki tam yolu
$filePath = $_GET["path"];

// Dosya mevcut mu kontrol edin
if (file_exists($filePath)) {
    // HTTP başlıklarını ayarlayın
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream'); // Tarayıcıda açılmayı engeller, indirir
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"'); // İndirilecek dosya adı
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath)); // Dosya boyutunu belirtin

    // Dosyayı okuyup gönderin
    readfile($filePath);
    ob_end_flush(); // Tamponu boşalt ve çıktı gönder
    exit;
} else {
    echo "Dosya bulunamadı!";
    ob_end_flush(); // Hata durumunda da tamponu boşalt
}

