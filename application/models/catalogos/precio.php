<?php
/**
 * Description of precio
 *
 * @author cherra
 */
class Precio extends CI_Model {
    
    private $tbl = 'Articulo_Lista';
    private $tbl_articulo = 'Articulo';
    
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL, $id_lista = NULL ) {
        $this->db->join($this->tbl_articulo.' a', 'al.id_articulo = a.id_articulo', 'left');
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('a.nombre',$f);
            }
        }
        if(!empty($id_lista))
            $this->db->where('al.id_lista', $id_lista);
        $query = $this->db->get($this->tbl.' al');
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('id_ArticuloLista','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL, $id_lista = NULL) {
        $this->db->join($this->tbl_articulo.' a', 'al.id_articulo = a.id_articulo', 'left');
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('a.nombre',$f);
            }
        }
        if(!empty($id_lista))
            $this->db->where('al.id_lista', $id_lista);
        $this->db->order_by('a.nombre','asc');
        return $this->db->get($this->tbl.' al', $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_ArticuloLista', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_articulo($id) {
        $this->db->where('id_articulo', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_lista($id) {
        $this->db->join($this->tbl_articulo.' a', 'al.id_articulo = a.id_articulo');
        $this->db->where('al.id_lista', $id);
        return $this->db->get($this->tbl.' al');
    }
    
    function get_precio($id_articulo, $id_lista) {
        $this->db->where('id_articulo', $id_articulo);
        $this->db->where('id_lista', $id_lista);
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
    function update($id_lista, $id_articulo, $datos) {
        $this->db->where('id_lista', $id_lista);
        $this->db->where('id_articulo', $id_articulo);
        $this->db->update($this->tbl, $datos);
        return $this->db->affected_rows();
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_ArticuloLista', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
