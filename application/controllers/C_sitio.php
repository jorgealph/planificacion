<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_sitio extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_usuario');
		$this->load->model('M_cuestionario');
		session_start();
	}

	public function index()
	{
		if(isset($_SESSION['usuario'])) $this->cuestionario(); //$this->load->view('index');
		else $this->load->view('login');		
	}

	public function iniciar()
	{
		$usuario = $this->input->post('usuario');
		$contra = $this->input->post('contrasenia');

		$model = new M_usuario();
		$resp = $model->inicia_sesion($usuario);
		if($resp!=false)
		{
			if(sha1($contra) == $resp[0]->vContrasenia)
			{
				echo 'success';
				$_SESSION['usuario']['usid'] = $resp[0]->iIdUsuario;
				$_SESSION['usuario']['nom'] = $usuario;
				$_SESSION['usuario']['tipo'] = $resp[0]->iTipoUsuario;
				$_SESSION['usuario']['tipo_proced'] = $resp[0]->iTipo;


			}
			else echo 'error1';
		}
		else echo 'error2';
	}

	public function salir()
	{		
		unset($_SESSION);
        session_destroy();
        if(!isset($_SESSION['usuario'])) echo 1;
	}

	public function usuarios()
	{
		if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
		else
		{
			$model = new M_usuario();
			$datos['usuarios'] = $model->carga_usuarios();
			$this->load->view('usuarios',$datos);
		}
	}

	public function preguntas()
	{
		$model = new M_cuestionario();
		$datos['preg']  = $model->carga_preguntas(1);

		if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
		else $this->load->view('preguntas',$datos);
	}

	public function respuestas()
	{
		$model = new M_cuestionario();
		$datos['opciones'] = $model->carga_resp(-1);

		if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
		else $this->load->view('respuestas',$datos);
	}

	public function agregar_pregunta()
	{
		if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
		else $this->load->view('form_preguntas');
	}

	public function modificar_pregunta()
	{
		$model = new M_cuestionario();
		$pregid = $this->input->get('pregid', TRUE);
		$preguntas = $model->carga_preguntas(1,$pregid);
		$tipo = $preguntas[0]->iTipoPregunta;
		$datos['datos_preg'] = $preguntas;
		$datos['tot_resp'] = $model->carga_resp($tipo);
		$datos['resp_preg'] = $model->carga_respuestas($pregid);
		$this->load->view('form_preguntas',$datos);
	}

	public function agregar_usuario()
	{
		if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
		else $this->load->view('form_usuarios');
	}

	public function modificar_usuario()
	{
		if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
		else
		{							
			$usid = $this->input->get('usid');
			$model = new M_usuario();
			$datos['resp'] = $model->datos_usuario($usid);
			$this->load->view('form_usuarios',$datos);	
		}
	}

	public function cuestionario()
	{
		$usid = $_SESSION['usuario']['usid'];
		$tipo_us = $_SESSION['usuario']['tipo'];
		
		if($tipo_us==1) $tipo_proced = 0;
		else $tipo_proced = $_SESSION['usuario']['tipo_proced'];

		if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
		else
		{	
			$model = new M_cuestionario();
			$datos['cuest'] = $model->carga_cuestionarios($tipo_proced);

			/*$preguntas = $model->carga_preguntas();
			if($preguntas!=false && count($preguntas) > 0)
			{
				$datos['preguntas'] = $preguntas;
				foreach ($preguntas as $vpreg) {
					$pregid = $vpreg->iIdPregunta;
					$resp_cal = $model->obtener_resp($pregid, $usid, 1);
					if($resp_cal!=false && count($resp_cal) > 0)
					{
						$vpreg->iCalificacion = $resp_cal[0]->iCalificacion;
						$vpreg->vArchivo = $resp_cal[0]->vArchivo;						
					}
					else 
					{
						$vpreg->iCalificacion = 0;
						$vpreg->vArchivo = '';
					}
				}

			}
			else $datos['preguntas'] = false;




			$resp = $model->resp_usuario($usid);
			if($resp!=false && count($resp) > 0) $datos['respuestas'] = $resp;
			else $datos['respuestas'] = false;

			$this->load->view('cuestionario',$datos);		
			*/
			$this->load->view('tabla_cuest',$datos);
		}

	}

	public function resp_cuestionario()
	{
		$cuestid = $this->input->get('cuestid', TRUE);
		$datos['cuestid'] = $cuestid;
		$usid = $_SESSION['usuario']['usid'];		

		if($cuestid > 0)
		{
			if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
			else
			{	
				$model = new M_cuestionario();

				$preguntas = $model->carga_preguntas(0,0,$cuestid);
				if($preguntas!=false && count($preguntas) > 0)
				{
					$datos['preguntas'] = $preguntas;
					foreach ($preguntas as $vpreg) {
						$pregid = $vpreg->iIdPregunta;
						$resp_cal = $model->obtener_resp($pregid, $usid, 1);
						if($resp_cal!=false && count($resp_cal) > 0)
						{
							$vpreg->vArchivo = $resp_cal[0]->vArchivo;


							$cal = $model->obtener_calif($pregid,$usid);
							if($cal!=false && count($cal) > 0) $vpreg->iCalificacion = $cal[0]->vCalificacion;
							else $vpreg->iCalificacion = 0;
						}
						else 
						{				
							$vpreg->iCalificacion = -1;
							$vpreg->vArchivo = '';
						}
					}

				}
				else $datos['preguntas'] = false;

				$resp = $model->resp_usuario($usid, $cuestid);
				if($resp!=false && count($resp) > 0) $datos['respuestas'] = $resp;
				else $datos['respuestas'] = false;

				$this->load->view('cuestionario',$datos);
			}			
		}
		else header('Location: '.base_url().'cuestionario');
	}

	public function calificar()
	{
		if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
		else
		{	
			$cuest_us = array();

			$model = new M_cuestionario();
			$usuarios = $model->cuest_usuario();
			if($usuarios!=false && count($usuarios) > 0)
			{
				foreach ($usuarios as $vus) {
					
					
					$resp_us = $model->resp_us($vus->iIdUsuario);
					if($resp_us!=false && count($resp_us) > 0) $r = $resp_us[0]->iIdUsuario;
					else $r = 0;

					$cal_us = $model->calif_us($vus->iIdUsuario);
					if($cal_us!=false && count($cal_us) > 0)
					{						
						foreach ($cal_us as $vcal) {
							
							$d = array(
								'iIdUsuario'=> $vus->iIdUsuario,
								'vNombreUsuario'=> $vus->vNombreUsuario,
								'vCorreo'=> $vus->vCorreo,
								'vEntidad'=> $vus->vEntidad,
								'vMunicipio'=> $vus->vMunicipio,
								'iTipo'=> $vus->iTipo,
								'resp' => $r,
								'calif' => $vcal->calif,
								'cuestid' => $vcal->iIdCuestionario,
								'nom_cuest' => $vcal->vCuestionario
							);

							array_push($cuest_us, $d);
						}					
					}
					else
					{
						$d = array(
								'iIdUsuario'=> $vus->iIdUsuario,
								'vNombreUsuario'=> $vus->vNombreUsuario,
								'vCorreo'=> $vus->vCorreo,
								'vEntidad'=> $vus->vEntidad,
								'vMunicipio'=> $vus->vMunicipio,
								'iTipo'=> $vus->iTipo,
								'resp' => $r,
								'calif' => 0,
								'cuestid' => 0,
								'nom_cuest' => ''
							);

							array_push($cuest_us, $d);
					}
				}
			}
			$datos['usuarios'] = $cuest_us;
			$this->load->view('calificar',$datos);
		}
	}

	public function calificar_usuario()
	{
		$usid = $this->input->get('usid', TRUE);
		$cuestid = $this->input->get('cuestid', TRUE);

		if($usid > 0 && $cuestid > 0)
		{
			if(!isset($_SESSION['usuario'])) header('Location: '.base_url());
			else
			{
				$model = new M_cuestionario();
				$preguntas = $model->carga_preguntas(0,0,$cuestid);

				if($preguntas!=false && count($preguntas) > 0)
				{
					$datos['preguntas'] = $preguntas;
					foreach ($preguntas as $vpreg) {
						$pregid = $vpreg->iIdPregunta;



						$cal = $model->obtener_calif($pregid,$usid);
						if($cal!=false && count($cal) > 0) $vpreg->iCalificacion = $cal[0]->vCalificacion;
						else $vpreg->iCalificacion = 0;


						$resp_cal = $model->obtener_resp($pregid, $usid, 1);
						if($resp_cal!=false && count($resp_cal) > 0)
						{						
							$vpreg->vArchivo = $resp_cal[0]->vArchivo;
						}
						else 
						{
							$vpreg->vArchivo = '';
						}
					}				

				}
				else $datos['preguntas'] = false;

				$datos['usid'] = $usid;
				$resp = $model->resp_usuario($usid, $cuestid);
				if($resp!=false && count($resp) > 0) $datos['respuestas'] = $resp;
				else $datos['respuestas'] = false;
				$this->load->view('cuestionario_calif', $datos);
			}
		}
		else header('Location: '.base_url().'calificar');
		
	}

	
}
