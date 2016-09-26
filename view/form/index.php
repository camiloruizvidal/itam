<?php
include '../../controller/controller_form.php';
$form->plantilla  = 'prueba1.php';
$form->parametros = array('titulo' => 'aaa'/* ,'js' => array('bbb', 'style'),'css' => array('css', 'se') */);
$form->create();
?>
<#--content_ini--#>
<div class="panel panel-primary">
    <div class="panel-heading">
        prueba
    </div>
    <div class="panel-body">
        <?php
        echo (1 + 1);
        ?>
        <a href="./dos">Ir al dos</a>
    </div>
</div>
<#--content_fin--#>
