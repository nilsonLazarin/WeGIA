<?php

class Memorando

{
	private $id_memorando;
	private $id_pessoa;
	private $id_status_memorando;
	private $titulo;
	private $data;

	public function __construct($titulo, $data)

	{

		$this->setTitulo($titulo);
		$this->setData($data);

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

	public function setData($data)

	{

		$this->data = $data;

	}

}

?>