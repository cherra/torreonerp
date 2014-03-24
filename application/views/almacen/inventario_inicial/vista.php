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
    <?php if(isset($inventario_inicial)){ ?>
    <div class="form-group">
        <label class="col-sm-3">Inventario inicial</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo !empty($inventario_inicial->cantidad) ? $inventario_inicial->cantidad : ''; ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3">Fecha</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo !empty($inventario_inicial->fecha) ? $inventario_inicial->fecha : ''; ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3">Hora</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo !empty($inventario_inicial->hora) ? $inventario_inicial->hora : ''; ?></p>
        </div>
    </div>
    <?php } ?>
    
<?php echo form_close(); ?>
