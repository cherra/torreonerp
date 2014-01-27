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
        <label class="col-sm-2" for="nombre">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" id="nombre" name="nombre" class="form-control required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="nombre_comercial">Nombre comercial</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="nombre_comercial" class="form-control" value="<?php echo (isset($datos->nombre_comercial) ? $datos->nombre_comercial : ''); ?>" placeholder="Nombre comercial">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="contacto">Contacto</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="contacto" class="form-control" value="<?php echo (isset($datos->contacto) ? $datos->contacto : ''); ?>" placeholder="Contacto">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="rfc">R.F.C.</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="rfc" class="form-control" value="<?php echo (isset($datos->rfc) ? $datos->rfc : ''); ?>" placeholder="R.F.C.">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="domicilio">Domicilio</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="domicilio" class="form-control required" value="<?php echo (isset($datos->domicilio) ? $datos->domicilio : ''); ?>" placeholder="Domicilio">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="colonia">Colonia</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="colonia" class="form-control required" value="<?php echo (isset($datos->colonia) ? $datos->colonia : ''); ?>" placeholder="Colonia">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="ciudad_estado">Ciudad y estado</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="ciudad_estado" class="form-control required" value="<?php echo (isset($datos->ciudad_estado) ? $datos->ciudad_estado : ''); ?>" placeholder="Ciudad y estado">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="entre_calles">Entre calles</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="entre_calles" class="form-control" value="<?php echo (isset($datos->entre_calles) ? $datos->entre_calles : ''); ?>" placeholder="Entre calles">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="cp">Código postal</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="number" name="cp" class="form-control" value="<?php echo (isset($datos->cp) ? $datos->cp : ''); ?>" placeholder="Código postal">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2" for="telefono">Teléfono</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="number" name="telefono" class="form-control required" value="<?php echo (isset($datos->telefono) ? $datos->telefono : ''); ?>" placeholder="Teléfono">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="telefono2">Teléfono 2</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="number" name="telefono2" class="form-control" value="<?php echo (isset($datos->telefono2) ? $datos->telefono2 : ''); ?>" placeholder="Teléfono 2" >
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="telefono3">Teléfono 3</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="number" name="telefono3" class="form-control" value="<?php echo (isset($datos->telefono3) ? $datos->telefono3 : ''); ?>" placeholder="Teléfono 3">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="id_lista">Lista de precios</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="id_lista" class="form-control required">
                <option value="">Selecciona una lista...</option>
                <?php
                if(isset($listas)){
                    foreach($listas as $lista){ ?>
                        <option value="<?php echo $lista->id_lista; ?>" <?php if(isset($datos) && $datos->id_lista == $lista->id_lista) echo "selected"; ?>><?php echo $lista->nombre; ?></option>
                <?php    }
                }
                ?>
            </select>
        </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>