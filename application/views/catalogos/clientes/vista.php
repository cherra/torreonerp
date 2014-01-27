
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
        <label class="col-sm-2">Número</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->id_cliente) ? $datos->id_cliente : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="nombre">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="nombre_comercial">Nombre comercial</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->nombre_comercial) ? $datos->nombre_comercial : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="contacto">Contacto</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->contacto) ? $datos->contacto : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="rfc">R.F.C.</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->rfc) ? $datos->rfc : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="domicilio">Domicilio</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->domicilio) ? $datos->domicilio : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="colonia">Colonia</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->colonia) ? $datos->colonia : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="ciudad_estado">Ciudad y estado</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->ciudad_estado) ? $datos->ciudad_estado : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="entre_calles">Entre calles</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->entre_calles) ? $datos->entre_calles : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="cp">Código postal</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->cp) ? $datos->cp : ''); ?></p>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2" for="telefono">Teléfono</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->telefono) ? $datos->telefono : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="telefono2">Teléfono 2</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->telefono2) ? $datos->telefono2 : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="telefono3">Teléfono 3</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->telefono3) ? $datos->telefono3 : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="id_lista">Lista de precios</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($lista) ? $lista->nombre : ''); ?></p>
        </div>
    </div>
<?php echo form_close(); ?>
