$(document).ready(function () {
    function setupCheckboxGroup(groupClass, masterId) {
        const $group = $(`.${groupClass}`);
        const $master = $(`#${masterId}`);

        $group.change(function () {
            $master.prop('checked', $group.length === $group.filter(':checked').length);
            $('#FiltreUygula').trigger('click');
        });

        $master.change(function () {
            $group.prop('checked', this.checked);
            $('#FiltreUygula').trigger('click');
        });
    }

    const checkboxGroups = [
        { group: 'kategori', master: 'TumKategori' },
        { group: 'kaynak', master: 'TumKaynak' },
        { group: 'olcek', master: 'TumOlcek' },
        { group: 'calisma', master: 'TumCalisma' }
    ];

    checkboxGroups.forEach(({ group, master }) => setupCheckboxGroup(group, master));
    

    $('#FiltreTemizle').click(function () {
        $('#TumKategori, #TumKaynak, #TumOlcek, #TumCalisma').prop('checked', true).change();
    });


});


