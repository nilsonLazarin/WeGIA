<?php

class Despacho
{
	private $id_despacho;
	private $id_memorando;
	private $id_remetente;
	private $id_destinatario;
	private $texto;
	private $data;

	public function __construct($texto)
	{
		$this->texto = $texto;
	}

	public function getId_despacho()
	{
		return $this->id_despacho;
	}

	public function getId_memorando()
	{
		return $this->id_memorando;
	}

	public function getId_remetente()
	{
		return $this->id_remetente;
	}

	public function getId_destinatario()
	{
		return $this->id_destinatario;
	}

	public function getTexto()
	{
		return $this->texto;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setId_Despacho($id_despacho)
	{
		$this->id_despacho = $id_despacho;
	}

	public function setId_Memorando($id_memorando)
	{
		$this->id_memorando = $id_memorando;
	}

	public function setId_remetente($id_remetente)
	{
		$this->id_remetente = $id_remetente;
	}

	public function setId_destinatario($id_destinatario)
	{
		$this->id_destinatario = $id_destinatario;
	}

	public function setTexto($texto)
	{
		$this->texto = $texto;
	}

	public function setData()
	{
		date_defaut_timezone_set('America/Sao_Paulo');
		$data = date('Y-m-d H:i:s');
		$this->data = $data;
	}
}
?>