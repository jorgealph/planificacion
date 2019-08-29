<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_usuario extends CI_Controller {
	

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_usuario');
		session_start();
	}

	public function guardar()
	{		
		$nombre = $this->input->post('nombre', TRUE);
		$correo = $this->input->post('correo', TRUE);
		$contrasenia = $this->input->post('contrasenia', TRUE);
		$tipo_us = $this->input->post('sel_us', TRUE);
		$tipo = $this->input->post('sel_tipo');
		if($tipo==1) { $ent = $this->input->post('entidad', TRUE); $mun = ''; }
		elseif($tipo==2) { $mun = $this->input->post('municipio', TRUE); $ent = ''; }


		$datos = array(
						'vNombreUsuario' => $nombre,
						'vContrasenia' => sha1($contrasenia),
						'vCorreo' => $correo,
						'iTipoUsuario' => $tipo_us,
						'iActivo' => 1,
						'iTipo' => $tipo,
						'vEntidad' => $ent,
						'vMunicipio' => $mun);
		$model = new M_usuario();
		$resp = $model->inserta_usuario($datos);
		echo $resp;		

	}

	public function eliminar()
	{
		$usid = $this->input->post('usid', TRUE);
		$model = new M_usuario();		
		$resp = $model->elimina_usuario($usid);
		echo $resp;
	}

	public function modificar()
	{
		$usid = $this->input->post('usuarioid', TRUE);
		$nombre = $this->input->post('nombre', TRUE);
		$correo = $this->input->post('correo', TRUE);
		$sel_tipo = $this->input->post('sel_tipo', TRUE);
		$ent = $this->input->post('entidad', TRUE);
		$mun = $this->input->post('municipio', TRUE);
		$sel_us = $this->input->post('sel_us', TRUE);

		$datos = array(
					'vNombreUsuario' => $nombre,
					'vCorreo' => $correo,
					'iTipoUsuario' => $sel_us,
					'iTipo' => $sel_tipo,
					'vEntidad' => $ent,
					'vMunicipio' => $mun
				);

		$model = new M_usuario();
		$resp = $model->modifca_usuario($datos, $usid);
		echo $resp;
		//$this->load->view('form_usuarios',$datos);	
	}
	
}
