<?php echo form_open_multipart($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo anchor($link_back,'<span class="'.$this->config->item('icono_regresar').'"></span> Regresar'); ?>
        </div>
        <div class="col-xs-6">
            <button type="submit" id="guardar" class="btn btn-primary pull-right"><span class="<?php echo $this->config->item('icono_guardar'); ?>"></span> Guardar</button>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="lista">Lista</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($lista) ? $lista->nombre : ''); ?></p>
            <input type="hidden" name="id_lista" value="<?php echo (isset($lista) ? $lista->id_lista : ''); ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="precio">Archivo</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="file" name="lista" class="required" />
            <span class="help-block">Archivo CSV con dos campos por linea: código y precio. Ej. 5040,140</span>
        </div>
    </div>
<?php echo form_close(); ?>