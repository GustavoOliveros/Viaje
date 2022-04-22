<?php

class Viaje{
    private $codViaje;
    private $destino;
    private $responsable;
    private $cantMaxPasajeros;
    private $pasajeros;

    /**
     * Método constructor
     * @param string $codViaje
     * @param string $destino
     * @param object $responsable
     * @param integer $cantMaxPasajeros
     * @param array $pasajeros arreglo indexado cuyos valores son objetos
     */
    public function __construct($codViaje, $destino, $responsable, $cantMaxPasajeros, $pasajeros)
    {
        $this->codViaje = $codViaje;
        $this->destino = $destino;
        $this->responsable = $responsable;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->pasajeros = $pasajeros;
    }

    // Métodos de acceso

    public function getCodViaje()
    {
        return $this->codViaje;
    }
    public function setCodViaje($nuevoCodViaje)
    {
        $this->codViaje = $nuevoCodViaje;
    }
    public function getDestino()
    {
        return $this->destino;
    }
    public function setDestino($nuevoDestino)
    {
        $this->destino = $nuevoDestino;
    }
    public function getCantMaxPasajeros()
    {
        return $this->cantMaxPasajeros;
    }
    public function setCantMaxPasajeros($nuevoCantMaxPasajeros)
    {
        $this->cantMaxPasajeros = $nuevoCantMaxPasajeros;
    }
    public function getPasajeros()
    {
        return $this->pasajeros;
    }
    public function setPasajeros($nuevoPasajeros)
    {
        $this->pasajeros = $nuevoPasajeros;
    }
    public function getResponsable()
    {
        return $this->responsable;
    }
    public function setReponsable($nuevoResponsable)
    {
        $this->responsable = $nuevoResponsable;
    }

    // Métodos varios

    /**
     * Cargar datos de viaje
     * @param string $codigoViaje
     * @param string $destino
     * @param int $cantidadMaximaPasajeros
     */
    public function cargarDatos($codigoViaje, $destino, $cantidadMaximaPasajeros){
        $this->setCodViaje($codigoViaje);
        $this->setDestino($destino);
        $this->setCantMaxPasajeros($cantidadMaximaPasajeros);
    }

    /**
     * Agrega uno o más pasajeros nuevos
     * @param array $pasajeroNuevo objeto o arreglo de objetos de la clase pasajero
     */
    public function agregarPasajeros($pasajeroNuevo){
        $arrayPasajeros = $this->getPasajeros();
        $indMaximo = count($pasajeroNuevo) - 1;
        for($i = 0; $i <= $indMaximo; $i++){
            array_push($arrayPasajeros, $pasajeroNuevo[$i]);
        }        
        $this->setPasajeros($arrayPasajeros);
    }

    /**
     * Busca un pasajero por número de documento
     * @param int $numDoc
     * @return int|null el índice del pasajero o null si no lo encuentra
     */
    public function buscarPasajero($numDoc){
        $arrayPasajeros = $this->getPasajeros();
        $contador = 0;
        
        // Para evitar error de clave indefenida a la hora de ingresar un pasajero
        // por primera vez. Se coloca que sólo haga la verificación de DNI si
        // existen pasajeros
        if(count($arrayPasajeros) > 0){
            do{
                $objPasajeros = $arrayPasajeros[$contador];
                $contador++;
            }while($contador < count($arrayPasajeros) && $objPasajeros->getNumDoc() != $numDoc);

            if($objPasajeros->getNumDoc() != $numDoc){
                return null;
            } else{
                return $contador - 1;
            }
        } else{
            return null;
        }  
    }

    /**
     * Modifica los datos de un pasajero. Se puede usar "*" para dejar algún dato igual
     * @param int $indicePasajero
     * @param string $nombre 
     * @param string $apellido
     * @param int $numDoc
     * @param string $telefono
     */
    public function modificarPasajero($indicePasajero, $nombre, $apellido, $numDoc, $telefono){
        $arrayPasajeros = $this->getPasajeros();
        $objPasajero = $arrayPasajeros[$indicePasajero];

        if($nombre != "*"){
            $objPasajero->setNombre($nombre);
        }
        if($apellido != "*"){
            $objPasajero->setApellido($apellido);
        }
        if($numDoc != "*"){
            $objPasajero->setNumDoc($numDoc);
        }
        if($telefono != "*"){
            $objPasajero->setTelefono($telefono);
        }

        $arrayPasajeros[$indicePasajero] = $objPasajero;
        $this->setPasajeros($arrayPasajeros);
    }

    /**
     * Elimina un pasajero
     * @param int $indicePasajero
     */
    public function eliminarPasajero($indicePasajero){
        $arrayPasajeros = $this->getPasajeros();
        array_splice($arrayPasajeros, $indicePasajero, 1);
        $this->setPasajeros($arrayPasajeros);
    }

    /**
     * Muestra un pasajero
     * @return string
     */
    public function mostrarPasajero($indicePasajero){
        $arrayPasajeros = $this->getPasajeros();
        $objPasajero = $arrayPasajeros[$indicePasajero];
        $stringPasajero = "\nPasajero número " . $indicePasajero .
        $objPasajero;

        return $stringPasajero;
    }

    /**
     * Retorna todos los pasajeros en un string
     * @return string
     */
    public function mostrarTodosPasajeros(){
        $pasajeros = $this->getPasajeros();
        $cantPasajeros = count($pasajeros);
        $coleccionString = "";

        for($i = 0; $i < $cantPasajeros; $i++){
            $coleccionString = $coleccionString . 
            "\n--------------------" .
            "\nPasajero número " . $i .
            $pasajeros[$i].
            "\n--------------------";
        }

        return $coleccionString;
    }

    // Método __toString

    public function __toString()
    {
        return
        "\nCódigo de viaje: " . $this->getCodViaje().
        "\nDestino: " . $this->getDestino(). "\n--------------------" .
        "\nResponsable:\n--------------------" . $this->getResponsable(). "\n--------------------" .
        "\nCantidad máxima de pasajeros: " . $this->getCantMaxPasajeros().
        "\nPasajeros: " . $this->mostrarTodosPasajeros().
        "\nCantidad de pasajeros: " . count($this->getPasajeros());
    }
}
?>