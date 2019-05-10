<?php


class Memorando{
	public $id_memorando;
	public $id_pessoa
	public $origem;
	public $despacho;
	public $titulo;
	public $data;
	public $anexo;
	public $status;
	
	public function __construct($id_memorando,$id_pessoa,$origem,$despacho,$titulo,$anexo,$data){
		
		$this->origem = origem;
		$this->despacho = despacho;
		$this->titulo = titulo;
		date_default_timezone_set('America/Sao_Paulo');
		$this->data = date("d/m/Y"); 
	}

	//Getters and Setters
	public fucntion setOrigem($origem){
		this->origem=$origem;
	}

	public function getOrigem(){
		return $this->origem;
	}

	public function setDespacho($despachoo){
		this->despacho=$despacho;
	}

	public function getDespacho(){
		return $this->despacho;
	}
	
	public function setTitulo($titulo){
		this->titulo=$titulo;
	}
	
	public function getTitulo(){
		return $this->titulo;
	}
	
	public setData($data){
		if($data){
		date_default_timezone_set('America/Sao_Paulo');
		this->data=date("d/m/Y");
		}
	}
	public function getData(){
		return $this->data;
	}

}

?>