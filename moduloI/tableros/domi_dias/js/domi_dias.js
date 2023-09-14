$(document).ready(function () {
    $(".verloader").click(function () {
        $(".loader").show();
    });

    $(".verloaderB").change(function () {
        $(".loader").show();
    });

    $("select").select2();
});

$(window).load(function () {
    $(".loader").fadeOut("slow");
});
