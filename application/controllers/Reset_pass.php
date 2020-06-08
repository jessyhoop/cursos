<?php

class Reset_pass extends CI_Controller {

    function __construct() {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->helper('url'); //agrega base_url
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');

        $this->load->model('cursos_model');
        $this->load->model('carreras_model');
        $this->load->model('usuarios_model');
        $this->load->model('cursos_alumno_model');
    }

    public function index() {
        $this->load->view('ccaragon/reset_pass_view');
    }

    public function get_existe_usuario() {
        $existe = $this->usuarios_model->get_existe_usuario_by_correo_num_cuenta(
                $this->input->post('correo_usuario'), $this->input->post('numcuenta_usuario')
        );
        echo json_encode($existe);
    }
    

    public function update_usuario_passwd() {
        $this->form_validation->set_rules('passwd_usuario_edit', 'passwd_usuario_edit', 'trim|required|exact_length[8]');
        if ($this->form_validation->run() !== FALSE) {
            $this->usuarios_model->update_passwd_usuario(
                    $this->input->post('idreg_usuario'), $this->input->post('passwd_usuario_edit')
            );
            echo TRUE;
        } else {
            return FALSE;
        }
    }

}

?>