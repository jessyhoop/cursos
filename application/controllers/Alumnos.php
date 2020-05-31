<?php

class Alumnos extends CI_Controller {

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
        $this->load->view('ccaragon/home_user_alumno');
    }

    public function lista_cursos() {
        $lista_cursos = $this->cursos_model->get_cursos_all(
        );
        echo json_encode($lista_cursos);
    }

    public function lista_curso_by_id() {
        $lista_cursos = $this->cursos_model->get_curso_by_id(
                $this->input->get('idcurso'));
        $lista_cursos['registrados'] = $this->cursos_alumno_model->count_alumnos_by_curso($this->input->get('idcurso'));
        echo json_encode($lista_cursos);
    }

    public function get_cursos_by_alumno() {
        $lista_cursos = $this->cursos_alumno_model->
                get_cursos_by_alumno($this->session->userdata('id_alumno'));
        echo json_encode($lista_cursos);
    }

//insert_curso_alumno
    public function insert_curso_alumno() {
        $this->form_validation->set_rules('lista_de_cursos', 'ID de curso', 'trim|required');
        if ($this->form_validation->run()) {
            $existe_curso = $this->cursos_alumno_model->valida_existe_alumno_curso(
                    $this->input->post('lista_de_cursos'), $this->session->userdata('id_alumno')
            );
            if ($existe_curso ['cantidad'] > 0) {//verificamos que la clave de la materia  no exista  en la bd  para poder  ingrasar los datos de la nueva materia
                echo json_encode(array("mensaje" => "Ya  registraste este curso", "codigo" => 401));
            } else {
                $cantidad_cursos_by_alumno = $this->cursos_alumno_model->count_alumnos_by_curso($this->input->post('lista_de_cursos'));
                $cantidad_cupo_by_curso = $this->cursos_model->get_cupo_by_curso($this->input->post('lista_de_cursos'));
                if ($cantidad_cursos_by_alumno['cantidad'] < $cantidad_cupo_by_curso['cupo']) {
                    $this->cursos_alumno_model->insert_alumno_curso($this->session->userdata('id_alumno'), $this->input->post('lista_de_cursos'), 1);
                    echo json_encode(array("mensaje" => 'Curso registrado con exito', "codigo" => 201));
                } else {
//
                    echo json_encode(array("mensaje" => "Ya no hay cupo para el curso", "codigo" => 401));
                }
            }
        }
    }

    public function eliminar_curso() {
        $curso = $this->cursos_alumno_model->eliminar_alumno_curso($this->input->get('idcurso'));
        echo json_encode($curso);
    }

}

?>