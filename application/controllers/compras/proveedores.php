<?php

/**
 * Description of proveedores
 *
 * @author cherra
 */
class Proveedores extends CI_Controller {
    
    private $folder = 'compras/';
    private $clase = 'proveedores/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function index( $offset = 0 ){
        $this->load->model('catalogos/proveedor','p');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Proveedores <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'agregar/'.$offset;
    	$data['action'] = $this->folder.$this->clase.'index';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->p->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'index');
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
    	$this->table->set_heading('Nombre', 'Nombre comercial', 'Teléfono', '');
    	foreach ($datos as $d) {
            $this->table->add_row(
                    $d->razon_social,
                    $d->nombre_comercial,
                    $d->telefono,
                    anchor($this->folder.$this->clase.'ver/' . $d->id_proveedor . '/' . $offset, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar un proveedor
     */
    public function agregar( $offset = 0 ) {
        $this->load->model('catalogos/proveedor','p');
        
    	$data['titulo'] = 'Proveedores <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'index/'.$offset;
    
    	$data['action'] = $this->folder.$this->clase.'agregar/'.$offset;
    	if ( ($datos = $this->input->post()) ) {
            if(strlen($datos['rfc']) > 0)
                $datos['tipo_impresion'] = 'factura';
            if( ($id = $this->p->save($datos)) ){
                $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                redirect($this->folder.$this->clase.'ver/'.$id.'/'.$offset);
            }else{
                $this->session->set_flashdata('mensaje',$this->config->item('error'));
                redirect($this->folder.$this->clase.'agregar/'.$offset);
            }
    	}
        
        $this->load->view('catalogos/proveedores/formulario', $data);
    }
    
    
    /*
     * Vista previa del proveedor
     */
    public function ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/proveedor','p');
        
        $proveedor = $this->p->get_by_id($id);
        if ( empty($id) OR $proveedor->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'index');
    	}
    	
    	$data['titulo'] = 'Proveedores <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'index/' . $offset;
        
    	$data['action'] = $this->folder.$this->clase.'editar/' . $id . '/' . $offset;

    	$data['datos'] = $proveedor->row();
        
        $this->load->view('catalogos/proveedores/vista', $data);
    }
    
    /*
     * Editar un proveedor
     */
    public function editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/proveedor','p');
        
        $cliente = $this->p->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'index');
    	}
    	
    	$data['titulo'] = 'Proveedores <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'ver/'.$id . '/' . $offset;
    	$data['action'] = $this->folder.$this->clase.'editar/' . $id . '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            $this->p->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'ver/'.$id . '/' . $offset);
    	}

    	$data['datos'] = $this->p->get_by_id($id)->row();
        
        $this->load->view('catalogos/proveedores/formulario', $data);
    }
}
?>
