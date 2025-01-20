<?php
$stm = $dbh->prepare("SELECT * FROM meta");
$stm->execute();

$sidebar = $stm->fetchAll(PDO::FETCH_ASSOC);

$kayitSayi = $stm->rowCount();
$kategori = "";
$kaynak = "";
$olcek = "";
$calisma = "";

if ($kayitSayi > 0) {
    foreach ($sidebar as $kayit) {
        $kategori .= "," . $kayit["kategori"];
        $kaynak .= "," . $kayit["kaynak"];
        $olcek .= "," . $kayit["olcek"];
        $calisma .= "," . $kayit["calisma"];
    }

    // Baştaki virgülü kaldırmak için trim kullanıyoruz -- 
    $kategori = ltrim($kategori, ",");
    $kategoriArray = explode(",", $kategori);
    $kategoriArray = array_unique($kategoriArray); // Kategorileri diziye çevir, yinelenenleri kaldır ve tekrar dizi olarak al
    $kategoriArray = array_values($kategoriArray); // Diziyi yeniden indekslemek için

    $kaynak = ltrim($kaynak, ",");
    $kaynakArray = explode(",", $kaynak);
    $kaynakArray = array_unique($kaynakArray); // Kaynakları diziye çevir, yinelenenleri kaldır ve tekrar dizi olarak al
    $kaynakArray = array_values($kaynakArray); // Diziyi yeniden indekslemek için

    $olcek = ltrim($olcek, ",");
    $olcekArray = explode(",", $olcek);
    $olcekArray = array_unique($olcekArray); // Ölçekleri diziye çevir, yinelenenleri kaldır ve tekrar dizi olarak al
    $olcekArray = array_values($olcekArray); // Diziyi yeniden indekslemek için

    $calisma = ltrim($calisma, ",");
    $calismaArray = explode(",", $calisma);
    $calismaArray = array_unique($calismaArray); // Çalışmaları diziye çevir, yinelenenleri kaldır ve tekrar dizi olarak al
    $calismaArray = array_values($calismaArray); // Diziyi yeniden indekslemek için
    
}
