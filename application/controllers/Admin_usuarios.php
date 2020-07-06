<?php

class Admin_usuarios extends CI_Controller {

    function __construct() {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->helper('url'); //agrega base_url
        $this->load->helper('form');
        //$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('usuarios_model');
        $this->load->model('profesores_model');
        $this->load->model('alumnos_model');
        $this->load->model('carreras_model');
    }

    public function index() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $data['titulo'] = 'Bienvenido ';
            $this->load->view('ccaragon/home_usuarios', $data);
        }
    }

    public function profesores_view() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $data['titulo'] = 'Bienvenido ';
            $this->load->view('ccaragon/admin_profesores_view', $data);
        }
    }

    public function alumnos_view() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $data['titulo'] = 'Bienvenido ';
            $this->load->view('ccaragon/admin_alumnos_view', $data);
        }
    }

    public function insert_usuario_profesor() {
        $this->form_validation->set_rules('correo_usuario', 'correo de usuario', 'trim|required|regex_match[/^[_a-z0-9-]+(.[_a-z0-9-]+)*@(aragon.unam.mx)$/]');
        $this->form_validation->set_rules('apellidop_usuario', 'Apellido Peterno', 'trim|required');
        $this->form_validation->set_rules('apellidom_usuario', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_rules('nombre_usuario', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_rules('passwd_usuario', 'passwd_usuario', 'trim|required|exact_length[8]');
        $this->form_validation->set_rules('numcuenta_usuario', 'Numero de cuenta', 'trim|required'
        );
        $this->form_validation->set_rules('rfc_usuario', 'RFC', 'trim|required|exact_length[13]');
        //validacion de datos
        if ($this->form_validation->run()) {
            $valida_existe_usuario = $this->usuarios_model->valida_existe_usuario($this->input->post('correo_usuario'));
            if ($valida_existe_usuario['cantidad'] > 0) {
                echo json_encode(array("mensaje" => "El usuario ya existe (intenta con otro correo)", "codigo" => 404));
            } else {
                $valida_existe_usuario_profesor = $this->profesores_model->valida_existe($this->input->post('numcuenta_usuario'), $this->input->post('rfc_usuario'));
                if ($valida_existe_usuario_profesor['cantidad'] > 0) {
                    echo json_encode(array("mensaje" => "usuario ya esta registrado con los mismo datos", "codigo" => 401));
                } else {
                    //se inserta el usuario primero y luego al alumno con el id retornado
                    $id_usuario = $this->usuarios_model->insert_datos_usuario(
                            $this->input->post('correo_usuario'), $this->input->post('passwd_usuario'), 2, 1);
                    $this->profesores_model->
                            insert($this->input->post('nombre_usuario'), $this->input->post('apellidop_usuario'), $this->input->post('apellidom_usuario'), $this->input->post('rfc_usuario'), $this->input->post('numcuenta_usuario'), 1, $id_usuario);
                    echo json_encode(array("mensaje" => "Registro creado con exito", "codigo" => 200));
                }
            }
        } else {
            echo json_encode(array("mensaje" => str_replace("\n", "", validation_errors()), "codigo" => 404));
        }
    }

    public function insert_usuario_alumno() {
        $data = [];
        $this->form_validation->set_rules('correo_usuario', 'correo de usuario', 'trim|required|valid_email');
        $this->form_validation->set_rules('apellidop_usuario', 'Apellido Peterno', 'trim|required');
        $this->form_validation->set_rules('apellidom_usuario', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_rules('nombre_usuario', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_rules('passwd_usuario', 'passwd_usuario', 'trim|required|exact_length[8]');
        $this->form_validation->set_rules('numcuenta_usuario', 'Numero de cuenta', 'trim|required|min_length[6]|max_length[9]');
        $this->form_validation->set_rules('rfc_usuario', 'RFC', 'trim|required|exact_length[13]');
        $this->form_validation->set_rules('carrera1', 'carrera1', 'trim|required');
        //validacion de datos
        if ($this->form_validation->run()) {
            $valida_existe_usuario = $this->usuarios_model->valida_existe_usuario(
                    $this->input->post('correo_usuario'));
            if ($valida_existe_usuario['cantidad'] > 0) {
                echo json_encode(array("mensaje" => "El usuario ya existe (intenta con otro correo)", "codigo" => 404));
            } else {
                $valida_existe_usuario_alumno = $this->alumnos_model->valida_existe_alumno(
                        $this->input->post('numcuenta_usuario'), $this->input->post('rfc_usuario'));
                if ($valida_existe_usuario_alumno['cantidad'] > 0) {
                    echo json_encode(array("mensaje" => "usuario ya esta registrado con los mismo datos", "codigo" => 404));
                } else {
                    $data = $this->input->post();
//                    print_r($data);
                    $registrar_alumno = $this->usuarios_model->insert_usuario_alumno($data);
                    if ($registrar_alumno) {
                        echo json_encode(array("mensaje" => "Registro creado con exito", "codigo" => 200));
                    } else {
                        echo json_encode(array("mensaje" => "Registro no creado", "codigo" => 404));
                    }
                }
            }
        } else {
            echo json_encode(array("mensaje" => str_replace("\n", "", validation_errors()), "codigo" => 404));
        }
    }

    public function lista_carreras() {
        $lista_carreras = $this->carreras_model->get_carreras();
        echo json_encode($lista_carreras);
    }

    public function lista_profesores() {
        $lista_pro = $this->profesores_model->get_profesores();
        echo json_encode($lista_pro);
    }

    public function lista_alumnos() {
        $lista_alumnos = $this->alumnos_model->get_alumnos();
        for ($i = 0; $i < count($lista_alumnos); $i++) {
            $lista_alumnos_carrera [] = array(
                'carrera' => $this->alumnos_model->get_carreras_by_alumno($lista_alumnos[$i]['idalumno']),
                'nombre_com' => $lista_alumnos[$i]['nombre_com'],
                'correoelectronico' => $lista_alumnos[$i]['correoelectronico'],
                'idalumno' => $lista_alumnos[$i]['idalumno'],
                'nombre' => $lista_alumnos[$i]['nombre'],
                'apellidop' => $lista_alumnos[$i]['apellido_p'],
                'apellidom' => $lista_alumnos[$i]['apellido_m'],
                'num_cuenta' => $lista_alumnos[$i]['num_cuenta'],
                'usuario_idusuario' => $lista_alumnos[$i]['usuario_idusuario'],
                'rfc' => $lista_alumnos[$i]['rfc']
            );
        }
//        echo '<pre>';
//        print_r($lista_alumnos_carrera);
//        echo '</pre>';
        echo json_encode($lista_alumnos_carrera);
    }

    public function update_usuario_profesor() {
        $this->form_validation->set_rules('correo_usuario_edit', 'correo de usuario', 'trim|required|regex_match[/^[_a-z0-9-]+(.[_a-z0-9-]+)*@(aragon.unam.mx)$/]');
        $this->form_validation->set_rules('apellidop_usuario_edit', 'Apellido Peterno', 'trim|required');
        $this->form_validation->set_rules('apellidom_usuario_edit', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_rules('nombre_usuario_edit', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_rules('numcuenta_usuario_edit', 'Numero de cuenta', 'trim|required');
        $this->form_validation->set_rules('rfc_usuario_edit', 'RFC', 'trim|required|exact_length[13]');
        //validacion de datos
        if ($this->form_validation->run()) {
            $valida_existe_usuario = $this->usuarios_model->
                    valida_existe_usuario_update($this->input->post('correo_usuario_edit'), $this->input->post('id_usuario')
            );
            if ($valida_existe_usuario['cantidad'] == 0) {
                $valida_existe_usuario_profesor = $this->profesores_model->
                        valida_existe_profesor_update
                        ($this->input->post('numcuenta_usuario_edit'), $this->input->post('rfc_usuario_edit'), $this->input->post('id_usuario')
                );

//                echo $valida_existe_usuario_profesor['cantidad'];
                if ($valida_existe_usuario_profesor['cantidad'] == 0
                ) {
                    $this->usuarios_model->update_usuario(
                            $this->input->post('id_usuario'), $this->input->post('correo_usuario_edit')
                    );
                    $this->profesores_model->
                            update_profesor($this->input->post('nombre_usuario_edit')
                                    , $this->input->post('apellidop_usuario_edit'), $this->input->post('apellidom_usuario_edit'), $this->input->post('rfc_usuario_edit'), $this->input->post('numcuenta_usuario_edit'), $this->input->post('id_usuario')
                    );
                    echo json_encode(array("mensaje" => "Registro Actualizado con exito", "codigo" => 200));
                } else {
                    echo json_encode(array("mensaje" => "usuario ya esta registrado con el mismo RFC/Cuenta", "codigo" => 401));
                }
            } else {
                echo json_encode(array("mensaje" => "usuario ya esta registrado con el mismo correo electronico", "codigo" => 401));
            }
        } else {
            echo json_encode(array("mensaje" => str_replace("\n", "", validation_errors()), "codigo" => 404));
        }
    }

    public function update_usuario_alumno() {
        $this->form_validation->set_rules('correo_usuario_edit', 'correo de usuario', 'trim|required|regex_match[/^[_a-z0-9-]+(.[_a-z0-9-]+)*@(aragon.unam.mx)$/]');
        $this->form_validation->set_rules('apellidop_usuario_edit', 'Apellido Peterno', 'trim|required');
        $this->form_validation->set_rules('apellidom_usuario_edit', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_rules('nombre_usuario_edit', 'Apellido Materno', 'trim|required');
        $this->form_validation->set_rules('numcuenta_usuario_edit', 'Numero de cuenta', 'trim|required'
        );
        $this->form_validation->set_rules('rfc_usuario_edit', 'RFC', 'trim|required|exact_length[13]');
        //validacion de datos
        if ($this->form_validation->run()) {
            $valida_existe_usuario = $this->usuarios_model->
                    valida_existe_usuario_update($this->input->post('correo_usuario_edit'), $this->input->post('id_usuario'));
            if ($valida_existe_usuario['cantidad'] == 0) {
                $cantidad_alumno_registrado = $this->alumnos_model->valida_existe_alumno_update($this->input->post('numcuenta_usuario_edit'), $this->input->post('rfc_usuario_edit'), $this->input->post('id_usuario'));
                if ($cantidad_alumno_registrado['cantidad'] == 0) {
                    $this->usuarios_model->update_usuario(
                            $this->input->post('id_usuario'), $this->input->post('correo_usuario_edit')
                    );
                    $this->alumnos_model->
                            update_alumno($this->input->post('nombre_usuario_edit'), $this->input->post('apellidop_usuario_edit'), $this->input->post('apellidom_usuario_edit'), $this->input->post('rfc_usuario_edit'), $this->input->post('numcuenta_usuario_edit'), $this->input->post('id_usuario')
                    );
                    echo json_encode(array("mensaje" => "Registro Actualizado con exito", "codigo" => 200));
                } else {
                    echo json_encode(array("mensaje" => "usuario ya esta registrado con el mismo RFC o N&uacute;mero de Cuenta/Trabajador", "codigo" => 401));
                }
            } else {
                echo json_encode(array("mensaje" => "usuario ya esta registrado con el mismo correo electronico", "codigo" => 401));
            }
        } else {
            echo json_encode(array("mensaje" => str_replace("\n", "", validation_errors()), "codigo" => 404));
        }
    }

    public function update_usuario_passwd() {
        $this->form_validation->set_rules('passwd_usuario_edit', 'passwd_usuario_edit', 'trim|required|exact_length[8]');
        if ($this->form_validation->run() !== FALSE) {
            $this->usuarios_model->update_passwd_usuario(
                    $this->input->post('idreg_usuario'), $this->input->post('passwd_usuario_edit')
            );
            echo true;
        } else {
            return FALSE;
        }
    }

    public function eliminar_usuario() {

        $usuario = $this->usuarios_model->elimina_usuario($this->input->post('idreg_usuario'));
        $profesor = $this->profesores_model->elimina_usuario($this->input->post('idreg_usuario'));
        if ($usuario && $profesor) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function eliminar_usuario_alumno() {
        $usuario = $this->usuarios_model->elimina_usuario($this->input->post('idreg_usuario'));
        $alumno = $this->alumnos_model->elimina_alumno($this->input->post('idreg_usuario'));
        if ($usuario && $alumno) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>