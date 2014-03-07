<?php
/**
  *
 * @author cherra
 */
class Salida extends CI_Model{
    
    private $tbl = 'Salida'; 
    
    function __construct() {
        parent::__construct();
    }
    
    /**
    * ***********************************************************************
    * Cantidad de registros
    * ***********************************************************************
    */
    function count_all( $filtro = null ) {
        $this->db->join('Cliente c','v.id_cliente = c.id_cliente');
        $this->db->join('Usuario u', 'v.id_usuario = u.id_usuario');
        $this->db->join('Empleado e','v.id_empleado = e.id_empleado');
        $this->db->join('Caja ca', 'v.id_caja = ca.id_caja');
        //$this->db->join('Venta_Articulo va', 'v.id_venta = va.id_venta');
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $like = '(c.nombre LIKE "%'.$f.'%" 
                    OR c.nombre_comercial LIKE "%'.$f.'%"
                    OR v.id_venta = "'.$f.'")';
                $this->db->where($like);
            }
        }
        $this->db->group_by('v.id_venta');
        $query = $this->db->get($this->tbl.' v');
        return $query->num_rows();
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($limit = null, $offset = 0, $filtro = null) {
        $this->db->select('v.*, c.*, CONCAT(u.nombre, " ", u.apellido) AS usuario, ca.nombre AS caja, CONCAT(e.nombre, " ", e.apellido) AS empleado', FALSE);
        $this->db->join('Cliente c','v.id_cliente = c.id_cliente');
        $this->db->join('Usuario u', 'v.id_usuario = u.id_usuario');
        $this->db->join('Empleado e','v.id_empleado = e.id_empleado');
        $this->db->join('Caja ca', 'v.id_caja = ca.id_caja');
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $like = '(c.nombre LIKE "%'.$f.'%" 
                    OR c.nombre_comercial LIKE "%'.$f.'%"
                    OR v.id_venta = "'.$f.'")';
                $this->db->where($like);
            }
        }
        $this->db->group_by('v.id_venta');
        $this->db->order_by('v.id_venta','desc');
        return $this->db->get($this->tbl.' v',$limit, $offset);
    }
    
    function get_by_fecha( $desde, $hasta, $filtro = null ){
        $this->db->select('v.*, c.*, CONCAT(u.nombre, " ", u.apellido) AS usuario, ca.nombre AS caja, CONCAT(e.nombre, " ", e.apellido) AS empleado, SUM(sa.cantidad) AS cantidad', FALSE);
        $this->db->join('Salida_Articulo sa', 'v.id_venta = sa.id_venta');
        $this->db->join('Cliente c','v.id_cliente = c.id_cliente');
        $this->db->join('Usuario u', 'v.id_usuario = u.id_usuario');
        $this->db->join('Empleado e','v.id_empleado = e.id_empleado');
        $this->db->join('Caja ca', 'v.id_caja = ca.id_caja');
        $this->db->where('v.fecha BETWEEN "'.$desde.'" AND "'.$hasta.'"');
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $like = '(c.nombre LIKE "%'.$f.'%" 
                    OR c.nombre_comercial LIKE "%'.$f.'%"
                    OR v.id_venta = "'.$f.'")';
                $this->db->where($like);
            }
        }
        $this->db->group_by('v.id_venta');
        $this->db->order_by('v.cancelada desc, ca.nombre, v.id_venta');
        return $this->db->get($this->tbl.' v');
    }
    
    /**
    * ***********************************************************************
    * Obtener recibo por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id_venta', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_last(){
        $this->db->order_by('id_venta', 'desc');
        return $this->db->get($this->tbl, 1);
    }
    
    /**
    * ***********************************************************************
    * Actualizar recibo por id
    * ***********************************************************************
    */
    function update( $id, $datos ) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $datos);
    }

    
    /**
    * ***********************************************************************
    * Cancelar
    * ***********************************************************************
    */
    function cancelar( $id ) {
        $this->db->where('id_venta', $id);
        $this->db->update($this->tbl, array('cancelada' => 's'));
    }

}

?>
