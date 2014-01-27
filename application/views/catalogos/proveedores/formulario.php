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
        <label class="col-sm-2" for="razon_social">Razón social</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" id="razon_social" name="razon_social" class="form-control required" value="<?php echo (isset($datos->razon_social) ? $datos->razon_social : ''); ?>" placeholder="Razón social">
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
        <label class="col-sm-2" for="ciudad">Ciudad</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="ciudad" class="form-control required" value="<?php echo (isset($datos->ciudad) ? $datos->ciudad : ''); ?>" placeholder="Ciudad">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="estado">Estado</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="estado" class="form-control required" value="<?php echo (isset($datos->estado) ? $datos->estado : ''); ?>" placeholder="Estado">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="cp">Código postal</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="cp" class="form-control" value="<?php echo (isset($datos->cp) ? $datos->cp : ''); ?>" placeholder="Código postal">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2" for="telefono">Teléfono</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="telefono" class="form-control required" value="<?php echo (isset($datos->telefono) ? $datos->telefono : ''); ?>" placeholder="Teléfono">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="telefono2">Teléfono 2</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="telefono2" class="form-control" value="<?php echo (isset($datos->telefono2) ? $datos->telefono2 : ''); ?>" placeholder="Teléfono 2">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="fax">Fax</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="fax" class="form-control" value="<?php echo (isset($datos->fax) ? $datos->fax : ''); ?>" placeholder="Fax">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="email">E-mail</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="email" class="form-control" value="<?php echo (isset($datos->email) ? $datos->email : ''); ?>" placeholder="E-mail">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="tipo">Tipo</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="tipo" class="form-control required">
                <option value="compras" <?php if(isset($datos->tipo) && $datos->tipo == 'compras') echo "selected"; ?>>Compras</option>
                <option value="servicios" <?php if(isset($datos->tipo) && $datos->tipo == 'servicios') echo "selected"; ?>>Servicios</option> 
                <option value="servicios_compras" <?php if(isset($datos->tipo) && $datos->tipo == 'servicios_compras') echo "selected"; ?>>Servicios y compras</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="tipo_pago">Tipo de pago</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="tipo_pago" class="form-control required">
                <option value="efectivo" <?php if(isset($datos->tipo) && $datos->tipo == 'efectivo') echo "selected"; ?>>Efectivo</option>
                <option value="cheque" <?php if(isset($datos->tipo) && $datos->tipo == 'cheque') echo "selected"; ?>>Cheque</option> 
                <option value="transferencia" <?php if(isset($datos->tipo) && $datos->tipo == 'transferencia') echo "selected"; ?>>Transferencia</option>
                <option value="efectivo_cheque" <?php if(isset($datos->tipo) && $datos->tipo == 'efectivo_cheque') echo "selected"; ?>>Efectivo o cheque</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="dias_credito">Días de crédito</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="dias_credito" class="form-control" value="<?php echo (isset($datos->dias_credito) ? $datos->dias_credito : ''); ?>" placeholder="Días de crédito">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="cuenta_contable">Cuenta contable</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="cuenta_contable" class="form-control" value="<?php echo (isset($datos->cuenta_contable) ? $datos->cuenta_contable : ''); ?>" placeholder="Cuenta contable">
        </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#razon_social').focus();
    
});

</script>