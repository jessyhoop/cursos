<?php

class Carreras extends CI_Controller {

    function __construct() {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->helper('url'); //agrega base_url
        $this->load->helper('form');
        //$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('carreras_model');
        $this->load->helper(array('download', 'file', 'url', 'html', 'form'));
    }

    public function index() {
        $this->load->view('ccaragon/carreras_view');
    }

    public function lista_carreras() {
        $lista_carreras = $this->carreras_model->get_carreras();
        echo json_encode($lista_carreras);
    }

    public function eliminar_materia() {
        $materia_eliminada = $this->carreras_model->eliminar_materia($this->input->post('id_materia'));
        echo json_encode($materia_eliminada);
    }

}

?>