<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model{

	//vars
	private $company_table;
	private $company_id;
	private $company_name;
	private $company_state;
	private $company_cnpj;
	
	function __construct() {
        parent::__construct();
		$this->company_id = 'id';
		$this->company_table = 'companies';
		$this->company_name = 'company_name';
		$this->company_state = 'company_state';
		$this->company_cnpj = 'company_cnpj';
    }
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//REGISTER COMPANY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function register_company($data = [])
	{
		
		$success = $this->db->insert($this->company_table, $data);
		return $success;

	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET COMPANY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function get_all_companies() {
		$this->db->select($this->company_id);
		$this->db->select($this->company_name);
		$query = $this->db->get($this->company_table);
		return $query->result();
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET COMPANY INFO 
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function get_company($id= NULL) {
		$this->db->where($this->company_id, $id);
		$query = $this->db->get($this->company_table);
		return $query->row();
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET COMPANY NAME
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function get_company_name() {
		return $this->company_name;
	}

	
}
