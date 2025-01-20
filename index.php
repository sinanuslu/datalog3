<?php
require_once "baglanti/baglan.php";
require_once "baglanti/sidebar.php";
require_once "tarih.php";
?>


<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
    <link href="navbar-top-fixed.css" rel="stylesheet" />
    <link href="headers.css" rel="stylesheet" />
    <link href="sidebars.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <link href="tarih.css" rel="stylesheet" />




    <title>DATALOG</title>

    <style>

    </style>

</head>

<body style="background-color: #edf8fc;">

    <!--NAV-->
    <div class="container-fluid bg fixed-top border-bottom" style="background-color: #287694;">
        <div class="container-md ">
            <header class="d-flex flex-wrap justify-content-between py-1 px-5 mb-0">
                <a href="/"
                    class="d-flex align-items-center my-auto mb-md-0 me-md-auto link-body-emphasis text-decoration-none me-auto pe-1">
                    <img src="icon/IBB-IPA-LOGOLAR-02.png" height="60" width="60" alt="" />
                </a>
                <span class="fs-4 my-auto" style="font-family: 'Audiowide', sans-serif; color:#FFF;">DATALOG</span>
            </header>
        </div>
    </div>
    <!--NAV END-->


    <!--MAIN -->
    <div class="container-md">
        <div id="row1" class="row">
            <!--SIDEBAR -->
            <div id="col1" class="col-sm-3 pe-2" style="background-color: #ebf4ff;">
                <div class="sticky-top sticky-offset pt-3">
                    <div class="flex-shrink-0 py-1 px-0" style="width: 100%;">

                        <div class="accordion scrollheight" style="overflow-y: scroll;"
                            id="accordionPanelsStayOpenExample">
                            <div class="kategori-color accordion-item">
                                <h2 class="accordion-header">
                                    <button class="kategori-color accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#kategori-collapseOne" aria-expanded="false"
                                        aria-controls="kategori-collapseOne">
                                        Kategoriler
                                    </button>
                                </h2>
                                <div id="kategori-collapseOne" class="accordion-collapse show">
                                    <div class="accordion-body">
                                        <div class="form-check form-switch ms-1">
                                            <input class="form-check-input" checked type="checkbox" id="TumKategori" />
                                            <label class="form-check-label" for="TumKategori">Tüm Kategoriler</label>
                                        </div>

                                        <?php foreach ($kategoriArray as $key => $value) { ?>
                                            <div class="form-check form-switch ms-1">
                                                <input class="kategori form-check-input" checked="" type="checkbox"
                                                    id="Kategori<?php echo $key ?>" name="kategori" value="<?php echo $value ?>" />
                                                <label class="form-check-label" for="Kategori<?php echo $key ?>">
                                                    <?php echo $value ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                        <!--DATABASE den eklenecek- id, name düzenlenecek-->
                                    </div>
                                </div>
                            </div>

                            <div class="kaynak-color accordion-item">
                                <h2 class="accordion-header">
                                    <button class="kaynak-color accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#kaynak-collapseOne" aria-expanded="false"
                                        aria-controls="kaynak-collapseOne">
                                        Kaynaklar
                                    </button>
                                </h2>
                                <div id="kaynak-collapseOne" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="form-check form-switch ms-1">
                                            <input class="form-check-input" checked type="checkbox" id="TumKaynak" />
                                            <label class="form-check-label" for="TumKaynak">Tüm Kaynaklar</label>
                                        </div>

                                        <?php foreach ($kaynakArray as $key => $value) { ?>
                                            <div class="form-check form-switch ms-1">
                                                <input class="kaynak form-check-input" checked="" type="checkbox"
                                                    id="Kaynak<?php echo $key ?>" name="kaynak" value="<?php echo $value ?>" />
                                                <label class="form-check-label" for="Kaynak<?php echo $key ?>">
                                                    <?php echo $value ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                        <!--DATABASE den eklenecek- id, name düzenlenecek-->
                                    </div>
                                </div>
                            </div>

                            <div class="olcek-color accordion-item">
                                <h2 class="accordion-header">
                                    <button class="olcek-color accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#olcek-collapseOne" aria-expanded="false"
                                        aria-controls="olcek-collapseOne">
                                        Ölçekler
                                    </button>
                                </h2>
                                <div id="olcek-collapseOne" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="form-check form-switch ms-1">
                                            <input class="form-check-input" checked type="checkbox" id="TumOlcek" />
                                            <label class="form-check-label" for="TumOlcek">Tüm Ölçekler</label>
                                        </div>

                                        <?php foreach ($olcekArray as $key => $value) { ?>
                                            <div class="form-check form-switch ms-1">
                                                <input class="olcek form-check-input" checked="" type="checkbox"
                                                    id="Olcek<?php echo $key ?>" name="olcek" value="<?php echo $value ?>" />
                                                <label class="form-check-label" for="Olcek<?php echo $key ?>">
                                                    <?php echo $value ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                        <!--DATABASE den eklenecek- id, name düzenlenecek-->
                                    </div>
                                </div>
                            </div>

                            <div class="calisma-color accordion-item">
                                <h2 class="accordion-header">
                                    <button class="calisma-color accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#calisma-collapseOne" aria-expanded="false"
                                        aria-controls="calisma-collapseOne">
                                        Çalışmalar
                                    </button>
                                </h2>
                                <div id="calisma-collapseOne" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="form-check form-switch ms-1">
                                            <input class="form-check-input" checked type="checkbox" id="TumCalisma" />
                                            <label class="form-check-label" for="TumCalisma">Tüm Çalışmalar</label>
                                        </div>

                                        <?php foreach ($sidebar as $key => $value) { ?>
                                            <div class="form-check form-switch ms-1">
                                                <input class="calisma form-check-input" checked="" type="checkbox"
                                                    id="Calışma<?php echo $value['calisma_id'] ?>" name="calisma" value="<?php echo $value['calisma_id'] ?>" />
                                                <label class="form-check-label" for="Calışma<?php echo $value['calisma_id'] ?>">
                                                    <?php echo $value['calisma'] ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                        <!--DATABASE den eklenecek- id, name düzenlenecek-->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--TARİH FİLTRE-->
                        <div class="slider" id="slider-distance">
                            <div>
                                <div class="inverse-left"></div>
                                <div class="inverse-right"></div>
                                <div class="range"></div>
                                <span class="thumb" id="thumb-left"></span>
                                <span class="thumb" id="thumb-right"></span>
                                <div class="sign" id="sign-left"><span class="value"></span></div>
                                <div class="sign" id="sign-right"><span class="value"></span></div>
                            </div>
                            <input type="range" id="range-left" value="1" max="<?php echo $monthDif; ?>" min="1" step="1">
                            <input type="range" id="range-right" value="<?php echo $monthDif; ?>" max="<?php echo $monthDif; ?>" min="1" step="1">
                        </div>


                        <!--TARİH FİLTRE END-->
                        <div class="btn-group gap-2 ms-auto mt-2 w-100 px-1" role="group" aria-label="Filtre Butonları">
                            <button id="FiltreUygula" title="Filtreyi Uygula" type="button"
                                class="btn btn-sm btn-primary ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-toggles" viewBox="0 0 16 16">
                                    <path
                                        d="M4.5 9a3.5 3.5 0 1 0 0 7h7a3.5 3.5 0 1 0 0-7zm7 6a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m-7-14a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5m2.45 0A3.5 3.5 0 0 1 8 3.5 3.5 3.5 0 0 1 6.95 6h4.55a2.5 2.5 0 0 0 0-5zM4.5 0h7a3.5 3.5 0 1 1 0 7h-7a3.5 3.5 0 1 1 0-7" />
                                </svg>
                                Filtrele
                            </button>
                            <button id="FiltreTemizle" title="Filtreyi Temizle" type="button"
                                class="btn btn-sm btn-outline-danger ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293z" />
                                </svg>
                                Temizle
                            </button>
                        </div>


                    </div>
                </div>
            </div>
            <!--SIDEBAR END-->

            <!--CONTENT -->
            <div class="col-sm-9 border-start">
                <!--SEARCH -->
                <div class="sticky-top sticky-offset py-3 border-bottom" style="background-color: #ebf4ff">

                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-key" viewBox="0 0 16 16">
                                <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8m4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5" />
                                <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                        </span>
                        <div class="tooltip-container">
                            <input id="search-input" type="text" class="form-control" placeholder="Anahtar Kelime" style="background-color: #f5f9ff;"
                                aria-label="Anahtar" aria-describedby="basic-addon1" />
                            <div class="tooltip" id="myTooltip">İki kelimeden oluşan aramaları parantez içine alınız. Örnek: (ev kadını)</div>
                        </div>
                        <button id="search-buton" class="btn btn-outline-success" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                        </button>
                        <button id="clear-buton" class="btn btn-outline-danger" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </button>
                    </div>

                    <div class="keys mt-2 mb-0" style="font-size: 0.75rem">
                        <span class="justify-content-center align-content-center mx-2 fw-bold"
                            style="padding-bottom: 5px; flex: 0 0 auto">Anahtar kelimeler :
                        </span>
                        <div id="anahtar-search" class="scroll-container">
                            <!--input alanından Gelecek-->
                        </div>
                    </div>

                </div>
                <!--SEARCH END-->

                <!--RESULTS -->

                <div id="content" class="row pt-1" style="background-color: #ebf4ff;">
                    <div class="m-0 p-0">
                        <div id="inner-content" class="row row-cols-1 row-cols-lg-3 row-cols-md-2 g-2 scrollheight2" style="overflow-y: scroll;" id="accordionFlushExample">
                            <!--db Den Gelecek-->
                        </div>


                    </div>
                </div>
                <!--RESULTS END-->
            </div>
            <!--CONTENT END-->
        </div>
    </div>
    <!--MAIN END-->

    <!-- Modal: METODOLOJİ -->
    <div class="modal fade" id="modalMetodoloji" tabindex="-1" aria-labelledby="modalMetodolojiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMetodolojiLabel">METODOLOJİ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="metodoloji" style="font-size: 0.75rem; overflow-x:hidden;">

                </div>
            </div>
        </div>
    </div>


    <!-- Modal: SORULAR -->
    <div class="modal fade" id="modalSorular" tabindex="-1" aria-labelledby="modalSorularLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSorularLabel">SORU / CEVAP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="sorular" style="font-size: 0.75rem; padding:0; margin:16px; overflow-x:hidden;">
                    <div id="infoDiv"></div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal: CEVAPLAR -->
    <div class="modal fade" id="modalCevaplar" tabindex="-1" aria-labelledby="modalCevaplarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCevaplarLabel">DÖKÜMAN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="dokuman" class="modal-body" style="font-size: 0.75rem; overflow-x:hidden;">

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="checkbox.js"></script>
    <script src="tarih.js" defer></script>
    <script src="innerContent.js"></script>


    <script>
        document.getElementById('search-input').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                document.getElementById('search-buton').click(); // "Search" butonunu tetikleme
            }
        });

        //tarih.php den
        const sliderConfig = {
            minMonth: <?php echo json_encode($minDateTime->format("m") - 1); ?>,
            minYear: <?php echo json_encode($minDateTime->format("Y")); ?>
        };
    </script>
</body>

</html>


<?php $stm = null;
$stmContent = null; ?>