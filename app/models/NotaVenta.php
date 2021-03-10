<?php 
require "../../config/Conexion.php";
class NotaVenta extends Conexion{
	private $id_venta;
    private $fecha;
    private $glosa;
    private $descuento;
	private $monto;
    private $facturada;
	private $estado;
    private $id_cliente;
	private $id_usuario;

	public function NotaVenta(){
		parent::Conexion();
		$this->id_venta=0;
        $this->fecha="";
        $this->glosa="";
        $this->descuento=0;
		$this->monto=0;
        $this->facturada=0;
		$this->estado="";
        $this->id_cliente=0;
		$this->id_usuario=0;
	}

	public function setIdNotaVenta($valor){ $this->id_venta=$valor; }
	public function getIdNotaVenta(){ return $this->id_venta; }
	public function setFecha($valor){ $this->fecha=$valor; }
	public function getFecha(){ return $this->fecha; }
    public function setGlosa($valor){ $this->glosa=$valor; }
	public function getGlosa(){ return $this->glosa; }
    public function setDescuento($valor){ $this->descuento=$valor; }
	public function getDescuento(){ return $this->descuento; }
    public function setMonto($valor){ $this->monto=$valor; }
	public function getMonto(){ return $this->monto; }
	public function setFacturada($valor){ $this->facturada=$valor; }
	public function getFacturada(){ return $this->facturada; }
	public function setEstado($valor){ $this->estado=$valor; }
	public function getEstado(){ return $this->estado; }
    public function setIdCliente($valor){ $this->id_cliente=$valor; }
	public function getIdCliente(){ return $this->id_cliente; }
	public function setIdUsuario($valor){ $this->id_usuario=$valor; }
	public function getIdUsuario(){ return $this->id_usuario; }

	public function limpiar($str){
        return parent::limpiarCadena($str);
    }

	public function listar(){
		$sql="SELECT v.id_venta,v.fecha,v.glosa,v.descuento,v.monto,v.facturada,v.estado,v.id_cliente,v.id_usuario,c.tipo,
        c.nombre as cpersona,c.razonSocial as cempresa,u.login as usuario FROM nota_venta v INNER JOIN cliente c 
        ON c.id_cliente=v.id_cliente INNER JOIN usuario u ON u.id_usuario=v.id_usuario ORDER BY v.id_venta desc";
		return parent::ejecutar($sql);		
	}

	public function selectCliente(){
		$sql="SELECT c.id_cliente,c.tipo,c.nombre,c.razonSocial FROM cliente c";
		return parent::ejecutar($sql);		
	}

	public function guardar($id_medicamentoAlmacen,$cantidad,$preciov){
		$sql="INSERT INTO nota_venta(fecha,glosa,descuento,monto,facturada,estado,id_cliente,id_usuario)	
		VALUES('$this->fecha','$this->glosa','$this->descuento','$this->monto','$this->facturada','$this->estado','$this->id_cliente','$this->id_usuario')";
		$idVentaNew=parent::ejecutarConsulta_retornarID($sql);

		$i=0;
		$sw=true;
		while ($i < count($id_medicamentoAlmacen)){
			$sql_detalle = "INSERT INTO detalle_venta(id_venta,id_medicamentoAlmacen,cantidad,preciov) 
			VALUES('$idVentaNew','$id_medicamentoAlmacen[$i]','$cantidad[$i]','$preciov[$i]')";
			parent::ejecutar($sql_detalle) or $sw = false;
			$i=$i + 1;
		}
		return $sw;
	}

	public function anular(){
		$sql="UPDATE nota_venta SET estado='Anulado' WHERE id_venta='$this->id_venta'";
		return parent::ejecutar($sql);
	}

	public function verDetalleVenta(){
		$sql="SELECT v.id_venta,v.fecha,v.glosa,v.descuento,v.monto,v.facturada,v.estado,v.id_cliente,v.id_usuario,c.nombre as cpersona,c.razonSocial as cempresa,u.login as usuario 
		FROM nota_venta v INNER JOIN cliente c ON c.id_cliente=v.id_cliente INNER JOIN usuario u ON u.id_usuario=v.id_usuario WHERE v.id_venta='$this->id_venta'";
		return parent::ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($id_venta){
		$sql="SELECT dv.id_venta,dv.id_medicamentoAlmacen,dv.cantidad,dv.preciov,m.nombre,m.precio
		FROM detalle_venta dv INNER JOIN medicamento_almacen ma ON ma.id_medicamentoAlmacen=dv.id_medicamentoAlmacen 
		INNER JOIN medicamento m ON m.id_medicamento=ma.id_medicamento WHERE dv.id_venta='$id_venta'";
		return parent::ejecutar($sql);
	}

}
?>