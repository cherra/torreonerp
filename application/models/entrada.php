<?php

/**
 * Description of entrada
 *
 * @author cherra
 */
class Entrada extends CI_Model {
    
    private $tbl = 'Entrada_Almacen';
    
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_entrada',$f);
            }
        }
        $query = $this->db->get($this->tbl);
        return $query->num_rows();
    }
    
    function count_by_fecha( $desde, $hasta, $limit = NULL, $offset = 0, $filtro = null ){
        $this->db->select('e.*, p.*, u.nombre AS usuario', FALSE);
        $this->db->join('Proveedor p','e.id_proveedor = p.id_proveedor');
        $this->db->join('Usuario u', 'e.id_usuario = u.id_usuario');
        $this->db->where('e.fecha BETWEEN "'.$desde.'" AND "'.$hasta.'"');
        if(!empty($filtro)){
            $like = '(p.nombre LIKE "%'.$filtro.'%" 
                OR p.nombre_comercial LIKE "%'.$filtro.'%"
                OR e.id_entrada = "'.$filtro.'"
                OR u.nombre LIKE "%'.$filtro.'%")';
            $this->db->where($like);
        }
        $this->db->group_by('e.id_entrada');
        $query = $this->db->get($this->tbl.' e', $limit, $offset);
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('id_entrada','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_entrada',$f);
            }
        }
        $this->db->order_by('id_entrada','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    function get_by_fecha( $desde, $hasta, $limit = NULL, $offset = 0, $filtro = null, $order_by_estado = FALSE ){
        $this->db->select('e.*, p.*, u.nombre AS usuario', FALSE);
        $this->db->join('Proveedor p','e.id_proveedor = p.id_proveedor');
        $this->db->join('Usuario u', 'e.id_usuario = u.id_usuario');
        $this->db->where('e.fecha BETWEEN "'.$desde.'" AND "'.$hasta.'"');
        if(!empty($filtro)){
            $like = '(p.nombre LIKE "%'.$filtro.'%" 
                OR p.nombre_comercial LIKE "%'.$filtro.'%"
                OR e.id_entrada = "'.$filtro.'"
                OR u.nombre LIKE "%'.$filtro.'%")';
            $this->db->where($like);
        }
        $this->db->group_by('e.id_entrada');
        if($order_by_estado)
            $this->db->order_by('e.cancelada asc');
        $this->db->order_by('e.id_entrada');
        return $this->db->get($this->tbl.' e', $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_entrada', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_articulos( $id = NULL ){
        $this->db->join('Articulo a','eaa.id_articulo = a.id_articulo');
        $this->db->where('eaa.id_entrada',$id);
        $this->db->order_by('eaa.id_entrada_almacen_articulo');
        return $this->db->get('Entrada_Almacen_Articulo eaa');
    }
    
    function get_acumulado_articulo( $id, $fecha = NULL){
        $this->db->select('SUM(eaa.cantidad) AS cantidad', FALSE);
        $this->db->join('Entrada_Almacen_Articulo eaa', 'ea.id_entrada = eaa.id_entrada');
        $this->db->join('Articulo a', 'eaa.id_articulo = a.id_articulo');
        $this->db->where('ea.cancelada','n');
        $this->db->where('a.id_articulo', $id);
        if(!empty($fecha)){
            $this->db->where('ea.fecha >=', $fecha);
        }
        return $this->db->get($this->tbl.' ea');
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
        $this->db->where('id_entrada', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_entrada', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
