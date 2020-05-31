<?php

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
    }
    public function index() {
        switch ($this->session->userdata('tipo_user')) {
            case '':
                $data['token'] = $this->token();
                $this->load->view('ccaragon/loginview', array('mensaje' => ''));
                break;
            case 1://ADMIN
                //echo "usaurio 1";
               $this->load->view('ccaragon/home_user_adm', array('tipo_user' => $this->session->userdata('tipo_user')));
                break;
            case 2://profesor
                //echo "usaurio 2";
                $this->load->view('ccaragon/home_user_profesor', array('tipo_user' => $this->session->userdata('tipo_user')));
                break;
            case 3://alumno
                redirect('Alumnos');
                break;

            default:
                $this->load->view('ccaragon/loginview', array('mensaje' => ''));
                break;
        }
    }

    public function token() {
        $token = md5(uniqid(rand(), true));
        $this->session->set_userdata('token', $token);
        return $token;
    }

    //---------------Funcion para logeo para cursos del CC----------//


    public function home_user_adm() {
        $this->load->view('ccaragon/home_user_adm.php');
    }
    public function home_user_profesor() {
        $this->load->view('ccaragon/home_user_profesor.php');
    }

    public function home_user_estadisticas() {
        $this->load->view('ccaragon/home_user_estadisticas.php');
    }

    public function login() {
        $user_session_data = array();
        $this->form_validation->set_rules('inp_usuario', 'Reingrese sus datos', 'required');
        $this->form_validation->set_rules('inp_contra', 'Reingrese sus datos', 'required');
        if ($this->form_validation->run()) {
            $username = $this->input->post('inp_usuario');
            $password = $this->input->post('inp_contra');
            $check_user = $this->login_model->login_usuario($username, $password);

            if ($check_user && $check_user['rol'] <= 3) {
                switch (($check_user['rol'])) {
                    case 2://profesor
                        $profesor = $this->login_model->get_datos_profesor($check_user['idusuario']);
//                        print_r($profesor);
                        $user_session_data['nombre_completo'] = $profesor['nombre_completo'];
                        $user_session_data['id_profesor'] = $profesor['idprofesor'];
                        $user_session_data['status'] = $profesor['status'];


                        break;
                    case 3://alumno
                        $alumno = $this->login_model->get_datos_alumno($check_user['idusuario']);
//                        print_r($profesor);
                        $user_session_data['status'] = $alumno['status'];
                        $user_session_data['nombre_completo'] = $alumno['nombre_completo'];
                        $user_session_data['id_alumno'] = $alumno['idalumno'];
                        break;
                }
                $user_session_data['iduser'] = $check_user['idusuario'];
                $user_session_data['tipo_user'] = $check_user['rol'];
                $user_session_data['logueado'] = true;
                //seteamos las variables de sesion     
                $this->session->set_userdata($user_session_data); //seteamos las variables de sesion      
                switch ($this->session->userdata('tipo_user')) {
                    case 1://ADMIN
                        $this->load->view('ccaragon/home_user_adm');
                        break;
                    case 2://profesor
                        $this->load->view('ccaragon/home_user_profesor');
                        break;
                    case 3://alumno
                        redirect('Alumnos');
                        break;
                    default:
                        $this->load->view('ccaragon/loginview', array('mensaje' => ''));
                        break;
                }
            } else {
                $this->load->view('ccaragon/loginview', array('mensaje' => 'datos incorrectos'));
            }
        } else {
            $this->load->view('ccaragon/loginview', array('mensaje' => 'datos incorrectos'));
        }
    }

    //-------------------Funcion para Cerrar Sesion-------------//

    public function adminLogOut() {
        $this->session->sess_destroy();
        redirect('Login');
    }

}

?>