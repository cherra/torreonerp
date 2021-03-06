<!-- La clase formulario se oculta en el template de para PDFs  -->
<div class="row formulario">
    <div class="col-xs-12 col-sm-6 col-md-4">
    <?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form')); ?>
        <div class="form-group">
            <label class="control-label hidden-xs col-sm-4" for="desde">Desde</label>
            <div class="col-sm-8">
                <input type="text" name="desde" id="desde" placeholder="Desde" class="form-control fecha required" value="<?php if(isset($desde)) echo $desde; ?>" >
            </div>
        </div>
        <div class="form-group">
            <label class="control-label hidden-xs col-sm-4" for="hasta">Hasta</label>
            <div class="col-sm-8">
                <input type="text" name="hasta" id="hasta" placeholder="Hasta" class="form-control fecha required" value="<?php if(isset($hasta)) echo $hasta; ?>" >
            </div>
        </div>
        <div class="form-group">
            <label class="control-label hidden-xs col-sm-4" for="tipo">Filtrar por:</label>
            <div class="col-sm-8">
                <select name="tipo" id="tipo" class="form-control required">
                    <option value="cliente" <?php if(isset($tipo) && $tipo == 'cliente') echo "selected"; ?>>Cliente</option>
                    <option value="usuario" <?php if(isset($tipo) && $tipo == 'usuario') echo "selected"; ?>>Cajero</option>
                    <option value="caja" <?php if(isset($tipo) && $tipo == 'caja') echo "selected"; ?>>Caja</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label hidden-xs col-sm-4" for="filtro">Filtros</label>
            <div class="col-sm-8">
                <input type="text" name="filtro" id="filtro" class="form-control" placeholder="Filtros de busqueda" value="<?php if(isset($filtro)) echo $filtro; ?>" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    <?php echo form_close(); ?>
    </div>
</div>
<!-- PDF generado  -->
<?php 
if(!empty($reporte)){
?>

<div class="row">
    <div class="col-sm-offset-10 col-sm-2">
        <?php echo form_open($action.'exportar', array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form')); ?>
        <div class="form-group pull-right">
            <input type="hidden" name="desde" id="desde" placeholder="Desde" class="form-control required" value="<?php if(isset($desde)) echo $desde; ?>" >
            <input type="hidden" name="hasta" id="hasta" placeholder="Hasta" class="form-control required" value="<?php if(isset($hasta)) echo $hasta; ?>" >
            <input type="hidden" name="tipo" id="tipo" placeholder="Tipo" class="form-control required" value="<?php if(isset($tipo)) echo $tipo; ?>" >
            <input type="hidden" name="filtro" id="filtro" class="form-control" placeholder="Filtros de busqueda" value="<?php if(isset($filtro)) echo $filtro; ?>" >
            <button type="submit" class="btn btn-default">Exportar</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <a id="informe_view" href="<?php echo asset_url().$this->configuracion->get_valor('tmp_path').$reporte; ?>"></a>
    </div>
</div>
<?php
}
?>

<script>
    $(document).ready(function(){
        $('#form').submit(function(event){
            $('#loadingModal').modal();
        });
        
        $('#informe_view').media({ width: '100%', height: 600, autoplay: true });
    });
</script>