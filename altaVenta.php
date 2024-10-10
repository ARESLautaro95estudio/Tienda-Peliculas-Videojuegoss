<?php
include_once "./productoConsultar.php";
class AltaVenta
{
    private $precio,$fechaDeSalida;
    public function crearId(): bool|int
    {
        if(!file_exists(filename: "./tienda.json"))
        {
            return rand(min: 1,max: 10000);
        }
        $id = rand(min: 1,max: 10000);
        $json = json_decode(file_get_contents("tienda.json"),true);
        foreach($json as $llave => $valor)
        {
            if($llave == "id" && $valor == $id)
            {
                $this->crearId();
                break;
            }
        }
        return $id;
    }
    public  function  altaVenta()
    {
        if(($this->consultarStock()))
        {
            $this->vender();
        }
    }
    public function consultarStock()
    {
        $deposito = json_decode(file_get_contents("./tienda.json"), true);
        foreach($deposito as $posicion=>$valor)
        {
            if($_POST['stock']<= $deposito[$posicion]["stock"])
            {
                $this->precio=$_POST['stock']*$deposito[$posicion]["precio"];
                $this->fechaDeSalida=$deposito[$posicion]["fechaDeSalida"];
                return true;
            }
        }
        return false;
    }
    public function vender()
    {
        $deposito = json_decode(file_get_contents("./tienda.json"), true);
        foreach($deposito as $posicion=>$valor)
        {
            if ($_POST['titulo'] == $deposito[$posicion]["titulo"] &&
            $_POST['tipo'] == $deposito[$posicion]["tipo"] &&
             $_POST['formato'] == $deposito[$posicion]["formato"])
            {
                $deposito[$posicion]["stock"]-=$_POST['stock'];
                file_put_contents("./tienda.json",json_encode($deposito,JSON_PRETTY_PRINT));
            }
        }
        $this->terminarVenta();
    }
    public function primerVenta()
    {
        move_uploaded_file($_FILES["foto"]['tmp_name'],"./ImagenesDeVenta/2024/".$_FILES["foto"]["name"]);
        return ["id"=>rand(min: 1,max: 10000),
        "titulo"=>$_POST['titulo'],
        "mail"=>$_POST['mail'],
        "tipo"=>$_POST['tipo'],
        "formato"=>$_POST['formato'],
        "fecha"=>date("Y-m-d"),
        "imagen"=>$_FILES["foto"]["name"],
        "cantidad"=>$_POST['stock'],
        "costo"=>$this->precio,
        "fechaDeSalida"=>$this->fechaDeSalida
        ];
    }
    public function terminarVenta()
    {
        if(!file_exists("./ventas.json"))
        {
            file_put_contents("./ventas.json",json_encode([$this->primerVenta()],JSON_PRETTY_PRINT));
            return true;
        }
        else
        {
            $venta = [
            "id"=>$this->crearId(),
            "titulo"=>$_POST['titulo'],
            "mail"=>$_POST['mail'],
            "tipo"=>$_POST['tipo'],
            "formato"=>$_POST['formato'],
            "fecha"=>date("Y-m-d"),
            "imagen"=>$_FILES["foto"]["name"],
            "cantidad"=>$_POST['stock'],
            "costo"=>$this->precio,
            "fechaDeSalida"=>$this->fechaDeSalida
            ];
            move_uploaded_file($_FILES["foto"]['tmp_name'],"./ImagenesDeVenta/2024/".$_FILES["foto"]["name"]);
            $registros = json_decode(file_get_contents("./ventas.json"), true);
            array_push($registros,$venta);
            file_put_contents("./ventas.json",json_encode($registros,JSON_PRETTY_PRINT));
        }
    }
}
$venta = new AltaVenta();
$venta->altaVenta();