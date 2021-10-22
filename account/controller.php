<?php 
	require 'database.php';
		if(isset($_POST['action_type'])){
			$action_type=$_POST['action_type'];
				switch($action_type){
					case "register":
						$user_username=$_POST['user_username'];
						$user_email=$_POST['user_email'];
						$user_password=$_POST['user_password'];
						$user_password=password_hash($user_password, PASSWORD_DEFAULT); 

						if(existing_user($user_username) && existing_email($user_email)){
							echo 'both taken';
						} // if both are taken
						else if(existing_user($user_username)){
							echo 'user taken';
						} // if user is taken
						else if(existing_email($user_email)){
							echo 'email taken';
						} // if email is taken
						else{
							add_new_user($user_username,$user_password,$user_email);
							echo 'user added';
						} //if both are not taken, success
						break;
					case "login":
						$user_username=$_POST['user_username'];
						$user_password=$_POST['user_password'];

						if(existing_user($user_username)){
							$res = login($user_username);
							if(password_verify($user_password, $res['user_password'])){	
								$_SESSION['user_session'] = $res['user_id'];
								$_SESSION['user_username'] = $res['user_username'];
								update_login($res['user_id']);
								echo 'success';
							}else{
								echo 'wrong password';
							}
						}else{
							echo 'username error';
						}
						break;
					case "add_new_game":
						$game_name=$_POST['game_name'];
						$game_desc=$_POST['game_desc'];
						$game_region=$_POST['game_region'];
						$game_server=$_POST['game_server'];

						if(!empty($game_name) && !empty($game_desc) && !empty($game_region) && !empty($game_server)){
						add_new_game($game_name,$game_desc,$game_region,$game_server);
							echo 'success';
						}else{
							echo 'field inputs error';
						}
						break;
					case "sell_game_item":
							$item_name=$_POST['item_name'];
							$item_quality=$_POST['item_quality'];
							$item_rarity=$_POST['item_rarity'];
							$item_detail1=$_POST['item_detail1'];
							$item_detail2=$_POST['item_detail2'];
							$item_detail3=$_POST['item_detail3'];
							$item_price=$_POST['item_price'];
							if(isset($_FILES['item_image'])){
							$item_image=file_get_contents($_FILES['item_image']['tmp_name']);}
							$user_id=$_POST['user_id'];
							$service_id=$_POST['service_id'];
							$order_id=$_POST['order_id'];

							if(!empty($item_name) && !empty($item_image) && !$item_quality != 'null' && $item_rarity != 'null' && $item_detail1 != 'null' && $item_detail2 != 'null' && $item_detail3 != 'null' && $service_id !='null'){
								if($res=existing_game_item($item_name,$item_quality,$item_rarity,$item_detail1,$item_detail2,$item_detail3)){
									add_new_game_item($item_name,$res['goods_id'],$item_quality,$item_rarity,$item_detail1,$item_detail2,$item_detail3,$item_price,$item_image,$user_id,$service_id,1,$order_id);
								echo 'success then copying the same goods id';
								}
								else{
									add_new_game_item($item_name,0,$item_quality,$item_rarity,$item_detail1,$item_detail2,$item_detail3,$item_price,$item_image,$user_id,$service_id,1,$order_id);
									$res=existing_game_item($item_name,$item_quality,$item_rarity,$item_detail1,$item_detail2,$item_detail3);
									add_item_goods_id($res['item_id']);
									echo 'success with new goods ID kay walay kaparehas';
								}
							}else{
								echo 'field inputs error';
							}
							break;			
					case "buy_game_item":
								$item_id=$_POST['item_id'];
								$buyer_id=$_POST['buyer_id'];
								$seller_id=$_POST['seller_id'];
								$service_id=$_POST['service_id'];
								$item_price=$_POST['item_price'];
								$game_id=$_POST['game_id'];
								$order_id=$_POST['order_id'];
								
									echo 'success then copying the same goods id';
									

								break;			
								
				}
			}
?>