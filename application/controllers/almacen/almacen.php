<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of almacen
 *
 * @author cherra
 */
class Almacen extends CI_Controller {
    
    private $folder = 'almacen/';
    private $clase = 'almacen/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('vacio');
    }
    public function inventario_inicial( $offset = 0 ){
        
        $this->load->model('catalogos/linea','l');
        $this->load->model('catalogos/presentacion','p');
        $this->load->model('inventario_inicial','ii');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Inventario inicial <small>Lista</small>';
    	$data['action'] = $this->folder.$this->clase.'inventario_inicial/'. $offset;
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->p->get_control_stock($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'inventario_inicial');
    	$config['total_rows'] = $this->p->count_control_stock($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', 'Código', 'Tipo', 'Línea', 'Stock inicial', 'Fecha', 'Hora', '');
    	foreach ($datos as $d) {
            $linea = $this->l->get_by_id($d->id_linea)->row();
            $stock = $this->ii->get_last_by_id($d->id_articulo)->row();
            $this->table->add_row(
                    $d->nombre,
                    $d->codigo,
                    $d->tipo,
                    (!empty($linea->nombre) ? $linea->nombre : ''),
                    !empty($stock->cantidad) ? $stock->cantidad : '',
                    !empty($stock->fecha) ? $stock->fecha : '',
                    !empty($stock->hora) ? $stock->hora : '',
                    anchor($this->folder.$this->clase.'inventario_inicial_ver/' . $d->id_articulo. '/' . $offset, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    public function inventario_inicial_ver( $id = NULL, $offset = 0 ) {
    	$this->load->model('catalogos/linea', 'l');
        $this->load->model('catalogos/presentacion','p');
        $this->load->model('inventario_inicial','ii');
        
        $presentacion = $this->p->get_by_id($id);
        if ( empty($id) OR $presentacion->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'inventario_inicial');
    	}
        
    	$data['titulo'] = 'Inventario inicial <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'inventario_inicial/'. $offset;
        
    	$data['action'] = $this->folder.$this->clase.'inventario_inicial_editar/' . $id.'/'. $offset;

    	$data['datos'] = $presentacion->row();
        $data['inventario_inicial'] = $this->ii->get_last_by_id($id)->row();
        $data['linea'] = $this->l->get_by_id($data['datos']->id_linea)->row();
        
        $this->load->view('almacen/inventario_inicial/vista', $data);
    }
    
    public function inventario_inicial_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/linea', 'l');
    	$this->load->model('catalogos/presentacion','p');
        $this->load->model('inventario_inicial','ii');
        
        $presentacion = $this->p->get_by_id($id);
        if ( empty($id) OR $presentacion->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'presentaciones');
    	}
    	
    	$data['titulo'] = 'Inventario inicial <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'inventario_inicial_ver/'.$id.'/'. $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'inventario_inicial_editar/' . $id.'/'. $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            $datos['id_articulo'] = $id;
            $this->ii->save($datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'inventario_inicial_ver/'.$id.'/'. $offset);
    	}

        $data['lineas'] = $this->l->get_all()->result();
    	$data['datos'] = $this->p->get_by_id($id)->row();
        $data['inventario_inicial'] = $this->ii->get_last_by_id($id)->row();
        
        $this->load->view('almacen/inventario_inicial/formulario', $data);
    }
    
}
?>
