<?php

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
        $output = '<h4>İlgili Kriterleri İçeren Çalışma Bulunamadı!</h4>';
    }

    return $outputMeta;
}
