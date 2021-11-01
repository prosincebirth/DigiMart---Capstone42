<?php include('head.php'); ?>
<?php if(!isset($_GET['goods_id'])){header("Location: market.php"); exit();} ?>
<?php include('header.php'); ?>

<?php $res=display_goods($_GET['goods_id']);?>
<?php $game=display_game_category(1);?>

<link rel="preload stylesheet" href="assets/css/item-card.css" as="style" crossorigin>
<link rel="preload stylesheet" href="assets/css/item-grid.css" as="style" crossorigin>
<link rel="preload stylesheet" href="assets/css/item.css" as="style" crossorigin>

<main>
	<section class="market_section">
		<div class="container">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="buy-market.php">Market</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php echo $res['goods_name'];?></li>
				</ol>
			</nav>
			<div class="item_detail">
				<div class="item_detail--wrapper">
					<div class="item_detail--img--content">
						<div class="img_wrapper">
						<?php echo '<img src="data:image/png;base64,'.base64_encode($res['goods_image']).'"height="260" >'; ?>
							
						</div>
						<div class="item_detail--content">
							<h2>
								<span><?php echo $res['goods_name'];?></span>								
								<span class="tag tag--immortal"><?php echo $res['goods_rarity'];?></span>
							</h2>
							<p>
								<span>
								<?php echo $game['goods_category1'];?> | 
									<span><?php echo $res['goods_detail_1'];?></span>
								</span>
								<span>
								<?php echo $game['goods_category2'];?> | 
									<span><?php echo $res['goods_detail_2'];?></span>
								</span>
								<span>
								<?php echo $game['goods_category3'];?> | 
									<span><?php echo $res['goods_detail_3'];?></span>
								</span>
							</p>
							<div class="item__ref--price">
								<span>
									Reference price | 
									<span>₱  <?php echo $res['item_price'];?></span>
									<span> </span>
								</span>
							</div>
						</div>
					</div>
					<div class="item_detail--ctas">
						<p>
						
						</p>
						<div>
							<a class="item_sell" data-toggle="modal" data-target="#sale_game_item_modal_2"
											data-goods_id="<?php echo $_GET['goods_id'];?>">Sell</a>
							<button type="button" class="item_place--buy--order" data-toggle="modal" data-target="#buyorder_game_item_modal_2"
											data-goods_id="<?php echo $_GET['goods_id'];?>">Place buy order</a>
						</div>
					</div>
				</div>
			</div>

			<div class="item_groups">
				<div class="item_groups--wrapper">
					<div class="item_groups--tab">
						<ul>
							<li class="active"><span>Sell</span></li>
							<li><span>Buy orders</span></li>
							<li><span>Trade Records</span></li>
						</ul>
					
					</div>
				</div>
				<div class="item_group--table">
					<div class="item_group--table--container">
						<table>
							<thead>
								<th>Items</th>
								<th>Seller</th>
								<th>Mode <i class="fas fa-question-circle" data-toggle="popover" data-html="true" title="Mode" data-content="
									P2P Delivery Item's are in seller's Inventory, sellers will deliver them directly to the buyer's Inventory <br><br>
									Manual Delivery Items are in seller's inventory, Sellers will deliver the items to the DigiMart inventory first and buyers can retrieve them from their backpacks <br><br>
									Automatic Delivery Items will be deposited to Digimart Inventory first and system delivers to the buyer's backpack after the payment are made
									" data-direction="right"></i></td></th>
								<th>Price</th>
								<th>Quantity</th>
								<th></th>
							
								
							</thead>
	
					<?php	$result = display_market_sell_goods($_GET['goods_id']);
                        	if($result->num_rows > 0){
                        	while ($res = $result->fetch_assoc()){?>      
							<tbody>
								<tr>
									<td>
										<div class="img_text">
											<?php echo '<img class="item__img" src="data:image/png;base64,'.base64_encode($res['goods_image']).'"height="72" >'; ?>
											<span><?php echo $res['goods_quality']," ",$res['goods_name'];?></span>	
										</div>
									</td>
									<td>
										<div class="img_text">

											<?php echo '<img class="item__seller" src="data:image/png;base64,'.base64_encode($res['goods_image']).'"height="40" >'; ?>
											<span><?php echo $res['user_username'];?></span>	
										</div>
									</td>
									<td>
										<span><?php echo $res['service_mode'];?></span>	

									</td>
									<td>
										<span><?php echo $res['item_price'];?></span>										
									</td>
									<td>
										<span><?php echo $res['item_quantity'];?></span>										
									</td>
									<td>
										<div class="item__group--cta">
											<a class="buy_btn wishlist_btn"  data-toggle="modal" data-target="#buy_game_item_modal" 
											data-item_price_f="<?php echo $res['item_price'];?>" 
											data-item_id_f="<?php echo $res['item_id'];?>"
											data-buyer_id_f="<?php if(!isset($_GET['goods_id'])){echo $_SESSION['user_session']; }?>" 
											data-seller_id_f="<?php echo $res['user_id'];?>" 
											data-service_id_f="<?php echo $res['service_id'];?>" 
											data-game_id_f="<?php echo $res['game_id'];?>" 
											data-order_id_f="<?php echo $res['order_id'];?>"> Buy</a>
											
											<a data-dismiss="modal" data-toggle="modal" data-target="#login_modal">Bargain</a>
											<a>
											</a>

										</div>
									</td>
									<?php } }?>
								</tr>

							</tbody>
						</table>
						
						<div class="pagination">
								<ul>
										<li><a href="">Previous</a></li>
										<li><a href="?page=1">1</a></li>
										<li><a href="?page=2">2</a></li>
										<li><a href="?page=3">3</a></li>
										<li><a href="">Next</a></li>
								</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>


<?php include('components/modal.php')?>
<?php include('footer.php'); ?>