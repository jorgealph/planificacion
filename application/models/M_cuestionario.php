<?php

class M_cuestionario extends CI_Model {


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function carga_preguntas($op=0,$id=0,$cuestid=0)
	{
		if($op==0)
		{
			if($cuestid > 0) 
			{
				$this->db->select('p.iIdCuestionario');
				$this->db->where('p.iIdCuestionario',$cuestid);				
			}

			$this->db->select('p.iIdPregunta, p.vPregunta, p.iPonderacion,p.iEvidencia, p.iTipoPregunta ,o.iIdOpcion, o.vOpcion, o.iOtro, r.iIdRespuesta');
			$this->db->from('iplan_preguntas p');
			$this->db->join('iplan_respuestas r','p.iIdPregunta = r.iIdPregunta and r.iActivo = 1', 'INNER');
			$this->db->join('iplan_opciones o','r.iIdOpcion = o.iIdOpcion and o.iActivo = 1', 'INNER');
			$this->db->where('p.iActivo',1);
			$this->db->order_by('p.iIdPregunta', 'ASC');
			$this->db->order_by('o.iIdOpcion', 'ASC');

		}
		elseif($op==1)
		{
			$this->db->select('iIdPregunta, vPregunta, iPonderacion, iEvidencia, iTipoPregunta');
			$this->db->from('iplan_preguntas');
			$this->db->where('iActivo',1);
			if($id>0) $this->db->where('iIdPregunta',$id);
			$this->db->order_by('iIdPregunta', 'ASC');
		}

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}	

	public function elimina_preg($pregid)
	{
		$this->db->set('iActivo',0);
		$this->db->where('iIdPregunta',$pregid);
		$query = $this->db->update('iplan_preguntas');
		return $query;
	}

	public function guarda_respuestas($datos)
	{
		return $this->db->insert('iplan_resp_usuario',$datos);
	}

	public function guarda_calif($datos)
	{
		return $this->db->insert('iplan_calif',$datos);
	}

