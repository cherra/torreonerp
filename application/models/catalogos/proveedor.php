<?php
/**
 * Description of proveedor
 *
 * @author cherra
 */
class Proveedor extends CI_Model {
    
    private $tbl = 'Proveedor';
    
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
            //$filtro = explode(' ', $filtro);
            //foreach($filtro as $f){
                $this->db->or_like('razon_social',$filtro);
                $this->db->or_like('nombre_comercial',$filtro);
                $this->db->or_like('contacto',$filtro);
            //}
        }
        $query = $this->db->get($this->tbl);
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('razon_social','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        if(!empty($filtro)){
            //$filtro = explode(' ', $filtro);
            //foreach($filtro as $f){
                $this->db->or_like('razon_social',$filtro);
                $this->db->or_like('nombre_comercial',$filtro);
                $this->db->or_like('contacto',$filtro);
            //}
        }
        $this->db->order_by('razon_social','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_proveedor', $id);
        return $this->db->get($this->tbl);
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
        $this->db->where('id_proveedor', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_proveedor', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
