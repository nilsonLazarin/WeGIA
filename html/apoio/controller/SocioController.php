<?php
require_once '../model/Socio.php';
require_once '../dao/SocioDAO.php';
require_once '../helper/Util.php';
class SocioController
{
    /**
     * Extraí o documento de um sócio da requisição e retorna os dados pertecentes a esse sócio.
     */
    public function buscarPorDocumento()
    {
        $documento = filter_input(INPUT_GET, 'documento');

        if (!$documento || empty($documento)) {
            http_response_code(400);
            echo json_encode(['Erro' => 'O documento informado não é válido.']);
            exit;
        }

        try {
            $socioDao = new SocioDAO();
            $socio = $socioDao->buscarPorDocumento($documento);

            if (!$socio || is_null($socio)) {
                echo json_encode(['resultado' => 'Sócio não encontrado']);
                exit;
            }

            //print_r($socio); //Averiguar a melhor maneira de retornar um sócio para o requisitante
            echo json_encode(['resultado' => $socio]);
            exit();
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['Erro' => $e->getMessage()]);
            exit;
        }
    }

    /**
     * Extraí o documento de um sócio da requisição e retorna a lista dos boletos pertecentes a esse sócio.
     */
    public function exibirBoletosPorCpf()
    {

        // Extrair dados da requisição
        $doc = trim($_GET['documento']);
        $docLimpo = preg_replace('/\D/', '', $doc);

        // Caminho para o diretório de PDFs
        $path = '../pdfs/';

        // Listar arquivos no diretório
        $arrayBoletos = Util::listarArquivos($path);

        if (!$arrayBoletos) {
            $mensagemErro = json_encode(['erro' => 'O diretório de armazenamento de PDFs não existe']);
            echo $mensagemErro;
            exit();
        }

        $boletosEncontrados = [];

        foreach ($arrayBoletos as $boleto) {
            // Extrair o documento do nome do arquivo
            $documentoArquivo = explode('_', $boleto)[1];
            if ($documentoArquivo == $docLimpo) {
                $boletosEncontrados[] = $boleto;
            }
        }

        // Retornar JSON com os boletos encontrados
        echo json_encode($boletosEncontrados);
    }
}
