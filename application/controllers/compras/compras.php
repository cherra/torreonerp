<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of compras
 *
 * @author cherra
 */
class Compras extends CI_Controller {
    
    private $folder = 'compras/';
    private $clase = 'compras/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('vacio');
    }
}
?>
