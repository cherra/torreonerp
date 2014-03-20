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
        <label class="col-sm-3" for="stock">Control de inventario</label>
        <div class="col-sm-6 col-md-4">
            <input type="checkbox" name="stock" value="s" <?php 
            if(isset($datos->stock)){
                echo $datos->stock == 's' ? 'checked' : ''; 
            }
            ?>>
        </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>