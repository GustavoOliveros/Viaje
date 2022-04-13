<?php

class Viaje{
    private $codViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $pasajeros;

    /**
     * Método constructor
     * @param string $codViaje
     * @param string $destino
     * @param integer $cantMaxPasajeros
     * @param array $pasajeros arreglo multidimensional (claves: nombre, apellido y numeroDoc)
     */
    public function __construct($codViaje, $destino, $cantMaxPasajeros, $pasajeros)
    {
        $this->codViaje = $codViaje;
        $this->destino = $destino;
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
     * @param array $pasajeroNuevo arreglo multidimensional (más de 1) ó asociativo (1)
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
     * Modifica los datos de un pasajero. Se puede usar "*" para dejar algún dato igual
     * @param int $indicePasajero
     * @param string $nombre 
     * @param string $apellido
     * @param int $numDoc
     */
    public function modificarPasajero($indicePasajero, $nombre, $apellido, $numDoc){
        $arrayPasajeros = $this->getPasajeros();

        if($nombre != "*"){
            $arrayPasajeros[$indicePasajero]["nombre"] = $nombre;
        }
        if($apellido != "*"){
            $arrayPasajeros[$indicePasajero]["apellido"] = $apellido;
        }
        if($numDoc != "*"){
            $arrayPasajeros[$indicePasajero]["numeroDoc"] = $numDoc;
        }

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
     */
    public function mostrarPasajero($indicePasajero){
        $arrayPasajeros = $this->getPasajeros();
        echo
        "\nPasajero número " . $indicePasajero .
        "\nNombre: " . $arrayPasajeros[$indicePasajero]["nombre"] .
        "\nApellido: " . $arrayPasajeros[$indicePasajero]["apellido"] .
        "\nNúmero de documento: " . $arrayPasajeros[$indicePasajero]["numeroDoc"];
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
            "\n--------------------\n" .
            "\nPasajero número " . $i .
            "\nNombre: " . $pasajeros[$i]["nombre"] .
            "\nApellido: " . $pasajeros[$i]["apellido"] .
            "\nNúmero de documento: " . $pasajeros[$i]["numeroDoc"] .
            "\n--------------------\n";
        }

        return $coleccionString;
    }

    // Método __toString

    public function __toString()
    {
        return
        "\nCódigo de viaje: " . $this->getCodViaje().
        "\nDestino: " . $this->getDestino().
        "\nPasajeros: " . $this->mostrarTodosPasajeros().
        "\nCantidad de pasajeros: " . count($this->getPasajeros());
    }
}
?>