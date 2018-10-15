<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	private $data;
	private $input_class;
	private $filter_class;
	private $button_class;
	private $company_array;
	
	function __construct() {
        parent::__construct();
		
		//Load helpers
		//------------------------------------------------------------
        $this->load->helper('form');
		
		//Load Libraries
		//------------------------------------------------------------
		$this->load->library('form_validation');
		
		//Load models
		//------------------------------------------------------------
		$this->load->model('provider_model');
		$this->load->model('company_model');

		//Set vars
		//------------------------------------------------------------
		$this->input_class = 'form-control';
		$this->button_class = 'btn btn-primary';
		$this->filter_class = 'form-control col-xl-3 common_input';
		$this->company_array = $this->company_model->get_all_companies();
		
		//set custom error messages
		//------------------------------------------------------------
		$this->form_validation->set_message('validate_provider', 'A empresa não permite fornecedores menores de 18 anos');
		$this->form_validation->set_message('required', 'O campo %s é obrigatório');
		$this->form_validation->set_message('min_length', 'Insira um %s valido');
		
		//load states list
		//------------------------------------------------------------
		$this->data['states'] = array(
			'' => 'UF',
			'AC'=>'Acre',
			'AL'=>'Alagoas',
			'AP'=>'Amapá',
			'AM'=>'Amazonas',
			'BA'=>'Bahia',
			'CE'=>'Ceará',
			'DF'=>'Distrito Federal',
			'ES'=>'Espírito Santo',
			'GO'=>'Goiás',
			'MA'=>'Maranhão',
			'MT'=>'Mato Grosso',
			'MS'=>'Mato Grosso do Sul',
			'MG'=>'Minas Gerais',
			'PA'=>'Pará',
			'PB'=>'Paraíba',
			'PR'=>'Paraná',
			'PE'=>'Pernambuco',
			'PI'=>'Piauí',
			'RJ'=>'Rio de Janeiro',
			'RN'=>'Rio Grande do Norte',
			'RS'=>'Rio Grande do Sul',
			'RO'=>'Rondônia',
			'RR'=>'Roraima',
			'SC'=>'Santa Catarina',
			'SP'=>'São Paulo',
			'SE'=>'Sergipe',
			'TO'=>'Tocantins'
		);

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//SET PROVIDER LIST INPUTS
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
		
		$this->data['provider_company_search'] = array(
			'name' => 'provider_company_search',
			'id' => 'provider_company_search',
			'class' => $this->input_class,
			'onchange' => 'toggleFilters()',
			'style' => 'margin-top: 10px;',
			
		);
		
		$this->data['name_search_input'] = array(
			'name' => 'name_search' ,
			'id' => 'name_search' ,
			'class' => $this->filter_class,
			
		);
		
		$this->data['cpf_search_input'] = array(
			'name' => 'cpf_search' ,
			'id' => 'cpf_search' ,
			'class' => $this->filter_class,
			
		);
		
		$this->data['register_date_search_input'] = array(
			'name' => 'register_date_search' ,
			'id' => 'register_date_search' ,
			'type' => 'date',
			'class' => $this->filter_class,
			
		);
		
		$this->data['search_button'] = array(
			'name' => 'search_button' ,
			'id' => 'search_button' ,
			'content' => 'filtrar',
			'class' => $this->button_class,
			'onclick' => 'filterResults()',
			
		);
		//------------------------------------------------------------
		//END OF COMPANY REGISTER INPUTS
		//------------------------------------------------------------	
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//SET COMPANY REGISTER INPUTS
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$this->data['company_name_input'] = array(
			'name' => 'company_name',
			'id' => 'company_name',
			'class' => $this->input_class,
		); 
		
		$this->data['company_state_input'] = array(
			'name' => 'company_state',
			'id' => 'company_state',
			'class' => $this->input_class,
		); 
		
		$this->data['company_cnpj_input'] = array(
			'name' => 'company_cnpj',
			'id' => 'company_cnpj',
			'class' => $this->input_class,
			
		); 
		
		$this->data['company_submit'] = array(
			'name' => 'provider_submit',
			'id' => 'provider_submit',
			'value' => 'Registrar',
			'class' => $this->button_class,
		);
		//------------------------------------------------------------
		//END OF COMPANY REGISTER INPUTS
		//------------------------------------------------------------	
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//SET PROVIDER REGISTER INPUTS
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$this->data['provider_name_input'] = array(
			'name' => 'provider_name',
			'id' => 'provider_name',
			'class' => $this->input_class,
		); 
		
		$this->data['companies'] = array(
			'' => 'selecione uma empresa'
		);
		
		foreach($this->company_array as $key => $value){
			$this->data['companies'][$value->id] = $value->company_name;
		}
		
		
		$this->data['provider_company_input'] = array(
			'name' => 'provider_company_input',
			'id' => 'provider_company_input',
			'class' => $this->input_class,
			
		); 
		
		$this->data['provider_physical_person_input'] = array(
			'name' => 'person_type',
			'id' => 'physical',
			'value' => 'physical',
			'type' => 'radio',
			'onclick' => 'physicalPerson()',
		); 
		
		$this->data['provider_juridical_person_input'] = array(
			'name' => 'person_type',
			'id' => 'juridical',
			'value' => 'juridical',
			'type' => 'radio',
			'checked' => TRUE,
			'onclick' => 'juridicalPerson()',
		); 
		
		
		$this->data['provider_cpf_input'] = array(
			'name' => 'provider_cpf',
			'id' => 'provider_cpf',
	
			'class' => $this->input_class,
		); 
		
		$this->data['provider_cnpj_input'] = array(
			'name' => 'provider_cnpj',
			'id' => 'provider_cnpj',
			'class' => $this->input_class,
			
		); 
		
		$this->data['provider_rg_input'] = array(
			'name' => 'provider_rg',
			'id' => 'provider_rg',
			'class' => $this->input_class,
		); 
		
		$this->data['provider_birth_date_input'] = array(
			'name' => 'provider_birth_date',
			'id' => 'provider_birth_date',
			'type' => 'date',
			'class' => $this->input_class,
		); 
		
		$this->data['provider_add_phone_input'] = array(
			'name' => 'provider_add_phone',
			'id' => 'provider_add_phone',
			'type' => 'tel',
			'class' => 'form-control col-xl-11',
			
		); 
		
		$this->data['add_phone_number_button'] = array('', 
			'name' => 'add_phone_number',
			'id' => 'add_phone_number',
			'content' => '+',
			'class' => 'form-control col-xl-1',
			'onclick' => 'addPhoneNumber()',
		);
		
		$this->data['provider_submit'] = array(
			'name' => 'provider_submit' ,
			'id' => 'provider_submit' ,
			'value' => 'Registrar',
			'class' => $this->button_class,
		);
		//------------------------------------------------------------
		//END OF PROVIDER REGISTER INPUTS
		//------------------------------------------------------------	
		
    }
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//INDEX
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function index(){
		$this->load->view('register', $this->data);
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//VALIDATE FORM AND REGISTER COMPANY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function register_company()
	{
		
		$this->form_validation->set_rules('company_name', 'Nome da empresa', 'required|trim');
		$this->form_validation->set_rules('company_state', 'Estado', 'required');
		$this->form_validation->set_rules('company_cnpj', 'CNPJ da empresa', 'required|min_length[18]');
		
		if ($this->form_validation->run() == TRUE)
		{
			$insert_data['company_name'] = $this->input->post('company_name');
			$insert_data['company_state'] = $this->input->post('company_state');
			$insert_data['company_cnpj'] = $this->input->post('company_cnpj');
			
			$this->data['success'] = $this->company_model->register_company($insert_data);
			unset($_POST);
			
			$this->company_array = $this->company_model->get_all_companies();
			foreach($this->company_array as $key => $value){
				$this->data['companies'][$value->id] = $value->company_name;
			}
		}else{
			$this->data['error'] = TRUE;
		}
		
		$this->index();

	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//VALIDATE FORM AND REGISTER PROVIDER
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function register_provider()
	{
		$this->form_validation->set_rules('provider_name', 'Nome', 'required|trim');
		$this->form_validation->set_rules('provider_company_input', 'Empresa', 'required|trim');
		$this->form_validation->set_rules('provider_phone[0]', 'Telefone', 'required|trim');
		
		$person = $this->input->post('person_type');
		
		if($person == 'juridical'){
			
			$this->form_validation->set_rules('provider_cnpj', 'CNPJ', 'required|trim|min_length[18]');
			
		}else{
			
			$this->form_validation->set_rules('provider_cpf', 'CPF', 'required|trim|min_length[14]');
			$this->form_validation->set_rules('provider_rg', 'RG', 'required|trim|min_length[9]');
			$company = $this->company_model->get_company($this->input->post('provider_company_input'));
			if($company->company_state == 'PR'){
				$this->form_validation->set_rules('provider_birth_date', 'Data de Nascimento', 'required|callback_validate_provider');
			}else{
				$this->form_validation->set_rules('provider_birth_date', 'Data de Nascimento', 'required');
			}
		}
		
		
		if ($this->form_validation->run() == TRUE)
		{	
			$phone_array = array();
			$provider_phone = $this->input->post('provider_phone');
			foreach($provider_phone as $key => $value){
				$phone_array += array('phone_'.$key => $value);
			}
	
			$insert_data['provider_phone'] = json_encode($phone_array);
			$insert_data['provider_name'] = $this->input->post('provider_name');
			$insert_data['provider_company'] = $this->input->post('provider_company_input');
			$insert_data['provider_cpf'] = $this->input->post('provider_cpf');
			$insert_data['provider_cnpj'] = $this->input->post('provider_cnpj');
			$insert_data['provider_birth_date'] = $this->input->post('provider_birth_date');
			$insert_data['provider_rg'] = $this->input->post('provider_rg');
			$insert_data['provider_register_date'] = date('Y-m-d H:i');
			
			$this->data['success'] = $this->provider_model->register_provider($insert_data);
		}else{
			$this->data['error'] = TRUE;
		}
		$this->load->view('register', $this->data);
	
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CHECK IF PROVIDER IS UNDER AGE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function validate_provider($provider_birth_date)
	{
		return $this->provider_model->validate_provider($provider_birth_date);

	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET ALL PROVIDERS OF COMPANY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_providers_list($id = NULL){
		$providers_list = $this->provider_model->get_provider_by_company($id);
		echo json_encode($providers_list);
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET ALL PROVIDERS PHONE LIST
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_provider_phone($id = NULL){
		$provider_phone = $this->provider_model->get_provider_phone($id);
		echo $provider_phone;
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET PROVIDERS WITH SEARCH PARAMETERS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function filter_results(){
		$data['id'] = $this->input->post('id');
		$data['name'] = $this->input->post('name');
		$data['cnpj'] = $this->input->post('cnpj');
		$data['date'] = $this->input->post('date');

		$result = $this->provider_model->filter_results($data);
		
		if($data['cnpj'] != ''){
			foreach($result as $key => $value){
				
				if($value['provider_cnpj'] == $data['cnpj'] or $value['provider_cpf'] == $data['cnpj']){
					$new_filter[$key]['id'] = $value['id'];
					$new_filter[$key]['provider_name'] = $value['provider_name'];
					$new_filter[$key]['provider_company'] = $value['provider_company'];
					$new_filter[$key]['provider_register_date'] = $value['provider_register_date'];
					$new_filter[$key]['provider_phone'] = $value['provider_phone'];
				}
				
				if($value['provider_cnpj'] == $data['cnpj']){
					$new_filter[$key]['provider_cnpj'] = $value['provider_cnpj'];
				}
				
				if($value['provider_cpf'] == $data['cnpj']){
					$new_filter[$key]['provider_cpf'] = $value['provider_cpf'];
				}
			}
			
			echo json_encode($new_filter);
			
		}else{
			
			echo json_encode($result);
		}
	}
	
}
