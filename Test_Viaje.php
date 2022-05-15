<?php
include_once 'Viaje.php';
include_once "Pasajero.php";
include_once "ResponsableV.php";
include_once "ViajeTerrestre.php";
include_once "ViajeAereo.php";

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
        1) Vender un pasaje
        2) Agregar múltiples pasajeros
        3) Modificar pasajero
        4) Eliminar pasajero
        5) Agregar/ modificar datos del responsable
        6) Ver información del viaje
        7) Modificar datos de viaje
        8) Ver información de un pasajero
        9) Salir
        >>>>>>>>>";
    $respuesta = rango(1, 9);
    return $respuesta;
}


// PROGRAMA principal

// Se inicializan las variables que serán los atributos del objeto
$arrayPasajeros = [];
$codigoDeViaje = "";
$destino = "";
$cantidadMaxPasajeros = "";

// Precarga de datos
echo "Tipo de viaje (terrestre/aereo): ";
$tipoViaje = trim(fgets(STDIN));

echo "¿Desea usar datos precargados? (s/n): ";
$respuestaPrecarga = trim(fgets(STDIN));

if($respuestaPrecarga == "s"){
    $codigoDeViaje = "00001-00001";
    $destino = "Neuquén";
    $cantidadMaxPasajeros = 10;
    $arrayPasajeros = precargaPasajeros();
    $responsable = new ResponsableV(1, 75384628, "Pedro", "Sanchez");
    $importe = 10000;
    $idaYVuelta = true;

    if($tipoViaje == "terrestre"){
        $comodidad = "cama";
    }else{
        $numVuelo = "AR8435";
        $categoriaAsiento = "primera clase";
        $nomAerolinea = "Aerolineas Argentinas";
        $cantEscalas = 0;
    }
} else{
    echo "Ingrese el código de viaje: ";
    $codigoDeViaje = trim(fgets(STDIN));
    echo "Ingrese el destino: ";
    $destino = trim(fgets(STDIN));
    echo "Ingrese la cantidad máxima de pasajeros: ";
    $cantidadMaxPasajeros = trim(fgets(STDIN));
    echo "Ingrese el importe del viaje: ";
    $importe = trim(fgets(STDIN));
    
    // Verificación para prevenir errores a la hora de vender un pasaje
    if(!is_numeric($importe)){
        $importe = 0;
    }

    echo "¿Ida y vuelta? (s/n): ";
    $idaYVuelta = trim(fgets(STDIN));
    $idaYVuelta = $idaYVuelta == "s";

    if($tipoViaje == "terrestre"){
        echo "Tipo de asientos del viaje (cama/semi-cama): ";
        $comodidad = trim(fgets(STDIN));
    }else{
        echo "Número de vuelo: ";
        $numVuelo = trim(fgets(STDIN));
        echo "Categoría del asiento (primera clase/economica): ";
        $categoriaAsiento = trim(fgets(STDIN));
        echo "Nombre de la aerolínea: ";
        $nomAerolinea = trim(fgets(STDIN));
        echo "Cantidad de escalas: ";
        $cantEscalas = trim(fgets(STDIN));
    }
    $responsable = new ResponsableV(0,0,"","");
}

// Se crean los objetos
if($tipoViaje == "terrestre"){
    $objViaje = new ViajeTerrestre($codigoDeViaje, $destino, $responsable,$cantidadMaxPasajeros,
    $arrayPasajeros, $importe, $idaYVuelta, $comodidad);
}else{
    $objViaje = new ViajeAereo($codigoDeViaje, $destino, $responsable, $cantidadMaxPasajeros,
    $arrayPasajeros, $importe, $idaYVuelta, $numVuelo, $categoriaAsiento, $nomAerolinea, $cantEscalas);
}

