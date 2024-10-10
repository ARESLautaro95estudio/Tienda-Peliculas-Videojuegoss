<?php
switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':
        include_once "./ConsultasVentas.php";
        break;
    case 'POST':
        if(isset($_POST["tituloP"]))
        {
            include_once "./altoCombo.php";
            break;
        }
        if(!isset($_POST["precio"]) && !isset($_POST["mail"]))
        {
            include_once "./productoConsultar.php";
            break;
        }
        else
        {
            if(isset($_POST["mail"]))
            {
                include_once "./AltaVenta.php";
                break;
            }
        }
        if(isset($_POST["precio"] ))
        { include_once "./tiendaAlta.php";
            break;
        }
        break;
    case 'PUT':
        include_once "./modificarVentas.php";
        break;
    case "DELETE":
        include_once "BorrarVentas.php";
        break;
    default:
        include_once "";
        break;
}