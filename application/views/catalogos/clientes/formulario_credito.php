
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
        <label class="col-sm-2" for="tipo_pago">Forma de pago</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="tipo_pago" class="form-control">
                <option value="contado" <?php if(isset($datos->tipo_pago) && $datos->tipo_pago == 'contado') echo 'selected'; ?>>Contado</option>
                <option value="credito" <?php if(isset($datos->tipo_pago) && $datos->tipo_pago == 'credito') echo 'selected'; ?>>Crédito</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="vencimiento">Días de vencimiento</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="number" name="vencimiento" class="form-control" value="<?php echo (isset($datos->vencimiento) ? $datos->vencimiento : ''); ?>" placeholder="Días de vencimiento">
        </div>
    </div>
<?php echo form_close(); ?>
