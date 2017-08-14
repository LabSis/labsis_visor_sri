$(document).ajaxStart(function () {
    $('#div_loading').show();
}).ajaxStop(function () {
    $('#div_loading').hide();
});
