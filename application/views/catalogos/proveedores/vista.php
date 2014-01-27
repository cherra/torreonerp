
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
        <label class="col-sm-2" for="razon_social">Razón social</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->razon_social) ? $datos->razon_social : ''); ?></p>
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
        <label class="col-sm-2" for="ciudad">Ciudad</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->ciudad) ? $datos->ciudad : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="estado">Estado</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->estado) ? $datos->estado : ''); ?></p>
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
        <label class="col-sm-2" for="fax">Fax</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->fax) ? $datos->fax : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="email">E-mail</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->email) ? $datos->email : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="tipo">Tipo</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->tipo) ? $datos->tipo : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="tipo_pago">Tipo de pago</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->tipo_pago) ? $datos->tipo_pago : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="dias_credito">Días de crédito</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->dias_credito) ? $datos->dias_credito : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="cuenta_contable">Cuenta contable</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->cuenta_contable) ? $datos->cuenta_contable : ''); ?></p>
        </div>
    </div>
<?php echo form_close(); ?>
