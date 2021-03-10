<?php 
require "../../config/Conexion.php";
class DetalleVenta extends Conexion{
	private $id_venta;
    private $id_medicamentoAlmacen;
    private $cantidad;
	private $preciov;

	public function DetalleVenta(){
		parent::Conexion();
		$this->id_venta=0;
        $this->id_medicamentoAlmacen=0;
        $this->cantidad=0;
		$this->preciov=0;
	}

	public function setIdVenta($valor){ $this->id_venta=$valor; }
	public function getIdVenta(){ return $this->id_venta; }
	public function setIdMedicamento($valor){ $this->id_medicamentoAlmacen=$valor; }
	public function getIdMedicamento(){ return $this->id_medicamentoAlmacen; }
    public function setCantidad($valor){ $this->cantidad=$valor; }
	public function getCantidad(){ return $this->cantidad; }
	public function setPrecioc($valor){ $this->preciov=$valor; }
	public function getPrecioc(){ return $this->preciov; }
}
?>