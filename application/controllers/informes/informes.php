<?php
/**
 * Description of ventas
 *
 * @author cherra
 */
class Informes extends CI_Controller{
    
    public $layout = 'template_backend';
    private $template = '';
    private $folder = 'informes/';
    private $clase = 'informes/';
    
    function __construct() {
        parent::__construct();
        $this->template = $this->load->file(APPPATH . 'views/templates/template_pdf.php', true);
        
        ini_set('memory_limit', '-1');
    }
    
    public function index(){
        $this->load->view('informes/informes');
    }
    
    public function salidas( $exportar = NULL ){
        $data['reporte'] = '';
        $data['action'] = $this->folder.$this->clase.'salidas/';
        
        if( ($post = $this->input->post()) ){
            date_default_timezone_set('America/Mexico_City'); // Zona horaria
            $desde = date_create($post['desde']);
            $hasta = date_create($post['hasta']);
            
            //$data['export_link'] = $this->folder.$this->clase.'ventas/'.$post['desde'].'/'.$post['hasta'].'/'.$filtro.'/exportar';
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('salida','v');
            $ventas = $this->v->get_by_fecha( $post['desde'], $post['hasta'], $post['filtro'] )->result();
            
            if(empty($exportar)){
                // generar tabla
                $this->load->library('table');
                $this->table->set_empty('&nbsp;');

                $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
                $this->table->set_template($tmpl);
                $this->table->set_heading('Folio', 'Fecha', 'Caja', 'Cajero', 'Cliente', 'Cantidad');
                $total = $total_vigentes = $total_canceladas = $total_caja = $total_caja_canceladas = 0;
                $estatus = 'n';
                $clase = '';
                $caja = '';
                foreach ($ventas as $v){

                    if($caja != '' && $caja != $v->caja){
                        if($v->cancelada == 'n' OR $estatus != $v->cancelada){
                            $this->table->add_row( '', '', '', '<h6>Total caja</h6>', array('data' => '<h6>'.number_format($total_caja,2).'</h6>', 'style' => 'text-align: right;'));
                            $this->table->add_row_class($clase);
                            $this->table->add_row( array('data' => '', 'colspan' => '5'));
                            $this->table->add_row_class($clase);
                            $total_caja = 0;
                        }
                    }
                    $caja = $v->caja;
                    
                    if($v->cancelada == 's'){
                        $clase = 'cancelado';
                        $total_canceladas += $v->cantidad;
                    }else{
                        $clase = '';
                        $total_vigentes += $v->cantidad;
                        $total_caja += $v->cantidad;
                    }

                    if($estatus != $v->cancelada){
                        // Total de facturas vigentes
                        if($v->cancelada == 's'){
                            $this->table->add_row( '', '', '', '<h5>Total</h5>', array('data' => '<h5>'.number_format($total_vigentes,2).'</h5>', 'style' => 'text-align: right;'));
                            $this->table->add_row_class($clase);
                            $total_vigentes = 0;

                            $this->table->add_row( array('data' => '', 'colspan' => '5'));
                            $this->table->add_row_class($clase);
                            $this->table->add_row( array('data' => 'CANCELADAS', 'colspan' => '5'));
                            $this->table->add_row_class($clase);
                        }else{
                            // Total de facturas canceladas
                            $this->table->add_row( '', '', '', 'Total canceladas', array('data' => number_format($total_canceladas,2), 'style' => 'text-align: right;'));
                            $this->table->add_row_class('info text-error');
                            $total_canceladas = 0;
                        }
                        $estatus = $v->cancelada;
                    }

                    

                    $fecha = date_create($v->fecha);
                    $this->table->add_row(
                        array('data' => $v->id_venta,'class' => $clase),
                        array('data' => date_format($fecha,'d/m/Y'),'class' => $clase),
                        array('data' => $v->caja,'class' => $clase),
                        array('data' => $v->usuario,'class' => $clase),
                        array('data' => $v->nombre,'class' => $clase),
                        array('data' => number_format($v->cantidad,2), 'style' => 'text-align: right;', 'class' => $clase)
                    );

                    $this->table->add_row_class($clase);

                    $total += $v->cantidad;
                }

                if($estatus == 'n'){
                    // Total de facturas vigentes
                    $this->table->add_row( '', '', '', '<h5>Total</h5>', array('data' => '<h5>'.number_format($total_vigentes,2).'</h5>', 'style' => 'text-align: right;'));
                    $this->table->add_row_class($clase);
                }

                // Total de facturas canceladas
                $this->table->add_row( '', '', '', 'Total canceladas', array('data' => number_format($total_canceladas,2), 'style' => 'text-align: right;'));
                $this->table->add_row_class('info text-error');

                $this->table->add_row( array('data' => '', 'colspan' => '5'));
                $this->table->add_row_class($clase);

                $tabla = $this->table->generate();
            
                $this->load->library('tbs');
                $this->load->library('pdf');

                // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
                $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

                // Se sustituyen los campos en el template
                $this->tbs->VarRef['titulo'] = 'Reporte de salidas de almacén';
                $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
                $this->tbs->VarRef['database'] = $this->session->userdata('basededatos');
                $this->tbs->VarRef['subtitulo'] = 'Del '.date_format($desde, 'd/m/Y').' al '.date_format($hasta, 'd/m/Y');
                $this->tbs->VarRef['contenido'] = $tabla;

                $this->tbs->Show(TBS_NOTHING);

                // Se regresa el render
                $output = $this->tbs->Source;

                $view = str_replace("{contenido_vista}", $output, $this->template);

                // PDF
                $this->pdf->pagenumSuffix = '/';
                $this->pdf->SetHeader('{PAGENO}{nbpg}');
                $pdf = $this->pdf->render($view);
                //$pdf = $view;

                $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'salidas_listado.pdf','w');
                fwrite($fp, $pdf);
                fclose($fp);
                $data['reporte'] = 'salidas_listado.pdf';
            }else{
                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('Reporte de salidas de almacén');
                
                $this->excel->getActiveSheet()->setCellValue('A1', 'Folio');
                $this->excel->getActiveSheet()->setCellValue('B1', 'Fecha');
                $this->excel->getActiveSheet()->setCellValue('C1', 'Caja');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Cajero');
                $this->excel->getActiveSheet()->setCellValue('E1', 'Cliente');
                $this->excel->getActiveSheet()->setCellValue('F1', 'Importe');
                
                $fila = 2;
                $estatus = 'n';
                foreach($ventas as $v){
                    if($v->cancelada != $estatus){
                        $this->excel->getActiveSheet()->setCellValue('A'.$fila, 'Canceladas');
                        $fila++;
                        $estatus = $v->cancelada;
                    }
                    $fecha = date_create($v->fecha);
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, $v->id_venta);
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, date_format($fecha,'d/m/Y'));
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, $v->caja);
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, $v->usuario);
                    $this->excel->getActiveSheet()->setCellValue('E'.$fila, $v->nombre);
                    $this->excel->getActiveSheet()->setCellValue('F'.$fila, $v->cantidad);
                    
                    $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                    $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                
                    $fila++;
                }
                //set cell A1 content with some text
