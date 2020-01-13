// MESSAGE FLASH
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

// COULEUR BACKGROUND MENU
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

 // ALERTE DE VALIDATION A LA SUPPRESSION
  $(function() {
    $(".delete").click(function(){
        if(confirm("Souhaitez vous valider la suppression")) {
            return true;
        } else {
            return false; 
        }
    });
  });

  //

  $(function(){
    $('.bloquer').click(function(e){
      swal('Pour voir le tuto, vous devez vous inscrire.');
      e.preventDefault();
    })
  })

// VERIFICATION POST TCHAT

$(function(){
  $(".postChat").click(function(e){
    var content = $('.chatMessage').val();
    console.log('prout');
    if(content == ''){
      swal('Votre message est vide.').then(function(){
        $('.chatMessage').focus();
      });
      e.preventDefault();
    }
  });
});

// VERIFICATION POST ASTUCE

$(function() {
  $(".astuceSubmit").click(function(e){
    var title = $('.astuceTitle').val();
    var content = $('.astuceContent').val();

    if(title == ''){
      swal('Vous devez choisir un titre à votre astuce!').then(function(){
        $('.astuceTitle').focus();
      });
      e.preventDefault();
    }

    if(content == ''){
      swal('Vous devez remplir une astuce pour pouvoir la publier!').then(function(){
        $('.astuceContent').focus();
      });  
      e.preventDefault(); 
    }
    
  });
});

// VERIFICATION FORM INSCRIPTION

$(function(){
  
  $('#inscription').click(function(e){
    var empty = new RegExp(/\s|^$/);
    var pseudo = $('#pseudo').val();
    var mail1 = $('#mailInsc').val();
    var mail2 = $('#mailInsc2').val();
    var mdp = $('#mdpInsc').val();

    if(empty.test(mail1)){
      swal('Votre mail est obligatoire.').then(function(){
        $('#mailInsc').focus();
      });
      e.preventDefault();
    }

    else if(pseudo == ''){
      swal('Vous devez choisir un pseudo').then(function(){
        $('#pseudo').focus();
      }); 
      e.preventDefault();
    }

    else if(empty.test(mail2)){
      swal('Vous devez confirmer votre mail').then(function(){
        $('#mailInsc2').focus();
      });
      e.preventDefault();
    }

    else if(mail1 != mail2){
      swal('Vos mail ne sont pas identiques');
      e.preventDefault();
    }

    else if(empty.test(mdp)){
      swal('Vous devez choisir un mot de passe').then(function(){
        $('#mdpInsc').focus();
      });
      e.preventDefault();
    }

  });
});

// VERIFICATION FORM CONNECTION

$(function(){
  
  $('#connection').click(function(e){
    var empty = new RegExp(/\s|^$/);
    var mailConnect = $('#mailConnection').val();
    var mdpConnect = $('#mdpConnection').val();

    if(empty.test(mailConnect)){
      swal('Votre mail est obligatoire').then(function(){
        $('#mailConnection').focus();
      });
      e.preventDefault();
    }

    else if(empty.test(mdpConnect)){
      swal('Votre mot de passe est obligatoire').then(function(){
        $('#mdpConnection').focus();
      });  
      e.preventDefault();
    };
  });
});

// VERIFICATION POST TUTO

$(function(){
  
  $('#tutoPublish').click(function(e){
    var title = $('#title').val();
    var description = $('#prez').val();
    var content = $('#texte').val();

    if(title == ''){
      swal('Vous devez saisir un titre à votre tuto.').then(function(){
        $('#title').focus();
      });
      e.preventDefault();
    }

    else if(description == ''){
      swal('Vous devez saisir une déscription à votre tuto.').then(function(){
        $('#prez').focus();
      });
      e.preventDefault();
    }

    else if(content == ''){
      swal('Vous n\'avez pas écris de tuto.').then(function(){
        $('#texte').focus();
      });
      e.preventDefault();
    }

  });
})



// AJAX TCHAT
let url = 'index.php?action=refresh';

  
  function messageChat(){
    
    setTimeout(function(){
      if(document.querySelector('.chat-content')){
        ajaxGet(url,function(response){
          let div = document.querySelector('.chat-content');
          div.innerHTML = response;
      });
      }
       
      
      messageChat();
    }, 500)
    
  };

  messageChat();


  // TOOLTIPS 
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })



      

  
 
    
