<?php

/**
 * Description of ventas
 *
 * @author cherra
 */
class Ventas extends CI_Controller {
    
    private $folder = 'ventas/';
    private $clase = 'ventas/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('vacio');
    }
    
    public function lista( $desde = NULL, $hasta = NULL, $tipo = NULL, $offset = 0 ){
        $this->load->model('venta','v');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Ajustes de venta <small>Lista</small>';
        if(empty($desde))
            $desde = date('Y-m-d');
        if(empty($hasta))
            $hasta = date('Y-m-d');
    	//$data['link_add'] = $this->folder.$this->clase.'lineas_agregar/'. $offset;
    	$data['action'] = $this->folder.$this->clase.'lista';

        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;

        $data['desde'] = $desde;
        $data['hasta'] = $hasta;
        $data['tipo'] = $tipo;
        $page_limit = $this->config->item("per_page");
        $datos = $this->v->get_by_fecha($desde, $hasta, $tipo, $filtro, $page_limit, $offset)->result();

        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url($this->folder.$this->clase.'lista/'.$desde.'/'.$hasta.'/'.$tipo);
        $config['total_rows'] = $this->v->count_by_fecha($desde, $hasta, $tipo, $filtro);
        $config['per_page'] = $page_limit;
        $config['uri_segment'] = 6;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Folio', 'Fecha', 'Hora', 'Cliente', 'Tipo', 'Caja', 'Usuario', 'Importe', '');
        foreach ($datos as $d) {
            $this->table->add_row(
                    $d->id_venta,
                    $d->fecha,
                    $d->hora,
                    $d->nombre,
                    $d->tipo,
                    $d->caja,
                    $d->usuario,
                    array('data' => number_format((empty($d->monto) ? 0 : $d->monto),2), 'style' => 'text-align: right;'),
                    anchor($this->folder.$this->clase.'ver/' . $d->id_venta . '/' . $desde .'/'. $hasta.'/'.$tipo. '/'. $offset, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
            if($d->cancelada == 's')
                $this->table->add_row_class ('danger');
            else
                $this->table->add_row_class ('');
        }
        $data['table'] = $this->table->generate();
    	
    	$this->load->view('ventas/ajustes/lista', $data);
    }
    
    public function ver( $id = NULL, $desde = NULL, $hasta = NULL, $tipo = NULL, $offset = 0 ){
        
        $this->load->model('venta','v');
        
        $venta = $this->v->get_by_id($id);
        if ( empty($id) OR $venta->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'lista');
    	}
    	
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/caja','ca');
        $this->load->model('usuario','u');
        
    	$data['titulo'] = 'Ventas <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'lista/' . $desde . '/'. $hasta.'/'.$tipo.'/'. $offset;
        
    	$data['action'] = $this->folder.$this->clase.'editar/' . $id . '/'. $desde . '/'. $hasta.'/'.$tipo. '/' . $offset;

    	$data['datos'] = $venta->row();
        $data['cliente'] = $this->c->get_by_id($data['datos']->id_cliente)->row();
        $data['usuario'] = $this->u->get_by_id($data['datos']->id_usuario)->row();
        $data['caja'] = $this->ca->get_by_id($data['datos']->id_caja)->row();
        
        $this->load->view('ventas/ajustes/vista', $data);
    }
    
    public function editar( $id = NULL, $desde = NULL, $hasta = NULL, $tipo = NULL, $offset = 0 ) {
        $this->load->model('venta','v');
        
        $venta = $this->v->get_by_id($id);
        if ( empty($id) OR $venta->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'lista');
    	}
        
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/caja','ca');
        $this->load->model('usuario','u');
        
        $data['titulo'] = 'Ventas <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'ver/'.$id . '/'. $desde . '/'. $hasta.'/'.$tipo.'/' . $offset;
    	
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'editar/' . $id . '/'. $desde . '/'. $hasta.'/'.$tipo. '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            $this->v->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'ver/'.$id . '/'. $desde . '/'. $hasta .'/'.$tipo .'/' . $offset);
    	}

        $data['datos'] = $this->v->get_by_id($id)->row();
        $data['cliente'] = $this->c->get_by_id($data['datos']->id_cliente)->row();
        $data['usuario'] = $this->u->get_by_id($data['datos']->id_usuario)->row();
        $data['caja'] = $this->ca->get_by_id($data['datos']->id_caja)->row();
        
        $this->load->view('ventas/ajustes/formulario', $data);
    }
}
?>
