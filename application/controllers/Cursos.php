<?php

class Cursos extends CI_Controller {

    function __construct() {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->helper('url'); //agrega base_url
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');

        $this->load->model('cursos_model');
        $this->load->model('cursos_alumno_model');
        $this->load->model('carreras_model');
        $this->load->model('usuarios_model');
    }

    public function index() {
        $this->load->view('ccaragon/home_cursos');
    }

    public function cursos_view() {
        $this->load->view('ccaragon/cursos_view'
        );
    }

    public function lista_profesores() {
        $lista_pro = $this->usuarios_model->get_usuarios();
//        print_r($lista_pro);
        echo json_encode($lista_pro);
    }

    public function lista_profesores_eval() {
        $lista_pro = $this->usuarios_model->get_profesores_activos();
//        print_r($lista_pro);
        echo json_encode($lista_pro);
    }

    public function lista_carreras() {
        $lista_carreras = $this->carreras_model->get_carreras();
        echo json_encode($lista_carreras);
    }

    public function lista_cursos() {
        $lista_cursos = $this->cursos_model->get_cursos_by_profesor( 
                $this->session->userdata('id_profesor')
);
        echo json_encode($lista_cursos);
    }

    public function get_alumnos_by_curso() {
        $lista_alumnos = $this->cursos_alumno_model->get_alumnos_by_curso( 
                $this->input->get('id_curso')
                
);
        echo json_encode($lista_alumnos);
    }

    public function insert_curso() {
        $this->form_validation->set_rules('carrera_id_curso', 'carrera_id_curso', 'trim|required');
        $this->form_validation->set_rules('curso_curso', 'curso_curso', 'trim|required');
        $this->form_validation->set_rules('turno_curso', 'turno_curso', 'trim|required');
        $this->form_validation->set_rules('cupo_curso', 'cupo_curso', 'trim|required');
        $this->form_validation->set_rules('fecha_inicio_curso', 'fecha_inicio_curso', 'trim|required');
        $this->form_validation->set_rules('fecha_fin_curso', 'fecha_inicio_curso', 'trim|required');
        $this->form_validation->set_rules('hora_inicio_curso', 'hora_inicio_curso', 'trim|required');
        $this->form_validation->set_rules('hora_fin_curso', 'hora_fin_curso', 'trim|required');
        if ($this->form_validation->run()) {
            $bool_fecha_incio_curso = $this->_format_date_mysql($this->input->post('fecha_inicio_curso'));
            $bool_fecha_fin_curso = $this->_format_date_mysql($this->input->post('fecha_fin_curso'));
            if ($bool_fecha_incio_curso && $bool_fecha_fin_curso) {
                $existe_curso = $this->cursos_model->valida_existe_curso(
            $this->input->post('carrera_id_curso'), 
                        $this->input->post('curso_curso'),
                        $this->input->post('turno_curso'), 
                        $this->session->userdata('id_profesor'),
                        $bool_fecha_incio_curso, 
                        $bool_fecha_fin_curso, 
                        $this->input->post('hora_inicio_curso'),
                        $this->input->post('hora_fin_curso')
                );
                if ($existe_curso ['cantidad'] > 0) {//verificamos que la clave de la materia  no exista  en la bd  para poder  ingrasar los datos de la nueva materia
                    return FALSE;
                } else {


                    $this->cursos_model->insert_datos_curso(
                            $this->input->post('carrera_id_curso'),
                            $this->input->post('curso_curso'), 
                            $this->input->post('turno_curso'), 
                            $this->session->userdata('id_profesor'), $bool_fecha_incio_curso, $bool_fecha_fin_curso, $this->input->post('hora_inicio_curso'), $this->input->post('hora_fin_curso'), $this->input->post('cupo_curso'), 1);
                    echo "formulario guardado con exito";
                }
            } else {
                echo 'La fecha no es una fecha valida o est&aacute; en el formato diferente al (dd/mm/aaaa) ';
            }
        } else {

            echo "Campos indvalidos";
// echo $this->session->userdata('nombre');
        }
    }

    public function update_curso() {
        $fecha_inicio = '';
        $fecha_fin = '';
        $fecha_inicio = ($this->input->post('fecha_inicio_curso_edit'));
        $fecha_fin = ($this->input->post('fecha_fin_curso_edit'));
        //  $this->form_validation->set_rules('turno_curso_edit', 'turno_curso_edit', 'trim|required');
        //        $this->form_validation->set_rules('carrera_id_curso_edit', 'carrera_id_curso_edit', 'trim|required');
        //        $this->form_validation->set_rules('curso_curso_edit', 'curso_curso_edit', 'trim|required');
        //        $this->form_validation->set_rules('fecha_inicio_curso_edit', 'fecha_inicio_curso_edit', 'trim|required');
        //        $this->form_validation->set_rules('fecha_fin_curso_edit', 'fecha_fin_curso_edit', 'trim|required');
        //        $this->form_validation->set_rules('hora_inicio_curso_edit', 'hora_inicio_curso_edit', 'trim|required');
        //        $this->form_validation->set_rules('hora_fin_curso_edit', 'hora_fin_curso_edit', 'trim|required');
//        if ($this->form_validation->run()) {
        if (!strpos($fecha_inicio, "-")) {
            $fecha_inicio = $this->_format_date_mysql($this->input->post('fecha_inicio_curso_edit'));
        }
        if (!strpos($fecha_fin, "-")) {
            $fecha_fin = $this->_format_date_mysql($this->input->post('fecha_fin_curso_edit'));
        }
        
        $this->cursos_model->update_datos_curso(
                $this->input->post('id_curso'),
                $this->input->post('turno_curso_edit'), 
                $this->input->post('carrera_id_curso_edit'),
                $this->input->post('curso_curso_edit'),
                $this->input->post('cupo_curso_edit'),
                $fecha_inicio, $fecha_fin, 
                $this->input->post('hora_inicio_curso_edit'), 
                $this->input->post('hora_fin_curso_edit'));
        echo "formulario editado con exito";
    }

    public function eliminar_curso() {

        $curso_eliminada = $this->cursos_model->eliminar_curso($this->input->post('idcurso'));
        echo json_encode($curso_eliminada);
    }


    private function _format_date_mysql($fecha) {//changes format a date to mysql format LLEGA COMO AAAA-MM-DD
        if ($fecha != "") {
            $date = explode('-', $fecha);
            if (count($date) === 3) {//valida que vengan los 3 datos separados por / array.length = 3
                if (checkdate($date[1], $date[2], $date[0])) {//mm/d/a
                    //int $month , int $day , int $year
                    //09/20/2018
                    return $date[0] . '-' . $date[1] . '-' . $date[2]; //aa-mm-d
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}

?>