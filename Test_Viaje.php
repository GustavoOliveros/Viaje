<?php

include 'Viaje.php';
include "Pasajero.php";
include "ResponsableV.php";

// Funciones

/**
 * Precarga datos de viaje
 * @return array
 */
function precargaPasajeros(){
    $arrayPsj[0] = new Pasajero("Juan", "Gómez", 31142341, "299-2241252");
    $arrayPsj[1] = new Pasajero("Enrique", "Hernandez", 24512552, "299-2242452");
    $arrayPsj[2] = new Pasajero("Gus", "Fernandez", 42482967, "299-2241352");
    $arrayPsj[3] = new Pasajero("Patricio", "Estrada", 35243434, "299-6341252");
    $arrayPsj[4] = new Pasajero("Roberto", "Peña", 31231241, "299-2241672");
    return $arrayPsj;
}

/**
 * Pide un número y se asegura de que se encuentre en un rango. Retorna un número válido
 * @param int $numMenor
 * @param int $numMayor
 * @return int
 */
function rango($numMenor, $numMayor){
    $contador = 0;
    do{
        if($contador != 0){
            echo "Ingrese un número entre " . $numMenor . " y " . $numMayor . ": ";
        }
        $respuesta = trim(fgets(STDIN));
        $contador++;
    }while(!is_numeric($respuesta) || ($respuesta > $numMayor || $respuesta < $numMenor));
    return $respuesta;
}

/**
 * Genera el menú
 * @return int
 */
function menu(){
    echo
        "\n
        1) Cargar/agregar pasajeros
        2) Modificar pasajero
        3) Eliminar pasajero
        4) Cargar/agregar datos del responsable
        5) Ver datos de viaje
        6) Ver información de un pasajero
        7) Salir
        >>>>>>>>>";
    $respuesta = rango(1, 7);
    return $respuesta;
}


// PROGRAMA principal

// Se declaran las variables que serán los atributos del objeto
$arrayPasajeros = [];
$codigoDeViaje = "";
$destino = "";
$cantidadMaxPasajeros = "";

// Precarga de datos
echo "¿Desea usar datos precargados? (s/n): ";
$respuestaPrecarga = trim(fgets(STDIN));

if($respuestaPrecarga == "s"){
    $codigoDeViaje = "00001-00001";
    $destino = "Neuquén";
    $cantidadMaxPasajeros = 10;
    $arrayPasajeros = precargaPasajeros();
    $responsable = new ResponsableV(1, 75384628, "Pedro", "Sanchez");
} else{
    echo "Ingrese el código de viaje: ";
    $codigoDeViaje = trim(fgets(STDIN));
    echo "Ingrese el destino: ";
    $destino = trim(fgets(STDIN));
    echo "Ingrese la cantidad máxima de pasajeros: ";
    $cantidadMaxPasajeros = trim(fgets(STDIN));
    $arrayPasajeros = [];
    $responsable = new ResponsableV(0,0,"","");
}

// Se crean los objetos
$objViaje = new Viaje($codigoDeViaje, $destino, $responsable, $cantidadMaxPasajeros, $arrayPasajeros);

