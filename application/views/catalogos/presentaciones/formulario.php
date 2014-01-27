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
        <label class="col-sm-3" for="nombre">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" id="nombre" name="nombre" class="form-control required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="codigo">Código</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="codigo" class="form-control number" value="<?php echo (isset($datos->codigo) ? $datos->codigo : ''); ?>" placeholder="Código">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="tipo">Unidades</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="tipo" class="form-control required">
                <option value="peso" <?php if(isset($datos) && $datos->tipo == 'peso') echo "selected"; ?>>Peso</option>
                <option value="pieza" <?php if(isset($datos) && $datos->tipo == 'pieza') echo "selected"; ?>>Pieza</option>
            </select>
        </div>
    </div>
    <?php if(isset($lineas)){ ?>
    <div class="form-group">
        <label class="col-sm-3" for="id_linea">Linea</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="id_linea" class="form-control required">
                <option value="">Selecciona una linea...</option>
                <?php foreach($lineas as $linea){ ?>
                <option value="<?php echo $linea->id_linea; ?>" <?php if(isset($datos) && $datos->id_linea == $linea->id_linea) echo "selected"; ?>><?php echo $linea->nombre; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <?php } ?>
    <div class="form-group">
        <label class="col-sm-3" for="inventariado">Control de inventario</label>
        <div class="col-sm-6 col-md-4">
            <input type="checkbox" name="inventariado" value="s" <?php 
            if(isset($datos->inventariado)){
                echo $datos->inventariado == 's' ? 'checked' : ''; 
            }
            ?>>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="kg_pieza">Kilos por pieza</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="kg_pieza" class="form-control number" value="<?php echo (isset($datos->kg_pieza) ? $datos->kg_pieza : ''); ?>" placeholder="Kilos por pieza">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="factor_peso">Factor de peso</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="factor_peso" class="form-control number" value="<?php echo (isset($datos->factor_peso) ? $datos->factor_peso : ''); ?>" placeholder="Factor">
            <span class="help-block">Útil en el caso de paquetes, ej. si 1 unidad = 3.5kg entonces el factor de peso = 3.5</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="tipo_factor_peso">Tipo de factor</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="tipo_factor_peso" class="form-control required">
                <option value="factor" <?php if(isset($datos) && $datos->tipo_factor_peso == 'factor') echo "selected"; ?>>Factor</option>
                <option value="fijo" <?php if(isset($datos) && $datos->tipo_factor_peso == 'fijo') echo "selected"; ?>>Fijo</option>
            </select>
            <span class="help-block">Factor = se multiplica por la cantidad. Fijo = No importa la cantidad, siempre se aplica este factor.</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="iva">IVA</label>
        <div class="col-sm-6 col-md-4">
            <input type="checkbox" name="iva" value="s" <?php 
            if(isset($datos->iva)){
                echo $datos->iva == 's' ? 'checked' : ''; 
            }
            ?>>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="observaciones">Observaciones</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <textarea name="observaciones" class="form-control" placeholder="Observaciones" rows="4"><?php echo (isset($datos->observaciones) ? $datos->observaciones : ''); ?></textarea>
        </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>