
<?php //Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<script src="https://cdn.firebase.com/v0/firebase.js"></script>
<script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<!-- Download from https://github.com/firebase/Firechat -->
<link rel="stylesheet" href="/crmmt/lib/firechat/firechat-default.css" />
<script src="/crmmt/lib/firechat/firechat-default.js"></script>
<style>
    #firechat-wrapper {
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
    }
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

<div id="firechat-responder"></div>
<button id="limpiarFirebase" class="btn btn-primary">Terminar</button>
<script type='text/javascript'>
    var sesion = <?php echo  CJSON::encode($model).';'; ?>
    var url_firebase = 'https://chatejemplo.firebaseio.com';

    function guardarMensaje(username, mensaje){
        var peticion = $.ajax({
                url: "<?php echo Yii::app()->createUrl('sesionchat/guardarMensaje'); ?>",
                type: 'POST',
                data: { 
                  id: sesion.id,
                  nombre_usuario: username,
                  mensaje: mensaje,
                  //fecha: 
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

    
    var conexion_firebase = new Firebase(url_firebase);
    var chat_ui           = new FirechatUI(conexion_firebase, document.getElementById("firechat-responder"));
    
    var autenticacion_simple = new FirebaseSimpleLogin(conexion_firebase, 
        function(err, usuario) {
            if (usuario) {
                //chat_ui._chat.userIsModerator();
                chat_ui.setUser(usuario.id, "<?php echo $nombre; ?>");
                setTimeout(function() {
                    chat_ui._chat.enterRoom(sesion.id_room);
                }, 1000);
            } else {
                autenticacion_simple.login('anonymous');    
            }
    });

    chat_ui._chat.on('message-add', 
        function(sala_id, msg){
            if(sesion.id_room){
                $("#firechat-messages"+sesion.id_room).scrollTop($("#firechat-messages"+sesion.id_room)[0].scrollHeight);
            }      
        }
    );


    function removerDatos(e){
        console.log('clic');
        if(sesion.id_room){
            var conexion_firebase = new Firebase(url_firebase);
            var firebase          = new Firechat(conexion_firebase);
            firebase.getUsersByRoom(sesion.id_room, null, 
                function(resultados){
                    var usu_firebase       = new Firebase(url_firebase + '/users/' + sesion.id_user);
                    var mensaje_firebase   = new Firebase(url_firebase + '/room-messages/' + sesion.id_room);
                    var room_meta_firebase = new Firebase(url_firebase + '/room-metadata/' + sesion.id_room);
                    var usuarios           = $.map(resultados, function (value, key) { return value; });
                    usuarios.forEach(function(usuario){
                        var usu_firebase = new Firebase(url_firebase + '/users/' + usuario.id);
                        usu_firebase.remove();
                    });
                    
                    mensaje_firebase.remove();
                    room_meta_firebase.remove();
                    usu_firebase.remove();

                });    
        }
    }

    $('#limpiarFirebase').on('click', removerDatos);

  </script>
