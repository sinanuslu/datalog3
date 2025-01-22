<?php
require_once "baglanti/baglan.php";



function searchDizi($searchKey, $id = "calisma_id")
{

    foreach ($searchKey as $key) {
        if ($key != '') {
            $queryKeyMeta[] = "meta_veri LIKE ?";
            $queryKeySoru[] = "soru LIKE ?";
            $queryKeyCevap[] = "cevap LIKE ?";
            $parametre[] = "%$key%";
        }
    }

    if (!empty($searchKey)) {
        //Anahtar kelimenin geçtiği tüm çalışmaları bulmak için hazırlanacak ANA SORGUda kullanılacak TABLO SORGUları
        $queryMeta = "SELECT $id FROM meta WHERE " . implode(" OR ", $queryKeyMeta) . " COLLATE utf8mb4_turkish_ci";
        $querySoru = "SELECT $id FROM meta_soru2 WHERE " . implode(" OR ", $queryKeySoru)  . " OR " . implode(" OR ", $queryKeyCevap) . " COLLATE utf8mb4_turkish_ci";
        $queryCevap = "SELECT $id FROM meta_soru2 WHERE " . implode(" OR ", $queryKeyCevap) . " COLLATE utf8mb4_turkish_ci";

        //Tüm tablolarda arama sonucunda çıkan çalışmaları bulmak için kullanılacak ANA SORGU
        $queryMain = "SELECT * FROM meta WHERE $id IN ($queryMeta" . " UNION " . $querySoru . " UNION " . $queryCevap . ")";

        //ANA SORGUdan gelecek tabloya SORU ve CEVAP anahtarlarının eklenmesinde kullanılacak sorgular ve
        $queryMeta = "SELECT * FROM meta WHERE " . implode(" OR ", $queryKeyMeta);
        $querySoru = "SELECT * FROM meta_soru2 WHERE " . implode(" OR ", $queryKeySoru) . " OR " . implode(" OR ", $queryKeyCevap);
        $queryCevap = "SELECT * FROM meta_soru2 WHERE " . implode(" OR ", $queryKeyCevap);
    } else {
        $parametre = [];

        //Tüm tablolarda arama sonucunda çıkan çalışmaları bulmak için kullanılacak ANA SORGU
        $queryMain = "SELECT * FROM meta";

        //ANA SORGUdan gelecek tabloya SORU ve CEVAP anahtarlarının eklenmesinde kullanılacak sorgular ve
        $queryMeta = "SELECT * FROM meta";
        $querySoru = "SELECT * FROM meta_soru2";
        $queryCevap = "SELECT * FROM meta_soru2";
    }

    $contentMeta = executeQuery($queryMeta, $parametre);
    $contentSoru = executeQuery($querySoru, array_merge($parametre, $parametre));
    $contentCevap = executeQuery($queryCevap, $parametre);
    $contentMain = executeQuery($queryMain, array_merge($parametre, $parametre, $parametre, $parametre));

    if (!empty($contentMain)) {
        foreach ($contentMain as $keyMain => &$valueMain) {
            $valueMain['soru'] = []; //Arama kelimelerini içeren SORULARI ilgili çalışmaya array olarak eklemek için
            $valueMain['cevap'] = []; //Arama kelimelerini içeren CEVAPLARI ilgili çalışmaya array olarak eklemek için
            foreach ($contentSoru as $keySoru => $valueSoru) {
                if ($valueMain[$id] == $valueSoru[$id]) {
                    $valueMain['soru'][$valueSoru['soru_id2']] = trChar($valueSoru['soru']);
                    $valueMain['cevap'][$valueSoru['soru_id2']] = trChar($valueSoru['cevap']);
                }
            }

            $output[] = $valueMain;
        }
        return $output;
    }
}

//TÜRKÇE KARAKTER SORUNU
function trChar($str, $to = 'UPPER')
{
    if ($to == 'LOWER') {
        return mb_strtolower(str_replace(array('I', 'Ğ', 'Ü', 'Ş', 'İ', 'Ö', 'Ç'), array('ı', 'ğ', 'ü', 'ş', 'i', 'ö', 'ç'), $str), 'utf-8');
    } elseif ($to == 'UPPER') {
        return mb_strtoupper(str_replace(array('ı', 'ğ', 'ü', 'ş', 'i', 'ö', 'ç'), array('I', 'Ğ', 'Ü', 'Ş', 'İ', 'Ö', 'Ç'), $str), 'utf-8');
    } else {
        trigger_error('Lütfen geçerli bir trChar() parametresi giriniz.', E_USER_ERROR);
    }
}

