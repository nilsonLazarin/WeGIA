<?php


class BackupBD {
    private $nome;
    private $ano;
    private $mes;
    private $dia;
    private $hora;
    private $minuto;

    // Constructor

    public function __construct($obj){
        $this
            ->setNome($obj->nome)
            ->setAno($obj->ano)
            ->setMes($obj->mes)
            ->setDia($obj->dia)
            ->setHora($obj->hora)
            ->setMinuto($obj->min)
        ;
    }
    
    // Getters & Setters

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    public function getMes()
    {
        return $this->mes;
    }

    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    public function getDia()
    {
        return $this->dia;
    }

    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    public function getMinuto()
    {
        return $this->minuto;
    }

    public function setMinuto($minuto)
    {
        $this->minuto = $minuto;

        return $this;
    }

    // Metodos

    public function display(){
        $nome = $this->getNome();
        $date = $this->getDia() . "/" . $this->getMes() . "/" . $this->getAno();
        $time = $this->getHora() . ":" . $this->getMinuto();
        echo("
            <div class='a'>
                <div class='b'>
                    <p>$nome</p>
                    <p>&#8226;</p>
                    <p>$date ás $time</p>
                </div>
                <!--
                <div class='c'>
                    <button>a
                    </button>
                    <button>b
                    </button>
                </div>
                -->
            </div>
        ");
    }

}