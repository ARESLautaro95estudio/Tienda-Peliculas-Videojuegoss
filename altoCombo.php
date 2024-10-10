<?php
class combo
{
    public function alta()
    {
        if($this->check()=="Existe")
        {
            move_uploaded_file($_FILES["foto"]['tmp_name'],"./ImagenesDeProductos/2024/".$_FILES["foto"]["name"]);
            $producto =["id"=>$this->crearId(),
            "tituloPelicula"=>$_POST['tituloP'],
            "precio"=>$_POST['precio'],
            "tipo"=>"combo",
            "formatoPelicula"=>$_POST['formatoP'],
            "tituloVidejuego"=>$_POST['tituloV'],
            "formatoVidejuego"=>$_POST['formatoV'],
            "imagen"=>$_FILES["foto"]["name"]
            ];
            $deposito = json_decode(file_get_contents("./tienda.json"), true);
            array_push($deposito,$producto);
            file_put_contents("./tienda.json",json_encode($deposito,JSON_PRETTY_PRINT));
        }
    }
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
    public function check()
    {
        $retorno ="";
        if(!file_exists(filename: "./tienda.json"))
        {$retorno = "no existen registros de la tienda";
        }
        else
        {
            $movie=false;
            $game=false;
            $deposito = json_decode(file_get_contents("./tienda.json"), true);
            foreach($deposito as $posicion=>$valor)
            {
                if($deposito[$posicion]["titulo"]==$_POST["tituloP"]
                &&$_POST["formatoP"]==$deposito[$posicion]["formato"]
                &&$deposito[$posicion]["titulo"]>0)
                {
                    $movie=true;
                }
                if($deposito[$posicion]["titulo"]==$_POST["tituloV"]
                &&$_POST["formatoV"]==$deposito[$posicion]["formato"]
                &&$deposito[$posicion]["titulo"]>0)
                {
                    $game=true;
                }
            }
            $retorno = "No existe";
        }
        if($game && $movie)
        {
            return "Existe";
        }
        return $retorno;
    }
}
$combo = new combo();
$combo->alta();