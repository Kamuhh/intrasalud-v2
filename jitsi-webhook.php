<?php
// jitsi-webhook.php
// Este archivo recibirá los datos enviados por Jitsi y los registrará para pruebas

file_put_contents('jitsi_log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

http_response_code(200);
echo 'OK';
