<?php
    class OcorrênciaDAO
    {

        public function IssetOcorrencia($id_ocorrencia)
        {
            try
            {
                $pdo = Conexao::connect();
                $consulta = $pdo->query("SELECT idatendido_ocorrencias FROM atendido_ocorrencia WHERE idatendido_ocorrencias=$id_ocorrencia");

                if(null == $consulta->fetch(PDO::FETCH_ASSOC))
                {
                    $retorno = 1;
                }
                else
                {
                    $retorno = 0;
                }
            }
            catch(PDOException $e)
            {
                echo 'Error:' . $e->getMessage();
            }
            return $retorno;
        }
    }

?>