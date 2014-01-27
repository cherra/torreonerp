
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
        <label class="col-sm-2">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Nombre comercial</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->nombre_comercial) ? $datos->nombre_comercial : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Contacto</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->contacto) ? $datos->contacto : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="tipo_pago">Forma de pago</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="tipo_pago" class="form-control">
                <option value="contado" <?php if(isset($datos->tipo_pago) && $datos->tipo_pago == 'contado') echo 'selected'; ?>>Contado</option>
                <option value="credito" <?php if(isset($datos->tipo_pago) && $datos->tipo_pago == 'credito') echo 'selected'; ?>>Crédito</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="vencimiento">Días de vencimiento</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="number" name="vencimiento" class="form-control" value="<?php echo (isset($datos->vencimiento) ? $datos->vencimiento : ''); ?>" placeholder="Días de vencimiento">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="limite_credito">Límite de crédito</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="number" name="limite_credito" class="form-control" value="<?php echo (isset($datos->limite_credito) ? $datos->limite_credito : ''); ?>" placeholder="Límite de crédito">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="id_ruta_cobranza">Ruta de cobranza</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="id_ruta_cobranza" class="form-control">
                <option value="" <?php if(isset($datos->id_ruta_cobranza) && $datos->id_ruta_cobranza == '0') echo 'selected'; ?>>Selecciona una ruta...</option>
                <?php
                if(isset($rutas)){
                    foreach($rutas as $ruta){
                        ?>
                        <option value="<?php echo $ruta->id_ruta_cobranza; ?>" <?php if(isset($datos->id_ruta_cobranza) && $datos->id_ruta_cobranza == $ruta->id_ruta_cobranza) echo 'selected'; ?>><?php echo $ruta->descripcion; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2">Días de cobro</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="checkbox" name="lun" value="s" <?php if(isset($datos->lun) && $datos->lun == 's') echo 'checked'; ?>>Lun
            <input type="checkbox" name="mar" value="s" <?php if(isset($datos->mar) && $datos->mar == 's') echo 'checked'; ?>>Mar
            <input type="checkbox" name="mie" value="s" <?php if(isset($datos->mie) && $datos->mie == 's') echo 'checked'; ?>>Mie
            <input type="checkbox" name="jue" value="s" <?php if(isset($datos->jue) && $datos->jue == 's') echo 'checked'; ?>>Jue
            <input type="checkbox" name="vie" value="s" <?php if(isset($datos->vie) && $datos->vie == 's') echo 'checked'; ?>>Vie
            <input type="checkbox" name="sab" value="s" <?php if(isset($datos->sab) && $datos->sab == 's') echo 'checked'; ?>>Sáb
            <input type="checkbox" name="dom" value="s" <?php if(isset($datos->dom) && $datos->dom == 's') echo 'checked'; ?>>Dom
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="deudor">Deudor</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="checkbox" name="deudor" value="s" <?php if(isset($datos->deudor) && $datos->deudor == 's') echo 'checked'; ?>>
        </div>
    </div>
<?php echo form_close(); ?>
