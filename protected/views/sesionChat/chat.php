<script type='text/javascript'>
    var sesion = <?php echo  CJSON::encode($model).';'; ?>

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
        });
           
        peticion.fail(function( jqXHR, textStatus ) {
        });
    }


    Firechat.prototype.sendMessage = (function(_super) {
        return function() {
            guardarMensaje(this._userName, arguments[1]);
            return _super.apply(this, arguments);
        };
    })(Firechat.prototype.sendMessage);

    (function(){
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
                                chat_ui.setUser(sesion.id_user, sesion.nombre_usuario);    
                                setTimeout(function() {
                                    chat_ui._chat.enterRoom(sesion.id_room);
                                    $('#firechat-messages'+sesion.id_room).scrollTop($('#firechat-messages'+sesion.id_room)[0].scrollHeight);
                              }, 500);  
                            
                            }, 500);
                        } else {
                            autenticacion_simple.login('anonymous');    
                        }
                });
       } 

    })();
    
</script>