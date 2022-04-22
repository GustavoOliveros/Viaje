<?php

class Pasajero{
    private $nombre;
    private $apellido;
    private $numDoc;
    private $telefono;

    /**
     * Método constructor
     * @param string $nombre
     * @param string $apellido
     * @param int $numDoc
     * @param string $telefono
     */
    public function __construct($nombre, $apellido, $numDoc, $telefono)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->numDoc = $numDoc;
        $this->telefono = $telefono;
    }

    // Métodos de acceso

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
    public function getNumDoc()
    {
        return $this->numDoc;
    }
    public function setNumDoc($nuevoNumDoc)
    {
        $this->numDoc = $nuevoNumDoc;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function setTelefono($nuevoTelefono)
    {
        $this->telefono = $nuevoTelefono;
    }

    // Método toString

    /**
     * Método toString para mostrar el objeto en string
     */
    public function __toString()
    {
        return
        "\nNombre: " . $this->getNombre().
        "\nApellido: " . $this->getApellido().
        "\nNúmero de documento: " . $this->getNumDoc().
        "\nNúmero de teléfono: " . $this->getTelefono();
    }
}