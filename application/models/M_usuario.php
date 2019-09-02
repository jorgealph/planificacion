<?php

class M_usuario extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function inicia_sesion($usuario)
	{	
		$this->db->select('vContrasenia,iTipoUsuario,iIdUsuario,iTipo');
		$this->db->from('iplan_usuarios');
		$this->db->where('vNombreUsuario',$usuario);
		$query = $this->db->get();

		if($query!=false) return $query->result();
		else return false;
	}

	public function carga_usuarios()
	{
		$this->db->select('iIdUsuario,vNombreUsuario,vCorreo,iTipoUsuario,iActivo');
		$this->db->from('iplan_usuarios');
		$this->db->where('iActivo',1);
		$query = $this->db->get();

		if($query!=false) return $query->result();
		else return false;
	}

	public function inserta_usuario($datos)
	{
		$query = $this->db->insert('iplan_usuarios', $datos);
		return $query;
	}

	public function elimina_usuario($usid)
	{
		$this->db->set('iActivo', 0);
		$this->db->where('iIdUsuario',$usid);
		$query = $this->db->update('iplan_usuarios');
		return $query;
	}


	public function modifca_usuario($datos, $usid)
	{		
		$this->db->where('iIdUsuario',$usid);
		$query = $this->db->update('iplan_usuarios',$datos);
		return $query;
	}

	public function datos_usuario($usid)
	{
		$this->db->select('iIdUsuario,vNombreUsuario,vCorreo,iTipoUsuario,iTipo,vEntidad,vMunicipio');
		$this->db->from('iplan_usuarios');
		$this->db->where('iIdUsuario', $usid);
		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}
}