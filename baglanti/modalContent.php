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
        $innerContent = getModalData($result, $filters, $searchKey, $_POST['modal']);
        $anahtarSearch = getKeys($searchKey);
        echo json_encode(array('innerContent' => $innerContent, 'anahtarSearch' => $anahtarSearch, 'keyWords' => $searchKey));
    }

    if ($_POST['action'] == 'docContent') {
        $output = '';
        $result = getDocs($_POST['id']);
        foreach ($result as $file) {
            $output .= '<a href="downDocs.php?path=' . $file . '"><span class="badge text-bg-secondary m-1 p-2 fs-6">' . basename($file) . '</span></a>';
        }
        echo json_encode(array('docs' => $output));
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

function getModalData($result, $filters = [], $etiket = [], $modal)
{

    $outputMeta = '';
    $outputSoru = '';
    $outputDokuman = '';

    if (!empty($result)) {
        foreach ($result as $value) {

            if ($modal == '#modalMetodoloji') {
                // Farklı bölümlerden gelen filtre değerleri sağlanıyorsa çalışacak
                $highlightedMetaVeri = highlightKeywords($value, "meta_veri", $etiket, "#329bdb");
                $outputMeta .= '<div class="pb-1 border-bottom">
                    <span class="badge rounded-pill bg-danger me-1" style="font-size:0.5rem;">'
                    . $highlightedMetaVeri['count'] . '</span>'
                    . implode("", array_unique($highlightedMetaVeri['tags']))
                    . '</div>
                    <div>'
                    . $highlightedMetaVeri['highlightedText'][$value['calisma_id']][0]
                    . '</div>';
            } elseif ($modal == '#modalSorular') {
                $highlightedSoru = highlightKeywords($value, "soru", $etiket, "#329bdb");
                $highlightedCevap = highlightKeywords($value, "cevap", $etiket, "#329bdb");
                $outputSoru .= '
                    <div>                    
                            <table class="table table-striped-columns" style="width: 100%;">
                            <thead><tr>
                            <th scope="col" style="width: 4%;">Soru ID</th>
                            <th scope="col" style="width: 48%;">
                            <div class="pb-1 border-bottom">
                            <span class="badge rounded-pill bg-danger me-1" style="font-size:0.5rem;">'
                            . $highlightedSoru['count'] . '</span>'
                            . implode("", array_unique($highlightedSoru['tags']))
                            . '</div>
                            Soru</th>
                            <th scope="col" style="width: 48%;">
                            <div class="pb-1 border-bottom">
                            <span class="badge rounded-pill bg-danger me-1" style="font-size:0.5rem;">'
                            . $highlightedCevap['count'] . '</span>'
                            . implode("", array_unique($highlightedCevap['tags']))
                            . '</div>
                            Cevap</th>
                            </tr></thead>';
                foreach ($highlightedSoru['highlightedText'][$value['calisma_id']] as $key => $soru) {
                    $cevap = $highlightedCevap['highlightedText'][$value['calisma_id']][$key];
                    $outputSoru .=  '<tr>
                                    <th scope="row">' . $key . '</th>
                                    <td><div class="tips">' . $soru . '</div>
                                        <span>' . $soru . '</span>
                                    </td>
                                    <td><div class="tips">' . $cevap . '</div>
                                        <span>';
                    if ($cevap == "[]") {
                        $outputSoru .= 'Açık Uçlu';
                    } else {
                        $outputSoru .= $cevap .
                            '</span>';
                    }
                    $outputSoru .=
                        '</td>
                                </tr>';
                }
                $outputSoru .= '</table>

                    </div>';
            }
        }
    } else {
        $outputMeta = '<h4>İlgili Kriterleri İçeren Çalışma Bulunamadı!</h4>';
        $outputSoru = '<h4>İlgili Kriterleri İçeren Çalışma Bulunamadı!</h4>';
    }

    return ['meta' => $outputMeta, 'soru' => $outputSoru];
}
