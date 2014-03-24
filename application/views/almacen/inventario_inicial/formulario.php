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
        <label class="col-sm-3">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3">Código</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->codigo) ? $datos->codigo : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="tipo">Unidades</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->tipo) ? ucfirst($datos->tipo) : ''); ?></p>
        </div>
    </div>
    <?php if(isset($linea)){ ?>
    <div class="form-group">
        <label class="col-sm-3">Linea</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo $linea->nombre; ?></p>
        </div>
    </div>
    <?php } ?>
    <div class="form-group">
        <label class="col-sm-3">Inventario inicial</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="cantidad" id="cantidad" class="form-control number" value="<?php echo (isset($inventario_inicial->cantidad) ? $inventario_inicial->cantidad : ''); ?>" placeholder="Cantidad">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3">Fecha</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="fecha" class="form-control fecha" value="<?php echo (isset($inventario_inicial->fecha) ? $inventario_inicial->fecha : ''); ?>" placeholder="Fecha">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3">Hora</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="hora" class="form-control hora" value="<?php echo (isset($inventario_inicial->hora) ? $inventario_inicial->hora : ''); ?>" placeholder="Hora">
        </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#cantidad').focus();
    
});

</script>