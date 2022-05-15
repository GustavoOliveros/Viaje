<?php

class ViajeTerrestre extends Viaje{
    private $comodidadAsiento;
    
    /**
     * Método constructor
     * @param string $codViaje
     * @param string $destino
     * @param object $responsable
     * @param integer $cantMaxPasajeros
     * @param array $pasajeros arreglo indexado cuyos valores son objetos
     * @param float $importe
     * @param boolean $idaYVuelta
     * @param string $comodidadAsiento
     */
    public function __construct($codViaje, $destino, $responsable, $cantMaxPasajeros, $pasajeros, $importe, $idaYVuelta, $comodidadAsiento)
    {
        parent::__construct($codViaje, $destino, $responsable, $cantMaxPasajeros, $pasajeros, $importe, $idaYVuelta);
        $this->comodidadAsiento = $comodidadAsiento;
    }

    // Métodos de acceso

    public function getComodidadAsiento()
    {
        return $this->comodidadAsiento;
    }
    public function setComodidadAsiento($comodidadAsiento)
    {
        $this->comodidadAsiento = $comodidadAsiento;
    }

    // Métodos varios

    /**
     * Cargar nuevos datos de viaje 
     * @param string $codViaje "*" deja el dato igual
     * @param string $destino "*" deja el dato igual
     * @param integer $cantMaximaPasajeros "*" deja el dato igual
     * @param float $importe "*" deja el dato igual
     * @param boolean $idaYVuelta "*" deja el dato igual
     * @param string $comodidad "*" deja el dato igual
     */
    public function cargarDatosT($codigoViaje, $destino, $cantidadMaximaPasajeros, $importe, $comodidad){
        parent::cargarDatos($codigoViaje, $destino, $cantidadMaximaPasajeros, $importe);
        if($comodidad != "*"){
            $this->setComodidadAsiento($comodidad);
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
            if($this->getComodidadAsiento() == "cama"){
                $importePasaje = $importePasaje * 1.25;
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

    /**
     * Método toString
     * @return string
     */
    public function __toString()
    {
        return parent::__toString() .
        "\n---- Datos de viaje terrestre ----".
        "\nComodidad del asiento: " . $this->getComodidadAsiento();
    }
}


?>