<?php

class Anexo
{
	private $id_anexo;
	private $id_despacho;
	private $anexo;
	private $extensao;
	private $nome;

	public function getId_anexo()
	{
		return $this->id_anexo;
	}

	public function getId_despacho()
	{
		return $this->id_despacho;
	}

	public function getAnexo()
	{
		return $this->anexo;
	}

	public function getExtensao()
	{
		return $this->extensao;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function setId_anexo($id_anexo)
	{
		$this->id_anexo = $id_anexo;
	}

	public function setId_despacho($id_despacho)
	{
		$this->id_despacho = $id_despacho;
	}

	public function setAnexo($anexo)
	{
		$this->anexo = $anexo;
	}

	public function setExtensao($extensao)
	{
		$this->extensao = $extensao;
	}

	public function setNome($nome)
	{
		$this->nome = $nome;
	}
}
?>