<?php
class ProductoConsultar
{
    public static function verificar()
    {return isset($_POST['titulo']) && isset($_POST['tipo']) && isset($_POST['formato']);}
    public static function consultar()
    {
        if(ProductoConsultar::verificar())
        {
            if(!file_exists(filename: "./tienda.json"))
            {echo "no existen registros de la tienda";}
            else
            {
                $deposito = json_decode(file_get_contents("./tienda.json"), true);
                $flag=false;
                foreach($deposito as $posicion=>$valor)
                {
                    if(($_POST['titulo'] == $deposito[$posicion]["titulo"])
                        && ($_POST['tipo'] == $deposito[$posicion]["tipo"]) &&
                        ($_POST['formato'] == $deposito[$posicion]["formato"]))
                    {
                        echo "Existe";
                        $flag=true;
                        break;
                    }
                    if(($_POST['titulo']==$deposito[$posicion]["titulo"])
                        && ($_POST['tipo']!=$deposito[$posicion]["tipo"])
                        && ($_POST['formato']==$deposito[$posicion]["formato"]))
                    {
                        echo "Existe el titulo pero no tenemos ese tipo";
                        $flag=true;
                        break;
                    }
                    if(($_POST['titulo']==$deposito[$posicion]["titulo"])
                        && ($_POST['tipo']==$deposito[$posicion]["tipo"]) &&
                        ($_POST['formato']!=$deposito[$posicion]["formato"]))
                    {
                        echo "Existe el titulo pero no tenemos ese formato";
                        $flag=true;
                        break;
                    }
                }
                if(!$flag)
                {echo "No existe";}
            }
        }
        else
        {
            echo "Faltan datos";
        }
    }
}
ProductoConsultar::consultar();