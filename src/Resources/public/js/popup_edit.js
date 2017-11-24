$(function() {
    $('input[name="hgabka_kunstmaanpopup_popup_type[type]"]').change(function() {
        var type = $('input[name="hgabka_kunstmaanpopup_popup_type[type]"]:checked').val();

        hideElem('#hgabka_kunstmaanpopup_popup_type_media');
        hideElem('#hgabka_kunstmaanpopup_popup_type_imageAlt');
        hideElem('#hgabka_kunstmaanpopup_popup_type_imageTitle');
        hideElem('#hgabka_kunstmaanpopup_popup_type_url_link_url');
        hideElem('#hgabka_kunstmaanpopup_popup_type_newWindow');
        hideElem('#hgabka_kunstmaanpopup_popup_type_html');

        if (type=='html') {
            showElem('#hgabka_kunstmaanpopup_popup_type_html');
        } else if (type=='image') {
            showElem('#hgabka_kunstmaanpopup_popup_type_media');
            showElem('#hgabka_kunstmaanpopup_popup_type_hoverMedia');
            showElem('#hgabka_kunstmaanpopup_popup_type_imageAlt');
            showElem('#hgabka_kunstmaanpopup_popup_type_imageTitle');
            showElem('#hgabka_kunstmaanpopup_popup_type_url_link_url');
            showElem('#hgabka_kunstmaanpopup_popup_type_newWindow');
        }
    }).change();

    function hideElem(selector)
    {
        $(selector).parents('.form-group').hide();
    }
    function showElem(selector)
    {
        $(selector).parents('.form-group').show();
    }
});