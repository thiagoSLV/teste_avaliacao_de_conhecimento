<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Register_model extends CI_Model {


	
	//table vars
	private $company_table;
	private $provider_table;

	
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->company_table = 'companies';
		$this->provider_table = 'providers';
    }
	
		
	
	
}

/* End of file Login_logic_model.php */
/* Location: ./application/models/Login_logic_model.php */