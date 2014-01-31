
<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <div class="col-xs-6">
            <p><?php echo anchor($link_back,'<span class="'.$this->config->item('icono_regresar').'"></span> Regresar'); ?></p>
        </div>
        <div class="col-xs-6">
            <button type="submit" id="editar" class="btn btn-warning pull-right"><span class="<?php echo $this->config->item('icono_editar'); ?>"></span> Editar</button>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Número</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->id_cliente) ? $datos->id_cliente : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Nombre comercial</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->nombre_comercial) ? $datos->nombre_comercial : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Contacto</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->contacto) ? $datos->contacto : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Forma de pago</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->tipo_pago) ? $datos->tipo_pago : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Días de vencimiento</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->vencimiento) ? $datos->vencimiento : ''); ?></p>
        </div>
    </div>
<?php echo form_close(); ?>
