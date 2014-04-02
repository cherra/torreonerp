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
        <label class="col-sm-2" for="cliente">Cliente</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($cliente) ? $cliente->nombre : ''); ?></p>
            <input type="hidden" name="id_cliente" value="<?php echo (isset($cliente) ? $cliente->id_cliente : ''); ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="id_articulo">Presentación</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <?php
            if(isset($presentaciones)){
            ?>
                <select name="id_articulo" id="id_articulo" class="form-control required">
                    <option value="">Selecciona un artículo...</option>
                    <?php
                        foreach($presentaciones as $p){ ?>
                            <option value="<?php echo $p->id_articulo; ?>" <?php if(isset($presentacion) && $presentacion->id_articulo == $p->id_articulo) echo "selected"; ?>><?php echo $p->nombre; ?></option>
                    <?php    }
                    ?>
                </select>
            <?php
            }else{
            ?>
                <p class="form-control-static"><?php echo (isset($presentacion) ? $presentacion->nombre : ''); ?></p>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="precio">Precio</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($precio) ? $precio->precio : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="descuento">Descuento</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" id="descuento" name="descuento" class="form-control required" value="<?php echo (isset($datos->descuento) ? $datos->descuento : ''); ?>" placeholder="Descuento">
        </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#descuento').focus();
    
    $('#id_articulo').change(function(){
        document.location = "<?php echo site_url('ventas/clientes/descuentos_agregar').'/'.$cliente->id_cliente.'/'.$offset.'/';  ?>"+$(this).val();
    });
    
});

</script>