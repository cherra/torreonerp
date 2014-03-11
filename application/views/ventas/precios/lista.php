<div class="row" style="margin-bottom: 10px;">
    <div class="col-xs-12">
        <?php echo anchor($link_back,'<span class="'.$this->config->item('icono_regresar').'"></span> Regresar'); ?>
    </div>
</div>
<?php echo form_open($action, array('class' => 'form-inline', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <label class="sr-only" for="id_lista">Lista</label>
        <select class="form-control" id="id_lista">
            <option value="">Selecciona una lista de precios...</option>
            <?php
            foreach($listas as $l){
                ?>
                <option value="<?php echo $l->id_lista; ?>" <?php if(isset($lista) && $lista->id_lista == $l->id_lista) echo "selected"; ?>><?php echo $l->nombre; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label class="sr-only" for="filtro">Filtros</label>
        <input type="text" class="form-control" name="filtro" id="filtro" placeholder="Filtros de busqueda" value="<?php if(isset($filtro)) echo $filtro; ?>" >
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><span class="<?php echo $this->config->item('icono_buscar'); ?>"></span></button>
    </div>
<?php echo form_close(); ?>
<div class="row">
    <div class="col-xs-12 col-sm-9 col-md-10">
        <?php if(isset($pagination))
            echo $pagination; ?>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-2">
        <?php if(isset($link_importar)){ ?>
        <p class="text-right">
            <?php echo anchor($link_importar,'<span class="'.$this->config->item('icono_upload').'"></span> Importar', array('class' => 'btn btn-default btn-block'));?>
        </p>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php if(isset($table))
            echo $table; ?>
    </div>
</div>
<script>
$(document).ready(function(){
    var url = "<?php echo site_url(); ?>/ventas/precios/index";

    $('#filtro').focus();
    
    $('#id_lista').change(function(){
        $(location).attr('href',url+'/'+$(this).val());
    });
});
</script>