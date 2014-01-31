<?php

/**
 * Description of cliente
 *
 * @author cherra
 */
class Cliente extends CI_Model {
    
    private $tbl = 'Cliente';
    
    function __construct() {
        parent::__construct();
        $db = $this->session->userdata('basededatos');
        $this->load->database($db);
    }
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_cliente',$f);
            }
        }
        $query = $this->db->get($this->tbl);
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('id_cliente','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_cliente',$f);
                $this->db->or_like('nombre',$f);
                $this->db->or_like('nombre_comercial',$f);
                $this->db->or_like('contacto',$f);
            }
        }
        $this->db->order_by('nombre','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_cliente', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_ultima_cuenta_contable(){
        $this->db->having('cuenta_contable BETWEEN 0 AND 50000');
        $this->db->select('cuenta_contable')->order_by('cuenta_contable','desc')->limit(1);
        $query = $this->db->get('Cliente');
        return $query->row_array();
    }
    
    /**
    * Alta
    */
    function save( $datos ) {
        $this->db->insert($this->tbl, $datos);
        return $this->db->insert_id();
    }

    /**
    * Actualizar por id
    */
    function update($id, $datos) {
        $this->db->where('id_cliente', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_cliente', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
