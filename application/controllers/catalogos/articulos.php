<?php
/**
 * Description of articulos
 *
 * @author cherra
 */
class Articulos extends CI_Controller {
    
    private $folder = 'catalogos/';
    private $clase = 'articulos/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function lineas( $offset = 0 ){
        $this->load->model('catalogos/linea','l');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Lineas <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'lineas_agregar/'. $offset;
    	$data['action'] = $this->folder.$this->clase.'lineas/'. $offset;
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->l->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'lineas');
    	$config['total_rows'] = $this->l->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', '');
    	foreach ($datos as $d) {
            $this->table->add_row(
                    $d->nombre,
                    anchor($this->folder.$this->clase.'lineas_ver/' . $d->id_linea . '/' . $offset, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar una linea
     */
    public function lineas_agregar( $offset = 0 ) {
        $this->load->model('catalogos/linea','l');
        
    	$data['titulo'] = 'Lineas <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'lineas/'. $offset;
    
    	$data['action'] = $this->folder.$this->clase.'lineas_agregar/'. $offset;
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->l->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'lineas_ver/'.$id.'/'. $offset);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'lineas_agregar/'. $offset);
                }
    	}
        $this->load->view('catalogos/lineas/formulario', $data);
    }
    
    
    /*
     * Vista previa de la linea
     */
    public function lineas_ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/linea','l');
        
        $linea = $this->l->get_by_id($id);
        if ( empty($id) OR $linea->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'lineas/'. $offset);
    	}
    	
    	$data['titulo'] = 'Lineas <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'lineas/'. $offset;
        
    	$data['action'] = $this->folder.$this->clase.'lineas_editar/' . $id . '/'. $offset;

    	$data['datos'] = $linea->row();
        
        $this->load->view('catalogos/lineas/vista', $data);
    }
    
    /*
     * Editar una linea
     */
    public function lineas_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/linea','l');
        
        $linea = $this->l->get_by_id($id);
        if ( empty($id) OR $linea->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'lineas/'. $offset);
    	}
    	
    	$data['titulo'] = 'Lineas <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'lineas_ver/'.$id.'/'. $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'lineas_editar/' . $id.'/'. $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
    		$this->l->update($id, $datos);
                $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
                redirect($this->folder.$this->clase.'lineas_ver/'.$id.'/'. $offset);
    	}

    	$data['datos'] = $this->l->get_by_id($id)->row();
        
        $this->load->view('catalogos/lineas/formulario', $data);
    }
    
    /*
     * Listado de presentaciones
     */
    public function presentaciones( $offset = 0 ){
        $this->load->model('catalogos/linea','l');
        $this->load->model('catalogos/presentacion','p');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Presentaciones <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'presentaciones_agregar/'. $offset;
    	$data['action'] = $this->folder.$this->clase.'presentaciones/'. $offset;
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->p->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'presentaciones');
    	$config['total_rows'] = $this->p->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', 'Código', 'Tipo', 'Subproducto', '');
    	foreach ($datos as $d) {
            $linea = $this->l->get_by_id($d->id_linea)->row();
            $this->table->add_row(
                    $d->nombre,
                    $d->codigo,
                    $d->tipo,
                    (!empty($linea->nombre) ? $linea->nombre : ''),
                    anchor($this->folder.$this->clase.'presentaciones_ver/' . $d->id_articulo. '/' . $offset, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar una presentación
     */
    public function presentaciones_agregar( $offset = 0 ) {
        $this->load->model('catalogos/linea','l');
        $this->load->model('catalogos/presentacion','p');
        
    	$data['titulo'] = 'Presentaciones <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'presentaciones/'. $offset;
    
    	$data['action'] = $this->folder.$this->clase.'presentaciones_agregar/'. $offset;
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->p->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'presentaciones_ver/'.$id.'/'. $offset);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'presentaciones_agregar/'. $offset);
                }
    		//$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>¡Registro exitoso!</div>';
    	}
        $data['linea'] = $this->l->get_all()->result();
        $this->load->view('catalogos/presentaciones/formulario', $data);
    }
    
    public function presentaciones_ver( $id = NULL, $offset = 0 ) {
    	$this->load->model('catalogos/linea', 'l');
        $this->load->model('catalogos/presentacion','p');
        
        $presentacion = $this->p->get_by_id($id);
        if ( empty($id) OR $presentacion->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'presentaciones');
    	}
    	
    	$data['titulo'] = 'Presentaciones <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'presentaciones/'. $offset;
        
    	$data['action'] = $this->folder.$this->clase.'presentaciones_editar/' . $id.'/'. $offset;

    	$data['datos'] = $presentacion->row();
        $data['linea'] = $this->l->get_by_id($data['datos']->id_linea)->row();
        
        $this->load->view('catalogos/presentaciones/vista', $data);
    }
    
    /*
     * Editar una presentación
     */
    public function presentaciones_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/linea', 'l');
    	$this->load->model('catalogos/presentacion','p');
        
        $presentacion = $this->p->get_by_id($id);
        if ( empty($id) OR $presentacion->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'presentaciones');
    	}
    	
    	$data['titulo'] = 'Presentaciones <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'presentaciones_ver/'.$id.'/'. $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'presentaciones_editar/' . $id.'/'. $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            if(strlen($datos['codigo']) == 0){
                $datos['codigo'] = null;
            }
            if(empty($datos['iva']))
                $datos['iva'] = 'n';
            if(empty($datos['inventariado']))
                $datos['inventariado'] = 'n';
            $this->p->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'presentaciones_ver/'.$id.'/'. $offset);
    	}

        $data['lineas'] = $this->l->get_all()->result();
    	$data['datos'] = $this->p->get_by_id($id)->row();
        
        $this->load->view('catalogos/presentaciones/formulario', $data);
    }
    
    
    /*
     * Listas de precios
     */
    public function precios_listas( $offset = 0 ){
        $this->load->model('catalogos/lista','l');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Listas de precios <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'precios_listas_agregar';
    	$data['action'] = $this->folder.$this->clase.'precios_listas';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->l->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'precios_listas');
    	$config['total_rows'] = $this->l->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', '', '', '');
    	foreach ($datos as $d) {
            $this->table->add_row(
                    $d->nombre,
                    anchor($this->folder.$this->clase.'precios_listas_ver/' . $d->id_lista, '<span class="'.$this->config->item('icono_editar').'"></span>'),
                    anchor($this->folder.$this->clase.'precios/' . $d->id_lista, '<span class="glyphicon glyphicon-usd"></span>'),
                    anchor($this->folder.$this->clase.'precios_exportar/'.$d->id_lista, '<span class="'.$this->config->item('icono_download').'"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar una lista de precios
     */
    public function precios_listas_agregar() {
        $this->load->model('catalogos/lista','l');
        
    	$data['titulo'] = 'Listas de precios <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'precios_listas';
    
    	$data['action'] = $this->folder.$this->clase.'precios_listas_agregar';
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->l->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'precios_listas_ver/'.$id);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'precios_listas_agregar');
                }
    	}
        $this->load->view('catalogos/precios_listas/formulario', $data);
    }
    
    
    /*
     * Vista previa de listas de precios
     */
    public function precios_listas_ver( $id = NULL ) {
        $this->load->model('catalogos/lista','l');
        
        $lista = $this->l->get_by_id($id);
        if ( empty($id) OR $lista->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'precios_listas');
    	}
    	
    	$data['titulo'] = 'Listas de precios <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'precios_listas';
        
    	$data['action'] = $this->folder.$this->clase.'precios_listas_editar/' . $id;

    	$data['datos'] = $this->l->get_by_id($id)->row();
        
        $this->load->view('catalogos/precios_listas/vista', $data);
    }
    
    /*
     * Editar una linea
     */
    public function precios_listas_editar( $id = NULL ) {
        $this->load->model('catalogos/lista','l');
        
        $lista = $this->l->get_by_id($id);
        if ( empty($id) OR $lista->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'precios_listas');
    	}
    	
    	$data['titulo'] = 'Listas de precios <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'precios_listas_ver/'.$id;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'precios_listas_editar/' . $id;
    	 
    	if ( ($datos = $this->input->post()) ) {
    		$this->l->update($id, $datos);
                $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
                redirect($this->folder.$this->clase.'precios_listas_ver/'.$id);
    	}

    	$data['datos'] = $this->l->get_by_id($id)->row();
        
        $this->load->view('catalogos/precios_listas/formulario', $data);
    }
    
    public function precios( $id_lista = NULL, $offset = 0 ){
        $this->load->model('catalogos/lista','l');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Precios <small>Lista</small>';
    	$data['action'] = $this->folder.$this->clase.'precios/'.$id_lista;
        $data['link_back'] = $this->folder.$this->clase.'precios_listas';
        
        $data['listas'] = $this->l->get_all()->result();
        if(!empty($id_lista)){
            $data['link_importar'] = $this->folder.$this->clase.'precios_importar/'.$id_lista . '/' . $offset;
            
            $data['lista'] = $this->l->get_by_id($id_lista)->row();

            $this->load->model('catalogos/precio','p');
            $this->load->model('catalogos/presentacion','pr');
            //$this->load->model('catalogos/linea','l');
        
            // Filtro de busqueda (se almacenan en la sesión a través de un hook)
            $filtro = $this->session->userdata('filtro');
            if($filtro)
                $data['filtro'] = $filtro;

            $page_limit = $this->config->item("per_page");
            $datos = $this->pr->get_paged_list($page_limit, $offset, $filtro)->result();

            // generar paginacion
            $this->load->library('pagination');
            $config['base_url'] = site_url($this->folder.$this->clase.'precios/'.$id_lista);
            $config['total_rows'] = $this->pr->count_all($filtro);
            $config['per_page'] = $page_limit;
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Código', 'Nombre', 'Precio mín.', 'Precio');
            foreach ($datos as $d) {
                $precio = $this->p->get_precio($d->id_articulo, $id_lista)->row();
                $this->table->add_row(
                        (strlen($d->codigo) > 0) ? $d->codigo : '',
                        $d->nombre,
                        array('data' => number_format((empty($precio->precio_minimo) ? 0 : $precio->precio_minimo),2), 'style' => 'text-align: right;'),
                        array('data' => number_format((empty($precio->precio) ? 0 : $precio->precio),2), 'style' => 'text-align: right;'),
                        anchor($this->folder.$this->clase.'precios_editar/' . $id_lista . '/' . $d->id_articulo. '/'. $offset, '<span class="'.$this->config->item('icono_editar').'"></span>')
                );
            }
            $data['table'] = $this->table->generate();
        }
    	
    	$this->load->view('catalogos/precios/lista', $data);
    }
    
    public function precios_editar( $id_lista = NULL, $id_articulo = NULL, $offset = 0 ) {
        if(empty($id_lista) OR empty($id_articulo))
            redirect($this->folder.$this->clase.'precios');
        
        $this->load->model('catalogos/lista','l');
        $this->load->model('catalogos/precio','p');
        $this->load->model('catalogos/presentacion','pr');
        
    	$data['titulo'] = 'Precios <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'precios/'.$id_lista.'/'.$offset;
    	$data['action'] = $this->folder.$this->clase.'precios_editar/' . $id_lista . '/' . $id_articulo . '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
    		$resultado = $this->p->update($id_lista, $id_articulo, $datos);
                if($resultado == 0){
                    $datos['id_articulo'] = $id_articulo;
                    $datos['id_lista'] = $id_lista;
                    $this->p->save($datos);
                }
                $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
                redirect($this->folder.$this->clase.'precios_editar/'.$id_lista.'/'.$id_articulo.'/'.$offset);
    	}

        $data['lista'] = $this->l->get_by_id($id_lista)->row();
        $data['presentacion'] = $this->pr->get_by_id($id_articulo)->row();
    	$data['datos'] = $this->p->get_precio($id_articulo, $id_lista)->row();
        
        $this->load->view('catalogos/precios/formulario', $data);
    }
    
    public function precios_importar( $id_lista = NULL, $offset = 0 ) {
        if(empty($id_lista))
            redirect($this->folder.$this->clase.'precios');
        
        $this->load->model('catalogos/lista','l');
        $this->load->model('catalogos/precio','p');
        
    	$data['titulo'] = 'Precios <small>Importar</small>';
    	$data['link_back'] = $this->folder.$this->clase.'precios/'.$id_lista.'/'.$offset;
    
    	$data['action'] = $this->folder.$this->clase.'precios_importar/'.$id_lista.'/'.$offset;
        
        $data['lista'] = $this->l->get_by_id($id_lista)->row();
        
    	if ( ($datos = $this->input->post()) ) {
            // Se define la ruta donde se va a guardar el archivo y se valida si existe y es escribible.
            $path = $this->config->item('tmp_path');
            if(!file_exists($path)){
                mkdir($path, 0777, true);
            }elseif(!is_writable($path)){
                chmod($path, 0777);
            }

            $config['upload_path'] = $path; // Se agrega la ruta donde se va a guardar el archivo.
            $config['allowed_types'] = 'csv|text|txt';
            
            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('lista') )
            {
                //$this->upload->display_errors()
                $this->session->set_flashdata('mensaje',$this->config->item('error'));
            }
            else
            {
                $archivo = array('upload_data' => $this->upload->data());

                $resultado = $this->importar_lista($id_lista, $archivo['upload_data']['full_path']);
                if($resultado)
                    $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
                else
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
            }
            redirect($this->folder.$this->clase.'precios_importar/'.$id_lista.'/'.$offset);
    	}
        $this->load->view('catalogos/precios/formulario_importar', $data);
    }
    
    private function importar_lista( $id_lista, $path ){
        if(!empty($path) && !empty($id_lista)){
            if( ($file= fopen($path,"r")) ){
                $this->load->model('catalogos/presentacion','pr');
                $this->load->model('catalogos/precio','p');
                while( ($datos = fgetcsv($file)) ){
                    $presentacion = $this->pr->get_by_codigo($datos[0])->row();
                    if($presentacion){
                        $resultado = $this->p->update($id_lista, $presentacion->id_articulo, array('precio' => $datos[1]));
                        if($resultado == 0){
                            $data['id_articulo'] = $presentacion->id_articulo;
                            $data['id_lista'] = $id_lista;
                            $data['precio'] = $datos[1];
                            $this->p->save($data);
                        }
                    }
                }
                fclose($file);
                unlink($path);
                return true;
            }
        }
    }
    
    public function precios_exportar( $id_lista ){
        if(!empty($id_lista)){
            $this->load->model('catalogos/precio','p');
            $this->load->model('catalogos/presentacion','pr');
            $this->load->model('catalogos/lista','l');
            
            $lista = $this->l->get_by_id($id_lista)->row();
            
            $path = $this->config->item('tmp_path');
            if(!file_exists($path)){
                mkdir($path, 0777, true);
            }elseif(!is_writable($path)){
                chmod($path, 0777);
            }
            
            $fp = fopen($path.$lista->nombre.'.csv','w');           
            
            $presentaciones = $this->pr->get_all()->result();
            foreach($presentaciones as $pr){
                $precio = $this->p->get_precio($pr->id_articulo, $id_lista)->row();
                if(!empty($pr->codigo)){
                    if(!empty($precio->precio))
                        $p = $precio->precio;
                    else
                        $p = 0;
                    fputcsv($fp, array($pr->codigo,$p, $pr->nombre));
                }
            }
            fclose($fp);
            
            $this->load->helper('download');
            $contenido = file_get_contents($path.$lista->nombre.'.csv');
            unlink($path.$lista->nombre.'.csv');
            force_download($lista->nombre.'.csv', $contenido);
        }
    }
}
?>
