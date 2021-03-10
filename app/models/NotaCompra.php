<?php 
require "../../config/Conexion.php";
class NotaCompra extends Conexion{
	private $id_compra;
    private $fecha;
    private $glosa;
	private $monto;
	private $estado;
    private $id_proveedor;
	private $id_usuario;

	public function NotaCompra(){
		parent::Conexion();
		$this->id_compra=0;
        $this->fecha="";
        $this->glosa="";
		$this->monto=0;
		$this->estado="";
        $this->id_proveedor=0;
		$this->id_usuario=0;
	}

	public function setIdNotaCompra($valor){ $this->id_compra=$valor; }
	public function getIdNotaCompra(){ return $this->id_compra; }
	public function setFecha($valor){ $this->fecha=$valor; }
	public function getFecha(){ return $this->fecha; }
    public function setGlosa($valor){ $this->glosa=$valor; }
	public function getGlosa(){ return $this->glosa; }
	public function setMonto($valor){ $this->monto=$valor; }
	public function getMonto(){ return $this->monto; }
	public function setEstado($valor){ $this->estado=$valor; }
	public function getEstado(){ return $this->estado; }
    public function setIdProveedor($valor){ $this->id_proveedor=$valor; }
	public function getIdProveedor(){ return $this->id_proveedor; }
	public function setIdUsuario($valor){ $this->id_usuario=$valor; }
	public function getIdUsuario(){ return $this->id_usuario; }

	public function limpiar($str){
        return parent::limpiarCadena($str);
    }

	public function listar(){
		$sql="SELECT c.id_compra,c.fecha,c.glosa,c.monto,c.estado,c.id_proveedor,c.id_usuario,p.tipo,p.nombre as ppersona,p.razonSocial as pempresa,u.login as usuario 
		FROM nota_compra c INNER JOIN proveedor p ON p.id_proveedor=c.id_proveedor INNER JOIN usuario u ON u.id_usuario=c.id_usuario ORDER BY c.id_compra desc";
		return parent::ejecutar($sql);		
	}

	public function selectProveedor(){
		$sql="SELECT p.id_proveedor,p.tipo,p.nombre,p.razonSocial FROM proveedor p";
		return parent::ejecutar($sql);		
	}

	public function guardar($id_medicamentoAlmacen,$cantidad,$precioc){
		$sql="INSERT INTO nota_compra(fecha,glosa,monto,estado,id_proveedor,id_usuario)	
		VALUES('$this->fecha','$this->glosa','$this->monto','$this->estado','$this->id_proveedor','$this->id_usuario')";
		$idCompraNew=parent::ejecutarConsulta_retornarID($sql);

		$i=0;
		$sw=true;
		while ($i < count($id_medicamentoAlmacen)){
			$sql_detalle = "INSERT INTO detalle_compra(id_compra,id_medicamentoAlmacen,cantidad,precioc) 
			VALUES('$idCompraNew','$id_medicamentoAlmacen[$i]','$cantidad[$i]','$precioc[$i]')";
			parent::ejecutar($sql_detalle) or $sw = false;
			$i=$i + 1;
		}
		return $sw;
	}

	public function anular(){
		$sql="UPDATE nota_compra SET estado='Anulado' WHERE id_compra='$this->id_compra'";
		return parent::ejecutar($sql);
	}

	public function verDetalleCompra(){
		$sql="SELECT c.id_compra,c.fecha,c.glosa,c.monto,c.estado,c.id_proveedor,c.id_usuario,p.nombre as ppersona,p.razonSocial as pempresa,u.login as usuario 
		FROM nota_compra c INNER JOIN proveedor p ON p.id_proveedor=c.id_proveedor INNER JOIN usuario u ON u.id_usuario=c.id_usuario WHERE c.id_compra='$this->id_compra'";
		return parent::ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($id_compra){
		$sql="SELECT dc.id_compra,dc.id_medicamentoAlmacen,dc.cantidad,dc.precioc,m.nombre,m.precio
		FROM detalle_compra dc INNER JOIN medicamento_almacen ma ON ma.id_medicamentoAlmacen=dc.id_medicamentoAlmacen 
		INNER JOIN medicamento m ON m.id_medicamento=ma.id_medicamento WHERE dc.id_compra='$id_compra'";
		return parent::ejecutar($sql);
	}

}
?>