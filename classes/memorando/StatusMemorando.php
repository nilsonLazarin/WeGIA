<?php

class StatusMemorando
{
    //Atributos privados
    private string $status;
    private int $idStatus;

    //Método construtor
    public function __construct(string $status, int $idStatus = null)
    {
        $this->setStatus($status);

        if ($idStatus) {
            $this->setIdStatus($idStatus);
        }
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getIdStatus()
    {
        return $this->idStatus;
    }

    public function setStatus(string $status)
    {
        if (empty($status)) {
            throw new InvalidArgumentException('O nome do status de um memorando não pode ser vazio.');
        }
        $this->status = $status;
    }

    public function setIdStatus(int $idStatus)
    {
        if ($idStatus < 1) {
            throw new InvalidArgumentException('O id de um status de um memorando não pode ser menor que 1.');
        }
        $this->idStatus = $idStatus;
    }
}
