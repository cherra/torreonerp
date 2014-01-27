<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rol_model
 *
 * @author cherra
 */
class Usuario extends CI_Model {
    
    private $tbl = "Usuario";
    private $tbl_permisos = "PermisosUsuario";
    private $tbl_roles = "RolesUsuario";
    
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('nombre', $f);
                $this->db->or_like('apellido', $f);
            }
        }
        $query = $this->db->get($this->tbl);
        return $query->num_rows;
    }
    
    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($limit = null, $offset = 0, $filtro = NULL) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('nombre', $f);
                $this->db->or_like('apellido', $f);
            }
        }
        $this->db->order_by('nombre','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * ***********************************************************************
    * Obtener usuario por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id_usuario', $id);
        return $this->db->get($this->tbl);
    }
    
    /**
    * ***********************************************************************
    * Alta de usuario
    * ***********************************************************************
    */
    function save($usuario) {
        $this->db->insert($this->tbl, $usuario);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar usuario por id
    * ***********************************************************************
    */
    function update($id, $usuario) {
        $this->db->where('id_usuario', $id);
        $this->db->update($this->tbl, $usuario);
    }

    /**
    * ***********************************************************************
    * Eliminar usuario por id
    * ***********************************************************************
    */
    function delete($id) {
        $this->db->where('id_usuario', $id);
        $this->db->delete($this->tbl);
    }
    
    /**
    * ***********************************************************************
    * Obtener permisos del usuario por id
    * ***********************************************************************
    */
    function get_permiso_by_id($id_permiso, $id_usuario) {
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('id_permiso', $id_permiso);
        return $this->db->get($this->tbl_permisos);
    }
    
    function update_permisos( $id, $permisos ){
        if(!empty($permisos)){
            $this->db->delete($this->tbl_permisos, array('id_usuario' => $id));
            $this->db->insert_batch($this->tbl_permisos, $permisos);
        }
    }
    
    /**
    * ***********************************************************************
    * Obtener roles del usuario por id
    * ***********************************************************************
    */
    function get_rol_by_id($id_rol, $id_usuario) {
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('id_rol', $id_rol);
        return $this->db->get($this->tbl_roles);
    }
    
    function update_roles( $id, $roles ){
        if(!empty($roles)){
            $this->db->delete($this->tbl_roles, array('id_usuario' => $id));
            $this->db->insert_batch($this->tbl_roles, $roles);
        }
    }

}

?>
