
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
    <div class="form-group">
        <label class="col-sm-2">Límite de crédito</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->limite_credito) ? number_format($datos->limite_credito,2) : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Ruta de cobranza</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($ruta_cobranza->descripcion) ? $ruta_cobranza->descripcion : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Días de cobro</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="checkbox" value="" <?php if(isset($datos->lun) && $datos->lun == 's') echo 'checked'; ?> disabled>Lun
            <input type="checkbox" value="" <?php if(isset($datos->mar) && $datos->mar == 's') echo 'checked'; ?> disabled>Mar
            <input type="checkbox" value="" <?php if(isset($datos->mie) && $datos->mie == 's') echo 'checked'; ?> disabled>Mie
            <input type="checkbox" value="" <?php if(isset($datos->jue) && $datos->jue == 's') echo 'checked'; ?> disabled>Jue
            <input type="checkbox" value="" <?php if(isset($datos->vie) && $datos->vie == 's') echo 'checked'; ?> disabled>Vie
            <input type="checkbox" value="" <?php if(isset($datos->sab) && $datos->sab == 's') echo 'checked'; ?> disabled>Sáb
            <input type="checkbox" value="" <?php if(isset($datos->dom) && $datos->dom == 's') echo 'checked'; ?> disabled>Dom
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Deudor</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="checkbox" value="" <?php if(isset($datos->deudor) && $datos->deudor == 's') echo 'checked'; ?> disabled>
        </div>
    </div>
<?php echo form_close(); ?>
