<?php 
require "../../config/Conexion.php";
class DetalleCompra extends Conexion{
	private $id_compra;
    private $id_medicamentoAlmacen;
    private $cantidad;
	private $precioc;

	public function DetalleCompra(){
		parent::Conexion();
		$this->id_compra=0;
        $this->id_medicamentoAlmacen=0;
        $this->cantidad=0;
		$this->precioc=0;
	}

	public function setIdCompra($valor){ $this->id_compra=$valor; }
	public function getIdCompra(){ return $this->id_compra; }
	public function setIdMedicamento($valor){ $this->id_medicamentoAlmacen=$valor; }
	public function getIdMedicamento(){ return $this->id_medicamentoAlmacen; }
    public function setCantidad($valor){ $this->cantidad=$valor; }
	public function getCantidad(){ return $this->cantidad; }
	public function setPrecioc($valor){ $this->precioc=$valor; }
	public function getPrecioc(){ return $this->precioc; }
}
?>