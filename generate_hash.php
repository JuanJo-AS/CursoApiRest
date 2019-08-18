<?php 

$time = time();

echo "Time: $time".PHP_EOL."HASH: ".sha1($argv[1].$time."Sh!! No se lo cuentes a nadie!").PHP_EOL;

/*
$ curl http://localhost:8000/books -H "X-HASH: 388852197ba6db765be131893943c7525759646f" -H "X-UID: 1" -H "X-TIMESTAMP: 1565647196"

$ curl http://localhost:8000/books 
-H "X-HASH: 388852197ba6db765be131893943c7525759646f" 
-H "X-UID: 1" 
-H "X-TIMESTAMP: 1565647196"
*/

?>