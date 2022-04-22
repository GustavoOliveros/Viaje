<?php

class ResponsableV{
    private $numEmpleado;
    private $numLicencia;
    private $nombre;
    private $apellido;

    /**
     * Método constructor
     * @param int $numEmpleado
     * @param int $numLicencia
     * @param string $nombre
     * @param string $apellido
     */
    public function __construct($numEmpleado, $numLicencia, $nombre, $apellido)
    {
        $this->numEmpleado = $numEmpleado;
        $this->numLicencia = $numLicencia;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }

    // Métodos de acceso

    
    public function getNumEmpleado()
    {
        return $this->numEmpleado;
    }
    public function setNumEmpleado($nuevoNumEmpleado)
    {
        $this->numEmpleado = $nuevoNumEmpleado;
    }
    public function getNumLicencia()
    {
        return $this->numLicencia;
    }
    public function setNumLicencia($nuevoNumLicencia)
    {
        $this->numLicencia = $nuevoNumLicencia;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nuevoNombre)
    {
        $this->nombre = $nuevoNombre;
    }
    public function getApellido()
    {
        return $this->apellido;
    }
    public function setApellido($nuevoApellido)
    {
        $this->apellido = $nuevoApellido;
    }

    // Método toString

    /**
     * Muestra los atributos del objeto como string
     */
    public function __toString()
    {
        return
        "\nNúmero de empleado: " . $this->getNumEmpleado().
        "\nNúmero de licencia: " . $this->getNumLicencia().
        "\nNombre: " . $this->getNombre().
        "\nApellido: " . $this->getApellido();
    }
}