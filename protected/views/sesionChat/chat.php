
  <?php //Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
  <script src="https://cdn.firebase.com/v0/firebase.js"></script>
  <script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
  <!-- Download from https://github.com/firebase/Firechat -->
  <link rel="stylesheet" href="/crmmt/lib/firechat/firechat-default.min.css" />
  <script src="/crmmt/lib/firechat/firechat-default.js"></script>
  <style>
    /*#firechat-wrapper {
      height: 475px;
      max-width: 325px;
      padding: 10px;
      border: 1px solid #ccc;
      background-color: #fff;
      margin: 50px auto;
      text-align: center;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      -webkit-box-shadow: 0 5px 25px #666;
      -moz-box-shadow: 0 5px 25px #666;
      box-shadow: 0 5px 25px #666;
    }*/
  </style>


<!--
  Example: Anonymous Authentication

  This example uses Firebase Simple Login to create 'anonymous' usuario sessions in Firebase,
  meaning that usuario credentials are not required, though a usuario has a valid Firebase
  authentication token and security rules still apply.

  Requirements: in order to use this example with your own Firebase, you'll need to do the following:
    1. Apply the security rules at https://github.com/firebase/firechat/blob/master/rules.json
    2. Enable the 'Anonymous' authentication provider in Forge
    3. Update the URL below to reference your Firebase
    4. Update the room id for auto-entry with a public room you have created
 -->
<!-- Firechat {_firebase: J, _user: Object, _userId: "-JETx_WA7hV1MeumC2fI", _userName: "hola", _isModerator: false…}
 23:125
["-JETxZf6x2zd_njJy3dx", "yeeeep"] 23:126
-->


<div id="chat" class="col-xs-offset-1 col-xs-11 col-sm-offset-2 col-sm-8 col-md-4">
    <div class="cabecera"><p>Chat<i id="desplegar" class="fa fa-plus-square white pull-right"></i></p></div>

    <div id="firechat-wrapper" ></div>
</div>
<script type='text/javascript'>
    var sesion = <?php echo  CJSON::encode($model).';'; ?>

    $('#desplegar').on('click', desplegar);

    function desplegar(e){
        console.log('ops');
        $('#firechat-wrapper').slideToggle('slow');
        $(e.target).toggleClass('fa-plus-square');
        $(e.target).toggleClass('fa-minus-square');
    }

    function guardarMensaje(username, mensaje){
        var peticion = $.ajax({
                url: "<?php echo Yii::app()->createUrl('sesionchat/guardarMensaje'); ?>",
                type: 'POST',
                data: { 
                    id: sesion.id,
                    nombre_usuario: username,
                    mensaje: mensaje
                },
                dataType: 'html'
        });
               
        peticion.done(function( msg ) {
            //console.log('exito '+msg);
        });
           
        peticion.fail(function( jqXHR, textStatus ) {
            //console.log('fallo '+textStatus);
        });
    }


    Firechat.prototype.sendMessage = (function(_super) {
        return function() {
            console.log(this);
            console.log(arguments);
            guardarMensaje(this._userName, arguments[1]);
            return _super.apply(this, arguments);
        };
    })(Firechat.prototype.sendMessage);


    var conexion_firebase = new Firebase('https://chatejemplo.firebaseio.com');
    var chat_ui           = new FirechatUI(conexion_firebase, document.getElementById('firechat-wrapper'));

    chat_ui._chat.on('message-add', 
        function(sala_id, msg){
            //console.log(msg);
            if(sesion.id_room){
                $("#firechat-messages"+sesion.id_room).scrollTop($("#firechat-messages"+sesion.id_room)[0].scrollHeight);
            }      
        }
    );



    // Primera vez que ingresa. No ha habido recargas a la página.
    if(!sesion.id_user && !sesion.id_room){
        chat_ui._chat.createRoom(
            'sala_'+sesion.id, 
            'private', 
            function(sala_id){
                var autenticacion_simple = new FirebaseSimpleLogin(conexion_firebase, 
                        function(err, usuario) {
                            if (usuario) {
                                setTimeout(function() {
                                    chat_ui.setUser(usuario.id, sesion.nombreusuario);
                                    setTimeout(function() {
                                        chat_ui._chat.enterRoom(sala_id);
                                        chat_ui._chat.resumeSession();
                                    }, 1000);  

                                    
                                    sesion.id_user = usuario.id;
                                    sesion.id_room = sala_id;
                                    
                                    var peticion = $.ajax({
                                            url: "<?php echo Yii::app()->createUrl('sesionchat/asignarsala'); ?>",
                                            type: 'POST',
                                            data: { 
                                              id: sesion.id,
                                              id_user: sesion.id_user,
                                              id_room: sesion.id_room
                                            },
                                            dataType: 'html'
                                    });
                                           
                                    peticion.done(function( msg ) {
                                        //console.log('exito '+msg);
                                    });
                                       
                                    peticion.fail(function( jqXHR, textStatus ) {
                                        //console.log('fallo '+textStatus);
                                    });
                                      
                              }, 2000);
                            } 
                            else {
                                autenticacion_simple.login('anonymous');    
                            }
                });
        });

    } else {
        chat_ui.setUser(sesion.id_user, sesion.nombreusuario);
        var autenticacion_simple = new FirebaseSimpleLogin(conexion_firebase, 
                function(err, usuario) {
                    if (usuario) {
                        setTimeout(function() {
                            chat_ui._chat.enterRoom(sesion.id_room);
                            setTimeout(function() {
                                $('#firechat-messages'+sesion.id_room).scrollTop($('#firechat-messages'+sesion.id_room)[0].scrollHeight);
                          }, 500);  
                        
                        }, 500);
                    } else {
                        autenticacion_simple.login('anonymous');    
                    }
            });
    }



    
  </script>
