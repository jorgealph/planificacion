<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_cuestionario extends CI_Controller {
	

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_cuestionario');
		$this->load->library('upload');
		session_start();
	}

	public function guarda_respuestas()
	{		
		$model = new M_cuestionario();
		$usid = $_SESSION['usuario']['usid'];
		$datos = array('iRevisado' => 0, 'iCalificacion' => 0);
		if(is_array($_POST) && !empty($_POST)) 		
		{
			$archivo = array();
			$res = array();
			$ids = array();
			foreach ($_POST as $key => $value) {
				//echo 'key: '.$key;
				
				$c = substr($key, 0, 3);			

				if($c=='ev_') 
				{
					$archivo[substr($key, 3)] = $value;
				}
				elseif($c=='re_')
				{
					$res[substr($key, 3)] = $value;
					//echo substr($key, 3);
					//print_r($ids);
					//if(in_array(substr($key, 3), $ids)) $datos['vRespuesta'] = $value;
				}
				else
				{
					array_push($ids, $value);		
					$datos['iIdRespuesta'] = $value;
					$datos['iIdUsuario'] = $usid;
					if(isset($archivo[substr($key, 5)])) $datos['vArchivo'] = $archivo[substr($key, 5)];
					else $datos['vArchivo'] = "";
					//var_dump($datos);
					$inserta = $model->guarda_respuestas($datos);

				}
				
			}
			//var_dump($ids);
			//var_dump($res);
			foreach ($res as $key => $value) {
				if(in_array($key, $ids)) $act = $model->act_resp($value,$usid,$key);
			}
		}
		echo $inserta;
	}

	public function archivo()
	{		
		//print_r($_FILES);

		$ruta = 'uploads/';
		$model = new M_cuestionario();
		$usid = $_SESSION['usuario']['usid'];
		//$tArchivos = 0;
		//$dFecha = date("Y-m-d H:i:s");
					
		//$tArchivos = count($_FILES["input_1"]["name"]);
		foreach ($_FILES as $key => $value) {
			//echo 'key: '.$key;

			$vNombreAdjunto = $_FILES[$key]["name"];
			$nombreTemp = $_FILES[$key]["tmp_name"];			
			$pregid = substr($key, 6);

			$respid = $model->obtener_resp($pregid, $usid, 0);
			$nombreArch = 'Evidencia_'.$pregid.'_'.$usid;			

			$resto = explode(".", $vNombreAdjunto); 
			$extension = end($resto);
			$nombreArch.='.'.$extension;

			$vRutaAdjunto = $ruta.$nombreArch;			

			move_uploaded_file($nombreTemp, $vRutaAdjunto);
			$datos = array('vArchivo' => $nombreArch);
			$resp = $model->inserta_archivo($datos,$respid[0]->iIdRespuesta,$usid);
		}		
		echo $resp;
	}

	public function eliminar_preg()
	{
		$pregid = $this->input->post('pregid');
		$model = new M_cuestionario();
		$resp = $model->elimina_preg($pregid);
		echo $resp;
	}

	public function carga_respuestas()
	{
		$op = $this->input->post('op', TRUE);
		$model = new M_cuestionario();
		$resp = $model->carga_resp($op);
		if($resp!=false && count($resp) > 0)
		{
			foreach ($resp as $vresp) {
				if($op==1 || $op==2) { $check = 'checked'; $col = ''; }
				else { $check = ''; $col = 'col-md-2'; }

				echo '<div class="'.$col.' custom-control custom-checkbox custom-control-inline">
	                    <input '.$check.' type="checkbox" id="op_'.$vresp->iIdOpcion.'" name="resp[]" class="custom-control-input" value="'.$vresp->iIdOpcion.'">
	                    <label class="custom-control-label" for="op_'.$vresp->iIdOpcion.'">'.$vresp->vOpcion.'</label>
	                </div>';
			}			
		}
		else echo '<a href="'.base_url().'listado-respuestas">Agregar respuestas</a>';


	}

	public function guardar_pregunta()
	{
		$nombre = $this->input->post('nombre', TRUE);
		$correo = $this->input->post('correo', TRUE);
		$sel_tipo = $this->input->post('sel_tipo', TRUE);
		$sel_preg = $this->input->post('sel_preg', TRUE);
		$resp = $this->input->post('resp', TRUE);
		
		$model = new M_cuestionario();

		$datos = array(
				'vPregunta' => $nombre,
				'iPonderacion' => $correo,
				'iEvidencia' => $sel_tipo,
				'iTipoPregunta' => $sel_preg,
				'iActivo' => 1
				);

		$insert = $model->guarda_pregunta($datos);

		if($insert>0) 
		{
			for ($i=0; $i < count($resp); $i++) {
				$datos_r = array(
					'iIdPregunta' => $insert,
					'iIdOpcion' => $resp[$i],
					'iActivo' => 1
				);

				$insert_r = $model->guarda_resp($datos_r);
			}
		}
		echo $insert_r;
	}		

	public function actualizar_pregunta()
	{		
		$pregid = $this->input->post('pregid');
		$preg = $this->input->post('nombre');
		$pond = $this->input->post('correo');
		$ev = $this->input->post('sel_tipo');
		$tipo = $this->input->post('sel_preg');
		$resp = $this->input->post('resp');
		$datos = array(
				'vPregunta' => $preg,
				'iPonderacion' => $pond,
				'iEvidencia' => $ev,
				'iTipoPregunta' => $tipo
			);

		$model = new M_cuestionario();
		$act = $model->actualiza_pregunta($pregid,$datos);
		echo $act;
		if($act==1)
		{
			for ($i=0; $i < count($resp); $i++) {
				$datos_r = array(
					'iIdPregunta' => $pregid,
					'iIdOpcion' => $resp[$i],
					'iActivo' => 1
				);

				$insert_r = $model->guarda_resp($datos_r);
				echo $insert_r;
			}
		}
	}

	public function eliminar_resp()
	{
		$respid = $this->input->post('respid', TRUE);
		$model = new M_cuestionario();
		$resp = $model->elimina_resp($respid);
		echo $resp;
	}

	public function guarda_opcion()
	{
		$respid = $this->input->post('respid', TRUE);
		$resp = $this->input->post('resp', TRUE);
		$tipo = $this->input->post('tipo_resp', TRUE);
		$otro = $this->input->post('otro_resp', TRUE);

		$model = new M_cuestionario();
		$datos = array('vOpcion' => $resp, 'iOtro' => $otro, 'iTipoR' => $tipo, 'iActivo' => 1);
		$resp = $model->guarda_opcion($datos,$respid);	
		echo $resp;
	}

	public function envia_calif()
	{
		$model = new M_cuestionario();
		$usid = $this->input->post('usid', TRUE);

		if(is_array($_POST) && !empty($_POST)) 		
		{
			$calif = array();
			foreach ($_POST as $key => $value) {
				//echo 'key: '.$key.'<br>--> value: '.$value;
				
				$c = substr($key, 0, 6);			

				if($c=='calif_') 
				{
					$d = substr($key, 6);
					$calif[$d] = $value;
					$datos = array('iCalificacion' => $value);

					$resp_id = $model->obtener_resp($d, $usid);
					$resp = $resp_id[0]->iIdRespuesta;
					$resp_calif = $model->act_calif($resp, $usid, $datos);
					//echo 'usuarioid: '.$usid.'<br> preguntaid: '.$d.'<br> respuestaid: '.$resp_id[0]->iIdRespuesta.'----<br>';

				}
			}
			echo $resp_calif;			
		}
	}
	
}
