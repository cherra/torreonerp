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
        <label class="col-sm-2" for="concepto">Descripción</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" id="concepto" name="concepto" class="form-control required" value="<?php echo (isset($datos->concepto) ? $datos->concepto : ''); ?>" placeholder="Descripción">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="codigo_barras">Código de barras</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="checkbox" name="codigo_barras" value="s" <?php if(isset($datos->codigo_barras) && $datos->codigo_barras == 's') echo 'checked'; ?> />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="tipo">Tipo</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="tipo" class="form-control">
                <option value="salida" <?php if(isset($datos->tipo) && $datos->tipo == 'salida') echo 'selected'; ?>>Salida</option>
                <option value="entrada" <?php if(isset($datos->tipo) && $datos->tipo == 'entrada') echo 'selected'; ?>>Entrada</option>
            </select>
        </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#concepto_pago').focus();
    
});

</script>