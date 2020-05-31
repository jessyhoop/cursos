<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');



if (!function_exists('validar_anio')) {

  function validar_anio($etiqueta) {
        $this->form_validation->set_rules($etiqueta, 'anio_form', 'trim|required');
//validacion de datos
        if ($this->form_validation->run()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}   