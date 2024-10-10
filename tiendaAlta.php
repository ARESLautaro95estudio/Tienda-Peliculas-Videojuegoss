<?php

// B- (1 pt.) TiendaAlta.php: (por POST) se ingresa título, precio, tipo ("Videojuego" o 
// "Pelicula"), aniooDeSalida,
// formato ("Digital" o "Fisico") y stock (unidades). 
// Se guardan los datos en el archivo de texto tienda.json, tomando
// un id autoincremental como identificador (emulado).
//  Si el título y tipo ya existen, se actualiza el precio y se suma
// al stock existente. 
// Completar el alta con imagen del producto, guardando la imagen con el título y tipo como
// identificación en la carpeta /ImagenesDeProductos/2024.


class TiendaAlta
{
    public function crearId(): bool|int
    {
        if(!file_exists(filename: "./tienda.json"))
        {
            return rand(min: 1,max: 10000);
        }
        $id = rand(min: 1,max: 10000);
        $json = file_get_contents("tienda.json");
        $json = json_decode($json,true);
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
    public static function verificar()
    {return isset($_POST['titulo']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['fechaDeSalida']) && isset($_POST['formato'])&&(isset($_POST["stock"]))&& isset($_FILES["foto"]);}
    public function alta()
    {
        if(TiendaAlta::verificar())
        {
            $path="./ImagenesDeProductos/2024/".$_FILES["foto"]["name"];
            $producto =["id"=>$this->crearId(),"titulo"=>$_POST['titulo'],"precio"=>$_POST['precio'],"tipo"=>$_POST['tipo'],"fechaDeSalida"=>$_POST['fechaDeSalida'],"formato"=>$_POST['formato'],"stock"=>$_POST["stock"],"imagen"=>$_FILES["foto"]["name"]];
            if($this->guardarJson($producto))
            {
                move_uploaded_file($_FILES["foto"]['tmp_name'],$path);
                echo "Se dio alta con exito";
                return true;
            }
            echo "No se pudo guardar datos";
            return false;
        }
        echo "Faltan datos";
        return false;
    }
    public function guardarJson($producto)
    {
        if(!file_exists(filename: "./tienda.json"))
        {
            $json=json_encode([$producto],JSON_PRETTY_PRINT);
            file_put_contents("./tienda.json",$json);
            return true;
        }
        $archivo = file_get_contents("./tienda.json");
        $deposito = json_decode($archivo, true);
        foreach($deposito as $posicion=>$valor)
        {
            if(($producto["titulo"]==$deposito[$posicion]["titulo"] )&& ($producto["tipo"]==$deposito[$posicion]["tipo"]))
            {
                $deposito[$posicion]["stock"]+= $producto["stock"];
                $deposito[$posicion]["precio"]= $producto["precio"];
                $json=json_encode($deposito,JSON_PRETTY_PRINT);
                file_put_contents("./tienda.json",$json);
                return true;
            }
        }
        array_push($deposito,$producto);
        $json=json_encode($deposito,JSON_PRETTY_PRINT);
        file_put_contents("./tienda.json",$json);
        return true;
    }
}
$store = new TiendaAlta();
$store->alta();