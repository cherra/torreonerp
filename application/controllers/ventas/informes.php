<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of informes
 *
 * @author cherra
 */
class informes extends CI_Controller {
    
    public $layout = 'template_backend';
    private $template = '';
    private $folder = 'ventas/';
    private $clase = 'informes/';
    
    function __construct() {
        parent::__construct();
        $this->template = $this->load->file(APPPATH . 'views/templates/template_pdf.php', true);
        
        ini_set('memory_limit', '-1');
    }
    
    public function ventas_contado( $exportar = NULL ){
        $data['reporte'] = '';
        $data['action'] = $this->folder.$this->clase.'ventas_contado/';
        
        if( ($post = $this->input->post()) ){
            date_default_timezone_set('America/Mexico_City'); // Zona horaria
            $desde = date_create($post['desde']);
            $hasta = date_create($post['hasta']);
            
            //$data['export_link'] = $this->folder.$this->clase.'ventas/'.$post['desde'].'/'.$post['hasta'].'/'.$filtro.'/exportar';
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['tipo'] = $post['tipo'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('venta','v');
            $ventas = $this->v->get_contado_by_fecha( $post['desde'], $post['hasta'], $post['tipo'], $post['filtro'], NULL, 0 )->result();
            
            if(empty($exportar)){
                // generar tabla
                $this->load->library('table');
                $this->table->set_empty('&nbsp;');

                $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
                $this->table->set_template($tmpl);
                $this->table->set_heading('Folio', 'Fecha', 'Caja', 'Cajero', 'Cliente', 'Importe');
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
                        $total_canceladas += $v->monto;
                    }else{
                        $clase = '';
                        $total_vigentes += $v->monto;
                        $total_caja += $v->monto;
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
                        array('data' => number_format($v->monto,2), 'style' => 'text-align: right;', 'class' => $clase)
                    );

                    $this->table->add_row_class($clase);

                    $total += $v->monto;
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
                $this->tbs->VarRef['titulo'] = 'Reporte de ventas de contado';
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

                $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'reporte_ventas_contado.pdf','w');
                fwrite($fp, $pdf);
                fclose($fp);
                $data['reporte'] = 'reporte_ventas_contado.pdf';
            }else{
                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('Reporte de ventas contado');
                
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
                    $this->excel->getActiveSheet()->setCellValue('F'.$fila, $v->monto);
                    
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

                $filename='reporte_de_ventas_contado.xls'; //save our workbook as this file name
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
        $data['titulo'] = 'Reporte de ventas de contado <small>Listado</small>';
        $this->load->view('ventas/informes/general', $data);
    }
    
    public function ventas_credito( $exportar = NULL ){
        $data['reporte'] = '';
        $data['action'] = $this->folder.$this->clase.'ventas_credito/';
        
        if( ($post = $this->input->post()) ){
            date_default_timezone_set('America/Mexico_City'); // Zona horaria
            $desde = date_create($post['desde']);
            $hasta = date_create($post['hasta']);
            
            //$data['export_link'] = $this->folder.$this->clase.'ventas/'.$post['desde'].'/'.$post['hasta'].'/'.$filtro.'/exportar';
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['tipo'] = $post['tipo'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('venta','v');
            $ventas = $this->v->get_credito_by_fecha( $post['desde'], $post['hasta'], $post['tipo'], $post['filtro'], NULL, 0 )->result();
            
            if(empty($exportar)){
                // generar tabla
                $this->load->library('table');
                $this->table->set_empty('&nbsp;');

                $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
                $this->table->set_template($tmpl);
                $this->table->set_heading('Folio', 'Fecha', 'Caja', 'Cajero', 'Cliente', 'Importe');
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
                        $total_canceladas += $v->monto;
                    }else{
                        $clase = '';
                        $total_vigentes += $v->monto;
                        $total_caja += $v->monto;
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
                        array('data' => number_format($v->monto,2), 'style' => 'text-align: right;', 'class' => $clase)
                    );

                    $this->table->add_row_class($clase);

                    $total += $v->monto;
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
                $this->tbs->VarRef['titulo'] = 'Reporte de ventas de crédito';
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

                $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'reporte_ventas_credito.pdf','w');
                fwrite($fp, $pdf);
                fclose($fp);
                $data['reporte'] = 'reporte_ventas_credito.pdf';
            }else{
                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('Reporte de ventas de crédito');
                
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
                    $this->excel->getActiveSheet()->setCellValue('F'.$fila, $v->monto);
                    
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

                $filename='reporte_de_ventas_credito.xls'; //save our workbook as this file name
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
        $data['titulo'] = 'Reporte de ventas de crédito <small>Listado</small>';
        $this->load->view('ventas/informes/general', $data);
    }
}
?>
