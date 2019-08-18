<?php
$method = strtoupper( $_SERVER["REQUEST_METHOD"] );

//$token = sha1( "Esto es un secreto!!" );
$token = "414a94af9a0c77518c35a9fad072f6de5e8db0";

if ( $method === "POST") {
    if ( !array_key_exists( "HTTP_X_CLIENT_ID", $_SERVER ) || !array_key_exists( "HTTP_X_SECRET", $_SERVER)){
        http_response_code( 404 );

        die( "Faltan parametros");
    }

    $clientId = $_SERVER["HTTP_X_CLIENT_ID"];
    $secret = $_SERVER["HTTP_X_SECRET"];

    if ( $clientId !== "1" || $secret !== "SuperSecreto!" ){
        http_response_code( 403 );

        die ( "No autorizado" );
    }

    echo "$token";
} elseif ( $method === "GET") {
    if ( !array_key_exists( "HTTP_X_TOKEN", $_SERVER ) ){
        http_response_code( 400 );

        die ( "Faltan parametros " );
    }

    if ( $_SERVER["HTTP_X_TOKEN"] == $token ){
        echo "true";
    }else{
        echo "false";
    }

}else {
    echo "false";
}
?>