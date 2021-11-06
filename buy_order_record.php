<?php include('head.php'); ?>
<?php include('header.php'); ?>


<main>    
<section class="market_section">
    <div class="container">
        <div class="market_wrapper">
            <div class="mainbar">
                <div class="market_item--wrapper">
                    <div class="market_tabs">
                        <ul class="market_tab--list">
                            <li><span onclick="window.location.href='buy_order.php';">Buy Orders</span></li>
                            <li class='active'><span onclick="window.location.href='buy_order_record.php';">Buy Order Records</span></li>
                            <li><span>Place Buy Order</span></li>
                        </ul>
                        
                    </div>
                    <div class="market_tabs">
                        <div class="search__bar">
                            <input type="search" name="" id="" class="form-control">
                            <button type="submit">
                            <i class="fas fa-search"></i>
                            <span>Search</span>
                            </button>
                        </div>
                    </div>
                    <div class="market_item--container">
                        <div class="items_wrapper">
                            <table class="table_list--items">
                                <thead>
                                    <tr>
                                        <th>Items</th>
                                        <th>Buy Order Price</th>
                                        <th>Progress</th>
                                        <th>Create Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <?php	$result = display_buy_order_records($_SESSION['user_session']);
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
										<span><?php echo $res['item_price'];?></span>									
									</td>
									<td>
										<span><?php echo $res['item_quantity'];?></span>
									</td>
									<td>
									<span><?php echo $res['item_date_added'];?></span>										
									</td>
									<td><?php
                                         if($res['item_status']!=1){
                                            echo '<span> Cancelled</span>';	
                                         }
                                         } }?>
									</td>
									
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
    </div>
</section>
</main>

<?php include('components/modal.php')?>
<?php include('footer.php'); ?>
</body>
</html>