//<![CDATA[
jQuery(function($){
    $('a.zoombox').zoombox();
     
    /**
    * Or You can also use specific options

    $('a.zoombox').zoombox({
        theme       : 'zoombox',        //available themes : zoombox,lightbox, prettyphoto, darkprettyphoto, simple
        opacity     : 0.8,              // Black overlay opacity
        duration    : 800,              // Animation duration
        animation   : true,             // Do we have to animate the box ?
        width       : 600,              // Default width
        height      : 400,              // Default height
        gallery     : true,             // Allow gallery thumb view
        autoplay : false                // Autoplay for video
    });
    */
    //Si il existe un message de notifications il disparait après 3 secondes
    if( $('.alert:visible').length > 0 ){
      $('.alert:visible').delay(3000).slideUp('slow');
    }
});
$(window).load(function() {
        $('#slider').nivoSlider({
          effect : 'fade',
          // controlNav: false,
          animSpeed: 850,
          pauseTime: 5000,
          pauseOnHover: true,
          directionNav: false,
          directionNavHide: true
        });
    });
//]]>