<?php

use function PHPSTORM_META\type;

require_once "baglan.php";
require "../func.php";

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'fetchData') {
        $searchKey = !empty(trim($_POST['searchKey']))
            ? preg_split('/\s+(?![^(]*\))/', trim($_POST['searchKey']))
            : [];

        // Parantezleri kaldır
        $searchKey = array_map(function ($item) {
            return trim($item, '()');
        }, $searchKey);

        // Boş değerleri filtrele
        $searchKey = array_filter($searchKey);
        $filters = isset($_POST['filters']) ? json_decode($_POST['filters'], true) : [];
        $result = searchDizi($searchKey);
        $innerContent = getData($result, $filters);
        $anahtarSearch = '';
        echo json_encode(array('innerContent' => $innerContent, 'anahtarSearch' => $anahtarSearch));
    }

    if ($_POST['action'] == 'searchRecord') {
        $searchKey = !empty(trim($_POST['searchKey']))
            ? preg_split('/\s+(?![^(]*\))/', trim($_POST['searchKey']))
            : [];

        // Parantezleri kaldır
        $searchKey = array_map(function ($item) {
            return trim($item, '()');
        }, $searchKey);

        // Boş değerleri filtrele
        $searchKey = array_filter($searchKey);
        $filters = isset($_POST['filters']) ? json_decode($_POST['filters'], true) : [];
        $result = searchDizi($searchKey);
        $innerContent = getData($result, $filters, $searchKey);
        $anahtarSearch = getKeys($searchKey);
        echo json_encode(array('innerContent' => $innerContent, 'anahtarSearch' => $anahtarSearch, 'keyWords' => $searchKey));
    }

    if ($_POST['action'] == 'searchFilter') {
        $searchKey = !empty(trim($_POST['searchKey']))
            ? preg_split('/\s+(?![^(]*\))/', trim($_POST['searchKey']))
            : [];

        // Parantezleri kaldır
        $searchKey = array_map(function ($item) {
            return trim($item, '()');
        }, $searchKey);

        // Boş değerleri filtrele
        $searchKey = array_filter($searchKey);
        $filters = isset($_POST['filters']) ? json_decode($_POST['filters'], true) : [];
        $result = searchDizi($searchKey);
        $innerContent = getData($result, $filters, $searchKey);
        $anahtarSearch = getKeys($searchKey);
        echo json_encode(array('innerContent' => $innerContent, 'anahtarSearch' => $anahtarSearch, 'keyWords' => $searchKey));
    }

}

