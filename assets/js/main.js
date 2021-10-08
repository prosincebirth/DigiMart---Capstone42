
$(document).ready(function(){   

    
    //$("#add_game_modal").hide();
    $("#register-form").validate({
        rules:
        {
            user_username: {
                required: true,
                minlength: 5
            },
            user_password: {
                required: true,
                minlength: 8,
                maxlength: 15
            },
            cpassword: {
                required: true,
                equalTo: '#user_password'
            },
            user_email: {
                required: true,
				email: true,
               
            },
        },
        messages:
        {
            user_username:{
                required: "Provide a Username",
                minlength: "Username Needs To Be Minimum of 5 Characters"
            },
            user_password:{
                required: "Provide a Password",
                minlength: "Password Needs To Be Minimum of 8 Characters"
            },
            user_email:{
                required: "Provide a Valid Email",
            },
            cpassword:{
                required: "Retype Your Password",
                equalTo: "Password Mismatch! Retype"
            }
        },
    });


    $("#add-game-form").validate({
        rules:
        {
            game_name: {
                required: true,
            },
            game_desc: {
                required: true,
            },
            game_region: {
                required: true,
            },
            game_server: {
                required: true,
            },
        },
        messages:
        {
            game_name:{
                required: "This field cannot be blank",
            },
            game_desc:{
                required: "This field cannot be blank",
            },
            game_region:{
                required: "This field cannot be blank",
            },
            game_server:{
                required: "This field cannot be blank",
            }
        },
    });    
	
    $("#login-form").validate({
        rules:
          {
          user_password: {
          required: true,
          },
          user_username: {
                      required: true,
  
                      },
              },
              messages:
              {
                      user_password:{
                              required: "Please enter your password"
                              },
                      user_username: "Please enter your username",
              },
        });
          

	$(".btn").on("click",function(){
		var btn_val=$(this).val();
            switch(btn_val){
            case "register":
                if($("#register-form").valid()){
                    var username=$("#user_username").val().trim();
                    var email=$("#user_email").val().trim();
                    var password=$("#user_password").val().trim();

                    var data=new FormData();
                    data.append("action_type","register");
                    data.append("user_username",username);
                    data.append("user_email",email);
                    data.append("user_password",password);
                    
                    $.ajax({
                        url:'account/controller.php',
                        method:"post",
                        data:data,
                        contentType:false,
                        cache:false,
                        processData:false,
                        success:function(res){
                            if(res=="both taken"){// both are taken
                                $('#error_email').fadeIn(400, function() {
                                    $('#error_email').html('<div class="alert alert-success">&nbsp; Email is already taken</div>').fadeIn(3000, function() {
                                      $('#error_email').fadeOut(3000, function(){
                                      })
                                    })
                                  });
                                  $('#error_username').fadeIn(400, function() {
                                    $('#error_username').html('<div class="alert alert-success">&nbsp; Username is already taken</div>').fadeIn(3000, function() {
                                      $('#error_username').fadeOut(3000, function(){
                                      })
                                    })
                                  });    
                            }
                            else if(res=="user taken"){//username is taken
                                $('#error_username').fadeIn(400, function() {
                                    $('#error_username').html('<div class="alert alert-success">&nbsp; Username is already taken</div>').fadeIn(3000, function() {
                                      $('#error_username').fadeOut(3000, function(){
                                      })
                                    })
                                  });    
                            }
                            else if(res=="email taken"){//email is taken
                                $('#error_email').fadeIn(400, function() {
                                    $('#error_email').html('<div class="alert alert-success">&nbsp; Email is already taken</div>').fadeIn(3000, function() {
                                      $('#error_email').fadeOut(3000, function(){
                                      })
                                    })
                                  });
                            }
                            else if(res=="user added"){//success
                                $('#for_register').fadeIn(400, function() {
                                    $('#for_register').html('<div class="alert alert-success">&nbsp; Success</div>').fadeIn(3000, function() {
                                   
                                    })
                                  }); 
                                  setTimeout(function() {
                                    window.location.href = "login.php";
                                  }, 2000);
                               
                            }
                        }
                    });	
                }
            break;               
            case "login":
                if($("#login-form").valid()){
                    var username=$("#user_username").val().trim();
                    var password=$("#user_password").val().trim();

                    var data=new FormData();
                    data.append("action_type","login");
                    data.append("user_username",username);
                    data.append("user_password",password);

                        $.ajax({
                            url:'account/controller.php',
                            method:"post",
                            data:data,
                            contentType:false,
                            cache:false,
                            processData:false,
                            success:function(res){
                                if(res=="success"){
                                    $('#for_login').fadeIn(400, function() {
                                        $('#for_login').html('<div class="alert alert-success">&nbsp; Success</div>').fadeIn(3000, function() {
                                        })
                                      }); 
                                      setTimeout(function() {
                                        window.location.href = "index.php";
                                      }, 1000);                                
                                }else if(res=="wrong password"){
                                    $('#error_password').fadeIn(400, function() {
                                        $('#error_password').html('<div class="alert alert-success">&nbsp; Incorrect Password </div>').fadeIn(3000, function() {
                                          $('#error_password').fadeOut(3000, function(){
                                          })
                                        })
                                      });

                                }else if(res=="username error"){
                                    $('#error_username').fadeIn(400, function() {
                                        $('#error_username').html('<div class="alert alert-success">&nbsp; Username is not recognized</div>').fadeIn(3000, function() {
                                          $('#error_username').fadeOut(3000, function(){
                                          })
                                        })
                                      });
                                }                        
                            }
                        });	
                    }
            break;
            case "save_new_game":
                if($("#add-game-form").valid()){
				var game_name=$("#game_name").val().trim();
                var game_desc=$("#game_desc").val().trim();
                var game_region=$("#game_region").val().trim();
                var game_server=$("#game_server").val().trim();

				var data=new FormData();
				data.append("action_type","add_new_game");
				data.append("game_name",game_name);
				data.append("game_desc",game_desc);
				data.append("game_region",game_region);
                data.append("game_server",game_server);
				//$("#game_desc").val("");$("#game_region").val("");$("#game_server").val("");

				$.ajax({	
					url:"account/controller.php",
					method:"post",
					data:data,
					contentType:false,
					cache:false,
					processData:false,
					success:function(res){
							alert(res)
                            console.log(res)
					}
				});//END OF AJAX IN ADDING NEW ITEM
            }
				
			break;//END OF SAVE NEW ITEM
		};	
	});	

});	// END OF FUNCTION 