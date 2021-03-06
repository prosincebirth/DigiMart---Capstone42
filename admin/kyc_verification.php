<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="modal fade" id="view_kyc_info_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="color:#4e73df" class="modal-title" id="exampleModalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="form-group">
                <label style="color:#4e73df"> First name :</label> <span id="firstname_kyc" id="firstname_kyc"> </span>
            </div>
            <div class="form-group">
              <label style="color:#4e73df"> Middle name :</label> <span id="middlename_kyc" id="middlename_kyc"> </span>
            </div>
            <div class="form-group">
              <label style="color:#4e73df"> Last name :</label> <span id="lastname_kyc" id="lastname_kyc"> </span>
            </div>
            <div class="form-group">
              <label style="color:#4e73df"> Address :</label> <span id="address_kyc" id="address_kyc"> </span>
            </div>
            <div class="form-group">
              <label style="color:#4e73df"> Identification type :</label> <span id="id_kyc" id="id_kyc"> </span>
            </div>
            <div class="form-group">
              <label style="color:#4e73df"> Identification number :</label> <span id="idnumber_kyc" id="idnumber_kyc"> </span>
            </div>
            <label style="color:#4e73df">Identification proof</label>
            <div class="form-group">
               
                <img src="data:image/png;base64," height="260px">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
        </div>
    </div>
  </div></div>



<div class="modal fade" id="update_kyc_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Verification Status </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Reason</label>
                <input type="text" name="reason_kyc" id="reason_kyc" class="form-control">
            </br>
                <label>Status</label>
                <input type="hidden" name="user_id" placeholder="user id" id="user_id" class="form-control">
                <input type="hidden" name="kyc_id" placeholder="kyc id" id="kyc_id" class="form-control">
                <div class="fld_input"><select name="update_kyc_status" id="update_kyc_status" class="form-control">						
                    <option value="2">Verified</option>';
                    <option value="3">Denied</option>';
										</select></div>
                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" value="update_kyc_modal" class="btn btn-primary">Confirm</button>
        </div>
    </div>
  </div></div> 

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">KYC Verification List</h6>
  </div>

  <div class="card-body">

    <div class="table-responsive">

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> ID </th>
            <th> User </th>
            <th> Date & Time Created</th>
            <th> Status </th>
            <th> Reason </th>
            <th colspan="2">Actions</th>

          </tr>
        </thead>
        <tbody>
        <?php	$display_kyc_verification_admin = display_kyc_verification_admin();foreach($display_kyc_verification_admin as $kyc){ ?>
          <tr>
            <td><?php echo $kyc['kyc_id']; ?></td>
            <td><?php echo $kyc['user_username']; ?></td>
            <td><?php echo $kyc['kyc_date_created']; ?></td>
            <td><?php 
                      if($kyc['kyc_status']==0){echo 'Not Verified';}
                      else if($kyc['kyc_status']==1){echo '<span style="color:blue"><b><i class="fas fa-spinner fa-pulse"></i> Active</span>';}
                      else if($kyc['kyc_status']==2){echo '<span style="color:green"><b><i class="fas fa-check-circle"></i> Verified';}
                      else if($kyc['kyc_status']==3){echo '<span style="color:red"><b><i class="fas fa-times-circle"></i> Denied';}?>
                  </td>
                  <td><?php echo $kyc['kyc_message']; ?></td>
            

            <?php if($kyc['kyc_status']==1){?>     
            <td>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#view_kyc_info_modal"
                  data-firstname_kyc	="<?php echo $kyc['firstname_kyc']?>"
                  data-middlename_kyc		="<?php echo $kyc['middlename_kyc']?>"
                  data-lastname_kyc	="<?php echo $kyc['lastname_kyc']?>"
                  data-address_kyc	="<?php echo $kyc['address_kyc']?>"
                  data-id_kyc	="<?php
                      if($kyc['id_type_kyc']==1){echo "Driver's License";}
                      else if($kyc['id_type_kyc']==2){echo 'Student ID';}
                      else if($kyc['id_type_kyc']==3){echo 'Passport';}
                      else if($kyc['id_type_kyc']==4){echo 'National ID';}
                      ?>"
                  data-idnumber_kyc	="<?php echo $kyc['idnumber_kyc']?>"
                  data-id_proof_kyc="<?php echo base64_encode($kyc['id_proof_kyc'])?>"
                  >View</button> 
            </td>  
            <td>
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#update_kyc_modal"
                  data-user_id="<?php echo $kyc['user_session_kyc']?>"
                  data-kyc_id="<?php echo $kyc['kyc_id']?>"
                  >Update</button> 
            </td>
            <?php }else if($kyc['kyc_status']!=1){?>
              <td>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#view_kyc_info_modal"
                  data-firstname_kyc	="<?php echo $kyc['firstname_kyc']?>"
                  data-middlename_kyc		="<?php echo $kyc['middlename_kyc']?>"
                  data-lastname_kyc	="<?php echo $kyc['lastname_kyc']?>"
                  data-address_kyc	="<?php echo $kyc['address_kyc']?>"
                  data-id_kyc	="<?php
                      if($kyc['id_type_kyc']==1){echo "Driver's License";}
                      else if($kyc['id_type_kyc']==2){echo 'Student ID';}
                      else if($kyc['id_type_kyc']==3){echo 'Passport';}
                      else if($kyc['id_type_kyc']==4){echo 'National ID';}
                      ?>"
                  data-idnumber_kyc	="<?php echo $kyc['idnumber_kyc']?>"
                  data-id_proof_kyc="<?php echo base64_encode($kyc['id_proof_kyc'])?>"
                  >View</button>
            </td>
            <?php } ?>
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