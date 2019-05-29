/* ###############################################################################################
                            Execution Au début de la Page
##################################################################################################*/

$(function(){


    /* ------------------- Affichage de la sécurité des Mot de Passe saisis ---------------- */
    $('#pass').keyup(function(e) {
         var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
         var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
         var enoughRegex = new RegExp("(?=.{6,}).*", "g");
         if (false == enoughRegex.test($(this).val())) {
                 $('#passstrength').html('More Characters');
         } else if (strongRegex.test($(this).val())) {
                 $('#passstrength').removeClass( "yellow red" ).addClass( "green" );
                 $('#passstrength').html('Strong');
         } else if (mediumRegex.test($(this).val())) {
                 $('#passstrength').removeClass( "green red" ).addClass( "yellow" );
                 $('#passstrength').html('Medium');
         } else {
                 $('#passstrength').removeClass( "yellow green" ).addClass( "red" );
                 $('#passstrength').html('Weak');
         }
         return true;
    });


    // Application des écouteurs de click sur les liens du menu chargant dynamiquement les pages contenues via Fetch
    $('.dashboardlink').click( function(e) {
      e.preventDefault();
      
      loadpage('#dashboardContent', this.getAttribute('href'), null);
    });

    /* Application de l'écouteur des bouton de révélation des mots de passe */
    revealPasswd();

    hideAlert();

});


/* ###############################################################################################
                    Fonctions de  Chargement Via Fetch des pages contenues
##################################################################################################*/


/**
* Fonction de chargement d'une page de manière assynchrone avec Fetch.
* Les pages sont appelées depuis le sider statique
*
* @param name   : Identifiant de la balise HTML dans laquelle charger la page
* @param fname  : chemin de la page à charger
*/
async function loadpage(name, fname, data){

//Animation de chargement pendant le loading de la page
var loading = '<div id="floatingCirclesG">'+
                    '<div class="f_circleG" id="frotateG_01"></div>'+
                    '<div class="f_circleG" id="frotateG_02"></div>'+
                    '<div class="f_circleG" id="frotateG_03"></div>'+
                    '<div class="f_circleG" id="frotateG_04"></div>'+
                    '<div class="f_circleG" id="frotateG_05"></div>'+
                   ' <div class="f_circleG" id="frotateG_06"></div>'+
                    '<div class="f_circleG" id="frotateG_07"></div>'+
                    '<div class="f_circleG" id="frotateG_08"></div>'+
                '</div>';

$(name).html(loading);

// Récuperation et affichage du contenu avec application de la méthode POST avec le contenu de search
  if(data !== null){
    var str = await fetch(fname, {  
        method: "POST",  
        body: data,
        headers: { 'Content-type': 'application/x-www-form-urlencoded' } 
      });
    $(name).html(await str.text());
  }
  else{
    var str = await fetch(fname);
    $(name).html(await str.text());
  }

  loadModalTraitment(name);

  hideAlert();
}

/**
* Mise en place des écouteurs de fenêtres modal de traitement des informations des pages
*
*/
function loadModalTraitment(name){

    $('.modalAdder').click(async function(){

        // récupération des données de formulaire modal
        var params = getInputs();
        var str = await fetch($(this).attr('href'), {  
            method: "POST",  
            body: params,
            headers: { 'Content-type': 'application/x-www-form-urlencoded' } 
          });
        $($(this).attr('modale-name')).modal('hide');
        loadpage(name, $(this).attr('data-page'), null);
    });
}


/**
* Récupération des données de formulaires des fenêtres modale
* Utilisé lors d'appels fetch pour masquer l'action d'inscription en BDD
*/
function getInputs(){
    var params = '';
    var and = '';
    $('.data-input').each(function(){
        params += and +  $(this).attr('name') + '=' + $(this).val();
        and='&';
    });

    return params;
}


/* ###############################################################################################
                    Fonctions utilitaires
##################################################################################################*/

/**
* Ecouteurs des boutons d'affichage / masquage des mots de passe
* Au premier click, révélation du mdp et changement de l'icone du bouton
* Au second click, retours au mot de passe masqué 
*/
function revealPasswd(){

    $(".reveal").click(function() {
        var $pwd = $(".pwd" + $(this).attr('data-int'));
        if ($pwd.attr('type') === 'password') {
            $(this).children().removeClass('fa-eye').addClass('fa-eye-slash');
            $pwd.attr('type', 'text');
        } else {
            $(this).children().removeClass('fa-eye-slash').addClass('fa-eye');
            $pwd.attr('type', 'password');
        }
    });
}

/**
* Fermeture automatique des alertes après 4 secondes
*
*/
function hideAlert(){

      setTimeout(function(){
        $(".alert").remove(); 
      }, 4000);
}


