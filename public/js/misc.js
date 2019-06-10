(function($) {
  'use strict';
  $(function() {
    var sidebar = $('.sidebar');
    var path = "/acc";
    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required
    var current = location.href.split(path).slice(-1)[0].replace(/^\/|\/$/g, '');
    
    $('.nav li a', sidebar).each(function() {
      var $this = $(this);
      var length = current.length;
      var toFind = $this.attr('href').split(path).slice(-1)[0].replace(/^\/|\/$/g, '');
      console.log(current);
      console.log(toFind);
      if(current == toFind) {
        
          $(this).parents('.nav-item').last().addClass('active');
          if ($(this).parents('.sub-menu').length) {
            $(this).closest('.collapse').addClass('show');
            $(this).addClass('active');
          }
        


      }
      
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
      if ($('.scroll-container').length) {
        const ScrollContainer = new PerfectScrollbar('.scroll-container');
      }
    }

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');


    $(".purchace-popup .popup-dismiss").on("click",function(){
      $(".purchace-popup").slideToggle();
    });
  });
})(jQuery);