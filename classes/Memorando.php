<?php

class Memorando
{
	private $id_memorando;
	private $id_pessoa;
	private $id_status_memorando;
	private $titulo;
	private $data;

	public function __construct($titulo)
	{
		$this->titulo=$titulo;
	}

	public function getId_memorando()
	{
		return $this->id_memorando;
	}

	public function getId_pessoa()
	{
		return $this->id_pessoa;
	}

	public function getId_status_memorando()
	{
		return $this->id_status_memorando;
	}

	public function getTitulo()
	{
		return $this->titulo;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setId_memorando($id_memorando)
	{
		$this->id_memorando = $id_memorando;
	}

	public function setId_pessoa($id_pessoa)
	{
		$this->id_pessoa = $id_pessoa;
	}

	public function setId_status_memorando($id_status_memorando)
	{
		$this->id_status_memorando = $id_status_memorando;
	}

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	public function setData()
	{
		date_default_timezone_set('America/Sao_Paulo');
        $data=date('Y-m-d H:i:s');
		$this->data = $data;
	}
}
?>