function getData($result, $filters = [], $etiket = [])
{
    $months = [
        "01" => "Ocak",
        "02" => "Şubat",
        "03" => "Mart",
        "04" => "Nisan",
        "05" => "Mayıs",
        "06" => "Haziran",
        "07" => "Temmuz",
        "08" => "Ağustos",
        "09" => "Eylül",
        "10" => "Ekim",
        "11" => "Kasım",
        "12" => "Aralık",
    ];
    $monthsEng = [
        "Ocak" => "January",
        "Şubat" => "February",
        "Mart" => "March",
        "Nisan" => "April",
        "Mayıs" => "May",
        "Haziran" => "June",
        "Temmuz" => "July",
        "Ağustos" => "August",
        "Eylül" => "September",
        "Ekim" => "October",
        "Kasım" => "November",
        "Aralık" => "December",
    ];

    $kategoriArr = explode(',', rtrim($filters['kategori'], ','));
    $kaynakArr = explode(',', rtrim($filters['kaynak'], ','));
    $olcekArr = explode(',', rtrim($filters['olcek'], ','));
    $calismaArr = explode(',', rtrim($filters['calisma'], ','));
    if (empty($filters['tarih'])) {
        $tarihArr = array();
    } else {
        $tarihArr = explode(',', rtrim(strtr($filters['tarih'], $monthsEng), ','));
    }

    //Tarihlerin timestamp dönüşümü ve ingilizce ay isim çevrimleri eklenecek
    //Aşağıda matchesFilter gibi tarih aralığını kontrol edilidiği  fonksiyon yazılacak 
    foreach ($tarihArr as $key => $tarih) {
        // Başına "01 " ekliyoruz ve DateTime nesnesine dönüştürüyoruz
        $dateString = "01 " . $tarih; // Örneğin: "01 January 2023"
        $dateTime = DateTime::createFromFormat("d F Y", $dateString);

        if ($dateTime) {
            // Dönüştürülmüş DateTime nesnesini alıp, yeniden formatlayabiliriz
            $tarihArr[$key] = $dateTime->format("Y-m-d");
        } else {
            // Hatalı tarih formatı kontrolü
            echo "Geçersiz tarih formatı: $dateString\n";
        }
    }

    $output = '';

    if (!empty($result)) {
        foreach ($result as $value) {

            // Filtrelenecek değerlerin kontrolü
            $filterKategori = empty($filters['kategori']) || matchesFilter($value, $kategoriArr, 'kategori');
            $filterKaynak = empty($filters['kaynak']) || matchesFilter($value, $kaynakArr, 'kaynak');
            $filterOlcek = empty($filters['olcek']) || matchesFilter($value, $olcekArr, 'olcek');
            $filterCalisma = empty($filters['calisma']) || matchesFilter($value, $calismaArr, 'calisma_id');
            $filterTarih = empty($filters['tarih']) || matchesFilterDate($value, $tarihArr, 'tarih');


            // Farklı bölümlerden gelen filtre değerleri sağlanıyorsa çalışacak
            if ($filterKategori && $filterKaynak && $filterOlcek && $filterCalisma && $filterTarih) {

                $date = new DateTime($value['tarih'], new DateTimeZone('UTC'));
                $month = strtr($date->format("m"), $months);
                $year = $date->format("Y");

                /* ESKİ İŞLEM
                // Process meta_veri and generate highlighted text and tags
                $meta_veri = htmlspecialchars(implode("|", $value["meta_veri"]), ENT_NOQUOTES, 'UTF-8'); //Tek tırnak sorunundan dolayı ENT_NOQUOTES kullanıldı
                $soru = htmlspecialchars(implode("|", $value["soru"]), ENT_NOQUOTES, 'UTF-8');
                $cevap = htmlspecialchars(implode("|", $value["cevap"]), ENT_NOQUOTES, 'UTF-8');
                */
                //meta_veri için vurgulama
                $tagMetaVeri = getTags($value, "meta_veri", $etiket); // Soru ve Cevap için de oluşturulacak
                $tagsSoru = getTags($value, "soru", $etiket);
                $tagsCevap = getTags($value, "cevap", $etiket);
                //tags yinelemelerini engellemek için birleştirildi
                $Tags = array_unique(array_merge($tagMetaVeri['tags'], $tagsSoru['tags'], $tagsCevap['tags']));

                // Start accordion item


                $output .= '<div class="col">
                <div class="card h-100">


                    <span style="display:none;">' . htmlspecialchars($value["calisma_id"]) . '</span>

                    <div class="card-header no-border text-center pt-1 justify-content-center align-content-center bg-body-secondary p-0" style="height:60px;">
                        <div class="widget-49-title-wrapper">
                            <div class="widget-49-date-success ms-2 me-1 p-2">
                                <span class="widget-49-date-day">' . $month . '</span>
                                <span class="widget-49-date-month">' . $year . '</span>
                            </div>
                            <div class="widget-49-meeting-info">
                                <h6 class="card-title p-1 m-0">' . htmlspecialchars($value["calisma"]) . '</h6>
                            </div>
                        </div>
                    </div>

                    <div class="card-body py-0">
                        <div class="">


                            ' . '<a style="cursor:pointer;" class="open-modal btn"  data-bs-toggle="modal" data-bs-target="#modalMetodoloji" data-id="' . htmlspecialchars($value["calisma_id"]) . '">
                            <div class="mt-1" style="max-height:150px; overflow:hidden;">' . $value['meta_veri'] . '
                                </div></a>
                        </div>
                    </div>

                    <div class="ms-3">
                    <span class="badge text-dark m-1 p-2" style="background-color: #0274d834; font-size:0.50rem;">' . str_replace(",", " / ", $value['kategori']) . '</span>'
                    . '<span class="badge text-dark m-1 p-2" style="background-color: #5cb85c36; font-size:0.50rem;">' . str_replace(",", " / ", $value['kaynak']) . '</span>'
                    . '<span class="badge text-dark m-1 p-2" style="background-color: #5bc0de2d; font-size:0.50rem;">' . str_replace(",", " / ", $value['olcek']) . '</span>'
                    . '</div>'
                    . '<div class="scroll-container mx-3" style="font-size:0.50rem;">' . implode("", $Tags)
                    . ' </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="#" class="open-modal position-relative btn btn-sm btn-flash-border-primary" data-bs-toggle="modal" data-bs-target="#modalSorular" data-id="' . htmlspecialchars($value["calisma_id"])
                    . '">SORU/CEVAP
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.5rem;">
                            ' . (count($value['soru']) > 0 ? count($value['soru']) : '#') . '</span>
                        </a>
                        <a href="#" class="doc-modal btn btn-sm btn-flash-border-primary" data-bs-toggle="modal" data-bs-target="#modalCevaplar" data-id="' . htmlspecialchars($value["calisma_id"]) . '">DÖKÜMAN</a>
                    </div>
                </div>

            </div>';
            }
        }
    } else {
        $output = '<h4>İlgili Kriterleri İçeren Çalışma Bulunamadı!</h4>';
    }

    return $output;
}


function getKeys($searchKey)
{
    $output = '';
    if (!empty($searchKey)) {
        foreach ($searchKey as $value) {
            $output .= '<span class="scroll-item badge bg-secondary py-1">' . htmlspecialchars($value) . '</span>';
        }
    } else {
        $output = '<span>...</span>';
    }
    return $output;
}

// Filtre bölümünden gelen değerleri kontrol
function matchesFilter($value, $filterArray, $field)
{
    foreach ($filterArray as $filter) {
        if (stripos($value[$field], $filter) !== false) {
            return true;
        }
    }
    return false;
}

function matchesFilterDate($value, $filterArray, $field)
{

    if (empty($filterArray)) { //Boşsa tarih filtresi uygulama
        return true;
    } else if ($value[$field] >= $filterArray[0] && $value[$field] <= $filterArray[1]) {
        return true;
    }
    return false;
}
