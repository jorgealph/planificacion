<?php

class M_cuestionario extends CI_Model {


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function carga_preguntas($op=0,$id=0)
	{
		if($op==0)
		{

			$this->db->select('p.iIdPregunta, p.vPregunta, p.iPonderacion,p.iEvidencia, p.iTipoPregunta ,o.iIdOpcion, o.vOpcion, o.iOtro, r.iIdRespuesta');
			$this->db->from('iplan_preguntas p');
			$this->db->join('iplan_respuestas r','p.iIdPregunta = r.iIdPregunta and r.iActivo = 1', 'LEFT');
			$this->db->join('iplan_opciones o','r.iIdOpcion = o.iIdOpcion and o.iActivo = 1', 'LEFT');
			$this->db->where('p.iActivo',1);
			$this->db->order_by('p.iIdPregunta', 'ASC');
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

	public function resp_usuario($usid)
	{
		$this->db->select('iIdRespuesta,vRespuesta,vArchivo');
		$this->db->from('iplan_resp_usuario');
		$this->db->where('iIdUsuario',$usid);

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
		$this->db->select('u.iIdUsuario, u.vNombreUsuario, u.vCorreo, vEntidad, vMunicipio, iTipo, (select r.iIdUsuario from iplan_resp_usuario r where r.iIdUsuario = u.iIdUsuario group by r.iIdUsuario) as resp, ( select SUM(r.iCalificacion) from iplan_resp_usuario r where r.iIdUsuario = u.iIdUsuario group by r.iIdUsuario) as calif');
		$this->db->from('iplan_usuarios u');
		$this->db->where('u.iActivo',1);
		$this->db->where('u.iTipoUsuario',3);
		
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

	public function act_calif($respid, $usid, $datos)
	{
		$this->db->where('iIdRespuesta',$respid);
		$this->db->where('iIdUsuario',$usid);

		$query = $this->db->update('iplan_resp_usuario',$datos);
		return $query;
	}

	public function inserta_archivo($datos,$respid,$usid)
	{
		
		$this->db->where('iIdRespuesta',$respid);
		$this->db->where('iIdUsuario',$usid);
		$query = $this->db->update('iplan_resp_usuario',$datos);
		return $query;
	}

}