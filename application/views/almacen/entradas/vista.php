
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
        <label class="col-sm-2">Folio</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->id_entrada) ? $datos->id_entrada : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Fecha y hora</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->fecha) ? $datos->fecha : ''); ?> <?php echo (isset($datos->hora) ? $datos->hora : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Proveedor</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($proveedor->razon_social) ? $proveedor->razon_social : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Usuario</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($usuario->nombre) ? $usuario->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="cancelada">Cancelada?</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->cancelada) ? $datos->cancelada : ''); ?></p>
        </div>
    </div>
<?php echo form_close(); ?>
<div class="row">
    <div class="col-sm-12">
        <?php echo $table; ?>
    </div>
</div>
