
  <?php //Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
  <!--<script src="https://cdn.firebase.com/v0/firebase.js"></script>
  <script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script> -->
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
  <!-- Download from https://github.com/firebase/Firechat -->
  <!--<link rel="stylesheet" href="/crmmt/lib/firechat/firechat-default.css" />
  <script src="/crmmt/lib/firechat/firechat-default.js"></script> -->
  <style>
    /*#firechat-contenedor {
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


<!-- <div id="chat" class="col-xs-offset-1 col-xs-11 col-sm-offset-2 col-sm-8 col-md-4">
    <div class="cabecera">
        <p>Chat<i id="desplegar" class="fa fa-plus-square white pull-right"></i></p>
    </div>
    <div id="firechat-contenedor" ></div>
</div> -->

<script type='text/javascript'>
    var sesion = <?php echo  CJSON::encode($model).';'; ?>

    // $('#desplegar').on('click', desplegar);
    // $('.cabecera').on('click', desplegar);

    // function desplegar(e){
    //     console.log('ops');
    //     $('#firechat-contenedor').slideToggle('fast');
    //     var icono = $('#desplegar');
    //     icono.toggleClass('fa-plus-square');
    //     icono.toggleClass('fa-minus-square');
    // }

    function guardarMensaje(username, mensaje){
        var peticion = $.ajax({
                url: "<?php echo Yii::app()->createUrl('sesionchat/guardarMensaje'); ?>",
                type: 'POST',
                data: { 
                    id             : sesion.id,
                    nombre_usuario : username,
                    mensaje        : mensaje
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
          //  console.log(this);
          //  console.log(arguments);
            guardarMensaje(this._userName, arguments[1]);
            return _super.apply(this, arguments);
        };
    })(Firechat.prototype.sendMessage);

    //(function(){
        var conexion_firebase = new Firebase('https://chatejemplo.firebaseio.com');
            var chat_ui           = new FirechatUI(conexion_firebase, document.getElementById('firechat-contenedor'));
            

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
                                        chat_ui.setUser(usuario.id, sesion.nombre_usuario);
                                        setTimeout(function() {
                                            chat_ui._chat.enterRoom(sala_id);
                                        }, 500);  

                                         if(!sesion.id_room){
                                            sesion.id_user = usuario.id;
                                            sesion.id_room = sala_id;
                                        }
                                        var peticion = $.ajax({
                                                url: "<?php echo Yii::app()->createUrl('sesionchat/asignarsala'); ?>",
                                                type: 'POST',
                                                data: { 
                                                  id      : sesion.id,
                                                  id_user : sesion.id_user,
                                                  id_room : sesion.id_room
                                                },
                                                dataType: 'html'
                                        });
                                               
                                        peticion.done(function( msg ) {
                                            //console.log('exito '+msg);
                                        });
                                           
                                        peticion.fail(function( jqXHR, textStatus ) {
                                            //console.log('fallo '+textStatus);
                                        });
                                          
                                  }, 500);
                                } 
                                else {
                                    autenticacion_simple.login('anonymous');    
                                }
                    });
            });

        } else {
     
            var autenticacion_simple = new FirebaseSimpleLogin(conexion_firebase, 
                    function(err, usuario) {
                        if (usuario) {
                            setTimeout(function() {
                                chat_ui.setUser(usuario.id, sesion.nombre_usuario, 
                                    function(res){ 
                                        console.log(res);
                                        chat_ui._chat.enterRoom(sesion.id_room);
                                });       
                                setTimeout(function() {
                                    
                                    $('#firechat-messages'+sesion.id_room).scrollTop($('#firechat-messages'+sesion.id_room)[0].scrollHeight);
                              }, 2000);  
                            
                            }, 500);
                        } else {
                            autenticacion_simple.login('anonymous');    
                        }
                });
       } 

   // })();
    
</script>
