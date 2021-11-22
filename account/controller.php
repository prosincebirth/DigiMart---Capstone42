<?php 
	require 'database.php';
		if(isset($_POST['action_type'])){
			$action_type=$_POST['action_type'];
				switch($action_type){
					case "register":
						$user_username_b=$_POST['user_username_b'];
						$user_email_b=$_POST['user_email_b'];
						$user_password_b=$_POST['user_password_b'];
						$user_password_b=password_hash($user_password_b, PASSWORD_DEFAULT); 

						if(existing_user($user_username_b) && existing_email($user_email_b)){
							echo 'both taken';
						} // if both are taken
						else if(existing_user($user_username_b)){
							echo 'user taken';
						} // if user is taken
						else if(existing_email($user_email_b)){
							echo 'email taken';
						} // if email is taken
						else{
							add_new_user($user_username_b,$user_password_b,$user_email_b);	
							echo 'Success';
						} //if both are not taken, success
						break;
					case "login":
						$user_username_a=$_POST['user_username_a'];
						$user_password_a=$_POST['user_password_a'];

						if(!empty($user_username_a) && !empty($user_password_a)){
							if(existing_user($user_username_a)){
								$res_a = login($user_username_a);
								if(password_verify($user_password_a, $res_a['user_password'])){	
									$_SESSION['user_session'] = $res_a['user_id'];
									$_SESSION['user_username'] = $res_a['user_username'];
									$_SESSION['user_status'] = $res_a['user_status'];
									session_write_close();
									update_login($res_a['user_id']);
										if(!get_wallet_balance($res_a['user_id'])){
												add_wallet($res_a['user_id']);										
											}
									echo 'Success';		
									//header('Location: home.php'); 
									//palihug ko try ani na fix para wla na alert mo gawas tanawa ang sa modal ilisdi ang button to submit para auto redirect ra siya
									//then e uncomment ang header 
								}else{
									echo 'Wrong Password';
								}
							}else{
								echo 'Username not recognized';
							}
						}else{ echo 'Empty Fields';
							}
						break;
					case "add_new_game_modal"://TESTED 11:56 pm , 25/10/2021
						$game_name_a=$_POST['game_name_a'];
						$game_desc_a=$_POST['game_desc_a'];
						$steam_game_id_a=$_POST['steam_game_id_a'];

						if(!empty($game_name_a) && !empty($game_desc_a) && !empty($steam_game_id_a)){
							add_new_game($game_name_a,$game_desc_a,$steam_game_id_a);
								echo 'Success';
						}else{
								echo 'Field inputs error';
						}
						break;
					case "edit_new_game_modal"://TESTED 11:56 pm , 25/10/2021
						$game_id_b=$_POST['game_id_b'];
						$game_name_b=$_POST['game_name_b'];
						$game_desc_b=$_POST['game_desc_b'];
						$steam_game_id_b=$_POST['steam_game_id_b'];

						if(!empty($game_name_b) && !empty($game_desc_b) && !empty($steam_game_id_b) && !empty($game_id_b)){
								edit_game($game_id_b,$game_name_b,$game_desc_b,$steam_game_id_b);
								echo 'Success';
						}else{
								echo 'Field inputs error';
						}
						break;	
					case "delete_new_game_modal"://TESTED 11:56 pm , 25/10/2021
						$game_id_c=$_POST['game_id_c'];

						if(!empty($game_id_c)){
								delete_game($game_id_c);
								echo 'Success';
						}else{
								echo 'Field inputs error';
						}
						break;
					case "add_new_service_modal"://TESTED 11:56 pm , 25/10/2021
						$service_mode_d=$_POST['service_mode_d'];
						$service_desc_d=$_POST['service_desc_d'];
						$game_id_d=$_POST['game_id_d'];

						if(!empty($service_mode_d) && !empty($service_desc_d) && !empty($game_id_d)){
						add_game_service($service_mode_d,$service_desc_d,$game_id_d);
							echo 'Success';
						}else{
							echo 'Field inputs error';
						}
						break;	
					case "edit_game_services_modal"://TESTED 11:56 pm , 25/10/2021
						$service_id_e=$_POST['service_id_e'];
						$service_mode_e=$_POST['service_mode_e'];
						$service_desc_e=$_POST['service_desc_e'];
						$game_id_e=$_POST['game_id_e'];

						if(!empty($service_id_e) && !empty($service_mode_e) && !empty($service_desc_e) && !empty($game_id_e)){
							edit_game_service($service_id_e,$service_mode_e,$service_desc_e,$game_id_e);
							echo 'Success';
						}else{
							echo 'Field inputs error';
						}
						break;

					case "delete_game_services_modal"://TESTED 11:56 pm , 25/10/2021
						$service_id_f=$_POST['service_id_f'];

						if(!empty($service_id_f)){
								delete_game_services($service_id_f);
								echo 'Success';
						}else{
								echo 'Field inputs error';
						}
						break;	
					case "sell_game_item":
							$goods_name_a=$_POST['goods_name_a'];
							$goods_quality_a=$_POST['goods_quality_a'];
							$goods_rarity_a=$_POST['goods_rarity_a'];
							$goods_detail1_a=$_POST['goods_detail1_a'];
							$goods_detail2_a=$_POST['goods_detail2_a'];
							$goods_detail3_a=$_POST['goods_detail3_a'];
							$goods_price_a=$_POST['goods_price_a'];
							$goods_quantity_a=$_POST['goods_quantity_a'];
							$goods_image_a ="";
							if(isset($_FILES['goods_image_a'])){
							$goods_image_a=file_get_contents($_FILES['goods_image_a']['tmp_name']);}
							$order_id_a=$_POST['order_id_a'];
							$service_id_a=$_POST['service_id_a'];
							//add_new_game_item($item_price,$item_quantity,$goods_id,$user_id,$service_id,$game_id,$order_id)
							//add_new_goods($goods_name,$goods_quality,$goods_rarity,$goods_detail1,$goods_detail2,$goods_detail3,$goods_image,$game_id)
							//existing_goods($goods_name,$goods_quality,$goods_rarity,$goods_detail_1,$goods_detail_2,$goods_detail_3,$goods_image,$game_id){
							if(!empty($goods_name_a) && is_numeric($goods_price_a) && is_numeric($goods_quantity_a) && !empty($_SESSION['user_session']) && !empty($order_id_a)  && !empty($goods_image_a) && $goods_quality_a != 'null' && $goods_rarity_a != 'null' && $goods_detail1_a != 'null' && $goods_detail2_a != 'null' && $goods_detail3_a != 'null' && $goods_price_a != 'null' && $goods_quantity_a !='null' && $order_id_a !='null' && $service_id_a !='null'){
								if($result_a=existing_goods($goods_name_a,$goods_quality_a,$goods_rarity_a,$goods_detail1_a,$goods_detail2_a,$goods_detail3_a,$goods_image_a,'1')){
									add_new_game_item($goods_price_a,$goods_quantity_a,$result_a['goods_id'],$_SESSION['user_session'],$service_id_a,'1','1');
									echo 'Success';
								}else{
									add_new_goods($goods_name_a,$goods_quality_a,$goods_rarity_a,$goods_detail1_a,$goods_detail2_a,$goods_detail3_a,$goods_image_a,'1');
									$result_a=existing_goods($goods_name_a,$goods_quality_a,$goods_rarity_a,$goods_detail1_a,$goods_detail2_a,$goods_detail3_a,$goods_image_a,'1');
									add_new_game_item($goods_price_a,$goods_quantity_a,$result_a['goods_id'],$_SESSION['user_session'],$service_id_a,'1','1');
									echo 'Success'; 
								}
							}else{
								echo 'Empty Fields'; // input is lacking , wrong inputs
							}
							break;			
					case "sell_game_item_2":
								$item_price_b=$_POST['item_price_b'];
								$items_quantity_b=$_POST['items_quantity_b']; 
								$goods_id_b=$_POST['goods_id_b'];
								$service_id_b=$_POST['service_id_b'];
								//add_new_game_item($item_price,$item_quantity,$goods_id,$user_id,$service_id,$game_id,$order_id)
									if(!empty($item_price_b) && is_numeric($item_price_b) && is_numeric($items_quantity_b) && !empty($items_quantity_b) && !empty($goods_id_b) && $service_id_b != 'NULL'){
										add_new_game_item($item_price_b,$items_quantity_b,$goods_id_b,$_SESSION['user_session'],$service_id_b,'1','1');
										echo 'Success'; // success posting item on item page , copying same attribute of the item rather than inputing everything 
									}else{
										echo 'Failed'; // Wrong input , Empty input
									}
								break;
					case "buyorder_game_item":
							$goods_name_d=$_POST['goods_name_d'];
							$goods_quality_d=$_POST['goods_quality_d'];
							$goods_rarity_d=$_POST['goods_rarity_d'];
							$goods_detail1_d=$_POST['goods_detail1_d'];
							$goods_detail2_d=$_POST['goods_detail2_d'];
							$goods_detail3_d=$_POST['goods_detail3_d'];
							$goods_price_d=$_POST['goods_price_d'];
							$goods_quantity_d=$_POST['goods_quantity_d'];
							$goods_image_d ="";
							if(isset($_FILES['goods_image_d'])){
							$goods_image_d=file_get_contents($_FILES['goods_image_d']['tmp_name']);}
							$order_id_d=$_POST['order_id_d'];
							$service_id_d=$_POST['service_id_d'];
							$user_id_d=$_SESSION['user_session'];
							//add_new_game_item($item_price,$item_quantity,$goods_id,$user_id,$service_id,$game_id,$order_id)
							//add_new_goods($goods_name,$goods_quality,$goods_rarity,$goods_detail1,$goods_detail2,$goods_detail3,$goods_image,$game_id)
							//existing_goods($goods_name,$goods_quality,$goods_rarity,$goods_detail_1,$goods_detail_2,$goods_detail_3,$goods_image,$game_id){
							if(!empty($goods_name_d) && is_numeric($goods_price_d) && is_numeric($goods_quantity_d) && !empty($_SESSION['user_session']) && !empty($order_id_d)  && !empty($goods_image_d) && $goods_quality_d != 'null' && $goods_rarity_d != 'null' && $goods_detail1_d != 'null' && $goods_detail2_d != 'null' && $goods_detail3_d != 'null' && $goods_price_d != 'null' && $goods_quantity_d !='null' && $order_id_d !='null' && $service_id_d !='null'){
								if($balance_d=get_wallet_balance($user_id_d)){
									$total_d = $goods_quantity_d * $goods_price_d;
											if($balance_d['wallet_balance'] >= $total_d){
												if($result_d=existing_goods($goods_name_d,$goods_quality_d,$goods_rarity_d,$goods_detail1_d,$goods_detail2_d,$goods_detail3_d,$goods_image_d,'1')){//existing on DB
													if(existing_game_items($result_d['goods_id'],$user_id_d)){
														echo 'Item already posted';//ITEM ALREADY EXISTED OR POSTED
													}
													else{
														add_new_game_item($goods_price_d,$goods_quantity_d,$result_d['goods_id'],$user_id_d,$service_id_d,'1','2');
														update_frozen_balance($user_id_d,$total_d);
														echo 'Success';//NEW GOODS_ID IS GENERATED
													}
												}else{//not existed , created new goods_id
													add_new_goods($goods_name_d,$goods_quality_d,$goods_rarity_d,$goods_detail1_d,$goods_detail2_d,$goods_detail3_d,$goods_image_d,'1');
													$result_d=existing_goods($goods_name_d,$goods_quality_d,$goods_rarity_d,$goods_detail1_d,$goods_detail2_d,$goods_detail3_d,$goods_image_d,'1');
													add_new_game_item($goods_price_d,$goods_quantity_d,$result_d['goods_id'],$user_id_d,$service_id_d,'1','2');
													update_frozen_balance($user_id_d,$total_d);
													echo 'Success';//GOODS_ID IS COPIED
												}
										}else{
											echo 'Insufficient Balance'; // input is lacking , wrong inputs
										}
								}
							}else{
								echo 'Empty Fields'; // input is lacking , wrong inputs
							}
							break;						
					case "buyorder_game_item_2":
								$item_price_e=$_POST['item_price_e'];
								$items_quantity_e=$_POST['items_quantity_e']; 
								$goods_id_e=$_POST['goods_id_e'];
								$service_id_e=$_POST['service_id_e'];
								$user_id_e=$_SESSION['user_session'];
								//add_new_game_item($item_price,$item_quantity,$goods_id,$user_id,$service_id,$game_id,$order_id)			
									if(!empty($item_price_e) && is_numeric($item_price_e) && is_numeric($items_quantity_e) && !empty($items_quantity_e) && !empty($goods_id_e) && $service_id_e != 'NULL'){
										if($balance_e=get_wallet_balance($user_id_e)){
										$total_e = $items_quantity_e * $item_price_e;
										if($balance_e['wallet_balance'] >= $total_e){
											if(existing_game_items($goods_id_e,$user_id_e)){
												echo 'Item already posted';
											}else{
												add_new_game_item($item_price_e,$items_quantity_e,$goods_id_e,$user_id_e,$service_id_e,'1','2');
												update_frozen_balance($user_id_e,$total_e);
												
												echo 'Success';
											} // success posting item on item page , copying same attribute of the item rather than inputing everything 
										}else{
											  echo 'Insufficient Balance'; // input is lacking , wrong inputs
											 }
										}
									}else{
										echo 'Empty Fields'; // Wrong input , Empty input
										}
								break;
					case "buy_game_item"://NOTIFICATION DONE 
								$item_quantity_f=$_POST['item_quantity_f'];
								$item_total_f=$_POST['item_total_f'];
								$item_id_f=$_POST['item_id_f'];
								$buyer_id_f=$_POST['buyer_id_f'];
								$seller_id_f=$_POST['seller_id_f'];
								$service_id_f=$_POST['service_id_f'];
								$game_id_f=$_POST['game_id_f'];
								$order_id_f=$_POST['order_id_f'];
								$item_stock_f=$_POST['item_stock_f'];
								
								//add_transaction($transaction_quantity,$transaction_amount,$game_item_id,$buyer_id,$seller_id,$service_id,$game_id,$order_id)
								if(empty($buyer_id_f)){ // trappings for not logged in
									echo 'Please Login';
								}
								else if($buyer_id_f == $seller_id_f){ // cannot buy your own game 
									echo 'You cannot buy your game';
								}
								else if($item_quantity_f > $item_stock_f){ // cannot exceed stock
									echo 'Exceed Quantity';
								}
								else if($item_quantity_f == $item_stock_f){
									if($balance_f=get_wallet_balance($buyer_id_f)){
										if($balance_f['wallet_balance'] >= $item_total_f){
											update_sale_order_item_quantity_out_of_stock($item_id_f);
											add_transaction($item_quantity_f,$item_total_f,$item_id_f,$buyer_id_f,$seller_id_f,$service_id_f,$game_id_f,$order_id_f);
											update_frozen_balance($buyer_id_f,$item_total_f);
											if($notification_f=get_game_item_information_notification($item_id_f)){
												add_notification('A buyer has purchased your item "'.$notification_f['goods_name'].'" x'.$item_quantity_f.' , <a href="sale_order.php">go to Sales</a>',$seller_id_f);
												add_notification('You purchased "'.$notification_f['goods_name'].'" x'.$item_quantity_f.' , <a href="buy_order.php">go to Buy Order</a>',$buyer_id_f);
												echo 'Success';}	
											
										}else{ 
												echo 'Insufficient Balance'; 
										}
									}
								}
								else{
									if($balance_f=get_wallet_balance($buyer_id_f)){
										if($balance_f['wallet_balance'] >= $item_total_f){
												update_sale_order_item_quantity($item_id_f,$item_quantity_f);
												add_transaction($item_quantity_f,$item_total_f,$item_id_f,$buyer_id_f,$seller_id_f,$service_id_f,$game_id_f,$order_id_f);
												update_frozen_balance($buyer_id_f,$item_total_f);
												if($notification_f=get_game_item_information_notification($item_id_f)){
													add_notification('A buyer has purchased your item "'.$notification_f['goods_name'].'" x'.$item_quantity_f.' , <a href="sale_order.php">go to Sales</a>',$seller_id_f);
													add_notification('You purchased "'.$notification_f['goods_name'].'" x'.$item_quantity_f.' , <a href="buy_order.php">go to Buy Order</a>',$buyer_id_f);
													echo 'Success';}	
										}else{ 
												echo 'Insufficient Balance'; 
											}
									}
								} 
								break;		
					case "bargain_game_item":		
								$minimum_g=$_POST['minimum_g'];
								$bargain_price_g=$_POST['bargain_price_g'];
								$item_price_g=$_POST['item_price_g'];
								$item_stock_g=$_POST['item_stock_g'];
								$item_quantity_g=$_POST['item_quantity_g'];
								$item_total_g=$_POST['item_total_g'];
								$item_id_g=$_POST['item_id_g'];
								$buyer_id_g=$_POST['buyer_id_g'];
								$seller_id_g=$_POST['seller_id_g'];
								$service_id_g=$_POST['service_id_g'];
								$game_id_g=$_POST['game_id_g'];
								$order_id_g=$_POST['order_id_g'];


								if(empty($buyer_id_g)){ // trappings for not logged in
									echo 'Please Login';
								}
								else if($buyer_id_g == $seller_id_g){ // cannot buy your own game 
									echo 'You cannot bargain your game ';
								}
								else if(!is_numeric($item_quantity_g)==0 && !is_numeric($bargain_price_g)==0){ // cannot buy your own game 
									echo 'Incorrect Input';
								}
								else if($item_quantity_g > $item_stock_g){ // cannot exceed stock
									echo 'Exceed Quantity';
								}
								else if($bargain_price_g < $minimum_g){ // cannot exceed stock
									echo 'Bargain price error low';
								}
								else if($bargain_price_g > $item_price_g){ // cannot exceed stock
									echo 'Bargain price error high';
								}
								else if($item_quantity_g == $item_stock_g){ // cannot exceed stock
									if($balance_g=get_wallet_balance($buyer_id_g)){					
										if($balance_g['wallet_balance'] >= $item_total_g){
												update_sale_order_item_quantity_out_of_stock($item_id_g);
												add_transaction($item_quantity_g,$item_total_g,$item_id_g,$buyer_id_g,$seller_id_g,$service_id_g,$game_id_g,$order_id_g);
												update_frozen_balance($buyer_id_g,$item_total_g);
												//A buyer has bargained ₱ 320 for Fractal Horns of Inner Abysm, please Go to view.
												if($notification_g=get_game_item_information_notification($item_id_g)){
													add_notification('A buyer has bargained your item ₱ '.$bargain_price_g.' for "'.$notification_g['goods_name'].'" x'.$item_quantity_g.' , <a href="sale_order.php">go to Sales</a>',$seller_id_g);
													add_notification('You bargained "'.$notification_g['goods_name'].'" x'.$item_quantity_f.' for ₱ '.$bargain_price_g.', <a href="bargain_order.php">go to Buy Order</a>',$buyer_id_g);
													echo 'Success';}	
										}else{
												echo 'Insufficient Balance'; 
										}
									}
								}
								else{
									if($balance_g=get_wallet_balance($buyer_id_g)){					
										if($balance_g['wallet_balance'] >= $item_total_g){
											update_sale_order_item_quantity($item_id_g,$item_quantity_g);
											add_transaction($item_quantity_g,$item_total_g,$item_id_g,$buyer_id_g,$seller_id_g,$service_id_g,$game_id_g,$order_id_g);
											update_frozen_balance($buyer_id_g,$item_total_g);
											if($notification_g=get_game_item_information_notification($item_id_g)){
												add_notification('A buyer has bargained your item ₱ '.$bargain_price_g.' for "'.$notification_g['goods_name'].'" x'.$item_quantity_g.' , <a href="sale_order.php">go to Sales</a>',$seller_id_g);
												add_notification('You bargained "'.$notification_g['goods_name'].'" x'.$item_quantity_g.' for ₱ '.$bargain_price_g.', <a href="bargain_order.php">go to Buy Order</a>',$buyer_id_g);
												echo 'Success';}
										}else{ 
											echo 'Insufficient Balance'; 
										}			
									}
								} 
								break;
					case "supply_item_modal":		

								$item_price_h=$_POST['item_price_h'];
								$item_stock_h=$_POST['item_stock_h'];
								$item_quantity_h=$_POST['item_quantity_h'];
								$item_total_h=$_POST['item_total_h'];
								$item_id_h=$_POST['item_id_h'];
								$buyer_id_h=$_POST['buyer_id_h'];
								$seller_id_h=$_POST['seller_id_h'];
								$service_id_h=$_POST['service_id_h'];
								$game_id_h=$_POST['game_id_h'];
								$order_id_h=$_POST['order_id_h'];

								if(empty($seller_id_h)){ // trappings for not logged in
									echo 'Please Login';
								}
								else if($buyer_id_h == $seller_id_h){ // cannot buy your own game 
									echo 'You cannot supply your own post ';
								}
								else if($item_quantity_h > $item_stock_h){ // cannot exceed stock
									echo 'Exceed Quantity';
								}						
								else if($item_quantity_h == $item_stock_h){
									update_buy_order_item_quantity_out_of_stock($item_id_h);
									add_transaction($item_quantity_h,$item_total_h,$item_id_h,$buyer_id_h,$seller_id_h,$service_id_h,$game_id_h,$order_id_h);
									add_notification("A seller has supplied your buy order",$seller_id_h);
									echo 'Success'; // success not buying his own posting
								}else{
									update_buy_order_item_quantity($item_id_h,$item_quantity_h);
									add_transaction($item_quantity_h,$item_total_h,$item_id_h,$buyer_id_h,$seller_id_h,$service_id_h,$game_id_h,$order_id_h);
									add_notification("A seller has supplied your buy order",$seller_id_h);
									echo 'Success'; 
								}
								break;							
					
					case "cancel_buy_order_modal":		
								$item_id_i=$_POST['item_id_i'];
								$user_id_i=$_POST['user_id_i'];
								
								if(empty($user_id_i)){ // trappings for not logged in
									echo 'Please Login';
								}						
								else if($result_i=get_game_item_information($item_id_i,$user_id_i)){
										cancel_buy_order($item_id_i,$user_id_i);
										update_wallet_balance($user_id_i,$result_i['item_price'] * $result_i['item_quantity']);
										
										echo 'Success'; 															
									}
								break;
					case "accept_buy_order_modal":		

								$transaction_id_j=$_POST['transaction_id_j'];
								$user_id_j=$_POST['user_id_j'];
								
								if(empty($user_id_j)){ // trappings for not logged in
									echo 'Please Login';
								}						
								else{
									accept_buy_order($transaction_id_j,$user_id_j);
									
									echo 'Success'; // success not buying his own posting
								} 
							break;				
								
					case "refuse_buy_order_modal":		

						$transaction_id_k=$_POST['transaction_id_k'];
						$user_id_k=$_POST['user_id_k'];
						
						if(empty($user_id_k)){ // trappings for not logged in
							echo 'Please Login';
						}
						//else if(){ balance trappings , cannot buy because the balance is insufficient
						//else if(){ email not verified trappings , cannot buy because the email is not verified
						//}								
						else if($result_k=get_buy_order_transaction_details($transaction_id_k,$user_id_k)){
							//update_game_quantity_reject($result_k['item_id'],$result_k['transaction_quantity']);
							update_transaction_buy_order($transaction_id_k);
							update_wallet_balance($user_id_k,$result_k['transaction_quantity']*$result_k['transaction_amount']);
							echo 'Success'; // success not buying his own posting
						} 
							break;
					case "item_deliver_sale_order_modal":		

						$transaction_id_l=$_POST['transaction_id_l'];
						$user_id_l=$_POST['user_id_l'];
						if(isset($_FILES['transaction_proof'])){
						$transaction_proof=file_get_contents($_FILES['transaction_proof']['tmp_name']);}
						
						if(empty($user_id_l)){ // trappings for not logged in
							echo 'Please Login';
						}
						//else if(){ balance trappings , cannot buy because the balance is insufficient
						//else if(){ email not verified trappings , cannot buy because the email is not verified
						//}								
						else{
							update_item_delivery($transaction_id_l,$user_id_l,$transaction_proof);
							echo 'Success'; // success not buying his own posting
						} 
						break;
					case "item_confirmation_buy_order_modal":		

						$transaction_id_m=$_POST['transaction_id_m'];
						$user_id_m=$_POST['user_id_m'];
						
						if(empty($user_id_m)){ // trappings for not logged in
							echo 'Please Login';
						}
						//else if(){ balance trappings , cannot buy because the balance is insufficient
						//else if(){ email not verified trappings , cannot buy because the email is not verified
						//}								
						else if($result_m=get_buy_order_transaction_details($transaction_id_m,$user_id_m)){
							send_wallet_balance($result_m['seller_id'],$result_m['transaction_quantity']*$result_m['transaction_amount']);
							deduct_wallet_balance($result_m['buyer_id'],$result_m['transaction_quantity']*$result_m['transaction_amount']);
							$total_gg=$result_m['transaction_quantity']*$result_m['transaction_amount'];
							update_item_confirmation($transaction_id_m,$user_id_m);
							add_notification("Buyer has received your item,₱ $total_gg has added to your balance.",$result_m['seller_id']);
							echo 'Success'; // success not buying his own posting
						} 
							break;
					case "cancel_sale_order_modal":		
							$item_id_n=$_POST['item_id_n'];
							$user_id_n=$_POST['user_id_n'];
							
							if(empty($user_id_n)){ // trappings for not logged in
								echo 'Please Login';
							}						
							else{
								cancel_sale_order($item_id_n,$user_id_n);
								echo 'Success'; 															
								}
						break;
					case "cancel_buy_order_modal_i":		
							$transaction_id_ii=$_POST['transaction_id_ii'];
							$user_id_ii=$_POST['user_id_ii'];
							
							if(empty($user_id_ii)){ // trappings for not logged in
								echo 'Please Login';
							}						
							else if($result_ii=get_bargain_order_transaction_details($transaction_id_ii,$user_id_ii)){
								cancel_bargain_order($transaction_id_ii,$user_id_ii);
								update_wallet_balance($user_id_ii,$result_ii['transaction_amount'] * $result_ii['transaction_quantity']);
								echo 'Success'; 															
								}
						break;
					case "cancel_sale_order_modal_nn":		
							$transaction_id_nn=$_POST['transaction_id_nn'];
							$user_id_nn=$_POST['user_id_nn'];
							
							if(empty($user_id_nn)){ // trappings for not logged in
								echo 'Please Login';
							}						
							else if($result_nn=get_sale_order_transaction_details($transaction_id_nn,$user_id_nn)){
								cancel_sale_order_nn($transaction_id_nn,$user_id_nn);
								update_wallet_balance($result_nn['buyer_id'],$result_nn['transaction_amount'] * $result_nn['transaction_quantity']);
								echo 'Success'; 															
								}
						break;			
					case "accept_sale_order_modal":		

						$transaction_id_o=$_POST['transaction_id_o'];
						$user_id_o=$_POST['user_id_o'];
						
						if(empty($user_id_o)){ // trappings for not logged in
							echo 'Please Login';
						}						
						else{
							accept_sale_order($transaction_id_o,$user_id_o);
							echo 'Success'; // success not buying his own posting
						} 
						break;
					case "refuse_sale_order_modal":		

						$transaction_id_p=$_POST['transaction_id_p'];
						$user_id_p=$_POST['user_id_p'];
						
						if(empty($user_id_p)){ // trappings for not logged in
							echo 'Please Login';
						}
						else if($result_p=get_sale_order_transaction_details($transaction_id_p,$user_id_p)){
							//update_game_quantity_reject($result_k['item_id'],$result_k['transaction_quantity']);
							update_transaction_sale_order($transaction_id_p);
							update_wallet_balance($result_p['buyer_id'],$result_p['transaction_quantity']*$result_p['transaction_amount']);
							echo 'Success'; // success not buying his own posting
						} 
						break;
					case "cancel_bargain_order_modal":		
							$transaction_id_q=$_POST['transaction_id_q'];
							$user_id_q=$_POST['user_id_q'];
							
							if(empty($user_id_q)){ // trappings for not logged in
								echo 'Please Login';
							}						
							else if($result_q=get_bargain_order_transaction_details($transaction_id_q,$user_id_q)){
								cancel_bargain_order($transaction_id_q,$user_id_q);
								update_wallet_balance($user_id_q,$result_q['transaction_amount'] * $result_q['transaction_quantity']);
								echo 'Success'; 															
								}
						break;
					case "dispute_item_not_received":		
							$transaction_id_dispute=$_POST['transaction_id_dispute'];
							$dispute_title_a=$_POST['dispute_title_a'];
							$dispute_message_a=$_POST['dispute_message_a'];
							
							if(empty($transaction_id_dispute) && empty($dispute_title_a)){ // trappings for not logged in
								echo 'Empty Fields';
							}						
							else{
								item_not_received_dispute($transaction_id_dispute);
								add_new_dispute($transaction_id_dispute,$dispute_title_a,$dispute_message_a);
								echo 'Success'; 															
								}
						break;
					case "edit_game_item_modal":		
							$goods_name_edit=$_POST['goods_name_edit'];
							$goods_quality_edit=$_POST['goods_quality_edit'];
							$goods_rarity_edit=$_POST['goods_rarity_edit'];
							$goods_detail1_edit=$_POST['goods_detail1_edit'];
							$goods_detail2_edit=$_POST['goods_detail2_edit'];
							$goods_detail3_edit=$_POST['goods_detail3_edit'];
							$order_id_edit=$_POST['order_id_edit'];
							$service_id_edit=$_POST['service_id_edit'];
							$goods_id_edit=$_POST['goods_id_edit'];

							
							if(empty($goods_name_edit) && empty($goods_quality_edit)  && empty($goods_rarity_edit)  && empty($goods_detail1_edit)  && empty($goods_detail2_edit)  && empty($goods_detail3_edit)  && empty($order_id_edit)  
							&& empty($service_id_edit)  && empty($goods_id_edit)){ // trappings for not logged in
								echo 'Empty Fields';
							}						
							else{
								update_goods_item_name($goods_id_edit,$goods_name_edit,$goods_quality_edit,$goods_rarity_edit,$goods_detail1_edit,$goods_detail2_edit,$goods_detail3_edit,$service_id_edit);
								echo 'Success'; 															
								}
						break;																
						
			}
		}
?>