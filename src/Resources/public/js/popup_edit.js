$(function() {
    $('input[name="hgabka_kunstmaanbanner_banner_type[type]"]').change(function() {
        var type = $('input[name="hgabka_kunstmaanbanner_banner_type[type]"]:checked').val();

        hideElem('#hgabka_kunstmaanbanner_banner_type_media');
        hideElem('#hgabka_kunstmaanbanner_banner_type_hoverMedia');
        hideElem('#hgabka_kunstmaanbanner_banner_type_imageAlt');
        hideElem('#hgabka_kunstmaanbanner_banner_type_imageTitle');
        hideElem('#hgabka_kunstmaanbanner_banner_type_url_link_url');
        hideElem('#hgabka_kunstmaanbanner_banner_type_newWindow');
        hideElem('#hgabka_kunstmaanbanner_banner_type_html');

        if (type=='html') {
            showElem('#hgabka_kunstmaanbanner_banner_type_html');
        } else if (type=='image') {
            showElem('#hgabka_kunstmaanbanner_banner_type_media');
            showElem('#hgabka_kunstmaanbanner_banner_type_hoverMedia');
            showElem('#hgabka_kunstmaanbanner_banner_type_imageAlt');
            showElem('#hgabka_kunstmaanbanner_banner_type_imageTitle');
            showElem('#hgabka_kunstmaanbanner_banner_type_url_link_url');
            showElem('#hgabka_kunstmaanbanner_banner_type_newWindow');
        }
    }).change();

    $('#hgabka_kunstmaanbanner_banner_type_place').change(function() {
        var url = $(this).data('url');
        $.post(url, { place : $(this).val()}, function(data) {
            $('#hgabka_kunstmaanbanner_banner_type_media_info_text').attr('data-original-title', data);
        });
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