<?php
class BorrarVentas
{
    private $pedido;
    public function __construct($pedido)
    {
        $this->pedido = $pedido;
        $this->borrar();
    }
    public function borrar()
    {
        $ventas = json_decode(file_get_contents('ventas.json'), true);
        $flag=false;
        foreach ($ventas as $posicion => $venta) {
            if ($this->pedido == $venta['id']) {
                copy("ImagenesDeVenta/2024/".$venta["imagen"], "ImagenesBackupVentas/2024/".$venta["imagen"] );
                $ventas[$posicion]["borrado"] = true;
                $flag=true;
            }
        }
        if(!$flag){
            echo "No se encontro el pedido";
            exit;
        }
        else
        {
            file_put_contents("ventas.json",json_encode($ventas,JSON_PRETTY_PRINT));
        }
    }
}
$BV =new BorrarVentas(json_decode(file_get_contents("php://input"), true)['id']);