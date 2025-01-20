
$(document).ready(function () {
    let searchKey = "";  // Global searchKey değişkeni
    let currentFilters = {
        'kategori': '',
        'kaynak': '',
        'olcek': '',
        'calisma': '',
        'tarih': ''
    };  // Filtreler için global değişken

    fetchData(); // Sayfa açıldığında veri döndürecek

    function fetchData() {
        var action = 'fetchData';
        $.ajax({
            url: "baglanti/innerContent.php",
            method: "POST",
            data: { action: action, filters: JSON.stringify(currentFilters), searchKey: searchKey },
            success: function (response) {
                $('#inner-content').html('<div class="h-100 bg-dark bg-opacity-25 spinner-grow rounded" style="width:inherit; top:50%;"></div>');
                setTimeout(() => {
                    let data = JSON.parse(response); // JSON formatında veri döndürecek
                    console.log(data);
                    // inner-content div'ine gelen veriyi yerleştir
                    $('#inner-content').html(data.innerContent);
                    // anahtar-search div'ine gelen veriyi yerleştir
                    $('#anahtar-search').html(data.anahtarSearch);
                }, 0.5 * 1000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    $("#clear-buton").click(function () {
        $('#search-input').val('');
        searchKey = "";
        fetchData();
    });

    $("#FiltreTemizle").click(function () {
        currentFilters = {
            'kategori': '',
            'kaynak': '',
            'olcek': '',
            'calisma': '',
            'tarih': ''
        };
        fetchData();
    });

    // search-buton tıklama işlemi
    $('#search-buton').click(function (event) {
        event.preventDefault();
        var action = 'searchRecord';
        searchKey = $('#search-input').val(); // Yeni searchKey'i arama kutusundan al
        if (searchKey.trim() === '') {
            fetchData();
        } else {
            $.ajax({
                url: "baglanti/innerContent.php",
                method: "POST",
                data: { action: action, searchKey: searchKey, filters: JSON.stringify(currentFilters) }, // Filtreler ve searchKey'i gönder
                success: function (response) {
                    $('#inner-content').html('<div class="h-100 bg-dark bg-opacity-25 spinner-grow rounded" style="width:inherit; top:50%;"></div>');
                    setTimeout(() => {
                        let data = JSON.parse(response); // JSON formatında veri döndürecek
                        // inner-content div'ine gelen veriyi yerleştir
                        $('#inner-content').html(data.innerContent);
                        // anahtar-search div'ine gelen veriyi yerleştir
                        $('#anahtar-search').html(data.anahtarSearch);
                    }, 0.5 * 1000);
                }
            });
        }
    });


    // #FiltreUygula butonuna tıklandığında filtreleri ve searchKey'i gönder
    $('#FiltreUygula').click(function (event) {
        event.preventDefault();
        var action = 'searchFilter';

        kategori = '';
        kaynak = '';
        olcek = '';
        calisma = '';
        tarih = '';

        $.each($("input[name='kategori']:checked"), function () {
            kategori = kategori.concat($(this).val(), ',');
        });

        $.each($("input[name='kaynak']:checked"), function () {
            kaynak = kaynak.concat($(this).val(), ',');
        });

        $.each($("input[name='olcek']:checked"), function () {
            olcek = olcek.concat($(this).val(), ',');
        });

        $.each($("input[name='calisma']:checked"), function () {
            calisma = calisma.concat($(this).val(), ',');
        });

        $('.value').each(function() {
            tarih = tarih.concat($(this).text(), ',');
        });


        currentFilters = {
            'kategori': kategori,
            'kaynak': kaynak,
            'olcek': olcek,
            'calisma': calisma,
            'tarih': tarih
        };

        $.ajax({
            url: "baglanti/innerContent.php",
            method: "POST",
            data: { action: action, filters: JSON.stringify(currentFilters), searchKey: searchKey }, // Filtreler ve searchKey'i gönder
            success: function (response) {
                $('#inner-content').html('<div class="h-100 bg-dark bg-opacity-25 spinner-grow rounded" style="width:inherit; top:50%;"></div>');
                setTimeout(() => {
                    let data = JSON.parse(response); // JSON formatında veri döndürecek
                    // inner-content div'ine gelen veriyi yerleştir
                    $('#inner-content').html(data.innerContent);
                    // anahtar-search div'ine gelen veriyi yerleştir
                    $('#anahtar-search').html(data.anahtarSearch);
                }, 0.5 * 1000);
            }
        });
    });



});

