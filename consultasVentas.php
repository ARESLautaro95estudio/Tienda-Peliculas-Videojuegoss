<?php
class ConsultasVentas
{
    private $ventas;
    public function __construct()
    {
        $this->ventas= json_decode(file_get_contents("./ventas.json"),true);
    }
    public function productoMasVendido()
    {
        $aux=0;
        $titulo ="";
        foreach($this->ventas as $posicion =>$valor)
        {
            if($aux<$this->ventas[$posicion]["cantidad"])
            {
                $aux=$this->ventas[$posicion]["cantidad"];
                $titulo=$this->ventas[$posicion]["titulo"];
            }
        }
        echo "titulo: " .$titulo." ventas :".($aux)."\n";
    }
    public function ventasDeUsuario($usuario)
    {
        $aux=$usuario." :";
        $ventas1=0;
        foreach($this->ventas as $posicion =>$valor)
        {
            if($usuario==$this->ventas[$posicion]["mail"])
            {
                $ventas1+=$this->ventas[$posicion]["cantidad"];
            }
        }
        echo $aux.$ventas1."\n";
    }
    public function ventasPorAñoDeSalida($año)
    {
        $aux=$año." :";
        $ventas1=0;
        foreach($this->ventas as $posicion =>$valor)
        {
            if($año==$this->ventas[$posicion]["fechaDeSalida"])
            {
                $ventas1=$this->ventas[$posicion]["cantidad"];
            }
        }
        echo $aux.$ventas1."\n";
    }
    public function ventasPorTipoDeProducto($tipo)
    {
        $aux=$tipo." :";
        $ventas=0;
        foreach($this->ventas as $posicion =>$valor)
        {
            if($tipo==$this->ventas[$posicion]["tipo"])
            {
                $ventas+=$this->ventas[$posicion]["cantidad"];
            }
        }
        echo $aux.$ventas."\n";
    }
    public function ventasEntrePrecios($precio1,$precio2)
    {
        $aux=0;
        foreach($this->ventas as $posicion =>$valor)
        {
            if($precio1<=$this->ventas[$posicion]["costo"]&&$precio2>=$this->ventas[$posicion]["costo"])
            {
                $aux++;
            }
        }
        echo($aux)."\n";
    }
}
$conV = new ConsultasVentas();
if(isset($_GET["mail"]))
{
    $conV->ventasDeUsuario($_GET["mail"]);
}
if(isset($_GET["tipo"]))
{
    $conV->ventasPorTipoDeProducto($_GET["tipo"]);
}
if(isset($_GET["producto"]))
{
    $conV->productoMasVendido();
}
if(isset($_GET["año"]))
{
    $conV->ventasPorAñoDeSalida($_GET["año"]);
}
if(isset($_GET["valor1"])&&isset($_GET["valor2"]))
{
    $conV->ventasEntrePrecios($_GET["valor1"],$_GET["valor2"]);
}