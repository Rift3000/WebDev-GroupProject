$(function() {
	
	$('input').click(function(){
		$(this).css.background = "rgb(240,240,240)";
	});
	
	
	$('#loginbtn').click(function(){
		if($('#email').val()==""){
			$('#email').css("background","pink");
		}
		if($('#password').val()==""){
			$('#password').css("background","pink");
		}
		
		 if($('#email').val()!="" || $('#password').val()!=""){
				 $.ajax({url: "index.php", method:"post",
				 data:{
					 status:'login',
					 username : $('#email').val(),
					 password : $('#password').val()
				 },
				 success: function(result){
					if(result == "Invalid Email"){
						$('.invalid').eq(0).slideDown();
					}else if(result == "Invalid Password"){
						$('.invalid').eq(1).slideDown();
					}else{
						$('#login').slideUp(500);
						$('#login').removeClass('activeshow');
						$('#login').addClass('inactivehide');
						
						$('#home').slideDown(500);
						$('#home').addClass('activeshow');
						$('#home').removeClass('inactivehide');
						$('.nav-link').removeClass('disabled');
						
						$('#email').val("");
						$('#password').val("");
						$('.invalid').eq(0).slideUp();
						$('.invalid').eq(1).slideUp();
						getIs();
						
						result = result.split('|');

						if(result[1] == result[0]){
							$('#v-pills-adduser-tab').removeClass("inactivehide2");
							$('#v-pills-adduser-tab').addClass("activeshow2");
						}else{
							$('#v-pills-adduser-tab').removeClass("activeshow2");
							$('#v-pills-adduser-tab').addClass("inactivehide2");
						}
					}
				  }});
			 }
		 
	});
	$('#v-pills-newissues-tab').click(function(){
		$.ajax({url: "index.php", method:"get",
			 data:{
				 status:'getusers'
			 },
			 success: function(result){
					$('#assigned').html(result);
					
				}
			  });
		
	});
	$('#v-pills-home-tab').click(function(){
		$.ajax({url: "index.php", method:"get",
			 data:{
				 status:'getissues'
			 },
			 success: function(result){
					$('#table_data').html(result);
				}
			  });
	});
	
	$('#v-pills-logoff-tab').click(function(){
		filter('#displayall','a');
		$.ajax({url: "index.php", method:"post",
			 data:{
				 status:'logout'
			 },
			 success: function(result){
					$('#home').removeClass('activeshow');
					$('#home').addClass('inactivehide');
					$('#login').removeClass('inactivehide');
					$('#login').addClass('activeshow');
					
					$('#home').slideUp();
					$('#login').slideDown();
					
					$('.nav-link').addClass('disabled');
					$('#v-pills-home-tab').removeClass('disabled');
				}
			  });
		
	});
	
	
	$('#submitissuebtn').click(function(){
		$.ajax({url: "index.php", method:"post",
			 data:{
				 status:'addissue',
				 title:$('#title').val(),
				 description:$('#description').val(),
				 assigned:$('#assigned').children("option:selected").val(),
				 priority:$('#priority').children("option:selected").val(),
				 typed:$('#typed').children("option:selected").val()
			 },
			 success: function(result){
				 if(result =="200 OK"){
					$('#title').val("");
					$('#description').val("");
					alert("Data Added");
				 }
					
				}
			  });
		
	});
	
	$('#submituserbtn').click(function(){
		$.ajax({url: "index.php", method:"post",
			 data:{
				 status:'adduser',
				 firstname:$('#firstname').val(),
				 lastname:$('#lastname').val(),
				 email:$('#setemail').val(),
				 password:$('#setpassword').val(),
			 },
			 success: function(result){
				 if(result =="200 OK"){
					 $('#firstname').val("");
					$('#lastname').val("");
					$('#setemail').val("");
					$('#setpassword').val("");
					alert("User Added");
				 }
					
				}
			  });
		
	});
});
var getIs = function(){
		$.ajax({url: "index.php", method:"get",
			 data:{
				 status:'getissues'
			 },
			 success: function(result){
					$('#table_data').html(result);
				}
			  });
	}
	
var getprofile = function(e){
		$.ajax({url: "index.php", method:"get",
			 data:{
				 status:'getiss',
				 id:e
			 },
			 success: function(result){
					$('#v-pills-profile').html(result);
				}
			  });
	}
	
var filter = function(e,r){
	if(!$(e).hasClass('btn-primary')){
		$('.filters').removeClass('btn-primary');
		$('.filters').addClass('custombtnlink');	
		$(e).removeClass('custombtnlink');
		$(e).addClass('btn-primary');
	}
		
		if(r=='o'){
			var data = $('#table_data').html().split('<tr style="display:none">').join('<tr>').split('<tr>');
		    var filtered="";
			for(var i=1;i<data.length;i++){
			if(data[i].search(">OPEN<")!=-1){
				filtered += "<tr>"+ data[i];
			 }else{
				 filtered += "<tr style='display:none'>"+ data[i];
			 }
			}
			$('#table_data').html(filtered);
		}else if(r=='a'){
			var data = $('#table_data').html().split('<tr style="display:none">').join('<tr>');
			$('#table_data').html(data);
		}else if(r=='m'){
			$.ajax({url: "index.php", method:"get",
			 data:{
				 status:'getuserid'
			 },
			 success: function(result){
					var data = $('#table_data').html().split('<tr style="display:none">').join('<tr>').split('<tr>');
					var filtered="";
					for(var i=1;i<data.length;i++){
						if(data[i].search('type="hidden" value="'+result+'"')!=-1){
							filtered += "<tr>"+ data[i];
						 }else{
							 filtered += "<tr style='display:none'>"+ data[i];
						 }
						}
					$('#table_data').html(filtered);
				}
			  });
		}
	
}
var markissue = function(e,r){
		var mrk = "";
		if(e=='p'){
			mrk = "IN PROGRESS";
		}else{
			mrk = "CLOSED";
		}
		
		$.ajax({url: "index.php", method:"POST",
			 data:{
				 status:'setupdate',
				 mark:mrk,
				 id:r
			 },
			 success: function(result){
					getIs();
				}
			  });
	}
	