// Se ejecuta el menú que permite modificar cada atributo del objeto
do{
    $respuestaMenu = menu();
    switch ($respuestaMenu) {
        case 1:
            echo "\n--------- Vender un pasaje ---------\n";
            if($objViaje->hayPasajeDisponible()){
                echo "Ingrese el número de documento del pasajero: ";
                $numDocPas = trim(fgets(STDIN));
                $indPsjExistente = $objViaje->buscarPasajero($numDocPas);
                if(is_null($indPsjExistente)){
                    echo "Ingrese el nombre del pasajero: ";
                    $nombrePas = trim(fgets(STDIN));
                    echo "Ingrese el apellido del pasajero: ";
                    $apellidoPas = trim(fgets(STDIN));
                    echo "Ingrese el número de teléfono del pasajero: ";
                    $telefonoPas = trim(fgets(STDIN));
                    $objPasajero = new Pasajero($nombrePas, $apellidoPas, $numDocPas, $telefonoPas);

                    // Sea clase terrestre o aéreo, el objeto responde al mismo método
                    $venta = $objViaje->venderPasaje($objPasajero);
                    echo "Importe a pagar: ". $venta;
                }else{
                    echo "ERROR: El pasajero ya fue previamente registrado.";
                }
            }else{
                echo "ERROR: No hay asientos disponibles";
            }
            
            break;
        case 2:
            echo "\n--------- Agregar múltiples pasajeros ---------\n";
            if($objViaje->hayPasajeDisponible()){
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
                        $objViaje->agregarPasajero($objPasajero);
                        $psjCreados++;
                    } else{
                        // Si ya existe, se muestra msj de error y se continua con el siguiente
                        echo "Este pasajero ya está registrado. Se procederá con el siguiente.\n";
                    }          
                }
                // Dependiendo de cuántos ingresó. Se muestra un mensaje u otro.
                if($psjCreados == 0){
                    echo "No se ingresó ningún pasajero.";
                } else{
                    echo "Se ingresaron ". $psjCreados . " pasajeros con éxito.";
                }
            }else{
                echo "ERROR: No hay pasajes disponibles.";
            }
            break;
        case 3:
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
                echo "Ingrese el nuevo número de documento del pasajero (ó * para dejarlo igual): ";
                $numDocPsj = trim(fgets(STDIN));
                $objViaje->modificarPasajero($indPasajero, $nombrePsj, $apellidoPsj, $numDocPsj, $telefonoPsj);
                echo "El pasajero fue modificado con éxito.";
            }else{
                echo "Error: El pasajero no fue encontrado.";
            }
            
            break;
        case 4:
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
        case 5:
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
        case 6:
            echo "--- Ver información del viaje ---";
            echo $objViaje;
            break;
        case 7:
            echo "--- Modificar datos del viaje ---\n";
            echo "Ingrese el código de viaje (* para dejarlo igual): ";
            $codigoDeViaje = trim(fgets(STDIN));
            echo "Ingrese el destino (* para dejarlo igual): ";
            $destino = trim(fgets(STDIN));
            echo "Ingrese la cantidad máxima de pasajeros (* para dejarlo igual): ";
            $cantidadMaxPasajeros = trim(fgets(STDIN));
            echo "Ingrese el importe del viaje (ó * para dejarlo igual): ";
            $importe = trim(fgets(STDIN));
            echo "¿Ida y vuelta? (s/n): ";
            $idaYVuelta = trim(fgets(STDIN));
            if($idaYVuelta != "*"){
                $objViaje->setIdaYVuelta($idaYVuelta == "s");
            }
            if($tipoViaje == "terrestre"){
                echo "Tipo de asientos del viaje (cama/semi-cama/* para dejarlo igual): ";
                $comodidad = trim(fgets(STDIN));
            }else{
                echo "Número de vuelo (ó * para dejarlo igual): ";
                $numVuelo = trim(fgets(STDIN));
                echo "Categoría del asiento (primera clase/economica/* para dejarlo igual): ";
                $categoriaAsiento = trim(fgets(STDIN));
                echo "Nombre de la aerolínea (* para dejarlo igual): ";
                $nomAerolinea = trim(fgets(STDIN));
                echo "Cantidad de escalas (* para dejarlo igual): ";
                $cantEscalas = trim(fgets(STDIN));
            }

            // Da error si se redefine el método cargarDatos de la clase Viaje con más parámetros
            // Por lo que optó por crear métodos distintos para cada clase hija
            if($tipoViaje == "terrestre"){
                $objViaje->cargarDatosT($codigoDeViaje, $destino, $cantidadMaxPasajeros, $importe, $comodidad);
            }else{
                $objViaje->cargarDatosA($codigoDeViaje, $destino, $cantidadMaxPasajeros, $importe, $numVuelo,
                $categoriaAsiento, $nomAerolinea, $cantEscalas);
            }
            break;
        case 8:
            echo "---- Mostrar información de un pasajero ----\n";
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
}while($respuestaMenu != 9);
?>