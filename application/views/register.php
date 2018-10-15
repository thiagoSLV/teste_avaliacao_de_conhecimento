<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">
	<title>Teste Bludata</title>
	
	<!--CSS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url('assets/css/common.css'); ?>">

	
	<!--JS-->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="<?php echo base_url('assets/js/my_functions.js');?>"></script>
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.js');?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.mask.js');?>"></script>

</head>

<body>

	<div id="general_content">
	
		<div class = 'col-xl-8 col-md-8 col-sm-8 offset-2'>
			
			<ul class = 'nav nav-tabs'>
			
					<!--Providers list tab-->
					<li class = 'nav-item'>
						<a href = '#list_providers' class = 'nav-link' role = 'tab' data-toggle = 'tab'>Lista de Fornecedores</a>
					</li>
					
					<!--Company Register tab-->
					<li class = 'nav-item'>
						<a href = '#company' class = 'nav-link' role = 'tab' data-toggle = 'tab'>Cadastro de Empresa</a>
					</li>
					
					<!--Provider Register tab-->
					<li class = 'nav-item'>
						<a href = '#provider' class = 'nav-link' role = 'tab' data-toggle = 'tab'>Cadastro de Fornecedor</a>
					</li>
			</ul>
			
			<div class = 'tab-content'>
				
				<!--Providers list-->
				<div role = 'tabpanel' class = 'tab-pane active' id = 'list_providers' >
					
					<!--Div to select company-->
					<div class = 'row' style = 'margin:0;'>
						<?php
							echo form_label('Empresa:', 'provider_company');
							echo form_dropdown($provider_company_search, $companies);
						?>
					</div>
					
					<!--Div to display filters-->
					<div class = 'row' id = 'search' style = 'margin:0;'>
						<?php
							echo form_input($name_search_input);
							echo form_input($cpf_search_input);
							echo form_input($register_date_search_input);
							echo form_button($search_button);
						?>
					</div>
					
					<!--Table to display providers of selected company-->
					
					<table id = 'data_table' class = 'table table-bordered'>
					
						<thead>
							<tr>
								<th scope="col">No.</th>
								<th scope="col">Fornecedor</th>
								<th scope="col">CPF/CNPJ</th>
								<th scope="col">Telefone</th>
								<th scope="col">Data de Registro</th>
							</tr>
						</thead>
				
						<!--Table data generated dynamically-->
						<tbody>
							
						</tbody>
						
					</table>
				
				</div>
				
				<!--Company Register form-->
				<div role = 'tabpanel' class = 'tab-pane' id = 'company' >
				
					<?php
						echo form_open('home/register_company'),
						
							form_label('Nome da empresa:', 'company_name'),
							form_input($company_name_input),
							form_label('Estado:', 'company_state'),
							form_dropdown($company_state_input, $states, 'UF'),
							form_label('CNPJ:', 'company_cnpj'),
							form_input($company_cnpj_input),
							form_submit($company_submit),
							
						form_close();
					?>
					
				</div>
				
				<!--Provider Register tab-->
				<div role = 'tabpanel' class = 'tab-pane' id = 'provider' >
					<?php
						// echo form_open('home/register_provider'),
						echo form_open('home/register_provider'),
							form_label('Nome do fornecedor:', 'provider_name'),
							form_input($provider_name_input),
							form_label('Empresa:', 'provider_company'),
							form_dropdown($provider_company_input, $companies),
							
							//area for person type
							'<div style = "border: 3px solid #F5F5F5;">',
								'<p>tipo de pessoa</p>',
								form_label('Física', 'physical'),
								form_input($provider_physical_person_input),
								form_label('Juridica', 'juridical'),
								form_input($provider_juridical_person_input),
							'</div>',
							
							form_label('CPF:', 'provider_cpf'),
							form_input($provider_cpf_input),
							form_label('RG:', 'provider_rg'),
							form_input($provider_rg_input),
							form_label('CNPJ:', 'provider_cnpj'),
							form_input($provider_cnpj_input),
							form_label('Data de nascimento:', 'provider_birth_date'),
							form_input($provider_birth_date_input),
							form_label('Telefone:', 'provider_phone'),
							//input to add new phones
							'<div class = "row" style = "margin:0;">',
								form_input($provider_add_phone_input),
								form_button($add_phone_number_button),
							'</div>',
							
							//area to of phones array
							'<div id = "phones" class = "row" style = "margin:0;">',
							'</div>',
							
							form_submit($provider_submit),
							
						form_close();
						
					?>
				</div>
				
				<!--Display Success Message-->
				<?php
					if(isset($success) and $success){
						echo 
						'<div id = "success" class="msg_div alert alert-success">
							<button id = "remove_btn" class = "remove_btn btn btn-danger" onclick = remove_div()>X</button>
							Registro efetuado com sucesso
						</div>';
		
					}
				?>
				
				<!--Display Error Message-->
				<?php	
					if( isset($error) and $error){
						echo 
						'<div id = "error" class="msg_div alert alert-danger">',
							'<button id = "remove_btn" class = "remove_btn btn btn-danger" onclick = remove_div()>X</button>',
							validation_errors(),
						'</div>';
					
					}
				?>

			</div>	

		</div>

	</div>

</body>

</html>