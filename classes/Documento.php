<?php 
	class Documento
	{
		private $imagem;
		private $extensao;
		private $descricao;
		private $idPessoa;
		private $idDocumento;
		public function __construct($idPessoa,$imagem,$extensao,$descricao)
		{
			$this->idPessoa=$idPessoa;
			$this->imagem=$imagem;
			$this->descricao=$descricao;
			$this->extensao=$extensao;
		}
		public function getImagem()
		{
			return $this->imagem;
		}
		public function getExtensao()
		{
			return $this->extensao;
		}
		public function getDescricao()
		{
			return $this->descricao;
		}
		public function getIdPessoa()
		{
			return $this->idPessoa;
		}
		public function getIdDocumento()
		{
			return $this->idDocumento;
		}
		public function setImagem($imagem)
		{
			$this->imagem=$imagem;
		}
		public function setExtensao($extensao)
		{
			$this->extensao=$extensao;
		}
		public function setDescricao($descricao)
		{
			$this->descricao=$descricao;
		}
		public function setIdPessoa($idPessoa)
		{
			$this->idPessoa=$idPessoa;
		}
		public function setIdDocumento($idDocumento)
		{
			$this->idDocumento=$idDocumento;
		}
	} 
?>