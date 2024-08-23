<?php
require_once "ConexionBD.class.php";
require_once("AccesoBD.class.php");

class Pedido
{
    private $cn;

    //EL CONSTRUCTOR CONSTRUYE LA VARIABLE $cn
    function __construct()
    {
        try {
            $con = ConexionBD::CadenaCN();
            $this->cn = AccesoBD::ConexionBD($con);
            $this->cn->query("SET NAMES 'utf8'");   //ACENTOS UTF8
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function addPedido(
        $idCliente,
        $direccionPedido,
        $pedidoTelefono,
        $pedidoObservaciones,
        $precioTotal,
        $puntosGanados,
        $lastFour,
        $cardNumber,
        $horaPedido,
        $brand,
        $saldoReducido = 0,
        $delivery = 'true',
        $distrito,
        $documento,
        $razonSocial,
        $direccionFiscal,
        $ruc,
        $latitud,
        $longitud,
        $costoEnvioPagado = 0,
        $idtienda = 0,
        $precio_con_descuento,
        $codigo_cupon,
        $estado_descuento
    ) {
        date_default_timezone_set('America/Lima');
        $actualDate = date('Ymd');
        $dateTime = time();
        $sql = "INSERT INTO pedidos (idCliente, direccionPedido, pedidoTelefono,fechaPedido,pedidoObservaciones,precioTotal,
    puntosGanados,last_four,card_number,horaPedido,brand,saldoReducido,dateTime,delivery,
    distrito,documento,razonSocial,direccionFiscal,ruc,latitud,longitud,costoEnvioPagado,idTienda,precio_con_descuento,codigo_cupon,estado_descuento)
                     VALUES ('$idCliente','$direccionPedido','$pedidoTelefono',
                     '$actualDate','$pedidoObservaciones','$precioTotal','$puntosGanados','$lastFour',
                     '$cardNumber','$horaPedido','$brand','$saldoReducido','$dateTime','$delivery','$distrito',
                     '$documento','$razonSocial','$direccionFiscal','$ruc','$latitud','$longitud','$costoEnvioPagado','$idtienda','$precio_con_descuento','$codigo_cupon','$estado_descuento')";
        $id = AccesoBD::InsertAndGetLastId($this->cn, $sql);
        return $id;
    }

    public function addItemsPedido($sql)
    {

        $id = AccesoBD::addMultiQuery($this->cn, $sql);
        return $id;
    }

    public function getPedido()
    {
        try {
            $sql = "SELECT * FROM pedidos";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista[0];
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }
    public function getPedidoByIdPedido($idPedido)
    {
        try {
            $sql = "SELECT * FROM pedidos where idPedido = '$idPedido'";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista[0];
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

    public function getFeedBackTokenByIdPedido($idPedido)
    {
        try {
            $sql = "SELECT idPedido,feedBackToken FROM pedidos where idPedido = '$idPedido'";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista[0];
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }
    public function updateFeedBackStatus($idPedido)
    {

        $sql = "UPDATE pedidos SET feedBackToken = '' WHERE idPedido = '$idPedido'";
        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    /* Promocion primer cliente PPC01 */
    public function numPedidosCliente($idCliente)
    {
        try {
            $sql = "SELECT count(*) as numPedidos FROM pedidos where idCliente = '$idCliente'";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista[0]['numPedidos'];
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }
    /* /Promocion primer cliente PPC01 */
}
