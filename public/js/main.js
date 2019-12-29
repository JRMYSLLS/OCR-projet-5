$(function($){

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
              header.css('background-color','white');
              header.css('transition','2s')
          } else {
              header.css('background-color','');
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

  /////////////////////TEST AJAX //////////////////

  let url = 'index.php?action=refresh';

  
  function messageChat(){
    
    setTimeout(function(){
      if(document.querySelector('.chat-content')){
        ajaxGet(url,function(response){
          let div = document.querySelector('.chat-content');
          div.innerHTML = response;
          //console.log(Date.now());
      });
      }
       
      
      messageChat();
    }, 200)
    
  };

  messageChat();
  //console.log(document.URL);



      

  
 
    
