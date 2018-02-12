<?php

require("Contenido.class.php");
require("Attachments.class.php");


$contenido = new Contenido();

$attach = new Attachments();

/*** OBTENIENDO LOS ARCHIVOS ADJUNTOS CSV ***/

$attachments = $attach->getAttachment();

/***** MOSTRAR CONTENIDO DE LOS ARCHIVOS ADJUNTOS *****/

$contenido->parseAttachment($attachments);

/*** CERRANDO CONEXIÓN IMAP UNA VEZ MOSTRADO EL CONTENIDO ***/

$contenido->destroyImap();

?>