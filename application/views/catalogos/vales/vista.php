
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
        <label class="col-sm-2" for="concepto">Descripción</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->concepto) ? $datos->concepto : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="codigo_barras">Código de barras</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="checkbox" <?php if(isset($datos->codigo_barras) && $datos->codigo_barras == 's') echo 'checked'; ?> disabled />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="tipo">Tipo</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->tipo) ? ucfirst($datos->tipo) : ''); ?></p>
        </div>
    </div>
<?php echo form_close(); ?>
