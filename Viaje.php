<?php

class Viaje{
    private $codViaje;
    private $destino;
    private $responsable;
    private $cantMaxPasajeros;
    private $pasajeros;
    private $importe;
    private $idaYVuelta;

    /**
     * Método constructor
     * @param string $codViaje
     * @param string $destino
     * @param object $responsable
     * @param integer $cantMaxPasajeros
     * @param array $pasajeros arreglo indexado cuyos valores son objetos
     * @param float $importe
     * @param boolean $idaYVuelta
     */
    public function __construct($codViaje, $destino, $responsable, $cantMaxPasajeros, $pasajeros, $importe, $idaYVuelta)
    {
        $this->codViaje = $codViaje;
        $this->destino = $destino;
        $this->responsable = $responsable;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->pasajeros = $pasajeros;
        $this->importe = $importe;
        $this->idaYVuelta = $idaYVuelta;
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
    public function getImporte()
    {
        return $this->importe;
    }
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }
    public function getIdaYVuelta()
    {
        return $this->idaYVuelta;
    }
    public function setIdaYVuelta($idaYVuelta)
    {
        $this->idaYVuelta = $idaYVuelta;
    }

    // Métodos varios

    /**
     * Cargar nuevos datos de viaje 
     * @param string $codViaje "*" deja el dato igual
     * @param string $destino "*" deja el dato igual
     * @param integer $cantMaximaPasajeros "*" deja el dato igual
     * @param float $importe "*" deja el dato igual
     * @param boolean $idaYVuelta "*" deja el dato igual
     */
    public function cargarDatos($codigoViaje, $destino, $cantidadMaximaPasajeros, $importe){
        if($codigoViaje != "*"){
            $this->setCodViaje($codigoViaje);
        }
        if($destino != "*"){
            $this->setDestino($destino);
        }
        if($cantidadMaximaPasajeros != "*"){
            $this->setCantMaxPasajeros($cantidadMaximaPasajeros);
        }
        if(is_numeric($importe) && $importe != "*"){
            $this->setImporte($importe);
        }
    }

    /**
     * Agrega un pasajero nuevo al arreglo
     * @param array $pasajeroNuevo objeto de la clase pasajero
     */
    public function agregarPasajero($pasajeroNuevo){
        $arrayPasajeros = $this->getPasajeros();
        $arrayPasajeros[count($arrayPasajeros)] = $pasajeroNuevo;
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

    /**
     * Retorna true si hay pasajes disponibles, false caso contrario
     * @return boolean
     */
    public function hayPasajeDisponible(){
        $cantPasajeros = count($this->getPasajeros());
        if($cantPasajeros < $this->getCantMaxPasajeros()){
            $hayDisponible = true;
        }else{
            $hayDisponible = false;
        }

        return $hayDisponible;
    }

    /**
     * Vende un pasaje si hay disponibles
     * @param object $pasajero objeto de la clase Pasajero
     * @return float|null el importe del pasaje o null si no se concretó
     */
    public function venderPasaje($pasajero){
        //Revisa si hay asientos disponibles
        if($this->hayPasajeDisponible()){
            // Si hay, agrega al pasajero y cambia la bandera.
            $this->agregarPasajero($pasajero);
            $resultado = $this->getImporte();
        }else{
            $resultado = null;
        }

        return $resultado;
    }

    // Método __toString

    public function __toString()
    {
        $idaYVuelta = $this->getIdaYVuelta() ? "Si" : "No";

        return
        "\nCódigo de viaje: " . $this->getCodViaje().
        "\nDestino: " . $this->getDestino().
        "\nImporte: " . $this->getImporte().
        "\nIda y vuelta: ". $idaYVuelta . "\n--------------------" .
        "\nResponsable:\n--------------------" . $this->getResponsable(). "\n--------------------" .
        "\nCantidad máxima de pasajeros: " . $this->getCantMaxPasajeros().
        "\nPasajeros: " . $this->mostrarTodosPasajeros().
        "\nCantidad de pasajeros: " . count($this->getPasajeros());
    }
}
?>