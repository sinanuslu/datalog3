<?php

use function PHPSTORM_META\type;

require_once "baglan.php";
require "../func.php";

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'modalContent') {
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
        $result = searchDizi($searchKey, $_POST['id']);
        $innerContent = getModalData($result, $filters, $searchKey);
        $anahtarSearch = getKeys($searchKey);
        echo json_encode(array('innerContent' => $innerContent, 'anahtarSearch' => $anahtarSearch, 'keyWords' => $searchKey));
    }
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

function getModalData($result, $filters = [], $etiket = [])
{
    
    $outputMeta = '';
    $outputSoru = '';
    $outputDokuman = '';

    if (!empty($result)) {
        foreach ($result as $value) {
            // Farklı bölümlerden gelen filtre değerleri sağlanıyorsa çalışacak

                $outputMeta .= $value['meta_veri'];

        }
    } else {
        $outputMeta = '<h4>İlgili Kriterleri İçeren Çalışma Bulunamadı!</h4>';
    }

    return $outputMeta;
}