<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo anchor($link_back,'<span class="'.$this->config->item('icono_regresar').'"></span> Regresar'); ?>
        </div>
        <div class="col-xs-6">
            <button type="submit" id="guardar" class="btn btn-primary pull-right"><span class="<?php echo $this->config->item('icono_guardar'); ?>"></span> Guardar</button>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Folio</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->id_venta) ? $datos->id_venta : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Fecha y hora</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->fecha) ? $datos->fecha : ''); ?> <?php echo (isset($datos->hora) ? $datos->hora : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Cliente</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($cliente->nombre) ? $cliente->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Caja</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($caja->nombre) ? $caja->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Usuario</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($usuario->nombre) ? $usuario->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="cancelada">Cancelada?</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="radio" name="cancelada" value="n" <?php echo (isset($datos->cancelada) && $datos->cancelada == 'n' ? 'checked' : ''); ?>>No
            <input type="radio" name="cancelada" value="s" <?php echo (isset($datos->cancelada) && $datos->cancelada == 's' ? 'checked' : ''); ?>>Si
        </div>
    </div>
<?php echo form_close(); ?>
<div class="row">
    <div class="col-sm-12">
        <?php echo $table; ?>
    </div>
</div>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>