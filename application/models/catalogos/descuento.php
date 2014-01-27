<?php
/**
 * Description of descuento
 *
 * @author cherra
 */
class Descuento extends CI_Model {
    
    private $tbl = 'Tarjeta_Cliente';
    
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_tarjeta',$f);
            }
        }
        $query = $this->db->get($this->tbl);
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('id_tarjeta','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_tarjeta',$f);
            }
        }
        $this->db->order_by('id_tarjeta','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_tarjeta', $id);
        return $this->db->get($this->tbl);
    }
    
    
    function count_by_cliente( $id, $filtro = NULL ) {
        $this->db->join('Articulo a','tc.id_articulo = a.id_articulo');
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('a.nombre',$f);
            }
        }
        $this->db->where('tc.id_cliente', $id);
        $query = $this->db->get($this->tbl.' tc');
        return $query->num_rows();
    }
    
    function get_by_cliente($id, $limit = NULL, $offset = 0, $filtro = NULL) {
        $this->db->join('Articulo a','tc.id_articulo = a.id_articulo');
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('a.nombre',$f);
            }
        }
        $this->db->where('tc.id_cliente', $id);
        $this->db->order_by('a.nombre');
        return $this->db->get($this->tbl.' tc', $limit, $offset);
    }
    
    function get_by_articulo($id) {
        $this->db->where('id_articulo', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_cliente_articulo($id_cliente, $id_articulo) {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('id_articulo', $id_articulo);
        return $this->db->get($this->tbl);
    }
    
    /**
    * Alta
    */
    function save( $datos ) {
        $this->db->where('id_cliente', $datos['id_cliente']);
        $this->db->where('id_articulo', $datos['id_articulo']);
        $this->db->delete($this->tbl);
        
        $this->db->insert($this->tbl, $datos);
        return $this->db->insert_id();
    }

    /**
    * Actualizar por id
    */
    function update($id, $datos) {
        $this->db->where('id_tarjeta', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_tarjeta', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
