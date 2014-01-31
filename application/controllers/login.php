<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public $layout = 'welcome';
    
    function __construct() {
        parent::__construct();
        // En el formulario de login se define la base de datos en la que se va a trabajar
        if(($datos = $this->input->post())){
            if(!empty($datos['basededatos'])){
                $this->session->set_userdata('basededatos', $datos['basededatos']);
                //$this->config->set_item('basededatos', $datos['basededatos']);
            }else{
                redirect('login');
            }
        }
    }

    /*
    * Muestra en pantalla el login del sistema
    */
    public function index( $msg = '' ) {
        $data['msg'] = $msg;
        $this->load->view('login', $data);
    }
        
    public function process(){
        $this->load->model('login_model');
        $result = $this->login_model->validate(); // Validamos que el usuario puede logearse
        
        // Verificamos el resultado de la validacion
        if(! $result){
            // Si el usuario no es valido, lo regresamos al login
            $msg = 'Usuario o contraseña inválidos.';
            $this->index($msg);
        }else{
            // Si el usuario valida, lo redireccionamos al home
            redirect('home');
        }       
    }
    
    // Método para destruir la sesión del usuario
    public function do_logout(){
        $this->session->sess_destroy();
        redirect('login'); // Inmediatamente después lo redireccionamos al login
    }

}

?>