// Glass window

// by Mexalim
// - ICQ 590881221
// - Email info@mexalim.com.ua

(function($) {
  $(function() {
      var popwindow = $('.popwindow'); // Класс окна
      var popbutton = $('.popbutton'); // Класс кнопки
      $("body").prepend("<div class='mask'></div>");
      function preparewindow(windowobject) {
      
      for(var x=0; x<windowobject.length; x++) {
      	
        wintitle = windowobject[x].getAttribute('data-title');
        
        $(windowobject[x]).wrap("<div class='box_window'></div>");
        $(windowobject[x]).addClass("box_window_in");
        $(windowobject[x]).parent(".box_window").prepend("<div class='bw_close'>сlose</div>");
        //windowobject.css("cursor","pointer");

        $(windowobject[x]).parent(".box_window").prepend('<div class="box_title" data-clipboard-text="5867687" data-clipboard-action="copy">'+wintitle+'</div>');
        
        if(windowobject[x].getAttribute('data-width')) {
         winwidth = windowobject[x].getAttribute('data-width');
         winheight = windowobject[x].getAttribute('data-height');
         winmargin = winwidth / 2;
         
         //if(winwidth<900) {

        $(windowobject[x]).parent(".box_window").css({'width':winwidth,'height':winheight,'margin-left':'-'+winmargin})
        $(windowobject[x]).css({'height':winheight})
        	//}
        }
        
      }
      }  
      if (popwindow.length) {
        preparewindow(popwindow);
        popbutton.click(function(){
            var idwind = $(this).data("window");
            $("#" + idwind).parent(".box_window").fadeIn().addClass("windactiv");
            $("#" + idwind+" .box_title").html($(this).data("title"));
            $(".mask").fadeIn();
            $(".to_blur").addClass("blur");
            return false;
        });
      };
      $(".mask, .bw_close").click(function(){
          $(".windactiv").fadeOut();
          $(".windactiv").removeClass("windactiv");
          $(".mask").fadeOut();
           $(".to_blur").removeClass("blur");
      });
  });
})(jQuery)