<?php
require_once '../model/Socio.php';
require_once '../dao/SocioDAO.php';
class SocioController{
    public function buscarPorDocumento(){
        $documento = filter_input(INPUT_GET, 'documento');

        if(!$documento || empty($documento)){
            http_response_code(400);
            echo json_encode(['Erro' => 'O documento informado não é válido.']);exit;
        }

        try{
            $socioDao = new SocioDAO();
            $socio = $socioDao->buscarPorDocumento($documento);

            if(!$socio || is_null($socio)){
                echo json_encode(['Resultado' => 'Sócio não encontrado']);exit;
            }

            print_r($socio); //Averiguar a melhor maneira de retornar um sócio para o requisitante
        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(['Erro' => $e->getMessage()]);exit;
        }
    }
}