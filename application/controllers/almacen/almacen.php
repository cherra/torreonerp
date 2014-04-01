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
    
    public function salidas( $desde = NULL, $hasta = NULL, $offset = 0 ){
        $this->load->model('salida','v');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Ajustes de salidas <small>Lista</small>';
        if(empty($desde))
            $desde = date('Y-m-d');
        if(empty($hasta))
            $hasta = date('Y-m-d');
    	//$data['link_add'] = $this->folder.$this->clase.'lineas_agregar/'. $offset;
    	$data['action'] = $this->folder.$this->clase.'salidas';

        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;

        $data['desde'] = $desde;
        $data['hasta'] = $hasta;
        $page_limit = $this->config->item("per_page");
        $datos = $this->v->get_by_fecha($desde, $hasta, $page_limit, $offset, $filtro)->result();

        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url($this->folder.$this->clase.'salidas/'.$desde.'/'.$hasta);
        $config['total_rows'] = $this->v->count_by_fecha($desde, $hasta, $filtro);
        $config['per_page'] = $page_limit;
        $config['uri_segment'] = 6;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Folio', 'Fecha', 'Hora', 'Cliente', 'Caja', 'Usuario', 'C', '');
        foreach ($datos as $d) {
            $this->table->add_row(
                    $d->id_venta,
                    $d->fecha,
                    $d->hora,
                    $d->nombre,
                    $d->caja,
                    $d->usuario,
                    array('data' => $d->cancelada, 'style' => 'text-align: center;'),
                    anchor($this->folder.$this->clase.'salidas_ver/' . $d->id_venta . '/' . $desde .'/'. $hasta. '/'. $offset, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
        }
        $data['table'] = $this->table->generate();
    	
    	$this->load->view('lista_fechas', $data);
    }
    
    public function salidas_ver( $id = NULL, $desde = NULL, $hasta = NULL, $offset = 0 ){
        
        $this->load->model('salida','v');
        
        $venta = $this->v->get_by_id($id);
        if ( empty($id) OR $venta->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'salidas');
    	}
    	
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/caja','ca');
        $this->load->model('usuario','u');
        
    	$data['titulo'] = 'Salidas <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'salidas/' . $desde . '/'. $hasta.'/'. $offset;
        
    	$data['action'] = $this->folder.$this->clase.'salidas_editar/' . $id . '/'. $desde . '/'. $hasta. '/' . $offset;

    	$data['datos'] = $venta->row();
        $data['cliente'] = $this->c->get_by_id($data['datos']->id_cliente)->row();
        $data['usuario'] = $this->u->get_by_id($data['datos']->id_usuario)->row();
        $data['caja'] = $this->ca->get_by_id($data['datos']->id_caja)->row();
        
        $this->load->view('almacen/ajustes/vista', $data);
    }
    
    public function salidas_editar( $id = NULL, $desde = NULL, $hasta = NULL, $offset = 0 ) {
        $this->load->model('salida','v');
        
        $venta = $this->v->get_by_id($id);
        if ( empty($id) OR $venta->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'salidas');
    	}
        
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/caja','ca');
        $this->load->model('usuario','u');
        
        $data['titulo'] = 'Salidas <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'salidas_ver/'.$id . '/'. $desde . '/'. $hasta.'/' . $offset;
    	
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'salidas_editar/' . $id . '/'. $desde . '/'. $hasta. '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            $this->v->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'salidas_ver/'.$id . '/'. $desde . '/'. $hasta .'/' . $offset);
    	}

        $data['datos'] = $this->v->get_by_id($id)->row();
        $data['cliente'] = $this->c->get_by_id($data['datos']->id_cliente)->row();
        $data['usuario'] = $this->u->get_by_id($data['datos']->id_usuario)->row();
        $data['caja'] = $this->ca->get_by_id($data['datos']->id_caja)->row();
        
        $this->load->view('almacen/ajustes/formulario', $data);
    }
    
    public function existencias( $offset = 0 ){
        
        $this->load->model('catalogos/linea','l');
        $this->load->model('catalogos/presentacion','p');
        $this->load->model('inventario_inicial','ii');
        $this->load->model('salida','s');
        $this->load->model('entrada','e');
        $this->load->model('venta','v');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Existencias <small>Lista</small>';
    	$data['action'] = $this->folder.$this->clase.'existencias/'. $offset;
        
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
    	$this->table->set_heading('Nombre', 'Código', 'Tipo', 'Línea', 'Fecha', 'Hora', 'Stock inicial', 'Entradas', 'Salidas', 'Ventas', 'Stock');
    	foreach ($datos as $d) {
            $stock = 0;
            $linea = $this->l->get_by_id($d->id_linea)->row();
            $inventario_inicial = $this->ii->get_last_by_id($d->id_articulo)->row();
            $entradas = $this->e->get_acumulado_articulo($d->id_articulo, !empty($inventario_inicial) ? $inventario_inicial->fecha.' '.$inventario_inicial->hora : NULL)->row();
            $salidas = $this->s->get_acumulado_articulo($d->id_articulo, !empty($inventario_inicial) ? $inventario_inicial->fecha : NULL, !empty($inventario_inicial) ? $inventario_inicial->hora : NULL)->row();
            $ventas = $this->v->get_acumulado_articulo($d->id_articulo, !empty($inventario_inicial) ? $inventario_inicial->fecha : NULL, !empty($inventario_inicial) ? $inventario_inicial->hora : NULL)->row();
            $stock += !empty($inventario_inicial) ? $inventario_inicial->cantidad : 0;
            $stock += !empty($entradas) ? $entradas->cantidad : 0;
            $stock -= !empty($salidas) ? $salidas->cantidad : 0;
            $stock -= !empty($ventas) ? $ventas->cantidad : 0;
            $this->table->add_row(
                    $d->nombre,
                    $d->codigo,
                    $d->tipo,
                    (!empty($linea->nombre) ? $linea->nombre : ''),
                    !empty($inventario_inicial->fecha) ? $inventario_inicial->fecha : '',
                    !empty($inventario_inicial->hora) ? $inventario_inicial->hora : '',
                    !empty($inventario_inicial->cantidad) ? $inventario_inicial->cantidad : '',
                    !empty($entradas->cantidad) ? number_format($entradas->cantidad, 2) : '',
                    !empty($salidas->cantidad) ? number_format($salidas->cantidad, 2) : '',
                    !empty($ventas->cantidad) ? number_format($ventas->cantidad, 2) : '',
                    array('data' => '<strong>'.number_format($stock, 2).'</strong>', 'class' => 'text-right')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
}
?>
