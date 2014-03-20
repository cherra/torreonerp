<?php
/**
 * Description of articulos
 *
 * @author cherra
 */
class Articulos extends CI_Controller {
    
    private $folder = 'ventas/';
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
    	$this->table->set_heading('Nombre', 'Código', 'Tipo', 'Línea', 'Stock', '');
    	foreach ($datos as $d) {
            $linea = $this->l->get_by_id($d->id_linea)->row();
            $this->table->add_row(
                    $d->nombre,
                    $d->codigo,
                    $d->tipo,
                    (!empty($linea->nombre) ? $linea->nombre : ''),
                    $d->stock,
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
            if(empty($datos['stock']))
                $datos['stock'] = 'n';
            $this->p->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'presentaciones_ver/'.$id.'/'. $offset);
    	}

        $data['lineas'] = $this->l->get_all()->result();
    	$data['datos'] = $this->p->get_by_id($id)->row();
        
        $this->load->view('catalogos/presentaciones/formulario', $data);
    }
}
?>
