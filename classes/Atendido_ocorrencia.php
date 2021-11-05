<?php

class Ocorrencia
{
	private $id_ocorrencia;
	private $id_pessoa;
	private $id_tipos_ocorrencia;
	private $titulo;
	private $data;

	public function __construct($titulo)
	{
		$this->titulo=$titulo;
	}

	public function getId_ocorrencia()
	{
		return $this->id_ocorrencia;
	}

	public function getId_pessoa()
	{
		return $this->id_pessoa;
	}

	public function getId_tipos_ocorrencia()
	{
		return $this->id_tipo_ocorrencia;
	}

	public function getTitulo()
	{
		return $this->titulo;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setId_ocorrencia($id_ocorrencia)
	{
		$this->id_ocorrencia = $id_ocorrencia;
	}

	public function setId_pessoa($id_pessoa)
	{
		$this->id_pessoa = $id_pessoa;
	}

	public function setId_tipos_ocorrencia($id_tipos_ocorrencia)
	{
		$this->id_tipos_ocorrencia = $id_tipos_ocorrencia;
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