//SORGULARI ÇALIŞTIRMA
function executeQuery($query, $parametre = [])
{
    $stm = $GLOBALS['dbh']->prepare($query);
    if (!empty($parametre)) {
        $stm->execute($parametre);
    } else {
        $stm->execute();
    }
    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

// Aranan kelimenin arka plan rengini belirler - Etiket olarak ekler     
function highlightKeywords($arrValue, $col, $keywords, $highlightColor = "yellow")
{
    $output = [];  // Anahtar kelimeler için oluşturulan etiketleri saklamak için bir dizi
    $count =  0;  // Toplam bulunan anahtar kelime sayısını takip eden sayaç
    $highlightedText = []; // Her bir metindeki vurgulanmış anahtar kelimeleri saklamak için bir dizi


    $id = $arrValue['calisma_id']; // Her metnin benzersiz ID'sini al
    $highlightedArr = []; // Vurgulanmış metinlerin geçici olarak saklandığı dizi

    if (!is_array($arrValue[$col])) {
        $arrValue[$col] = [$arrValue[$col]];
    }
    foreach ($arrValue[$col] as $key => $value) { // Metin sütunundaki her bir öğeyi kontrol et
        $text = $value; // Orijinal metni al
        // Metni XSS'ye karşı güvenli hale getirmek için temizle
        $processedText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        foreach ($keywords as $keyword) { // Anahtar kelimeler üzerinde dolaş
            $sanitizedKeyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); // Anahtar kelimeyi de güvenli hale getir
            $start = 0; // Aramaya başlanacak konum

            // Anahtar kelimeyi metin içinde ararken büyük/küçük harf duyarsızlık uygula
            while (($pos = mb_stripos(trChar($processedText), trChar($sanitizedKeyword), $start, 'UTF-8')) !== false) {

                // Bulunan anahtar kelimeyi vurgulamak için <span> ile sar
                $highlighted = "<span style='background-color: $highlightColor;'>"
                    . mb_substr($processedText, $pos, mb_strlen($sanitizedKeyword, 'UTF-8'), 'UTF-8')
                    . "</span>";

                // Vurgulanmış metni yeni metin olarak oluştur
                $processedText = mb_substr($processedText, 0, $pos, 'UTF-8')
                    . $highlighted
                    . mb_substr($processedText, $pos + mb_strlen($sanitizedKeyword, 'UTF-8'), null, 'UTF-8');

                // Döngünün sonsuza girmesini önlemek için başlangıç konumunu ileri taşı
                $start = $pos + mb_strlen($highlighted, 'UTF-8');
                $count++; // Bulunan kelime sayısını artır
            }

            // Anahtar kelimenin orijinal metinde geçtiğini kontrol et
            if (mb_stripos(trChar($text), trChar($sanitizedKeyword), 0, 'UTF-8') !== false) {
                // Anahtar kelime için bir etiket oluştur ve listeye ekle
                $output[] = '<span class="scroll-item badge bg-secondary py-1 me-1">' . $sanitizedKeyword . '</span>';
            }
        }
        $highlightedArr[$key] = $processedText; // Vurgulanmış metni geçici diziye ekle
    }
    $highlightedText[$id] = $highlightedArr; // ID'ye göre vurgulanmış metinleri sakla


    // Vurgulanmış metinler, etiketler ve toplam anahtar kelime sayısını döndür
    return ['highlightedText' => $highlightedText, 'tags' => $output, 'count' => $count];
    /* 
    * Döndürülen değerin yapısı:
    * highlightedText : 
    * Array
    * (
    *     ['calisma_id'] => Array
    *     (
    *         ['soru_id2'] => VURGULANAN TEXT
    *     )
    * )
    */
    /**
     * highlightKeywords($arr, $col, $keywords, $highlightColor = "yellow");
     * Örnek:
     * - $arr = searchDizi fonksiyonunda keywords aratılan Sorgu sonucu dönen dizi (tüm çalışmalar)
     * - $col = 'soru' sütununda veya 'cevap' sütununda arama yapılır
     * - $keywords = ['aranan değerler'] ile belirtilen kelimeler bulunur ve vurgulanır
     */
}


$searchKey = "(ev hanımı) yaş";

$searchKey = trim($searchKey);

// Düzenli ifadeyle "(...)" içindeki metni ve diğer kelimeleri al
preg_match_all('/\((.*?)\)|\S+/', $searchKey, $matches);

// Parantezleri kaldırarak sadece içerikleri ve kelimeleri al
$searchKeyArray = array_map(function($item) {
    return trim($item, '()');
}, array_filter($matches[0]));

// Çıktı kontrolü
print_r($searchKeyArray);



/*
$aa = searchDizi($searchKey);

echo "<pre>";
//var_dump($aa);
$soru = $aa[0];
$soru = highlightKeywords($soru, "soru", $searchKey);

echo "<br><br>";
print_r($soru["highlightedText"]);
echo "<br><br>";
echo $soru['highlightedText'][1][0];

print_r($soru["tags"]);

echo "<br><br>";
echo $soru["count"];
echo "<br><br>";

/*$soru2 = explode(" | ", $soru["highlightedText"]);
var_dump($soru2);
echo "</pre>";
*/

