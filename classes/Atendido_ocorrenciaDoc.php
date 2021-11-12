<?php

class Atendido_ocorrenciaDoc
{
	private $idatendido_ocorrencia_doc;
	private $atentido_ocorrencia_idatentido_ocorrencias;
	private $anexo;
	private $extensao;
	private $nome;

	public function getIdatendido_ocorrencia_doc()
	{
		return $this->idatendido_ocorrencia_doc;
	}

	public function getAtentido_ocorrencia_idatentido_ocorrencias()
	{
		return $this->atentido_ocorrencia_idatentido_ocorrencias;
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

	public function setIdatendido_ocorrencia_doc($idatendido_ocorrencia_doc)
	{
		$this->idatendido_ocorrencia_doc = $idatendido_ocorrencia_doc;
	}

	public function setAtentido_ocorrencia_idatentido_ocorrencias($atentido_ocorrencia_idatentido_ocorrencias)
	{
		$this->atentido_ocorrencia_idatentido_ocorrencias = $atentido_ocorrencia_idatentido_ocorrencias;
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