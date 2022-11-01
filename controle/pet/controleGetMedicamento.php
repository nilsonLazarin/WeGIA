<?php

require_once '../../classes/session.php';
require_once './MedicamentoControle.php';

$c = new MedicamentoControle();

$p = $c->listarMedicamento();

echo json_encode($p);