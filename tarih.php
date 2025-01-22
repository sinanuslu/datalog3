<?php 
// Zaman dilimini ayarla
date_default_timezone_set('Europe/Istanbul');

$tarihArray = [];
foreach ($sidebar as $kayit) {
    $tarihArray[] = strtotime($kayit["tarih"]);
}

// Tarihlerin minimum ve maksimum değerlerini al
$minTarih = min($tarihArray);
$maxTarih = max($tarihArray);

// DateTime nesnelerine dönüştür
$minDateTime = new DateTime("@$minTarih", new DateTimeZone('UTC')); // '@' UNIX timestamp olduğunu belirtir
$maxDateTime = new DateTime("@$maxTarih", new DateTimeZone('UTC'));
//UTC'den Europe/Istanbul'a dönüşüm
$minDateTime->setTimezone(new DateTimeZone('Europe/Istanbul'));
$maxDateTime->setTimezone(new DateTimeZone('Europe/Istanbul'));

// İki tarih arasındaki farkı hesapla
$dif = $maxDateTime->diff($minDateTime);
// Ay farkını al başlangıç ayını eklemek için 2 ekle
$monthDif = $dif->y * 12 + $dif->m + 2;

?>