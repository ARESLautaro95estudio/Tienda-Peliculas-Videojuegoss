<?php

class ModificarVenta
{
    private $ventas;
    private $ventaAModificar;
    public function __construct()
    {
        $this->getVentas();
        $this->getVentaAModificar();
    }
    public function getVentas()
    {
        $archivo = file_get_contents("./ventas.json");
        $dataAux = json_decode($archivo, true);
        $this->ventas = $dataAux;
    }
    public function getVentaAModificar()
    {
        $this->ventaAModificar = json_decode(file_get_contents("php://input"), true);
    }
    public function buscarVenta()
    {

        foreach ($this->ventas as $posicion => $venta)
        {
            if ($venta["id"] == $this->ventaAModificar["id"])
            {
                $this->modificar($posicion);
                return true;
            }
        }
        echo "no se encontro el pedido";
    }
    public function modificar($posicion)
    {
        $this->ventas[$posicion]["titulo"] = $this->ventaAModificar["titulo"];
        $this->ventas[$posicion]["formato"] = $this->ventaAModificar["formato"];
        $this->ventas[$posicion]["tipo"] = $this->ventaAModificar["tipo"];
        $this->ventas[$posicion]["mail"] = $this->ventaAModificar["mail"];
        $this->ventas[$posicion]["anioDeSalida"] = $this->ventaAModificar["anioDeSalida"];
        $this->ventas[$posicion]["imagen"] = $this->ventaAModificar["imagen"];
        $this->ventas[$posicion]["cantidad"] = $this->ventaAModificar["cantidad"];

        $json = json_encode($this->ventas, JSON_PRETTY_PRINT);
        file_put_contents("./ventas.json", $json);
    }
    public function ejecutar()
    {
        if($this->buscarVenta()){echo "modificado con exito";}
    }
}
$modif = new ModificarVenta();
$modif->ejecutar();

