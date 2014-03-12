<?php
    if(isset($link_back)){
    ?>
    <div class="row">
        <div class="col-xs-6">
            <p><?php echo anchor($link_back,'<span class="'.$this->config->item('icono_regresar').'"></span> Regresar'); ?></p>
        </div>
    </div>
    <?php
    }
    ?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4">
<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <label class="control-label hidden-xs col-sm-2" for="desde">Desde</label>
        <div class="col-sm-10">
            <input type="text" name="desde" id="desde" placeholder="Desde" class="form-control fecha required" value="<?php if(isset($desde)) echo $desde; ?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label hidden-xs col-sm-2" for="hasta">Hasta</label>
        <div class="col-sm-10">
            <input type="text" name="hasta" id="hasta" placeholder="Hasta" class="form-control fecha required" value="<?php if(isset($hasta)) echo $hasta; ?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label hidden-xs col-sm-2" for="filtro">Filtros</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="filtro" id="filtro" placeholder="Filtros de busqueda" value="<?php if(isset($filtro)) echo $filtro; ?>" >
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
<?php
if(isset($table)){
?>
<div class="row">
    <div class="col-xs-12 col-sm-9 col-md-10">
        <?php echo $pagination; ?>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-2">
        <?php if(isset($link_add)){ ?>
        <p class="text-right"><?php echo anchor($link_add,'<span class="'.$this->config->item('icono_nuevo').'"></span> Nuevo', array('class' => 'btn btn-default btn-block')); ?></p>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php echo $table; ?>
    </div>
</div>
<?php
}
?>
<script>
$(document).ready(function(){
    var url = "<?php echo site_url($action); ?>";
    
    $('#filtro').focus();
    
    $('form').validate({
        errorClass: "has-error",
        validClass: "has-success",
        highlight: function(element, errorClass, validClass) {
            $(element).parent().parent().addClass(errorClass).fadeOut(function() {
              $(element).parent().parent().fadeIn();
            });
        },
        unhighlight: function(element, errorClass, validClass){
            $(element).parent().parent().removeClass(errorClass);
        },
        submitHandler: function(form){
            $('#form').attr('action',url+'/'+$('#desde').val()+'/'+$('#hasta').val());
            //$(location).attr('href',url+'/'+$('#desde').val()+'/'+$('#hasta').val());
            form.submit();
        }
    });
});
</script>