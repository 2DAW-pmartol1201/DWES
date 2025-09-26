<?php

/* Inicialización del entorno */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Zona de declaración de funciones */
//Funciones de debugueo
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

//Función lógica presentación
function getTableroMArkup ($tablero, $batman){
    $contador = 0;
    $output = '';
    //dump($tablero);


    foreach ($tablero as $filaIndex => $datosFila) {
        foreach ($datosFila as $columnaIndex => $tileType) {
            //dump($tileType);
            $contador++;
         
                if($contador == $batman){
                    $output .= '<div class = "tile ' . $tileType . '">';
                    if(isset($batman)){
                    $output .= pintarBatman();
                    }
                    $output .= '</div>';
                }else{
                    $output .= '<div class = "tile ' . $tileType . '"></div>';
                }
            
        }
    }

    return $output;

}
//Lógica de negocio
//El tablero es un array bidimensional en el que cada fila contiene 12 palabras cuyos valores pueden ser:
// agua
//fuego
//tierra
// hierba
function leerArchivoCSV($archivoCSV) {
    $tablero = [];

    if (($puntero = fopen($archivoCSV, "r")) !== FALSE) {
        while (($datosFila = fgetcsv($puntero)) !== FALSE) {
            $tablero[] = $datosFila;
        }
        fclose($puntero);
    }

    return $tablero;
}

$tablero = leerArchivoCSV('contenido_tablero/contenido.csv');

$batman = null;

function pintarBatman(){
    return '<img src="batman2.png">';
}

if (isset($_GET['fila']) && isset($_GET['columna']) && $_GET['fila'] > 0 && $_GET['fila'] <= 12 && $_GET['columna'] > 0 && $_GET['columna'] <= 12) {

$fila=$_GET['fila'];

$columna=$_GET['columna'];
$batman = (($fila*12-12)+ $columna);
}



//Lógica de presentación
$tableroMarkup = getTableroMArkup($tablero, $batman);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .contenedorTablero {
            width: 600px;
            height: 600px;
            border-radius: 5px;
            border: solid 2px grey;
            box-shadow: grey;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(12, 1fr);
        }
        .tile {
            width: 50px;
            height: 50px;
            float: left;
            margin: 0;
            padding: 0;
            border-width: 0;
            background-size: 209px;
            background-image: url('464.jpg');

        }
        .fuego {
            background-position: 104px -52px;
        }
        .tierra {
            background-position: 104px -156px;
        }
        .agua {
            background-position: -52px 0px;
        }
        .hierba {
            background-position: -52px 52px;
        }
        img {
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>
    <h1>Tablero juego super rol DWES</h1>
    <div class="contenedorTablero">
        <?php echo $tableroMarkup; ?>
  
    </div>

 
</body>
</html>