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
    
    function count_by_fecha( $desde, $hasta, $filtro = null ) {
        $this->db->join('Cliente c','v.id_cliente = c.id_cliente');
        $this->db->join('Usuario u', 'v.id_usuario = u.id_usuario');
        $this->db->join('Empleado e','v.id_empleado = e.id_empleado');
        $this->db->join('Caja ca', 'v.id_caja = ca.id_caja');
        //$this->db->join('Venta_Articulo va', 'v.id_venta = va.id_venta');
        $this->db->where('v.fecha BETWEEN "'.$desde.'" AND "'.$hasta.'"');
        if(!empty($filtro)){
            $like = '(c.nombre LIKE "%'.$filtro.'%" 
                OR c.nombre_comercial LIKE "%'.$filtro.'%"
                OR v.id_venta = "'.$filtro.'"
                OR u.nombre LIKE "%'.$filtro.'%"
                OR ca.nombre LIKE "%'.$filtro.'%")';
            $this->db->where($like);
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
    
    function get_by_fecha( $desde, $hasta, $limit = NULL, $offset = 0, $filtro = null, $order_by_estado = FALSE ){
        $this->db->select('v.*, c.*, u.nombre AS usuario, ca.nombre AS caja, CONCAT(e.nombre, " ", e.apellido) AS empleado', FALSE);
        $this->db->join('Cliente c','v.id_cliente = c.id_cliente');
        $this->db->join('Usuario u', 'v.id_usuario = u.id_usuario');
        $this->db->join('Empleado e','v.id_empleado = e.id_empleado');
        $this->db->join('Caja ca', 'v.id_caja = ca.id_caja');
        $this->db->where('v.fecha BETWEEN "'.$desde.'" AND "'.$hasta.'"');
        if(!empty($filtro)){
            $like = '(c.nombre LIKE "%'.$filtro.'%" 
                OR c.nombre_comercial LIKE "%'.$filtro.'%"
                OR v.id_venta = "'.$filtro.'"
                OR u.nombre LIKE "%'.$filtro.'%"
                OR ca.nombre LIKE "%'.$filtro.'%")';
            $this->db->where($like);
        }
        $this->db->group_by('v.id_venta');
        if($order_by_estado)
            $this->db->order_by('v.cancelada desc');
        $this->db->order_by('ca.nombre, v.id_venta');
        return $this->db->get($this->tbl.' v', $limit, $offset);
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
    
    function get_articulos( $id = NULL ){
        $this->db->join('Articulo a','sa.id_articulo = a.id_articulo');
        $this->db->where('sa.id_venta',$id);
        $this->db->order_by('sa.id_venta_articulo');
        return $this->db->get('Salida_Articulo sa');
    }
    
    function get_acumulado_articulo( $id, $fecha = NULL, $hora = NULL){
        $this->db->select('SUM(sa.cantidad) AS cantidad', FALSE);
        $this->db->join('Salida_Articulo sa', 's.id_venta = sa.id_venta');
        $this->db->join('Articulo a', 'sa.id_articulo = a.id_articulo');
        $this->db->where('s.cancelada', 'n');
        $this->db->where('a.id_articulo', $id);
        if(!empty($fecha)){
            $this->db->where('s.fecha >=', $fecha);
        }
        if(!empty($hora)){
            $this->db->where('s.hora >=', $hora);
        }
        return $this->db->get($this->tbl.' s');
    }
    
    /**
    * ***********************************************************************
    * Actualizar recibo por id
    * ***********************************************************************
    */
    function update( $id, $datos ) {
        $this->db->where('id_venta', $id);
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
