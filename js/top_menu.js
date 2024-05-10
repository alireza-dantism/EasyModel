/**
 * Created by Alireza Dantism on 10/24/2021.
 */
// $('#header').prepend('<div id="menu-icon" class="font-18 color-68"><i class="fa fa-bars"></i></div>');
(function($) {
    var $window = $(window);

    $window.resize(function resize() {
        if ($window.width() < 768) {
            return $('#menu-icon').addClass('menu-icon');
        }

        $('#menu-icon').removeClass('menu-icon');
    }).trigger('resize');
})(jQuery);

$(".menu-icon").on("click", function(){
    $("nav").slideToggle();
    $(this).toggleClass("active");
});

$(document).ready(function(){
    $('a[target!="_blank"]').click(function(event){
        event.preventDefault();
        window.location = $(this).attr('href');
        
    });
});