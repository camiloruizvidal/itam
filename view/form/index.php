<?php
include '../../controller/controller_form.php';
$form->create_formulario('prueba1.php'
        /* , 
          array('titulo' => 'aaa',
          'js' => array('bbb', 'style'),
          'css' => array('css', 'se')) */
);
?>

<#--content_ini--#>
<div class="panel panel-primary">
    <div class="panel-heading">
        prueba
    </div>
    <div class="panel-body">
        <?php echo (1 + 1); ?>
    </div>
</div>
<#--content_fin--#>
