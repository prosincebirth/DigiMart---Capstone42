<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Buy Order List</h6>
  </div>

  <div class="card-body">

    <div class="table-responsive">

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

        <thead>
          <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>Item Quantity</th>
            <th>User</th>
            <th>Game Name</th>
            <th>Service Name</th>
            <th>Date Created</th>
          </tr>
        </thead>
        <tbody>
        <?php	$display_buy_orders_admin = display_buy_orders_admin();foreach($display_buy_orders_admin as $buy_orders){ ?>
          <tr>
            <td><?php echo $buy_orders['item_id']; ?></td>
            <td><?php echo $buy_orders['goods_name']; ?></td>
            <td><?php echo $buy_orders['item_price']; ?></td>
            <td><?php echo $buy_orders['item_quantity']; ?></td>
            <td><?php echo $buy_orders['user_username']; ?></td>
            <td><?php echo $buy_orders['game_name']; ?></td>
            <td><?php echo $buy_orders['service_mode']; ?></td>
            <td><?php echo date('Y-m-d',strtotime($buy_orders['item_date_added'])); ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
     
    </div>
  </div>
</div>

</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>