//                $this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
//                //change the font size
//                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
//                //make the font become bold
//                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
//                //merge cell A1 until D1
//                $this->excel->getActiveSheet()->mergeCells('A1:D1');
//                //set aligment to center for that merged cell (A1 to D1)
//                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $filename='reporte_de_salidas.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache

                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');
            }
        }
        $data['titulo'] = 'Reporte de salidas de almacén <small>Listado</small>';
        $this->load->view('informes/listado', $data);
    }
    
    public function recibos_listado(){
        $data['reporte'] = '';
        if( ($post = $this->input->post()) ){
            
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('recibo','r');
            $recibos = $this->r->get_by_fecha( $post['desde'].' 00:00:00', $post['hasta'].' 23:59:59', $post['filtro'] )->result();
            
            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            
            $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Número', 'Fecha', 'Contrato', 'Cliente', 'Importe');
            $total = $total_vigentes = $total_canceladas = 0;
            $estatus = 'vigente';
            $clase = '';
            foreach ($recibos as $r){
                if($r->estado == 'cancelado'){
                    $clase = 'cancelado';
                    $total_canceladas += $r->total;
                }else{
                    $clase = '';
                    $total_vigentes += $r->total;
                }
                if($estatus != $r->estado){
                    // Total de recibos vigentes
                    $this->table->add_row( '', '', '', '<h5>Total</h5>', array('data' => '<h5>'.number_format($total_vigentes,2).'</h5>', 'style' => 'text-align: right;'));
                    $this->table->add_row_class($clase);
                    $estatus = $r->estado;
                    
                    $this->table->add_row( array('data' => '', 'colspan' => '5'));
                    $this->table->add_row_class($clase);
                    $this->table->add_row( array('data' => 'CANCELADOS', 'colspan' => '5'));
                    $this->table->add_row_class($clase);
                }
                $fecha = date_create($r->fecha);
                $this->table->add_row(
                    array('data' => $r->numero,'class' => $clase),
                    array('data' => date_format($fecha,'d/m/Y'),'class' => $clase),
                    array('data' => $r->contrato,'class' => $clase),
                    array('data' => $r->cliente,'class' => $clase),
                    array('data' => number_format($r->total,2), 'style' => 'text-align: right;', 'class' => $clase)
    		);
                
                $this->table->add_row_class($clase);
                
                $total += $r->total;
            }
            if($estatus == 'vigente'){
                // Total de recibos vigentes
                $this->table->add_row( '', '', '', '<h5>Total</h5>', array('data' => '<h5>'.number_format($total_vigentes,2).'</h5>', 'style' => 'text-align: right;'));
                $this->table->add_row_class($clase);
            }
            // Total de facturas canceladas
            $this->table->add_row( '', '', '', 'Total cancelados', array('data' => number_format($total_canceladas,2), 'style' => 'text-align: right;'));
            $this->table->add_row_class('info text-error');
            
            $this->table->add_row( array('data' => '', 'colspan' => '5'));
            $this->table->add_row_class($clase);
            // Total
            //$this->table->add_row( '', '', '', '<strong>TOTAL</strong>', array('data' => '<strong>'.number_format($total,2).'</strong>', 'style' => 'text-align: right;'));
            //$this->table->add_row_class('info');
            
            $tabla = $this->table->generate();
            
            //$tabla.= '</tbody></table>';
            $this->load->library('tbs');
            $this->load->library('pdf');
            
            // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Listado de recibos';
            date_default_timezone_set('America/Mexico_City'); // Zona horaria
            $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
            $desde = date_create($post['desde']);
            $hasta = date_create($post['hasta']);
            $this->tbs->VarRef['subtitulo'] = 'Del '.date_format($desde, 'd/m/Y').' al '.date_format($hasta, 'd/m/Y');
            $this->tbs->VarRef['contenido'] = $tabla;
            
            $this->tbs->Show(TBS_NOTHING);
            
            // Se regresa el render
            $output = $this->tbs->Source;
            
            $view = str_replace("{contenido_vista}", $output, $this->template);
            
            // PDF
            $pdf = $this->pdf->render($view,'Letter',null,true);
            //$pdf = $view;
            
            $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'recibos_listado.pdf','w');
            fwrite($fp, $pdf);
            fclose($fp);
            $data['reporte'] = 'recibos_listado.pdf';
        }
        $data['titulo'] = 'Informe de recibos <small>Listado</small>';
        $this->load->view('informes/listado', $data);
    }
    
    public function contratos_listado(){
        $data['reporte'] = '';
        if( ($post = $this->input->post()) ){
            
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('contrato','c');
            $this->load->library('rango');

            $contratos = $this->c->get_by_fecha( $post['desde'].' 00:00:00', $post['hasta'].' 23:59:59', $post['filtro'] )->result();
            
            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            
            $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Número', 'Fecha', 'Cliente', 'Calle', 'Módulos', array('data' => 'Total', 'style' => 'text-align: right;'));
            $total = $total_vigentes = $total_canceladas = 0;
            $estatus = 'autorizado';
            $clase = '';
            $contrato = '';
            foreach ($contratos as $c){
                $importe = $this->c->get_importe($c->id);
                if($c->estado == 'cancelado'){
                    $clase = 'cancelado';
                    $total_canceladas += $importe;
                }else{
                    $clase = '';
                    $total_vigentes += $importe;
                }
                if($estatus != $c->estado){
                    // Total de recibos vigentes
                    $this->table->add_row( '', '', '', array('data' => '<h5>Total</h5>', 'colspan' => '2'), array('data' => '<h5>'.number_format($total_vigentes,2).'</h5>', 'style' => 'text-align: right;'));
                    $this->table->add_row_class($clase);
                    $estatus = $c->estado;
                    
                    $this->table->add_row( array('data' => '', 'colspan' => '6'));
                    $this->table->add_row_class($clase);
                    $this->table->add_row( array('data' => 'CANCELADOS', 'colspan' => '6'));
                    $this->table->add_row_class($clase);
                }
                $fecha = date_create($c->fecha);
                $modulos_contrato = $this->c->get_modulos_agrupados($c->id)->result();
                $calles = '';
                $modulos = '';
                $i = 0;
                foreach($modulos_contrato as $m){
                    if($i > 0){
                        $calles .= '<br>';
                        $modulos .= '<br>';
                    }
                    $calles .= $m->calle;
                    $arreglo = explode(', ',$m->modulo);
                    $modulos .= $this->rango->array_to_rango($arreglo);
                    $i++;
                }
                
                //if($contrato != $c->id){
                    $this->table->add_row(
                        array('data' => $c->numero.'/'.$c->sufijo,'class' => $clase),
                        array('data' => date_format($fecha,'d/m/Y'),'class' => $clase),
                        array('data' => $c->cliente,'class' => $clase),
                        array('data' => $calles,'class' => $clase),
                        array('data' => $modulos,'class' => $clase),
                        array('data' => number_format($importe,2), 'style' => 'text-align: right;', 'class' => $clase)
                    );
                /*}else{
                    $this->table->add_row('','','',
                        array('data' => $c->calle,'class' => $clase),
                        array('data' => $rango,'class' => $clase),
                        ''
                    );
                }*/
                
                $contrato = $c->id;
                $this->table->add_row_class($clase);
                
                $total += $importe;
            }
            
            if($estatus == 'autorizado'){
                // Total de recibos vigentes
                $this->table->add_row( '', '', '', array('data' => '<h5>Total</h5>', 'colspan' => '2'), array('data' => '<h5>'.number_format($total_vigentes,2).'</h5>', 'style' => 'text-align: right;'));
                $this->table->add_row_class($clase);
            }
            
            // Total de facturas canceladas
            $this->table->add_row( '', '', '', array('data' => 'Total cancelados', 'colspan' => '2'), array('data' => number_format($total_canceladas,2), 'style' => 'text-align: right;'));
            $this->table->add_row_class('info text-error');
            
            $this->table->add_row( array('data' => '', 'colspan' => '6'));
            $this->table->add_row_class($clase);
            // Total
            //$this->table->add_row( '', '', '', array('data' => '<strong>TOTAL</strong>', 'colspan' => '2' ), array('data' => '<strong>'.number_format($total,2).'</strong>', 'style' => 'text-align: right;'));
            //$this->table->add_row_class('info');
            
            $tabla = $this->table->generate();
            
            //$tabla.= '</tbody></table>';
            $this->load->library('tbs');
            $this->load->library('pdf');
            
            // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Listado de contratos';
            date_default_timezone_set('America/Mexico_City'); // Zona horaria
            $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
            $desde = date_create($post['desde']);
            $hasta = date_create($post['hasta']);
            $this->tbs->VarRef['subtitulo'] = 'Del '.date_format($desde, 'd/m/Y').' al '.date_format($hasta, 'd/m/Y');
            $this->tbs->VarRef['contenido'] = $tabla;
            
            $this->tbs->Show(TBS_NOTHING);
            
            // Se regresa el render
            $output = $this->tbs->Source;
            
            $view = str_replace("{contenido_vista}", $output, $this->template);
            
            // PDF
            $pdf = $this->pdf->render($view,'Letter',null,true);
            //$pdf = $view;
            
            $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'contratos_listado.pdf','w');
            fwrite($fp, $pdf);
            fclose($fp);
            $data['reporte'] = 'contratos_listado.pdf';
        }
        $data['titulo'] = 'Informe de contratos <small>Listado</small>';
        $this->load->view('informes/listado', $data);
    }
    
    
    public function contratos_calle_listado(){
        $data['reporte'] = '';
        $this->load->model('calle', 'ca');
        $data['calles'] = $this->ca->get_all()->result();
        if( ($post = $this->input->post()) ){
            
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['id_calle'] = $post['id_calle'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('contrato','c');
            $this->load->library('rango');

            $contratos = $this->c->get_autorizados_by_fecha( $post['desde'].' 00:00:00', $post['hasta'].' 23:59:59', $post['filtro'], $post['id_calle'] )->result();
            
            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            
            $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Número', 'Fecha', 'Cliente', 'Calle', 'Módulos', array('data' => 'Total', 'style' => 'text-align: right;'));
            $total = 0;
            $contrato = '';
            foreach ($contratos as $c){
                $fecha = date_create($c->fecha);
                $modulos_contrato = $this->c->get_modulos_agrupados_by_calle($c->id, $post['id_calle'])->result();
                $modulos = '';
                $importe = 0;
                foreach($modulos_contrato as $m){
                    $calle = $m->calle;
                    $arreglo = explode(', ',$m->modulo);
                    $modulos .= $this->rango->array_to_rango($arreglo);
                    $importe += $m->importe;
                }
                
                // Se agregan las filas al reporte
                $this->table->add_row(
                    $c->numero.'/'.$c->sufijo,
                    date_format($fecha,'d/m/Y'),
                    $c->cliente,
                    $calle,
                    $modulos,
                    array('data' => number_format($importe,2), 'style' => 'text-align: right;')
                );
                $contrato = $c->id;
                
                $total += $importe;
            }
            
            $this->table->add_row( '', '', '', array('data' => '<h5>Total</h5>', 'colspan' => '2'), array('data' => '<h5>'.number_format($total,2).'</h5>', 'style' => 'text-align: right;'));
            
            $tabla = $this->table->generate();
            
            $this->load->library('tbs');
            $this->load->library('pdf');
            
            // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Listado de contratos por calle <br><small>'.$calle.'</small>';
            date_default_timezone_set('America/Mexico_City'); // Zona horaria
            $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
            $desde = date_create($post['desde']);
            $hasta = date_create($post['hasta']);
            $this->tbs->VarRef['subtitulo'] = 'Del '.date_format($desde, 'd/m/Y').' al '.date_format($hasta, 'd/m/Y');
            $this->tbs->VarRef['contenido'] = $tabla;
            
            $this->tbs->Show(TBS_NOTHING);
            
            // Se regresa el render
            $output = $this->tbs->Source;
            
            $view = str_replace("{contenido_vista}", $output, $this->template);
            
            // PDF
            $pdf = $this->pdf->render($view,'Letter',null,true);
            //$pdf = $view;
            
            $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'contratos_listado.pdf','w');
            fwrite($fp, $pdf);
            fclose($fp);
            $data['reporte'] = 'contratos_listado.pdf';
        }
        $data['titulo'] = 'Informe de contratos por calle <small>Listado</small>';
        $this->load->view('informes/listado_contratos_calle', $data);
    }
    
    public function saldos_clientes(){
        $data['reporte'] = '';
        if( ($post = $this->input->post()) ){
            
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('contrato','c');
            $this->load->model('recibo', 'r');
            $this->load->model('nota_credito', 'n');
            $this->load->library('rango');

            $contratos = $this->c->get_con_adeudo( $post['filtro'] )->result();
            
            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            
            $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Cliente', 'Calle', 'Módulos', 'Contrato', 'Fecha', 'Recibo/Nota', array('data' => 'Cargos', 'style' => 'text-align: right;'), array('data' => 'Abonos', 'style' => 'text-align: right;'), array('data' => 'Saldo', 'style' => 'text-align: right;'));
            $contrato = '';
            $total = 0;
            foreach ($contratos as $c){
                $importe = $this->c->get_importe($c->id);
                $fecha = date_create($c->fecha);
                $modulos_contrato = $this->c->get_modulos_agrupados($c->id)->result();
                $calles = '';
                $modulos = '';
                $i = 0;
                foreach($modulos_contrato as $m){
                    if($i > 0){
                        $calles .= '<br>';
                        $modulos .= '<br>';
                    }
                    $calles .= $m->calle;
                    $arreglo = explode(', ',$m->modulo);
                    $modulos .= $this->rango->array_to_rango($arreglo);
                    $i++;
                }
                
                // Contrato
                $this->table->add_row(
                        $c->cliente,
                        $calles,
                        $modulos,
                        $c->numero.'/'.$c->sufijo,
                        date_format($fecha,'d/m/Y'),
                        '',
                        array('data' => number_format($importe,2), 'style' => 'text-align: right;'),
                        '', ''
                );
                
                // Abonos
                $recibos = $this->r->get_by_contrato($c->id)->result();
                foreach($recibos as $r){
                    $fecha_recibo = date_create($r->fecha);
                    $this->table->add_row('','','','',
                            date_format($fecha_recibo,'d/m/Y'),
                            array('data' => $r->numero, 'style' => 'text-align: center;'),
                            '',
                            array('data' => number_format($r->total,2), 'style' => 'text-align: right;'),
                            ''
                    );
                }
                
                // Notas de crédito
                $notas = $this->n->get_by_contrato($c->id)->result();
                foreach($notas as $n){
                    $fecha_nota = date_create($n->fecha);
                    $this->table->add_row('','','','',
                            date_format($fecha_nota,'d/m/Y'),
                            array('data' => $n->serie.$n->folio, 'style' => 'text-align: center;'),
                            '',
                            array('data' => number_format($n->importe,2), 'style' => 'text-align: right;'),
                            ''
                    );
                }
                
                $abonos = $this->c->get_abonos($c->id) + $this->c->get_notas($c->id);
                
                $saldo = $importe - $abonos;
                // Saldo
                $this->table->add_row('','','','','','','', '', array('data' => '<strong>'.number_format($saldo,2).'</strong>', 'style' => 'text-align: right;'));
                
                $contrato = $c->id;
                $total += $saldo;
            }
            
            // Total
            $this->table->add_row( '', '', '', '', '', '', array('data' => '<h5>TOTAL</h5>', 'colspan' => '2' ), array('data' => '<h5>'.number_format($total,2).'</h5>', 'style' => 'text-align: right;'));
            
            $tabla = $this->table->generate();
            
            //$tabla.= '</tbody></table>';
            $this->load->library('tbs');
            $this->load->library('pdf');
            
            // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Saldos de clientes';
            date_default_timezone_set('America/Mexico_City'); // Zona horaria
            $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
            $this->tbs->VarRef['subtitulo'] = '';
            $this->tbs->VarRef['contenido'] = $tabla;
            
            $this->tbs->Show(TBS_NOTHING);
            
            // Se regresa el render
            $output = $this->tbs->Source;
            
            $view = str_replace("{contenido_vista}", $output, $this->template);
            
            // PDF
            $pdf = $this->pdf->render($view,'Letter',null,true);
            //$pdf = $view;
            
            $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'saldos_clientes.pdf','w');
            fwrite($fp, $pdf);
            fclose($fp);
            $data['reporte'] = 'saldos_clientes.pdf';
        }
        $data['titulo'] = 'Saldos de clientes';
        $this->load->view('informes/listado_sin_fechas', $data);
    }
    
    public function clientes_contrato_listado(){
        $data['reporte'] = '';
        if( ($post = $this->input->post()) ){
            
            //$data['desde'] = $post['desde'];
            //$data['hasta'] = $post['hasta'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('cliente','cl');
            $this->load->model('contrato','c');
            $this->load->model('giro','g');
            
            $clientes = $this->cl->get_all_contrato()->result();
            
            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            
            $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Nombre', 'Domicilio', 'Ciudad', 'Teléfono', 'Giro', 'Contrato');
            $registros = 0;
            foreach ($clientes as $c){
                // Clientes con contrato
                $contrato = $this->c->get_by_id_cliente($c->id)->row();
                //echo var_dump($contrato);
                //die();
                $giro = $this->g->get_by_id($c->id_giro)->row();
                $this->table->add_row( 
                        ($c->tipo == 'fisica' ? $c->apellido_paterno.' '.$c->apellido_materno.' '.$c->nombre : $c->razon_social),
                        $c->calle.' '.$c->numero_exterior.' '.$c->numero_interior,
                        $c->ciudad.', '.$c->estado,
                        $c->telefono,
                        $giro->nombre,
                        array('data' => $contrato->numero.'/'.$contrato->sufijo, 'style' => 'text-align: right;')
                        );
                $registros++;
            }
            
            $this->table->add_row( '<strong>Total registros</strong>', '<strong>'.$registros.'</strong>', '','','','');
            
            $tabla = $this->table->generate();
            
            $this->load->library('tbs');
            $this->load->library('pdf');
            
            // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Listado de clientes con contrato';
            date_default_timezone_set('America/Mexico_City'); // Zona horaria
            $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
            //$desde = date_create($post['desde']);
            //$hasta = date_create($post['hasta']);
            //$this->tbs->VarRef['subtitulo'] = 'Del '.date_format($desde, 'd/m/Y').' al '.date_format($hasta, 'd/m/Y');
            $this->tbs->VarRef['subtitulo'] = '';
            $this->tbs->VarRef['contenido'] = $tabla;
            
            $this->tbs->Show(TBS_NOTHING);
            
            // Se regresa el render
            $output = $this->tbs->Source;
            
            $view = str_replace("{contenido_vista}", $output, $this->template);
            
            // PDF
            $this->pdf->pagenumSuffix = '/';
            $this->pdf->SetHeader('{PAGENO}{nbpg}');
            $pdf = $this->pdf->render($view);
            //$pdf = $view;
            
            $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'clientes_listado.pdf','w');
            fwrite($fp, $pdf);
            fclose($fp);
            $data['reporte'] = 'clientes_listado.pdf';
        }
        $data['titulo'] = 'Clientes con contrato <small>Listado</small>';
        $this->load->view('informes/listado_sin_fechas', $data);
    }
}

?>
