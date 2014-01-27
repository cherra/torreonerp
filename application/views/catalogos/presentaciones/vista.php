
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
    <div class="form-group">
        <label class="col-sm-3" for="inventariado">Control de inventario</label>
        <div class="col-sm-6 col-md-4">
            <input type="checkbox" name="inventariado" disabled <?php 
            if(isset($datos->inventariado)){
                echo $datos->inventariado == 's' ? 'checked' : ''; 
            }
            ?>>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="kg_pieza">Kilos por pieza</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->kg_pieza) ? $datos->kg_pieza : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="factor_peso">Factor de peso</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->factor_peso) ? $datos->factor_peso : ''); ?></p>
            <span class="help-block">Útil en el caso de paquetes, ej. si 1 unidad = 3.5kg entonces el factor de peso = 3.5</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="tipo_factor_peso">Tipo de factor</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->tipo_factor_peso) ? ucfirst($datos->tipo_factor_peso) : ''); ?></p>
            <span class="help-block">Factor = se multiplica por la cantidad. Fijo = No importa la cantidad, siempre se aplica este factor.</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="iva">IVA</label>
        <div class="col-sm-6 col-md-4">
            <input type="checkbox" name="iva" disabled <?php 
            if(isset($datos->iva)){
                echo $datos->iva == 's' ? 'checked' : ''; 
            }
            ?>>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="observaciones">Observaciones</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->observaciones) ? $datos->observaciones : ''); ?></p>
        </div>
    </div>
    
<?php echo form_close(); ?>
