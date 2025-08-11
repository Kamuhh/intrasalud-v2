<?php
/*
Plugin Name: Zoom Deauth Handler
Description: Maneja la notificación de desautorización de la app de Zoom.
Version: 1.0
Author: Intrasalud
*/

add_action('rest_api_init', function () {
    register_rest_route('intrasalud/v1', '/zoom/uninstalled', [
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) {
            return new WP_REST_Response(['status' => 'Zoom app uninstalled'], 200);
        },
        'permission_callback' => '__return_true'
    ]);
});
