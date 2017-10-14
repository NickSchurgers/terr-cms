/**
 * Created by nschu on 08/07/2017.
 */
$(document).ready(function () {
    $("li.is-submenu-item > a").click(function () {
        var elem = $(".accordion-menu");
        elem.foundation('hideAll');
    });
});

