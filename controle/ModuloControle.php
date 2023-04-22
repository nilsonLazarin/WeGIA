<?php
include_once '../classes/Modulo.php';
include_once '../dao/ModuloDAO.php';
class ModuloControle
{
    public function alterar_modulos_visiveis(){
        extract($_REQUEST);
        var_dump($_REQUEST);
        var_dump($_REQUEST['recurso']);
        try {
            $modulo = new ModuloDAO();
            $editar_visualizacao = $modulo->alterar_modulos_visiveis($recurso);
            header('Location:'.$nextPage.'?msg_c=Visualização atualizada com sucesso.');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}