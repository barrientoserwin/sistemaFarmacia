<?php 
require "../../config/Conexion.php";
class MedicamentoAlmacen extends Conexion{
	private $id_medicamentoAlmacen;
    private $id_medicamento;
    private $id_almacen;
    private $stock;

	public function MedicamentoAlmacen(){
		parent::Conexion();
		$this->id_medicamentoAlmacen=0;
        $this->id_medicamento=0;
        $this->id_almacen=0;
        $this->stock=0;
	}

	public function setIdMedicamentoAlmacen($valor){ $this->id_medicamentoAlmacen=$valor; }
	public function getIdMedicamentoAlmacen(){ return $this->id_medicamentoAlmacen; }
	public function setIdMedicamento($valor){ $this->id_medicamento=$valor; }
	public function getIdMedicamento(){ return $this->id_medicamento; }
    public function setIdAlmacen($valor){ $this->id_almacen=$valor; }
	public function getIdAlmacen(){ return $this->id_almacen; }
    public function setStock($valor){ $this->stock=$valor; }
	public function getStock(){ return $this->stock; }

    public function listar(){
		$sql="SELECT ma.id_medicamentoAlmacen,m.nombre,m.accionTerapeutica,c.nombre as categoria,l.nombre as laboratorio,m.precio,ma.stock,m.fechaVcto,a.nombre as almacen
        FROM medicamento_almacen ma INNER JOIN medicamento m ON m.id_medicamento=ma.id_medicamento INNER JOIN laboratorio l ON l.id_laboratorio=m.id_laboratorio 
        INNER JOIN categoria c ON c.id_categoria=m.id_categoria INNER JOIN almacen a ON a.id_almacen=ma.id_almacen";
		return parent::ejecutar($sql);
	}

	public function listarMedicamentoAl(){
		$sql="SELECT m.id_medicamento,m.nombre,c.nombre as categoria,l.nombre as laboratorio,m.precio,m.fechaVcto,m.foto
		FROM medicamento m INNER JOIN laboratorio l ON l.id_laboratorio=m.id_laboratorio INNER JOIN categoria c ON c.id_categoria=m.id_categoria
		WHERE m.id_medicamento NOT IN (SELECT ma.id_medicamento FROM medicamento_almacen ma WHERE ma.id_almacen='$this->id_almacen')";
		return parent::ejecutar($sql);
	}

	public function listarMedicamentoAlmacen(){
		$sql="SELECT ma.id_medicamentoAlmacen,m.nombre,c.nombre as categoria,l.nombre as laboratorio,m.precio,m.fechaVcto,m.foto
		FROM medicamento_almacen ma INNER JOIN medicamento m ON m.id_medicamento=ma.id_medicamento INNER JOIN laboratorio l ON l.id_laboratorio=m.id_laboratorio INNER JOIN categoria c ON c.id_categoria=m.id_categoria
		WHERE ma.id_medicamentoAlmacen in (SELECT ma.id_medicamentoAlmacen  FROM medicamento_almacen ma WHERE ma.id_almacen='$this->id_almacen')";
		return parent::ejecutar($sql);
	}

	public function guardar($id_medicamento,$stock){
		$i=0;
		$sw=true;
		while ($i < count($id_medicamento)){
			$sql_detalle = "INSERT INTO medicamento_almacen(id_medicamento,id_almacen,stock) VALUES('$id_medicamento[$i]','$this->id_almacen','$stock[$i]')";
			parent::ejecutar($sql_detalle) or $sw = false;
			$i=$i + 1;
		}
		return $sw;
	}
}
?>