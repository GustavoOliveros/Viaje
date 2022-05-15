<?php

class ViajeAereo extends Viaje{
    private $numVuelo;
    private $categoriaAsiento;
    private $nomAerolinea;
    private $cantEscalas;

    /**
     * Método constructor
     * @param string $codViaje
     * @param string $destino
     * @param object $responsable
     * @param integer $cantMaxPasajeros
     * @param array $pasajeros arreglo indexado cuyos valores son objetos
     * @param float $importe
     * @param boolean $idaYVuelta
     * @param string $numVuelo
     * @param string $categoriaAsiento (primera clase/clase economica)
     * @param string $nomAerolinea
     * @param int $cantEscalas
     */
    public function __construct($codViaje, $destino, $responsable, $cantMaxPasajeros, $pasajeros, $importe, $idaYVuelta, $numVuelo, $categoriaAsiento, $nomAerolinea, $cantEscalas)
    {
        parent::__construct($codViaje, $destino, $responsable, $cantMaxPasajeros, $pasajeros, $importe, $idaYVuelta);
        $this->categoriaAsiento = $categoriaAsiento;
        $this->numVuelo = $numVuelo;
        $this->nomAerolinea = $nomAerolinea;
        $this->cantEscalas = $cantEscalas;
    }

    // Métodos set y get


    public function getNumVuelo()
    {
        return $this->numVuelo;
    }
    public function setNumVuelo($numVuelo)
    {
        $this->numVuelo = $numVuelo;
    }
    public function getCategoriaAsiento()
    {
        return $this->categoriaAsiento;
    }
    public function setCategoriaAsiento($categoriaAsiento)
    {
        $this->categoriaAsiento = $categoriaAsiento;
    }
    public function getNomAerolinea()
    {
        return $this->nomAerolinea;
    }
    public function setNomAerolinea($nomAerolinea)
    {
        $this->nomAerolinea = $nomAerolinea;
    }
    public function getCantEscalas()
    {
        return $this->cantEscalas;
    } 
    public function setCantEscalas($cantEscalas)
    {
        $this->cantEscalas = $cantEscalas;
    }

    // Métodos varios

    /**
     * Cargar nuevos datos de viaje 
     * @param string $codViaje "*" deja el dato igual
     * @param string $destino "*" deja el dato igual
     * @param integer $cantMaximaPasajeros "*" deja el dato igual
     * @param float $importe "*" deja el dato igual
     * @param boolean $idaYVuelta "*" deja el dato igual
     * @param string $numVuelo
     * @param string $categoriaAsiento (primera clase/clase economica)
     * @param string $nomAerolinea
     * @param int $cantEscalas
     */
    public function cargarDatosA($codigoViaje, $destino, $cantidadMaximaPasajeros, $importe, $numVuelo, $categoriaAsiento, $nomAerolinea, $cantEscalas){
        parent::cargarDatos($codigoViaje, $destino, $cantidadMaximaPasajeros, $importe);
        if($numVuelo != "*"){
            $this->setNumVuelo($numVuelo);
        }
        if($categoriaAsiento != "*"){
            $this->setCategoriaAsiento($categoriaAsiento);
        }
        if($nomAerolinea != "*"){
            $this->setNomAerolinea($nomAerolinea);
        }
        if($cantEscalas != "*"){
            $this->setCantEscalas($cantEscalas);
        }
    }

    /**
     * Vende un pasaje
     * @param object $pasajero
     * @return float|null el importe del pasaje o null si no se concretó
     */
    public function venderPasaje($pasajero){
        $importePasaje = parent::venderPasaje($pasajero);

        if(!is_null($importePasaje)){
            if($this->getCategoriaAsiento() == "primera clase" && $this->getCantEscalas() == 0){
                $importePasaje = $importePasaje * 1.40;
            }
            if($this->getCategoriaAsiento() == "primera clase" && $this->getCantEscalas() > 0){
                $importePasaje = $importePasaje * 1.60;
            }
            if(parent::getIdaYVuelta()){
                $importePasaje = $importePasaje * 1.50;
            }
            $resultado = $importePasaje;
        }else{
            $resultado = null;
        }

        return $resultado;
    }

    // Método toString

    /**
     * Método toString
     * @return string
     */
    public function __toString()
    {
        return parent::__toString() .
        "\n---- Datos de viaje aéreo ----".
        "\nNúmero de vuelo: " . $this->getNumVuelo() .
        "\nCategoría de asiento: " . $this->getCategoriaAsiento() .
        "\nAerolínea: " . $this->getNomAerolinea() .
        "\nCantidad de escalas: " . $this->getCantEscalas();
    }
}







?>
