var phoneNumbers = [];
var index_array = new Array();
var getUrl = window.location;
var base_url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
var obj;
var html;
var count;

$(document).ready(function() {
	$('#provider_add_phone').mask("(00) 0 0000-0000",{placeholder: "(__) _ ____-____"})
	$('#provider_cpf').mask("999.999.999-99")
	$('#provider_rg').mask('9.999.999');
	$('#provider_cnpj').mask("99.999.999/9999-99");
	$('#company_cnpj').mask("99.999.999/9999-99");
	
	toggleFilters();
	if($('#juridical').prop('checked')){
		juridicalPerson();
	}
	if($('#physical').prop('checked')){
		physicalPerson();
	}
});

function nextIndex(id){
	this.index_array[id] += 1;	
}

function previousIndex(id){
	this.index_array[id] -= 1;	
}

function nextPhoneNumber(id){
	
	$.ajax({
		url:base_url + "/home/get_provider_phone/" + id,
		type:"POST",
		success: function(result){
			obj = $.parseJSON(result);
			count = 0;
			
			$.each( obj, function() {
				count ++;
			});
			if(index_array[id] == count - 1 ){
				return;
			}
			nextIndex(id);
			html = '<id = "phone_data_'+id+'">' + obj['phone_' + index_array[id]] + 
						'<button class = "nav_button" onclick = "nextPhoneNumber('+ id + ', ' + index_array[id] +')">></button>'+
						'<button class = "nav_button" onclick = "previousPhoneNumber('+ id + ', ' + index_array[id] +')"><</button>';
			$("#phone_data_"+id).html(html);
			return;
		}


	});
}

function previousPhoneNumber(id){

	$.ajax({
		
		url:base_url + "/home/get_provider_phone/" + id,
		type:"POST",
		success: function(result){
			
			obj = $.parseJSON(result);
			
			if(index_array[id] == 0 ){
				return;
			}
			
			previousIndex(id);
			html = '<id = "phone_data_'+id+'">' +
						obj['phone_' + index_array[id]] + 
						'<button class = "nav_button" onclick = "nextPhoneNumber('+ id + ', ' + index_array[id] +')">></button>'+
						'<button class = "nav_button" onclick = "previousPhoneNumber('+ id + ', ' + index_array[id] +')"><</button>';
			$("#phone_data_"+id).html(html);
		}


	});

}

function getProvidersList(){

	var id = $("#provider_company_search").val();
	$.ajax({
        
        url:base_url + "/home/get_providers_list/" + id,
        type:"POST",
        success: function(result){
            setProvidersList(result);
			
        }
    });
	
}

function setProvidersList(json_obj){
	
	var id;
	var provider;
	var cnpj; 
	var cpf;
	var register_date;
	var phones;
	
	$('#data_table tbody').children('tr').remove();
	obj = $.parseJSON(json_obj);
	$.each( obj, function( key, value ) {
		id = obj[key]['id'];
		provider = obj[key]['provider_name'];
		cnpj = obj[key]['provider_cnpj'];
		cpf = obj[key]['provider_cpf'];
		register_date = obj[key]['provider_register_date'];
		phones = $.parseJSON(obj[key]['provider_phone']);
		index_array[id] = 0;
		
		if(cnpj != "" && cnpj != undefined){
			$('#data_table tbody:last-child').
				append('<tr>'+
							'<td>' + id + '</td>'+
							'<td>' + provider + '</td>'+
							'<td>' + cnpj + '</td>'+
							'<td id = "phone_data_'+id+'">' + 
								phones['phone_0'] + '<button class = "nav_button" onclick = "nextPhoneNumber('+ id + ', ' + index_array[id] +')">></button>' +
								'<button class = "nav_button" onclick = "previousPhoneNumberbutton ('+ id + ', ' + index_array[id] +')"><</button>'+
							'</td>'+
							'<td>'+ register_date +'</td>'+
						'<tr/>');
		}else{
			$('#data_table tbody:last-child').
				append('<tr>'+
							'<td>' + id + '</td>'+
							'<td>' + provider + '</td>'+
							'<td>' + cpf + '</td> <td id = "phone_data_'+id+'">' + 
								phones['phone_0'] + '<button class = "nav_button" onclick = "nextPhoneNumber('+ id + ', ' + index_array[id] +')">></button>' +
								'<button class = "nav_button" onclick = "previousPhoneNumber('+ id + ', ' + index_array[id] +')"><</button>'+
							'</td>'+
							'<td>'+ register_date +'</td>'+
						'<tr/>');
			
		}
		
	});
}

function juridicalPerson(){
	$("label[for='provider_cpf']").hide();
	$("#provider_cpf").hide();
	$("#provider_cpf").val(""); 
	$("label[for='provider_rg']").hide();
	$("#provider_rg").hide();
	$("#provider_rg").val(""); 
	$("label[for='provider_birth_date']").hide();
	$("#provider_birth_date").hide();
	$("#provider_birth_date").val(""); 
	$("label[for='provider_cnpj']").show();
	$("#provider_cnpj").show();
}

function physicalPerson(){
	$("label[for='provider_cpf']").show();
	$("#provider_cpf").show();
	$("label[for='provider_rg']").show();
	$("#provider_rg").show();
	$("label[for='provider_birth_date']").show();
	$("#provider_birth_date").show();
	$("label[for='provider_cnpj']").hide();
	$("#provider_cnpj").hide();
	$("#provider_cnpj").val(""); 
}

function addPhoneNumber(){
	var val; 
	var new_input;
	
	val = $("input[name='provider_add_phone']").val();
	$("#provider_add_phone").val("");
	new_input = '<input type = "text" name = "provider_phone[]" id = "name" class = "form-control" style = "margin-top: 10px;" value ="' + val +'">';
	

	$('#phones').append(new_input);

}

function filterResults(){
	var id = $("#provider_company_search").val();
	var name = $("#name_search").val();
	var cpf = $("#cpf_search").val();
	var cnpj = $("#cpf_search").val();
	var date = $("#register_date_search").val();
	
	$.ajax({
		url:base_url + "/home/filter_results",
		type:"POST",
		data: { id: id, name: name, cpf: cpf, cnpj: cnpj,date: date},
		success: function(result){
			var obj = $.parseJSON(result);
			if(obj.length == 0){
				alert('Nenhum fornecedor encontrado');
			}
			setProvidersList(result);
		},

	});
	
	
}

function toggleFilters(){
	if($( "#provider_company_search option:selected" ).val() != ''){
		$( "#search" ).show();
		$('#data_table').show();
		getProvidersList();
	}else{
		$( "#search" ).hide();
		$('#data_table tbody').children('tr').remove();
		$('#data_table').hide();
	}
	
}

function remove_div(){
	$('.msg_div').remove();
}