	public function rangos_respuestas($iIdPregunta)
	{
		$this->db->select('ra.iLimiteMin,ra.vValor');
		$this->db->from('iplan_rangos ra');
		$this->db->where('ra.iIdPregunta',$iIdPregunta);
		$this->db->order_by('ra.iLimiteMin','ASC');

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function guarda_pregunta($datos)
	{
		$this->db->insert('iplan_preguntas', $datos);
		$query = $this->db->insert_id();
		return $query;
	}

	public function guarda_resp($datos_r)
	{
		return $this->db->insert('iplan_respuestas', $datos_r);
	}

	public function resp_usuario($usid, $cuestid)
	{
		/*$this->db->select('iIdRespuesta,vRespuesta,vArchivo');
		$this->db->from('iplan_resp_usuario');
		$this->db->where('iIdUsuario',$usid);*/

		$this->db->select('re.iIdRespuesta,re.vRespuesta,re.vArchivo');
		$this->db->from('iplan_resp_usuario re');
		$this->db->join('iplan_respuestas r','re.iIdRespuesta = r.iIdRespuesta','INNER');
		$this->db->join('iplan_preguntas p','r.iIdPregunta = p.iIdPregunta','INNER');
		$this->db->where('re.iIdUsuario',$usid);
		$this->db->where('p.iIdCuestionario',$cuestid);

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function act_resp($resp,$usid,$respid)
	{
		$this->db->set('vRespuesta', $resp);
		$this->db->where('iIdUsuario',$usid);
		$this->db->where('iIdRespuesta',$respid);
		$query = $this->db->update('iplan_resp_usuario');
		return $query;
	}

	public function carga_resp($op=0)
	{
		$this->db->select('iIdOpcion, vOpcion, iTipoR, iOtro');
		$this->db->from('iplan_opciones');
		$this->db->where('iActivo',1);
		if($op >= 0) $this->db->where('iTipoR',$op);

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function carga_respuestas($pregid = 0)
	{
		$this->db->select('r.iIdPregunta, o.iIdOpcion, o.vOpcion');
		$this->db->from('iplan_respuestas r');
		$this->db->join('iplan_opciones o','r.iIdOpcion = o.iIdOpcion and o.iActivo = 1','INNER');
		if($pregid > 0) $this->db->where('r.iIdPregunta',$pregid);		

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function actualiza_pregunta($pregid,$datos)
	{
		$this->db->where('iIdPregunta',$pregid);
		$act = $this->db->update('iplan_preguntas',$datos);

		if($act==1) 
		{
			$resp = $this->reinicia_preguntas($pregid);
			return $resp;
		}
	}

	private function reinicia_preguntas($pregid)
	{
		$this->db->set('iActivo',0);
		$this->db->where('iIdPregunta',$pregid);
		$query = $this->db->update('iplan_respuestas');
		return $query;
	}

	public function elimina_resp($respid)
	{
		$this->db->set('iActivo',0);
		$this->db->where('iIdOpcion',$respid);
		$query = $this->db->update('iplan_opciones');
		return $query;
	}

	public function guarda_opcion($datos,$respid)
	{
		if($respid > 0) 
		{ 
			$this->db->where('iIdOpcion',$respid);
			$query = $this->db->update('iplan_opciones', $datos);
			return $query;
		}
		else return $this->db->insert('iplan_opciones', $datos);
	}

	public function cuest_usuario()
	{
		$this->db->select('u.iIdUsuario, u.vNombreUsuario, u.vCorreo, vEntidad, vMunicipio, iTipo');
		$this->db->from('iplan_usuarios u');
		$this->db->where('u.iActivo',1);
		$this->db->where('u.iTipoUsuario',3);

		/*$this->db->select('u.iIdUsuario, u.vNombreUsuario, u.vCorreo, vEntidad, vMunicipio, iTipo, ( select r.iIdUsuario from iplan_resp_usuario r where r.iIdUsuario = u.iIdUsuario group by r.iIdUsuario ) as resp, ( select SUM(c.vCalificacion) from iplan_calif c where c.iIdUsuario = u.iIdUsuario group by c.iIdUsuario ) as calif');
		$this->db->from('iplan_usuarios u');
		$this->db->where('u.iActivo',1);
		$this->db->where('u.iTipoUsuario',3);*/

		/*
		$this->db->select('c.iIdUsuario,SUM(c.vCalificacion),p.iIdPregunta, p.iIdCuestionario, u.iIdUsuario, u.vNombreUsuario, u.vCorreo, u.vEntidad, u.vMunicipio, u.iTipo');
		$this->db->from('iplan_usuarios u');
		$this->db->join('iplan_calif c','c.iIdUsuario = u.iIdUsuario','LEFT');
		$this->db->join('iplan_preguntas p','c.iIdPregunta = p.iIdPregunta','LEFT');
		$this->db->group_by('c.iIdUsuario, p.iIdCuestionario'); 
		*/

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function resp_us($usid)
	{
		$this->db->select('r.iIdUsuario'); 
		$this->db->from('iplan_resp_usuario r');
		$this->db->where('r.iIdUsuario',$usid);
		$this->db->group_by('r.iIdUsuario ');

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function calif_us($usid)
	{
		$this->db->select('SUM(c.vCalificacion) as calif, p.iIdCuestionario, cu.vCuestionario');
		$this->db->from('iplan_calif c') ;
		$this->db->join('iplan_preguntas p', 'c.iIdPregunta = p.iIdPregunta', 'INNER');
		$this->db->join('iplan_cuestionarios cu', 'p.iIdCuestionario = cu.iIdCuestionario', 'INNER');
		$this->db->where('c.iIdUsuario', $usid);
		$this->db->group_by('c.iIdUsuario, p.iIdCuestionario');

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function obtener_resp($pregid, $usid, $op=0)
	{
		if($op==0) $this->db->select('ru.iIdRespuesta');
		else $this->db->select('ru.iIdRespuesta, ru.vRespuesta, ru.iIdUsuario, ru.iCalificacion, r.iIdRespuesta,r.iIdPregunta,r.iIdOpcion,ru.vArchivo');

		$this->db->from('iplan_resp_usuario ru');
		$this->db->join('iplan_respuestas r ','ru.iIdRespuesta = r.iIdRespuesta','LEFT');
		$this->db->where('ru.iIdUsuario',$usid);
		$this->db->where('r.iIdPregunta',$pregid);

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function valor_opcion($op)
	{
		$this->db->select('r.iIdPregunta,r.iIdOpcion,o.vOpcion,o.vValor');
		$this->db->from('iplan_respuestas r');
		$this->db->join('iplan_opciones o','r.iIdOpcion = o.iIdOpcion','INNER');
		$this->db->where('r.iIdRespuesta', $op);

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function act_calif($respid, $usid, $datos)
	{
		$this->db->where('iIdRespuesta',$respid);
		$this->db->where('iIdUsuario',$usid);

		$query = $this->db->update('iplan_resp_usuario',$datos);
		return $query;
	}

	public function obtener_calif($pregid,$usid)
	{	
		$this->db->select('vCalificacion');
		$this->db->from('iplan_calif');
		$this->db->where('iIdUsuario',$usid);
		$this->db->where('iIdPregunta',$pregid);
		$this->db->group_by('iIdPregunta');
		
		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function inserta_archivo($datos,$respid,$usid)
	{
		$this->db->where('iIdRespuesta',$respid);
		$this->db->where('iIdUsuario',$usid);
		$query = $this->db->update('iplan_resp_usuario',$datos);
		return $query;
	}	

	/*	Funciones para usar transacciones
	======================================
	*/
	public function iniciar_transaccion()
	{
	  $con = $this->load->database('default',TRUE);
	  $con->trans_begin();
	  return  $con;
	}

	public function terminar_transaccion($con)
	{
		if ($con->trans_status() === FALSE)
		{
			$con->trans_rollback();
			return false;
		}
		else 
		{
			$con->trans_commit();
			return true;
		}
	}

	public function insertar_registro($tabla,$datos,$con='')
	{
		if($con == '') $con = $this->db;

		if($con->insert($tabla,$datos)) return $con->insert_id();
		else return false;
	}

	public function insertar_registro_no_pk($tabla,$datos,$con='')
	{
		if($con == '') $con = $this->db;

		if($con->insert($tabla,$datos)) return true;
		else return false;
	}

	public function actualizar_registro($tabla,$where,$datos,$con='')
	{
		if($con == '') $con = $this->db;
		$con->where($where);
		return $con->update($tabla, $datos);
	}

	public function eliminar_registro($tabla,$where,$con)
	{
		return $con->delete($tabla,$where);
	}

	public function desactivar_registro($tabla,$where,$con='')
	{
		if($con == '') $con = $this->db;
		$con->where($where);
		return $con->update($tabla, array('iActivo' => 0));

		return ($con->affected_rows() > 0);
	}

	public function activar_registro($tabla,$where,$con='')
	{
		if($con == '') $con = $this->db;
		$con->where($where);
		$con->update($tabla, array('iActivo' => 1));

		return ($con->affected_rows() > 0);
	}

	public function carga_cuestionarios($tipo_proced)
	{		
		$this->db->select('iIdCuestionario,vCuestionario,vDescripcion');
		$this->db->from('iplan_cuestionarios');
		$this->db->where('iActivo',1);
		if($tipo_proced > 0) $this->db->where('iTipo',$tipo_proced);

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function preguntas_cuestionario($cuestid)
	{
		$this->db->select('iIdPregunta');
		$this->db->from('iplan_preguntas');
		$this->db->where('iIdCuestionario', $cuestid);
		$this->db->where('iActivo', 1);

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	/*	Funciones para usar transacciones
	======================================
	*/

	public function cuestionarios($id=0)
	{
		$this->db->select('iIdCuestionario, vCuestionario, vDescripcion, iTipo');
		$this->db->from('iplan_cuestionarios');
		$this->db->where('iActivo',1);
		if($id > 0) $this->db->where('iIdCuestionario',$id);
		return $this->db->get();
	}

	public function preguntas($iIdCuestionario)
	{
		$this->db->select('iIdPregunta');
		$this->db->from('iplan_preguntas');
		$this->db->where('iActivo',1);
		$this->db->where('iIdCuestionario',$iIdCuestionario);
		
		return $this->db->get();
	}

	public function campos_tabla_cuestionario()
	{
		$sql = "SHOW COLUMNS FROM iplan_cuestionarios FROM {$this->db->database};";
		return $this->db->query($sql); 
	}

	public function pregunta($iIdPregunta)
	{
		$this->db->select('iIdPregunta, vPregunta, iEvidencia, iTipoPregunta, iNumero');
		$this->db->from('iplan_preguntas');
		$this->db->where('iActivo',1);
		$this->db->where('iIdPregunta',$iIdPregunta);
		
		return $this->db->get()->row();
	}

	public function opciones($iIdPregunta)
	{
		$this->db->select('o.iIdOpcion, o.vOpcion, o.iTipoR, o.vValor, p.iTipoPregunta, o.iOtro');
		$this->db->from('iplan_opciones o');
		$this->db->join('iplan_preguntas p','p.iIdPregunta = o.iIdPregunta','INNER');
		$this->db->where('o.iIdPregunta',$iIdPregunta);
		$this->db->where('o.iActivo',1);

		$this->db->order_by('o.iIdOpcion');

		return $this->db->get();
	}

	public function rangos($iIdPregunta)
	{
		$this->db->select('o.vValor, o.iLimiteMin, o.iLimiteMax');
		$this->db->from('iplan_rangos o');
		$this->db->where('o.iIdPregunta',$iIdPregunta);

		$this->db->order_by('o.vValor');

		return $this->db->get();
	}

}