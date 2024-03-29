<?php 

/*Autenticacion TOKEN
    // curl http://localhost:8000/books -H "X-Token:414a94af9a0c77518c35a9fad072f6de5e8db0" 
    if ( !array_key_exists( "HTTP_X_TOKEN", $_SERVER ) ){
        die;
    }

    $url = "http://localhost:8001";

    $ch = curl_init( $url );
    curl_setopt( 
        $ch,
        CURLOPT_HTTPHEADER,
        [
            "X-Token: {$_SERVER['HTTP_X_TOKEN']}"
        ]
        );
    curl_setopt(
        $ch,
        CURLOPT_RETURNTRANSFER,
        true
    );

    $ret = curl_exec( $ch );

    echo $ret;

    if( $ret !== "true"){
        die;
    }
*/
/*Autenticacion HMAC
    //Comprobamos que nos llegan los parametros necesarios para realizar la
    //autenticacion
    if( 
        !array_key_exists("HTTP_X_HASH", $_SERVER) ||
        !array_key_exists("HTTP_X_TIMESTAMP", $_SERVER) ||
        !array_key_exists("HTTP_X_UID", $_SERVER) 
    ) {
        die;
    }

    //asignamos las tres variables en una misma sentencia
    list( $hash, $uid, $timestamp ) = [
        $_SERVER["HTTP_X_HASH"],
        $_SERVER["HTTP_X_UID"],
        $_SERVER["HTTP_X_TIMESTAMP"],
    ];

    $secret = "Sh!! No se lo cuentes a nadie!";

    $newHash = sha1($uid.$timestamp.$secret);

    if( $newHash !== $hash) {
        die;
    }
*/
/*Autenticacion HTTP
    Autenticacion HTTP
    $user = array_key_exist( "PHP_AUTH_USER", $_SERVER ) ? $_SERVER["PHP_AUTH_USER"] : "";

    $pwd = array_key_exist( "PHP_AUTH_PW", $_SERVER ) ? $_SERVER["PHP_AUTH_PW"] : "";

    if ( $user !== "juanjo" || $pwd != "1234" ){
        die;
    }

    $ curl http://juanjo:1234@localhost:8000/books

*/
//Definimos los recursos disponibles
$allowedResourcesTypes = [
    "books",
    "authors",
    "generes",
];

//Validamos que el recurso este disponible
$resourceType = $_GET["resource_type"];

if(!in_array($resourceType, $allowedResourcesTypes)){
    http_response_code( 400 );
    die;
}
//Defino los recursos

$books = [
    1=>[
        "titulo" => "Lo que el viento se llevo",
        "id_autor" => 1,
        "id_genero" => 2,
    ],
    2=>[
        "titulo" => "La Iliada",
        "id_autor" => 2,
        "id_genero" => 2
    ],
    3=>[
        "titulo" => "La Odisea",
        "id_autor" => 3,
        "id_genero" => 2,
    ]
];

header("Content-Type: application/json");

// Comprobamos el id de el recurso buscado
$resourceId = array_key_exists("resource_id", $_GET) ? $_GET["resource_id"] : "";
//echo $resourceId;
//Genereamos la respuesta asumiendo que el pedido es correcto
switch(strtoupper($_SERVER["REQUEST_METHOD"])){
    case "GET":
        if( empty($resourceId )){
            echo json_encode($books);
        }else {
            if( array_key_exists($resourceId, $books )){
                echo json_encode($books[$resourceId]);
            } else {
                http_response_code( 404 );
            }
        }
        
        break;
    case "POST":
        //Tomamos la entrada "cruda"
        $json = file_get_contents("php://input");

        $books[] = json_decode( $json, true );

        //echo array_keys( $books )[ count($books) - 1];

        echo json_encode( $books );
        break;
    case "PUT":
        //Validamos que el recurso buscado exista
        if ( !empty($resourceId) && array_key_exists( $resourceId, $books) ){
            $json = file_get_contents( 'php://input' );


            $books[ $resourceId ] = json_decode( $json, true);

            //Retornamos la coleccion modificada en formato json
            echo json_encode( $books );
        }
        break;
    case "DELETE":
        //Validamos que el recurso exista
        if ( !empty($resourceId) && array_key_exists( $resourceId, $books) ){
            
            //Eliminamos el recurso
            unset( $books[ $resourceId ] );

            //Retornamos la coleccion modificada en formato json
            echo json_encode( $books );
        }
        break;
}
?>