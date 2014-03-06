<!-- La clase formulario se oculta en el template de para PDFs  -->
<div class="row formulario">
    <div class="col-xs-12 col-sm-6 col-md-4">
    <?php echo form_open('', array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form')) ?>
        <div class="form-group">
            <label class="control-label hidden-phone" for="desde">Desde</label>
            <input type="text" name="desde" id="desde" placeholder="Desde" class="form-control fecha required" value="<?php if(isset($desde)) echo $desde; ?>" >
        </div>
        <div class="form-group">
            <label class="control-label hidden-phone" for="hasta">Hasta</label>
            <input type="text" name="hasta" id="hasta" placeholder="Hasta" class="form-control fecha required" value="<?php if(isset($hasta)) echo $hasta; ?>" >
        </div>
        <div class="form-group">
            <label class="control-label hidden-phone" for="filtro">Filtros</label>
            <input type="text" name="filtro" id="filtro" class="form-control" placeholder="Filtros de busqueda" value="<?php if(isset($filtro)) echo $filtro; ?>" >
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    <?php echo form_close(); ?>
    </div>
</div>
<!-- PDF generado  -->
<div class="row">
    <div class="col-xs-12">
        <a id="informe_view" href="<?php echo asset_url().$this->configuracion->get_valor('tmp_path').$reporte; ?>"></a>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#form').submit(function(event){
            $('#loadingModal').modal();
        });
        
        $('#informe_view').media({ width: '100%', height: 600, autoplay: true });
    });
</script>