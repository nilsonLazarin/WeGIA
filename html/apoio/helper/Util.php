<?php
class Util
{
    /**
     * Retorna um número com a quantidade de algarismos informada no parâmetro
     */
    public static function gerarNumeroDocumento($tamanho)
    {
        $numeroDocumento = '';

        for ($i = 0; $i < $tamanho; $i++) {
            $numeroDocumento .= rand(0, 9);
        }

        return intval($numeroDocumento);
    }

    /**
     * Retorna apenas os números de um CPF
     */
    public static function limpaCpf($cpf)
    {
        return preg_replace('/\D/', '', $cpf);
    }
}
