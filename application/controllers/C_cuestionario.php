<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_cuestionario extends CI_Controller {
	

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_cuestionario','mc');
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
	

	function listar_cuestionarios()
	{
		$datos['tabla'] = $this->tabla_cuestionarios();

		$this->load->view('listado_cuestionarios',$datos);
	}

	function tabla_cuestionarios()
	{
		$cuestionarios = $this->mc->cuestionarios();


		$html = ' <div class="table-responsive">                                 
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del cuestionario</th>
                                <th>Tipo</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>';
         if($cuestionarios->num_rows() > 0)
         {
         	$cuestionarios = $cuestionarios->result();

         	foreach ($cuestionarios as $cuestionario)
         	{
         		$cuestionario->iTipo = ($cuestionario->iTipo == 1) ? 'Entidad federativa':'Municipio';

         		  $html.= '<tr id="cu_'.$cuestionario->iIdCuestionario.'"><td>'.$cuestionario->iIdCuestionario.'</td>
                        <td>'.$cuestionario->vCuestionario.'</td>
                        <td>'.$cuestionario->iTipo.'</td>
                        <td>';
                            
                        $html.='<a href="javascript:" title="Editar" onclick="capturarCuestionario('.$cuestionario->iIdCuestionario.');"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp&nbsp';

                        $html.='<a href="javascript:" title="Eliminar" onclick="eliminarCuestionario('.$cuestionario->iIdCuestionario.');"><i class="fas fa-times"></i></a>&nbsp&nbsp&nbsp';                              

                    $html.= '</td>
                    </tr>';
         	}
         }


        $html .= '		</tbody>
        			</table>
        		</div>';

        return $html;                 
	}

	function capturar_cuestionario()
	{
		$iIdCuestionario = (isset($_GET['cuestid']) && !empty($_GET['cuestid'])) ? $_GET['cuestid']:0;
		$datos['iIdCuestionario'] = $iIdCuestionario;


		if($iIdCuestionario == 0)
		{
			$d_cuestionario = array('vCuestionario' => '', 'vDescripcion' => '');
			$iIdCuestionario = $this->mc->insertar_registro('iplan_cuestionarios',$d_cuestionario);
		}


		$query = $this->mc->cuestionarios($iIdCuestionario);
		$query = $query->row();
		foreach ($query as $campo => $valor)
        {
            $datos[$campo] = $valor;
        }		

		$qpreguntas = $this->mc->preguntas($iIdCuestionario);
		
		$qpreguntas = $qpreguntas->result();

		$datos['preguntas'] = '';

		foreach ($qpreguntas as $pregunta) {
			$datos['preguntas'].= $this->html_pregunta($pregunta->iIdPregunta);
		}

		$this->load->view('form_captura_cuestionario',$datos);

	}

	function guardar_cuestionario()
	{
		$datos = array(	'vCuestionario' => $this->input->post('vCuestionario'),
						'vDescripcion' => '',
						'iTipo' => $this->input->post('iTipo'),
						'iActivo' => 1 );
		$where['iIdCuestionario'] = $this->input->post('iIdCuestionario');

		$con = $this->mc->iniciar_transaccion();
		$iIdCuestionario = $this->mc->actualizar_registro('iplan_cuestionarios',$where,$datos,$con);

		if($this->mc->terminar_transaccion($con)) echo '1';
		else echo 'Los cambios no pudieron ser guardados';
	}

	public function crear_pregunta()
	{
		if(isset($_POST['iIdCuestionario']) && !empty($_POST['iIdCuestionario']))
		{
			$datos = array(	'vPregunta' => '', 'iTipoPregunta' => 0, 'iEvidencia'=> 1,'iIdCuestionario' => $this->input->post('iIdCuestionario'));

			$con = $this->mc->iniciar_transaccion();

			$iIdPregunta = $this->mc->insertar_registro('iplan_preguntas',$datos,$con);

			$opcion1 = array( 'vOpcion' => 'Opcion 1' , 'iIdPregunta' => $iIdPregunta, 'vValor' => 0);
			$opcion2 = array( 'vOpcion' => 'Opcion 2' , 'iIdPregunta' => $iIdPregunta, 'vValor' => 1);
			$opcion3 = array( 'vOpcion' => 'Opcion 3' , 'iIdPregunta' => $iIdPregunta, 'vValor' => 2);
			$opcion4 = array( 'vOpcion' => 'Opcion 4' , 'iIdPregunta' => $iIdPregunta, 'vValor' => 3);

			$iIdOpcion1 = $this->mc->insertar_registro('iplan_opciones',$opcion1,$con);
			$iIdOpcion2 = $this->mc->insertar_registro('iplan_opciones',$opcion2,$con);
			$iIdOpcion3 = $this->mc->insertar_registro('iplan_opciones',$opcion3,$con);
			$iIdOpcion4 = $this->mc->insertar_registro('iplan_opciones',$opcion4,$con);

			$rango1 = array( 'vValor' => 0 , 'iIdPregunta' => $iIdPregunta, 'iLimiteMin' => '', 'iLimiteMax' => 0);
			$rango2 = array( 'vValor' => 1 , 'iIdPregunta' => $iIdPregunta, 'iLimiteMin' => '', 'iLimiteMax' => 0);
			$rango3 = array( 'vValor' => 2 , 'iIdPregunta' => $iIdPregunta, 'iLimiteMin' => '', 'iLimiteMax' => 0);
			$rango4 = array( 'vValor' => 3 , 'iIdPregunta' => $iIdPregunta, 'iLimiteMin' => '', 'iLimiteMax' => 0);
			

			$iIdRango1 = $this->mc->insertar_registro('iplan_rangos',$rango1,$con);
			$iIdRango2 = $this->mc->insertar_registro('iplan_rangos',$rango2,$con);
			$iIdRango3 = $this->mc->insertar_registro('iplan_rangos',$rango3,$con);
			$iIdRango4 = $this->mc->insertar_registro('iplan_rangos',$rango4,$con);

			//	-- 
			//	Insertamos la configuración
			$respuesta1 = array('iIdPregunta' => $iIdPregunta, 'iIdOpcion' => $iIdOpcion1);
			$respuesta2 = array('iIdPregunta' => $iIdPregunta, 'iIdOpcion' => $iIdOpcion2);
			$respuesta3 = array('iIdPregunta' => $iIdPregunta, 'iIdOpcion' => $iIdOpcion3);
			$respuesta4 = array('iIdPregunta' => $iIdPregunta, 'iIdOpcion' => $iIdOpcion4);

			$iIdRespuesta1 = $this->mc->insertar_registro('iplan_respuestas',$respuesta1,$con);
			$iIdRespuesta2 = $this->mc->insertar_registro('iplan_respuestas',$respuesta2,$con);
			$iIdRespuesta3 = $this->mc->insertar_registro('iplan_respuestas',$respuesta3,$con);
			$iIdRespuesta4 = $this->mc->insertar_registro('iplan_respuestas',$respuesta4,$con);

			if($this->mc->terminar_transaccion($con) > 0) echo '1-'.$iIdPregunta;
			else echo '0-La pregunta no pudo ser creada'; 
		}
		
	}

	public function agregar_opcion()
	{
		if(isset($_POST['iIdPregunta']) && !empty($_POST['iIdPregunta']))
		{
			$iIdPregunta = $this->input->post('iIdPregunta');
			
			//	Iniciamos la transacción
			$con = $this->mc->iniciar_transaccion();

			//	Insertamos la opción
			$opcion = array( 'vOpcion' => '' , 'iIdPregunta' => $iIdPregunta, 'vValor' => -1);
			$iIdOpcion = $this->mc->insertar_registro('iplan_opciones',$opcion,$con);

			//	Insertamos la configuración
			$respuesta = array('iIdPregunta' => $this->input->post('iIdPregunta'), 'iIdOpcion' => $iIdOpcion);
			$iIdRespuesta = $this->mc->insertar_registro('iplan_respuestas',$respuesta,$con);

			//	Terminar transacción
			if($this->mc->terminar_transaccion($con)) echo '1';
			else echo 'La pregunta no pudo ser creada'; 
		}
		
	}

	function guardar_texto_pregunta(){
		if(isset($_POST['iIdPregunta']) && !empty($_POST['iIdPregunta']))
		{
			$datos['vPregunta'] = $this->input->post('vPregunta');
			$where['iIdPregunta'] = $this->input->post('iIdPregunta');
			$this->mc->actualizar_registro('iplan_preguntas',$where,$datos);
		}
	}

	function guardar_texto_opcion(){
		if(isset($_POST['iIdOpcion']) && !empty($_POST['iIdOpcion']))
		{
			$datos['vOpcion'] = $this->input->post('vOpcion');
			$where['iIdOpcion'] = $this->input->post('iIdOpcion');
			$this->mc->actualizar_registro('iplan_opciones',$where,$datos);
		}
	}

	function guardar_rango(){
		if(isset($_POST['iIdPregunta']) && !empty($_POST['iIdPregunta']))
		{
			$datos = array( 'iLimiteMin' => $this->input->post('iLimiteMin'));
			$where['iIdPregunta'] = $this->input->post('iIdPregunta');
			$where['vValor'] = $this->input->post('vValor');
			if($this->mc->actualizar_registro('iplan_rangos',$where,$datos)) echo 1;
			else echo 'El registro no pudo ser actualizado';
		}
	}

	public function mostrar_pregunta($iIdPregunta)
	{
		echo $this->html_pregunta($iIdPregunta);
	}

	public function mostrar_opciones($iIdPregunta)
	{
		echo $this->html_opciones($iIdPregunta);
	}

	public function html_pregunta($iIdPregunta)
	{
		$p = $this->mc->pregunta($iIdPregunta);
		$sel1 = ($p->iTipoPregunta == 0) ? 'selected':'';
		$sel2 = ($p->iTipoPregunta == 1) ? 'selected':'';
		$sel3 = ($p->iTipoPregunta == 2) ? 'selected':'';
		$sel4 = ($p->iTipoPregunta == 3) ? 'selected':'';

		$sel1_e = ($p->iEvidencia == 0) ? 'selected':'';
		$sel2_e = ($p->iEvidencia == 1) ? 'selected':'';


		$html = '<div class="card" id="div-pregunta-'.$p->iIdPregunta.'"> 
					<div class="card-body">
					<form name="form-preg'.$p->iIdPregunta.'" id="form-preg'.$p->iIdPregunta.'">
						<div class="row">
							<div class="col-md-12 text-right"><i style="cursor:pointer;" title="Elimnar pregunta" onclick="eliminarPregunta('.$p->iIdPregunta.');" class="fas fa-times"></i></div>
						</div>
	                    <div class="row">
	                        <div class="col-md-12">
	                            <div class="form-group">
	                                <input type="hidden" name="iIdPregunta" id="iIdPregunta" value="'.$p->iIdPregunta.'">
	                                <input type="text" class="form-control required" id="vPregunta" name="vPregunta" value="'.$p->vPregunta.'" onblur="guardarTextoPregunta('.$p->iIdPregunta.');" placeholder="Escriba aquí su pregunta">
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
                            <div class="col-md-8">
                                 <div class="form-group">
                                    <label for="iTipo"> Tipo de pregunta: <span class="text-danger">*</span> </label>
                                    <select name="iTipo" id="iTipo" class="form-control" onchange="cambiarTipoPregunta('.$p->iIdPregunta.');">
                                        <option value="0" '.$sel1.'>Opción multiple</option>
                                        <option value="1" '.$sel2.'>Dicotómica</option>
                                        <option value="2" '.$sel3.'>Abierta</option>
                                        <option value="3" '.$sel4.'>Selección multiple</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="iEvidencia">¿El usuario debe adjuntar evidencia?: <span class="text-danger">*</span> </label>
                                    <select name="iEvidencia" id="iEvidencia" class="form-control" onchange="cambiarTipoPregunta('.$p->iIdPregunta.');">
                                        <option value="0" '.$sel1_e.'>No</option>
                                        <option value="1" '.$sel2_e.'>Sí</option>
                                    </select>
                                </div>
                            </div>  
                        </div>
	                </form>';

       

	    $html.= '<div class="row">
	    			<div id="div-opciones'.$p->iIdPregunta.'" class="col-md-12">'.$this->html_opciones($p->iIdPregunta).'</div>';

	   	/* if($p->iTipoPregunta == 3)
	    {
	    	$html.= '<div id="div-rangos'.$p->iIdPregunta.'" class="col-md-5">'.$this->html_rangos($iIdPregunta).'</div>';
	    }*/

	    $html.=	'</div>
	    		</div>
	    	</div>';

	    return $html;
	}

	public function html_rangos($iIdPregunta)
	{
		$html = '';
		$query = $this->mc->rangos($iIdPregunta);
		$query = $query->result();
		$html .=  '<div class="row">
						<div class="col-md-12"><small>Indique el el número de opciones que deben seleccionarse para cada puntaje</small></b></div>
					</div>';
		foreach ($query as $p)
		{
			$html.= '<form name="form-rango-'.$iIdPregunta.'-'.$p->vValor.'" id="form-rango-'.$iIdPregunta.'-'.$p->vValor.'">
					<div class="row">
						<div class="col-md-12">
							<input type ="hidden" name="iIdPregunta" value="'.$iIdPregunta.'">
							<input type ="hidden" name="vValor" value="'.$p->vValor.'">
							<input name="iLimiteMin" id="iLimiteMin" type="text" class="form-control" value="'.$p->iLimiteMin.'"placeholder="Ej: 0, 1-2" onblur="guardarRango('.$iIdPregunta.','.$p->vValor.');">
							<small>Puntaje: '.$p->vValor.' </small>
						</div>
					</div>
					</form>';
		}

		return $html;
	}


	public function html_opciones($iIdPregunta)
	{
		$html = '';
		$query = $this->mc->opciones($iIdPregunta);
		$query = $query->result();
		$bandera = false;

		$tipo = 0;
		$html.= '<div class="row">
					<div class="col-md-7">';

		foreach ($query as $p)
		{
			$tipo = $p->iTipoPregunta;
			$html.= '';
			if($p->iTipoPregunta == 0)	// Opcion múltiple (4 radio)
			{
				$html.= '<form name="form-op'.$p->iIdOpcion.'" id="form-op'.$p->iIdOpcion.'">
						<div class="form-group">
						<div class="custom-control custom-radio">
							<input type="hidden" name="iIdOpcion" id="iIdOpcion" value="'.$p->iIdOpcion.'">
		                    <input type="radio" class="custom-control-input">
		                    <label class="custom-control-label" for="customRadio1"><input type="text" class="form-control" name="vOpcion" id="vOpcion" value="'.$p->vOpcion.'" onblur="guardarTextoOpcion('.$p->iIdOpcion.');"><small>Puntaje: '.$p->vValor.'</small></label>
		                </div>
		                </div>
		                </form>'; 
            }

            if($p->iTipoPregunta == 1)	// Dicotómica (2 radio)
			{
				$html.= '<form name="form-op'.$p->iIdOpcion.'" id="form-op'.$p->iIdOpcion.'">
						<div class="form-group">
						<div class="custom-control custom-radio">
							<input type="hidden" name="iIdOpcion" id="iIdOpcion" value="'.$p->iIdOpcion.'">
		                    <input type="radio" class="custom-control-input">
		                    <label class="custom-control-label" for="customRadio1"><input type="text" class="form-control" name="vOpcion" id="vOpcion" value="'.$p->vOpcion.'" onblur="guardarTextoOpcion('.$p->iIdOpcion.');"><small>Puntaje: '.$p->vValor.'</small></label>
		                </div>
		                </div>
		                </form>'; 
            }

            if($p->iTipoPregunta == 2)	// Abierta (text)
			{
				$html.= '<form name="form-op'.$p->iIdOpcion.'" id="form-op'.$p->iIdOpcion.'">
						<div class="form-group">
						<div class="custom-control custom-radio">
							<input type="hidden" name="iIdOpcion" id="iIdOpcion" value="'.$p->iIdOpcion.'">
		                    <textarea class="form-control" name="" id="" disabled></textarea>
		                    <small>Puntaje: '.$p->vValor.'</small>
		                </div>
		                </div>
		                </form>'; 
            }

            if($p->iTipoPregunta == 3)	// Selección múltiple (check)
			{
				$checked = ($p->iOtro == 1) ? 'checked':'';
				$bandera = true;
            	$html.= '<form name="form-op'.$p->iIdOpcion.'" id="form-op'.$p->iIdOpcion.'">
            			<div class="form-group">
        				<div class="custom-control custom-checkbox">
        					<input type="hidden" name="iIdOpcion" id="iIdOpcion" value="'.$p->iIdOpcion.'">
                            <input type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="customCheck3"><input type="text" class="form-control" name="vOpcion" id="vOpcion" value="'.$p->vOpcion.'" onblur="guardarTextoOpcion('.$p->iIdOpcion.');"></label> <i style="cursor:pointer;" class="fas fa-times" title="Eliminar opción" onclick="eliminarOpcion('.$p->iIdOpcion.','.$iIdPregunta.');"></i>
                            <br><small><input onchange="guardarOtro('.$p->iIdOpcion.');" type="checkbox" name="iOtro" '.$checked.'> Requiere un campo de texto</small>
                        </div>
                        </div>
                        </form>';
          	}
          	
		}


        if($bandera)
		{
			$bandera = false;
			$html.= '<div class="row">
                <div class="col-md-12"><button class="btn btn-success" onclick="agregarOpcion('.$iIdPregunta.');" ><i class="fas fa-plus"></i>&nbsp;Agregar opción</button></div>
    		</div> <br>';
    	}

		$html.= '</div>';

		if($tipo == 3)
		{
			$html.= '<div id="div-rangos'.$iIdPregunta.'" class="col-md-5">'.$this->html_rangos($iIdPregunta).'</div>';
		}

		$html.= '</div>';

		return $html;
	}

	public function cambiar_tipo_pregunta()
	{
		if(isset($_POST['iIdPregunta']) && !empty($_POST['iIdPregunta']))
		{
			$dTipo['iTipoPregunta'] = $iTipoPregunta = $this->input->post('iTipo');
			$datos = array('iActivo' => 0);
			$where = 'iIdPregunta = '.$this->input->post('iIdPregunta');

			$con = $this->mc->iniciar_transaccion();
			//	Actualizamos el tipo de pregunta
			$this->mc->actualizar_registro('iplan_preguntas',$where,$dTipo,$con);

			//Borramos todas las opciones
			$this->mc->actualizar_registro('iplan_opciones',$where,$datos,$con);

			//Activamos las respuestas en base al tipo
			if($iTipoPregunta == 0)
			{
				$datos['iActivo'] = 1;
				$where.= ' AND vValor IN(0,1,2,3)';
				$this->mc->actualizar_registro('iplan_opciones',$where,$datos,$con);
			} 

			if($iTipoPregunta == 1)
			{
				$datos['iActivo'] = 1;
				$where.= ' AND vValor IN(0,3)';
				$this->mc->actualizar_registro('iplan_opciones',$where,$datos,$con);
			}

			if($iTipoPregunta == 2)
			{
				$datos['iActivo'] = 1;
				$where.= ' AND vValor = 3';
				$this->mc->actualizar_registro('iplan_opciones',$where,$datos,$con);
			} 

			if($iTipoPregunta == 3)
			{
				$datos['iActivo'] = 1;
				$this->mc->actualizar_registro('iplan_opciones',$where,$datos,$con);
			} 

			if($this->mc->terminar_transaccion($con)) echo '1';
			else echo 'Los datos no puedieron actualizarse';
		}
	}

	public function guardar_otro()
	{
		if(isset($_POST['iIdOpcion']) && !empty($_POST['iIdOpcion']))
		{
			$datos['iOtro'] = (isset($_POST['iOtro'])) ? 1:0;
			$where['iIdOpcion'] = $this->input->post('iIdOpcion');

			$this->mc->actualizar_registro('iplan_opciones',$where,$datos);
		}
	}

	public function eliminar_cuestionario()
	{
		if(isset($_POST['id']) && !empty($_POST['id']))
		{
			
			$where['iIdCuestionario'] = $this->input->post('id');

			if($this->mc->desactivar_registro('iplan_cuestionarios',$where) > 0) echo '1';
			else echo 'El registro no pudo ser eliminado';
		}
	}

	public function eliminar_pregunta()
	{
		if(isset($_POST['iIdPregunta']) && !empty($_POST['iIdPregunta']))
		{
			
			$where['iIdPregunta'] = $this->input->post('iIdPregunta');

			if($this->mc->desactivar_registro('iplan_preguntas',$where) > 0) echo '1';
			else echo 'El registro no pudo ser eliminado';
		}
	}

	public function eliminar_opcion()
	{
		if(isset($_POST['iIdOpcion']) && !empty($_POST['iIdOpcion']))
		{			
			$where['iIdOpcion'] = $this->input->post('iIdOpcion');

			$con = $this->mc->iniciar_transaccion();

			// Eliminamos la opción del catálogo
			$this->mc->desactivar_registro('iplan_opciones',$where,$con);
			//	Eliminas de la configuración
			$this->mc->desactivar_registro('iplan_respuestas',$where,$con);
			if( $this->mc->terminar_transaccion($con) ) echo '1';
			else echo 'El registro no pudo ser eliminado';
		} else {echo 'noentro';}
	}
}