// Se ejecuta el menú que permite modificar cada atributo del objeto
do{
    $respuestaMenu = menu();
    switch ($respuestaMenu) {
        case 1:
            echo "\n--------- Cargar pasajero ---------\n";
            echo "¿Cuántos pasajeros desea ingresar?: ";
            $limitePasajeros = $objViaje->getCantMaxPasajeros() - count($objViaje->getPasajeros());
            $cantEntradaPasajeros = rango(0, $limitePasajeros);
            $psjCreados = 0;
            
            for($i = 0; $i < $cantEntradaPasajeros; $i++){
                echo "Ingrese el número de documento del pasajero " . $psjCreados + 1 . ": ";
                $numDocPas = trim(fgets(STDIN));
                // Se busca el pasajero
                $indPsjExistente = $objViaje->buscarPasajero($numDocPas);

                // Si no existe, se procede con la carga
                if(is_null($indPsjExistente)){
                    echo "Ingrese el nombre del pasajero " . $psjCreados + 1 . ": ";
                    $nombrePas = trim(fgets(STDIN));
                    echo "Ingrese el apellido del pasajero " . $psjCreados + 1 . ": ";
                    $apellidoPas = trim(fgets(STDIN));
                    echo "Ingrese el número de teléfono del pasajero " . $psjCreados + 1 . ": ";
                    $telefonoPas = trim(fgets(STDIN));
                    $objPasajero = new Pasajero($nombrePas, $apellidoPas, $numDocPas, $telefonoPas);
                    $arrayNuevoPasajeros[$psjCreados] = $objPasajero;
                    $psjCreados++;
                } else{
                    // Si ya existe, se muestra msj de error y se continua con el siguiente
                    echo "Este pasajero ya está registrado. Se procederá con el siguiente.\n";
                }          
            }
            if($psjCreados == 0){
                echo "No se ingresó ningún pasajero.";
            } else{
                $objViaje->agregarPasajeros($arrayNuevoPasajeros);
                echo "Se ingresaron ". $psjCreados . " pasajeros con éxito.";
            }
            break;
        case 2;
            echo "---- Modificar pasajero ----\n";
            echo "Ingrese el número de documento del pasajero a modificar: ";
            $numDocPsj = trim(fgets(STDIN));
            $indPasajero = $objViaje->buscarPasajero($numDocPsj);

            if(!is_null($indPasajero)){
                echo "Ingrese el nombre del pasajero (ó * para dejarlo igual): ";
                $nombrePsj = trim(fgets(STDIN));
                echo "Ingrese el apellido del pasajero (ó * para dejarlo igual): ";
                $apellidoPsj = trim(fgets(STDIN));
                echo "Ingrese el teléfono del pasajero (ó * para dejarlo igual): ";
                $telefonoPsj = trim(fgets(STDIN));
                $objViaje->modificarPasajero($indPasajero, $nombrePsj, $apellidoPsj, $numDocPsj, $telefonoPsj);
            }else{
                echo "Error: El pasajero no fue encontrado.";
            }
            
            break;
        case 3;
            echo "--- Eliminar pasajero ---\n";
            echo "Ingrese el número de documento del pasajero que desea eliminar: ";
            $numDocPsjAEliminar = trim(fgets(STDIN));
            $psjAEliminar = $objViaje->buscarPasajero($numDocPsjAEliminar);

            if(!is_null($psjAEliminar)){
                $objViaje->eliminarPasajero($psjAEliminar);
                echo "Pasajero eliminado exitosamente.";
            } else{
                echo "Error: el pasajero no fue encontrado.";
            }
            
            break;
        case 4;
            echo "\n--------- Cargar/ modificar datos del responsable ---------\n";
            $objResponsable = $objViaje->getResponsable();

            echo "Ingrese el nombre del responsable (ó * para dejar igual): ";
            $nomResponsable = trim(fgets(STDIN));

            if($nomResponsable != "*"){
                $objResponsable->setNombre($nomResponsable);
            }
            
            echo "Ingrese el apellido del responsable (ó * para dejar igual): ";
            $apellidoResponsable = trim(fgets(STDIN));

            if($apellidoResponsable != "*"){
                $objResponsable->setApellido($apellidoResponsable);
            } 

            echo "Ingrese el número de empleado del responsable (ó * para dejar igual): ";
            $numEmpleadoResponsable = trim(fgets(STDIN));

            if($numEmpleadoResponsable != "*"){
                $objResponsable->setNumEmpleado($numEmpleadoResponsable);
            } 

            echo "Ingrese el número de licencia del responsable (ó * para dejar igual): ";
            $numLicenciaResponsable = trim(fgets(STDIN));

            if($numLicenciaResponsable != "*"){
                $objResponsable->setNumLicencia($numLicenciaResponsable);
            }

            echo "Se agregó con éxito.";
            $objViaje->setReponsable($objResponsable);
            break;
        case 5;
            echo "--- Ver información del viaje ---";
            echo $objViaje;
            break;
        case 6;
            echo "---- Mostrar pasajero ----\n";
            echo "Ingrese el número de documento del pasajero a mostrar: ";
            $numDocPsj = trim(fgets(STDIN));
            $indicePsj = $objViaje->buscarPasajero($numDocPsj);
            if(!is_null($indicePsj)){
                echo $objViaje->mostrarPasajero($indicePsj);
            }else{
                echo "Error: El pasajero no fue encontrado.";
            }
            break;
    }
}while($respuestaMenu != 7);
?>