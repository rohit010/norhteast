var curent_assignee = "0";


$(document).ready(function(){
	$('.assign_leads').live("click",function(){
		reset_button(0);
		$('#lead_id').val($(this).parent().parent().find(".lead_status").attr("data-id"));
		$('#assigne_exist').val("1");
		$('#lead_name').html($(this).parent().parent().find(".lead_status").attr("data-name"));
		$('#lead_email').html($(this).parent().parent().find(".lead_status").attr("data-email"));
		$('#lead_mobile_number').html($(this).parent().parent().find(".lead_status").attr("data-number"));
		$('#data_query').html($(this).parent().parent().find(".lead_status").attr("data-query"));
		
		$('#lead_assigne').show();
		$('#lead_assigne_managers').hide();
		
		$('#lead_assigne').val($(this).parent().parent().find(".lead_status").attr("data-assigne"));
		$('#lead_status_info').val(parseInt($(this).parent().parent().find(".lead_status").attr("data-status")));
		curent_assignee = $(this).parent().parent().find(".lead_status").attr("data-assigne");
		$('#lead_assigne').attr("disabled",false);
		$('#lead_status_info').attr("disabled",true);
	});
	$('.lead_status').change(function(){
		var conf = confirm("Are you sure you want to change the lead status to "+$(this).children("option[selected='selected']").text());
		if(conf==true){
			reset_button(0);
			$('#assign_leads').modal("show");
			$('#lead_id').val($(this).attr("data-id"));
			$('#lead_name').html($(this).attr("data-name"));
			$('#lead_email').html($(this).attr("data-email"));
			$('#lead_mobile_number').html($(this).attr("data-number"));
			$('#data_query').html($(this).attr("data-query"));
			$('#lead_status_info').val(this.value);
			$('#assigne_exist').val("0");
			$('#lead_assigne').val($(this).attr("data-assigne"));
			$('#lead_assigne').attr("disabled",true);
			$('#lead_status_info').attr("disabled",false);
		} else {
			return false;
		}
		
	});
	$('.remove_users_hierarchy').live("click",function(){
		var parent_id = $(this).attr("data-parent-id");
		var user_id = $(this).attr("data-user-id");
		var thisObject = $(this);
		if(parent_id!="" && user_id!=""){
			$.ajax({
					type:"POST",
					url:"/internal/Manage_user_hierarchy",
					dataType : "json",
					data:{'method':'remove','parent_id':parent_id,'user_id':user_id},
					success: function(msg){
						if(msg.status==0){
							$('#manage_hirarchy_msg').html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+msg.msg+'</div>');
							return false;
						} else if(msg.status==1){
							$(thisObject).parent().parent().remove();
							$('#manage_hirarchy_msg').html('<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+msg.msg+'</div>');
						}
					},
					error: function  (argument) {
						$('#manage_hirarchy_msg').html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Something went wrong please try again some time</div>');
					}
			});
		} else {
			alert("Unable to delete user please try again some time..");
		}
	});
	$('#add_user_hirerchy_button').live("click",function(){
		var parent_id =  $(this).attr("data-parent-id");
		var user_id = $('#unassignedusersList').val(); 
		if(parent_id!="" && user_id!=""){
			if(user_id==""){
				alert("Please Chose a user to assign to lead");
				return false;	
			}
			$.ajax({
					type:"POST",
					url:"/internal/Manage_user_hierarchy",
					dataType : "json",
					data:{'method':'add','parent_id':parent_id,'user_id':user_id},
					success: function(msg){
						if(msg.status==0){
							$('#manage_hirarchy_msg').html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+msg.msg+'</div>');
							return false;
						} else if(msg.status==1){
							$('#myusersList').append('<tr><td>'+user_id+'</td><td>'+$("#unassignedusersList option:selected").text()+'</td><td><a href="#" data-parent-id="'+parent_id+'" data-user-id="'+user_id+'" class="remove_users_hierarchy">Remove</a></td></tr>');
							$('#manage_hirarchy_msg').html('<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+msg.msg+'</div>');
						}
					},
					error: function  (argument) {
						$('#manage_hirarchy_msg').html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Something went wrong please try again some time</div>');
					}
			});
			
		} else {
			alert("Unable to add users to this lead please try again some time");
		}
		
	});
	$('.LeadDetails').click(function(){
		var url = $(this).attr("data-href");
		$('#LeadDetails').load(url);
	});
	$('.user_status').change(function(){
		var conf = confirm("Are you sure you want to change the user status to "+$(this).children("option[selected='selected']").text());
		if(conf==true){
			$(this).attr("disabled","disabled");
			var changing_status = this.value;
			var uid = $(this).attr("data-uid");
			var thisObject = $(this);
			$.ajax({
					type:"POST",
					url:"/internal/AjaxUpadeUserStatus",
					dataType : "json",
					data:{'uid':uid,'change_status':changing_status},
					success: function(msg){
						alert(msg.status_msg);
						$(thisObject).removeAttr("disabled");
						//alert($(thisObject).attr("disabled","false"));
						
					},
					error: function  (argument) {
					}
			});
		}
	});
	$("#lead_update_form").on('submit',function(event) {
		event.preventDefault();
		if($('#lead_status_info').val()==""){
			alert("Please Chose a Status");
			return false;
		}
		if($('#assigne_exist').val()=="1"){
			var users_type = $('.change_users_type:checked').val();
			if(users_type=="all"){
				if($('#lead_assigne').val()==""){
					alert("Please Chose a Assigne");
					return false;
				}
			} else if(users_type=="managers"){
				if($('#lead_assigne_managers').val()==""){
					alert("Please Chose a Assigne");
					return false;
				}			
			}
			

		}
		if($('textarea[name="lead_comments"]').val()==""){
			alert("Please Enter the Comments");
			return false;
		}
		if(($('#assigne_exist').val()=="1")){
			if(curent_assignee!=$('#lead_assigne').val()){
				var conf = confirm("Are you sure you want to change the Assignee for this lead ");
				if(conf==true){
				} else {
					return false;
				}
			}
		}
		$('#progressbar').show();
		reset_button(1);
		var thisObject = $(this);
		$.ajax({
				type:"POST",
				url:"/internal/AJAXUpdateLeadInformation",
				dataType : "json",
				data:$(this).serialize(),
				success: function(msg){
					$('#assign_leads').modal("hide");
					location.reload();
					reset_button(0);
					$('#progressbar').hide();
				},
				error: function  (argument) {
				}
		});
	});
	$('#show_password').click(function(){
		if($(this).attr("checked")){
			document.getElementById("Users_password").setAttribute("type", "text");
			document.getElementById("Users_repeat_password").setAttribute("type", "text");
		} else {
			document.getElementById("Users_password").setAttribute("type", "password");
			document.getElementById("Users_repeat_password").setAttribute("type", "password");
		}
	});
	$('#select_all').click(function(){
		if($('#select_all').is(':checked')){
			$('.select_lead').attr("checked",true);
		} else {
			$('.select_lead').attr("checked",false);
		}
	});
	$('.select_lead').click(function(){
		var total_records = $('.select_lead').length;
		var selected_records = $('.select_lead:checked').length;
		if(selected_records==total_records){
			$('#select_all').attr("checked",true);
		} else {
			$('#select_all').attr("checked",false);
		}
	});
	
	$('.bulk_assign_leads').click(function(){
		$('#bulk_lead_assigne_id').show();
		$('#bulk_lead_assigne_managers').hide();
		var total_leads = $(".select_lead:checked").length;
		if(total_leads>0){
			var lead_list = [];
			var lead_list_names = [];
			$(".select_lead:checked").each(function() {
				lead_list.push(this.value);
				var lead_name = $(this).parent().parent().find(".LeadDetails").html();
				lead_list_names.push(lead_name);
			});
			$('#selected_lead_list').html(lead_list_names.join());
			$('#selected_lead_ids').val(lead_list.join());
			
		} else {
			alert("No Lead Selected please select and then assign the leads");
			return false;
		}
	});
	
	$('#bulk_lead_assigne').click(function(){
		$('#bulk_lead_assigne').attr("disabled",false);
		var lead_assignee = 0;
		var users_type = $('.change_bulk_users_type:checked').val();
		if(users_type=="all"){
			if($('#bulk_lead_assigne_id').val()==""){
				alert("please select assigne and click on save button");
				return false;
			} else {
				lead_assignee = $('#bulk_lead_assigne_id').val();
			}
		} else if(users_type=="managers"){
			if($('#bulk_lead_assigne_managers').val()==""){
				alert("please select assigne and click on save button");
				return false;
			} else {
				lead_assignee = $('#bulk_lead_assigne_managers').val();
			}			
		}
		if($('#bulk_lead_comments').val()==""){
			alert("Please Enter Some comment and click on save");
			return false;
		}
		if($('#selected_lead_ids').val()==""){
			alert("No leads selected please select lead and assigne it to employee");
			return false;
		} 

		$('#bulk_lead_progressbar').show();
		$('#bulk_lead_assigne').text($('#bulk_lead_assigne').attr("data-loading-text"));
		$('#bulk_lead_assigne').attr("disabled",true);
		$.ajax({
				type:"POST",
				url:"/internal/AJAXBulkAssigneLeads",
				dataType : "json",
				data:{	"assigne_id"		: 	lead_assignee,
						"lead_ids"			: 	$('#selected_lead_ids').val(),
						"bulk_lead_comments": 	$('#bulk_lead_comments').val() 
					},
				success: function(msg){
					alert(msg.sucess+" Lead assigned");
					$('#bulk_lead_assigne').text("Save Changes");
					$('#bulk_lead_assigne').attr("disabled",false);
					location.reload();
					reset_button(0);
					$('#bulk_lead_progressbar').hide();
				},
				error: function  (argument) {
				}
		});
	});
	
	$('.change_users_type').change(function(){
		var users_type = $(this).val();
		if(users_type=="all"){
			$('#lead_assigne').show();
			$('#lead_assigne_managers').hide();
		} else if(users_type=="managers"){
			$('#lead_assigne').hide();
			$('#lead_assigne_managers').show();
		}
	});
	
	$('.change_bulk_users_type').change(function(){
		var users_type = $(this).val();
		if(users_type=="all"){
			$('#bulk_lead_assigne_id').show();
			$('#bulk_lead_assigne_managers').hide();
		} else if(users_type=="managers"){
			$('#bulk_lead_assigne_id').hide();
			$('#bulk_lead_assigne_managers').show();
		}
	});
	
	
});


function premium_status_change(){
	alert("");
}
function reset_button(thisObject,opertation){
	if(opertation==1){
		$('#lead_update_button').text("Updating...");
		$('#lead_update_button').attr("disabled",true);
	} else {
		$('#lead_update_button').text("Save Changes");
		$('#lead_update_button').attr("disabled",false);
	}
}
