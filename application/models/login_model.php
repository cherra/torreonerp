<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login model class
 */
class Login_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $db = $this->session->userdata('basededatos');
        $this->load->database($db);
    }
     
    public function validate(){
        // grab user input
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
         
        // Prep the query
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('eliminado','n');
        //$this->db->where("password = SHA1('$password')", NULL, FALSE);
         
        // Run the query
        $query = $this->db->get('Usuario');
        // Let's check if there are any results
        if($query->num_rows == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();
            $data = array(
                    'id_usuario' => $row->id_usuario,
                    'nombre' => $row->nombre,
                    'username' => $row->username,
                    'validado' => true
                    );
            $this->session->set_userdata($data);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
}
?>