<script src="https://cdn.firebase.com/v0/firebase.js"></script>
<script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
<link rel="stylesheet" href="/crmmt/lib/firechat/firechat-default.css" />
<script src="/crmmt/lib/firechat/firechat-default.js"></script>
<script src="/crmmt/lib/jquery.cookie.js"></script>

<div class="col-md-6">
    <div class="row">
        <strong>Usuario del chat: </strong><div class="pull-right"><?php echo $model->nombre_usuario ?></div>
    </div>
    <div class="row">
        <strong>Correo: </strong><div class="pull-right"><?php echo $model->correo ?></div>
    </div>
    <div class="row" style="margin-top: 1em">
            <div id="firechat-responder"></div>
    </div>
    <div class="row">
        <!-- <div class="col-md-4"> -->
            <?php echo CHtml::button('Terminar sesión', array('id' => 'limpiar-firebase','class' => 'btn btn-primary btn-block')); ?>
        <!-- </div> -->
    </div>
</div>

<script type='text/javascript'>
    var sesion = <?php echo  CJSON::encode($model).';'; ?>
    var url_firebase = 'https://chatejemplo.firebaseio.com';

    function borrarCookie( name ) {
        $.cookie(name, null, { path: '/' });
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
        });
           
        peticion.fail(function( jqXHR, textStatus ) {
        });
    }

    function terminarSesion(){
        if(sesion.id_room){
            var peticion = $.ajax({
                    url: "<?php echo Yii::app()->createUrl('sesionchat/terminarsesion'); ?>",
                    type: 'GET',
                    data: { 
                      id: sesion.id,
                    },
                    dataType: 'html'
            });
                   
            peticion.done(function( msg ) {
                window.location.replace('<?php echo Yii::app()->createUrl("sesionchat/admin"); ?>');
            });
               
            peticion.fail(function( jqXHR, textStatus ) {
            });
        }
    }

    Firechat.prototype.sendMessage = (function(_super) {
        return function() {
            console.log(this);
            console.log(arguments);
            guardarMensaje(this._userName, arguments[1]);
            return _super.apply(this, arguments);
        };
    })(Firechat.prototype.sendMessage);

    borrarCookie('firebaseSessionKey');
    var conexion_firebase = new Firebase(url_firebase);
    var chat_ui           = new FirechatUI(conexion_firebase, document.getElementById("firechat-responder"));
    
    var autenticacion_simple = new FirebaseSimpleLogin(conexion_firebase, 
        function(err, usuario) {
            if (usuario) {
                //chat_ui._chat.userIsModerator();
                chat_ui.setUser(usuario.id, "<?php echo 'AlmacenesMT ('.$nombre.')'; ?>");
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
            terminarSesion();    
        }
    }

    $('#limpiar-firebase').on('click', removerDatos);

</script>