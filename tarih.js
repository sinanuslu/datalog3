
$(document).ready(function () {
    const months = [
        "Aralık", "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
        "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım"
    ];

    const minMonth = sliderConfig.minMonth - 1; //index.php sliderConfig nesnesinden geliyor
    const minYear = sliderConfig.minYear; //index.php sliderConfig nesnesinden geliyor

    function updateSlider() {
        const min = parseInt($("#range-left").attr("min"));
        const max = parseInt($("#range-left").attr("max"));

        const leftValue = parseInt($("#range-left").val());
        const rightValue = parseInt($("#range-right").val());

        const leftPercent = Math.ceil(((leftValue - min) / (max - min)) * 100);
        const rightPercent = Math.ceil(((rightValue - min) / (max - min)) * 100);

        const yearLeft = Math.floor((leftValue + minMonth - 1) / 12) + parseInt(minYear);
        const yearRight = Math.floor((rightValue + minMonth - 1) / 12) + parseInt(minYear);

        const textLeft = `${months[(leftValue + minMonth) % 12]} ${yearLeft}`;
        const textRight = `${months[(rightValue + minMonth) % 12]} ${yearRight}`;

        const changes = [];

        // Güncelleme işlemlerini topluca ekleyin
        changes.push(() => $(".inverse-left").css("width", `${leftPercent}%`));
        changes.push(() => $(".inverse-right").css("width", `${100 - rightPercent}%`));
        changes.push(() => $(".range").css({ left: `${leftPercent}%`, right: `${100 - rightPercent}%` }));
        changes.push(() => $("#thumb-left").css("left", `${leftPercent}%`));
        changes.push(() => $("#thumb-right").css("left", `${rightPercent}%`));
        changes.push(() => $("#sign-left").css("left", `${leftPercent}%`).find(".value").text(textLeft));
        changes.push(() => $("#sign-right").css("left", `${rightPercent}%`).find(".value").text(textRight));

        // Tüm değişiklikleri tek seferde DOM'a uygula
        changes.forEach((change) => change());
        
    }

    function updateDateText(newTextLeft, newTextRight) {
        textLeft = newTextLeft;
        textRight = newTextRight;
    }

    $("#range-left").on("input", function () {
        const rightValue = parseInt($("#range-right").val());
        $(this).val(Math.min(parseInt($(this).val()), rightValue - 1));
        updateSlider();
    });

    $("#range-left").on("mouseup", function () {
        $('#FiltreUygula').trigger('click');
    });

    $("#range-right").on("input", function () {
        const leftValue = parseInt($("#range-left").val());
        $(this).val(Math.max(parseInt($(this).val()), leftValue + 1));
        updateSlider();
    });

    $("#range-right").on("mouseup", function () {
        $('#FiltreUygula').trigger('click');
    });

    updateSlider();
});
