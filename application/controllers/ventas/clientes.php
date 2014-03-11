<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clientes
 *
 * @author cherra
 */
class Clientes extends CI_Controller {
    
    private $folder = 'ventas/';
    private $clase = 'clientes/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function index( $offset = 0 ){
        $this->load->model('catalogos/cliente','c');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Clientes <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'agregar/'.$offset;
    	$data['action'] = $this->folder.$this->clase.'index';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->c->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'index');
    	$config['total_rows'] = $this->c->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Núm.','Nombre', 'Teléfono', 'Forma de pago', '');
    	foreach ($datos as $d) {
            $this->table->add_row(
                    $d->id_cliente,
                    $d->nombre,
                    $d->telefono,
                    $d->tipo_pago,
                    anchor($this->folder.$this->clase.'ver/' . $d->id_cliente . '/' . $offset, '<span class="'.$this->config->item('icono_editar').'"></span>'),
                    anchor($this->folder.$this->clase.'credito_ver/' . $d->id_cliente . '/' . $offset, '<span class="glyphicon glyphicon-pencil"></span>','title="Crédito"'),
                    anchor($this->folder.$this->clase.'descuentos_ver/' . $d->id_cliente . '/' . $offset, '<span class="glyphicon glyphicon-usd"></span>','title="Descuentos"')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar un cliente
     */
    public function agregar( $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/lista','l');
        
    	$data['titulo'] = 'Clientes <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'index/'.$offset;
    
    	$data['action'] = $this->folder.$this->clase.'agregar/'.$offset;
    	if ( ($datos = $this->input->post()) ) {
            if(strlen($datos['rfc']) > 0)
                $datos['tipo_impresion'] = 'factura';
            if( ($id = $this->c->save($datos)) ){
                $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                redirect($this->folder.$this->clase.'ver/'.$id.'/'.$offset);
            }else{
                $this->session->set_flashdata('mensaje',$this->config->item('error'));
                redirect($this->folder.$this->clase.'agregar/'.$offset);
            }
    	}
        
        $data['listas'] = $this->l->get_all()->result();
        $this->load->view('catalogos/clientes/formulario', $data);
    }
    
    
    /*
     * Vista previa del cliente
     */
    public function ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/lista','l');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'index');
    	}
    	
    	$data['titulo'] = 'Clientes <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'index/' . $offset;
        
    	$data['action'] = $this->folder.$this->clase.'editar/' . $id . '/' . $offset;

    	$data['datos'] = $cliente->row();
        $data['lista'] = $this->l->get_by_id($data['datos']->id_lista)->row();
        
        $this->load->view('catalogos/clientes/vista', $data);
    }
    
    /*
     * Editar un cliente
     */
    public function editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/lista','l');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'index');
    	}
    	
    	$data['titulo'] = 'Clientes <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'ver/'.$id . '/' . $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'editar/' . $id . '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            if(strlen($datos['rfc']) > 0)
                $datos['tipo_impresion'] = 'factura';
            $this->c->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'ver/'.$id . '/' . $offset);
    	}

        $data['listas'] = $this->l->get_all()->result();
    	$data['datos'] = $this->c->get_by_id($id)->row();
        
        $this->load->view('catalogos/clientes/formulario', $data);
    }
    
    /*
     * Vista previa datos de crédito
     */
    public function credito_ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'index/' . $offset);
    	}
    	
    	$data['titulo'] = 'Clientes <small>Datos de crédito</small>';
    	$data['link_back'] = $this->folder.$this->clase.'index/'. $offset;
        
    	$data['action'] = $this->folder.$this->clase.'credito_editar/' . $id . '/' . $offset;

    	$data['datos'] = $cliente->row();
        
        $this->load->view('catalogos/clientes/vista_credito', $data);
    }
    
    /*
     * Editar datos de crédito
     */
    public function credito_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'index');
    	}
    	
    	$data['titulo'] = 'Clientes <small>Editar datos de crédito</small>';
    	$data['link_back'] = $this->folder.$this->clase.'credito_ver/'.$id . '/' . $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'credito_editar/' . $id . '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            $this->c->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'credito_ver/'.$id . '/' . $offset);
    	}

    	$data['datos'] = $this->c->get_by_id($id)->row();
        
        $this->load->view('catalogos/clientes/formulario_credito', $data);
    }
    
    /*
     * Vista previa descuentos
     */
    public function descuentos_ver( $id = NULL, $offset = 0 ) {
        
        if(empty($id)){
            redirect($this->folder.$this->clase.'clientes');
        }
        
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/descuento','d');
        $this->load->model('catalogos/presentacion','p');
        $this->load->model('catalogos/precio','pr');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Descuentos por cliente <small>Lista</small>';
    	$data['action'] = $this->folder.$this->clase.'descuentos_ver/'.$id.'/'.$offset;
        $data['link_back'] = $this->folder.$this->clase.'index/'.$offset;
        $data['link_add'] = $this->folder.$this->clase.'descuentos_agregar/'. $id.'/'. $offset;
        
        $data['cliente'] = $this->c->get_by_id($id)->row();

        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;

        $page_limit = $this->config->item("per_page");
        $datos = $this->d->get_by_cliente($id, $page_limit, $offset, $filtro)->result();

        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url($this->folder.$this->clase.'descuentos_ver/'.$id);
        $config['total_rows'] = $this->d->count_by_cliente($id, $filtro);
        $config['per_page'] = $page_limit;
        $config['uri_segment'] = 5;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Código', 'Nombre', 'Precio', 'Descuento', '', '');
        foreach ($datos as $d) {
            $presentacion = $this->p->get_by_id($d->id_articulo)->row();
            $precio = $this->pr->get_precio($d->id_articulo, $data['cliente']->id_lista)->row();
            $this->table->add_row(
                    (strlen($presentacion->codigo) > 0) ? $presentacion->codigo : '',
                    $presentacion->nombre,
                    array('data' => number_format((empty($precio->precio) ? 0 : $precio->precio),2), 'style' => 'text-align: right;'),
                    array('data' => number_format((empty($d->descuento) ? 0 : $d->descuento),2), 'style' => 'text-align: right;'),
                    anchor($this->folder.$this->clase.'descuentos_editar/' . $d->id_cliente . '/' . $d->id_tarjeta. '/'. $offset, '<span class="'.$this->config->item('icono_editar').'"></span>'),
                    anchor($this->folder.$this->clase.'descuentos_quitar/' . $d->id_cliente . '/' . $d->id_tarjeta. '/'. $offset, '<span class="'.$this->config->item('icono_borrar').'"></span>')
            );
        }
        $data['table'] = $this->table->generate();
        
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Editar datos de crédito
     */
    public function descuentos_editar( $id_cliente = NULL, $id_tarjeta = NULL, $offset = 0 ) {
        $this->load->model('catalogos/descuento','d');
        
        $descuento = $this->d->get_by_id($id_tarjeta);
        if ( empty($id_tarjeta) OR $descuento->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'index');
    	}
    	
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/presentacion','p');
        $this->load->model('catalogos/precio','pr');
        
    	$data['titulo'] = 'Clientes <small>Editar descuentos</small>';
    	$data['link_back'] = $this->folder.$this->clase.'descuentos_ver/'.$id_cliente . '/' . $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'descuentos_editar/' . $id_cliente . '/' . $id_tarjeta . '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            $this->d->update($id_tarjeta, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'descuentos_ver/'.$id_cliente . '/' . $offset);
    	}

    	$data['datos'] = $this->d->get_by_id($id_tarjeta)->row();
        $data['cliente'] = $this->c->get_by_id($id_cliente)->row();
        $data['presentacion'] = $this->p->get_by_id($data['datos']->id_articulo)->row();
        $data['precio'] = $this->pr->get_precio($data['datos']->id_articulo, $data['cliente']->id_lista)->row();
         
        $this->load->view('catalogos/clientes/formulario_descuento', $data);
    }
    
    /*
     * 
     * Agregar un descuento
     */
    
    public function descuentos_agregar( $id_cliente = NULL,  $offset = 0, $id_articulo = NULL ) {
        $this->load->model('catalogos/cliente','c');
        
        $cliente = $this->c->get_by_id($id_cliente);
        if ( empty($id_cliente) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'index');
    	}
        
        $this->load->model('catalogos/descuento','d');
        $this->load->model('catalogos/presentacion','p');
        $this->load->model('catalogos/precio','pr');
        
    	$data['titulo'] = 'Clientes <small>Agregar un descuento</small>';
    	$data['link_back'] = $this->folder.$this->clase.'descuentos_ver/'.$id_cliente.'/'.$offset;
    
    	$data['action'] = $this->folder.$this->clase.'descuentos_agregar/'.$id_cliente.'/'.$offset;
    	if ( ($datos = $this->input->post()) ) {
            if( ($id = $this->d->save($datos)) ){
                $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                redirect($this->folder.$this->clase.'descuentos_ver/'.$id_cliente.'/'.$offset);
            }else{
                $this->session->set_flashdata('mensaje',$this->config->item('error'));
                redirect($this->folder.$this->clase.'descuentos_agregar/'.$id_cliente.'/'.$offset);
            }
    	}
        
        $data['presentaciones'] = $this->p->get_all()->result();
        $data['cliente'] = $cliente->row();
        if(!empty($id_articulo)){
            $data['presentacion'] = $this->p->get_by_id($id_articulo)->row();
            $data['precio'] = $this->pr->get_precio($id_articulo, $data['cliente']->id_lista)->row();
        }
        $data['offset'] = $offset;
        
        $this->load->view('catalogos/clientes/formulario_descuento', $data);
    }
    
    public function descuentos_quitar( $id_cliente = NULL, $id = NULL, $offset = 0 ) {
        if(empty($id_cliente)){
            redirect($this->folder.$this->clase.'index');
        }
        if(empty($id)){
            redirect($this->folder.$this->clase.'descuentos_ver/'.$id_cliente);
        }
        
        $this->load->model('catalogos/descuento','d');
            	
        $this->d->delete( $id );
        redirect($this->folder.$this->clase.'descuentos_ver/'.$id_cliente.'/'. $offset);
    }
}
?>
