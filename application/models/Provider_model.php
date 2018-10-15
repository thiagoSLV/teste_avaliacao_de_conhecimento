<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Provider_model extends CI_Model{

	//vars
	private $provider_table;
	private $provider_id;
	private $provider_name;
	private $provider_company;
	private $provider_cnpj;
	private $provider_cpf;
	private $provider_register_date;
	private $provider_phone;
	private $provider_rg;
	private $provider_birth_date;
	
	function __construct() {
        parent::__construct();
		$this->provider_table = 'providers';
		$this->provider_id = 'id';
		$this->provider_name = 'provider_name';
		$this->provider_company = 'provider_company';
		$this->provider_cnpj = 'provider_cnpj';
		$this->provider_cpf = 'provider_cpf';
		$this->provider_register_date = 'provider_register_date';
		$this->provider_phone = 'provider_phone';
		$this->provider_rg = 'provider_rg';
		$this->provider_birth_date = 'provider_birth_date';
    }
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//REGISTER PROVIDER
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function register_provider($data = [])
	{
		
		$success = $this->db->insert($this->provider_table, $data);
		return $success;

	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET PROVIDER OF COMPANY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function get_provider_by_company($id= NULL) {
		$this->db->select($this->provider_id);
		$this->db->select($this->provider_name);
		$this->db->select($this->provider_cnpj);
		$this->db->select($this->provider_cpf);
		$this->db->select($this->provider_phone);
		$this->db->select($this->provider_register_date);
		$this->db->where($this->provider_company, $id);
		$query = $this->db->get($this->provider_table);
		return $query->result_array();
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET PROVIDER WITH PARAMETERS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function filter_results($parameters = []) {
		$data = [];
		if($parameters['name'] != ''){
			$this->db->like($this->provider_name, $parameters['name']);
		}
		
		if($parameters['date'] != ''){
			$this->db->like($this->provider_register_date, $parameters['date']);
		}
		
		$this->db->where($this->provider_company, $parameters['id']);
		$query = $this->db->get($this->provider_table);

		foreach($query->result() as $key => $value){
			$data[$key]['id'] = $value->id;
			$data[$key]['provider_name'] = $value->provider_name;
			$data[$key]['provider_company'] = $value->provider_company;
			$data[$key]['provider_cpf'] = $value->provider_cpf;
			$data[$key]['provider_cnpj'] = $value->provider_cnpj;
			$data[$key]['provider_register_date'] = $value->provider_register_date;
			$data[$key]['provider_phone'] = $value->provider_phone;

		}
		return $data;
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET PROVIDER CNPJ WITH PARAMETERS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function get_cnpj($cnpj = NULL) {
	
		$this->db->select($this->provider_cnpj);
		$this->db->like($this->provider_cnpj, $cnpj);
		$query = $this->db->get($this->provider_table);
		
		return $query->result();
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET PROVIDER cpf WITH PARAMETERS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function get_cpf($cpf = NULL) {
	
		$this->db->select($this->provider_cpf);
		$this->db->like($this->provider_cpf, $cnpj);
		$query = $this->db->get($this->provider_table);
		
		return $query->result();
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET PROVIDER PHONE LIST
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function get_provider_phone($id= NULL) {
		$this->db->select($this->provider_phone);
		$this->db->where($this->provider_id, $id);
		$query = $this->db->get($this->provider_table);
		return $query->row()->provider_phone;
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CHECK IF PROVIDER IS UNDER AGE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function validate_provider($provider_birth_date)
	{
		$date = date('Y-m-d');
		$provider_age = $date - $provider_birth_date;
		
		if($provider_age < 18){
			return FALSE;
		}
		
		return TRUE;

	}


	
}
