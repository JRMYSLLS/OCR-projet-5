jQuery(function($){

    var alert = $('#alert');
    if(alert.length > 0){
      alert.hide().slideDown(500).delay(2000).slideUp();
      alert.find('.close').click(function(e){
        e.preventDefault();
        alert.slideUp();
      })
    }
  });
  
  $(function() {
      var header = $(".nav-custom");
      $(window).scroll(function() {
          var scroll = $(window).scrollTop();
  
          if (scroll >= 20) {
              header.css('opacity','1');
              header.css('transition','1s')
          } else {
              header.css('opacity','');
          }
      });
  });
  
  $(function() {
    $(".delete").click(function(){
        if(confirm("Souhaitez vous valider la suppression")) {
            return true;
        } else {
            return false; 
        }
    });
  });