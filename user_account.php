<?php 

ob_start();
session_start();

    function connection3(){// DB CONNECTION PDO
    $conn=new PDO("mysql:host=localhost;dbname=digimart","root","");
    return $conn;}

    function add_steam_id($user_id,$user_steam_id){
		$conn=connection3();
		$query="UPDATE users set user_steam_id=:user_steam_id where user_id=:user_id";
		$prepare=$conn->prepare($query);
		$exec=$prepare->execute(array(":user_id"=>$user_id,":user_steam_id"=>$user_steam_id));
		$conn=null;}

if (isset($_GET['login'])){
	require 'openid.php';
	try {
		require 'SteamConfig.php';
		$openid = new LightOpenID($steamauth['domainname']);
		
		if(!$openid->mode) {
			$openid->identity = 'https://steamcommunity.com/openid';
			header('Location: ' . $openid->authUrl());
		} elseif ($openid->mode == 'cancel') {
			echo 'User has canceled authentication!';
		} else {
			if($openid->validate()) { 
				$id = $openid->identity;
				$ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
				preg_match($ptn, $id, $matches);
				
				$_SESSION['steamid'] = $matches[1];

                if (empty($_SESSION['steam_uptodate']) or empty($_SESSION['steam_personaname'])) {
                    require 'SteamConfig.php';
                    $url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$_SESSION['steamid']); 
                    $content = json_decode($url, true);
                    $_SESSION['steam_profileurl'] = $content['response']['players'][0]['profileurl'];
                }

                add_steam_id($_SESSION['user_session'],$_SESSION['steam_profileurl']);
                
				if (!headers_sent()) {
					header('Location: '.$steamauth['loginpage']);
					exit;
				} else {
					?>
					<script type="text/javascript">
						window.location.href="<?=$steamauth['loginpage']?>";
					</script>
					<noscript>
						<meta http-equiv="refresh" content="0;url=<?=$steamauth['loginpage']?>" />
					</noscript>
					<?php
					exit;
				}
			} else {
				echo "User is not logged in.\n";
			}
		}
	} catch(ErrorException $e) {
		echo $e->getMessage();
	}
}?>

<?php include('head.php'); ?>
<?php if($_SESSION['user_status']!=1){header("Location: index.php"); exit();} ?>
<?php include('header.php'); ?>


<!-- <link rel="preload stylesheet" href="assets/css/item-card.css" as="style" crossorigin>
<link rel="preload stylesheet" href="assets/css/item-grid.css" as="style" crossorigin> -->
<link rel="preload stylesheet" href="assets/css/user-account.css" as="style" crossorigin>

<div class="modal fade" id="kyc_services_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><center>KYC Verification</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="form-inline">
                <input type="hidden" class="form-control"  name="user_session_kyc" placeholder="Game Name" id="user_session_kyc" value="<?php echo $_SESSION['user_session'];?>" class="form-control">
                <label style="margin:5px; width:30%; float:left;">First name</label> 
                <input style="width:60%; float:center; margin:5px;" type="text" class="form-control" name="firstname_kyc" placeholder="e.g. Jason" id="firstname_kyc" class="form-control">
            </div>
            <div class="form-inline">
                <label style="margin:5px; width:30%; float:left;">Middle name</label> 
                <input style="width:60%; float:center; margin:5px;" type="text" class="form-control" name="middlename_kyc" placeholder="e.g. Optina" id="middlename_kyc" class="form-control">
            </div>
            <div class="form-inline">
                <label style="margin:5px; width:30%; float:left;">Last name</label> 
                <input style="width:60%; float:center; margin:5px;" type="text" class="form-control" name="lastname_kyc" placeholder="e.g. Baguio" id="lastname_kyc" class="form-control">
            </div>
            <div class="form-inline">
                <label style="margin:5px; width:30%; float:left;">ID number</label>
                <input style="width:60%; float:center; margin:5px;"type="text" name="idnumber_kyc" placeholder="e.g. 15401441" id="idnumber_kyc" class="form-control">
            </div>
            <div class="form-inline">
                <label style="margin:5px; width:30%; float:left;">Address</label>
                <input style="width:60%; float:center; margin:5px;"type="text" name="address_kyc" placeholder="e.g. Summerland Cebu City" id="address_kyc" class="form-control">
            </div>
            <div class="form-inline">
                <label style="margin:5px; width:30%; float:left;">Identification</label>
                <select style="width:60%; float:center; margin:5px;" name="id_kyc" id="id_kyc" class="form-control">
                <option value="" disabled selected>Type of ID</option>	
                <option value="1">Driver's License</option>
                <option value="2">Student ID</option>
                <option value="3">Passport</option>
                <option value="4">National ID</option></select>   
           </div>
            <div class="form-inline">
                <label style="margin:5px; width:30%; float:left;"> </label>
                <input style="width:60%; float:center; margin:5px;" type="file" name="id_proof_kyc" placeholder="Service Description" id="id_proof_kyc" class="form-control">
           </div>
           
        </div>
        <div class="modal-footer">
            <button type="button" value="kyc_services_modal" class="btn btn-primary">Confirm</button>
        </div>
    </div>
  </div></div>


<main>
    <section class="market_section">
        <div class="container">
            <div class="layout">
                <div class="column col1">
                    <div class="panel user__panel">

                        <div class="user-image">
                            <div class="image">
                                <img src="" input type="file" name="item_image"alt="">
                            </div>
                            <div class="name">
                                <h2><?php echo $_SESSION['user_username']; ?></h2>
                            </div>
                        </div>

                        <div class="menu">
                            <ul>
                                <li onclick="location.href='user_wallet.php'"><span ><i class="fas fa-wallet"></i>My wallet</span></li>
                                <li onclick="location.href='user_account.php'" class="active"><span  ><i class="fas fa-cog"></i>Account</span></li>
                                <li onclick="location.href='user_messages.php'"><span ><i class="fas fa-envelope"></i>Messages</span></li>
                                <!-- <li href="javascript:void(0);"><span ><i class="fas fa-comment-dots"></i>Support</span></li> -->
                            </ul>
                        </div>
                    </div>
                </div>

                
                <div class="column col2"> 
                    <div class="main">
                        <div class="user-setting">
                            <h3>Basic Settings</h3>
                            <table class="list-tab" >
                                <tbody>
                                    <tr>
                                        <td class="t-left">Avatar</td>
                                        <td class="t-left"> <img src="" alt=""></td>
                                    </tr>
                                    <tr>
                                        <td class="t-left" width="120">Username</td>
                                        <td class="t-left"><span class="name-tab" style="display: inline; color:var(--primary-color);font-weight:bold;"><?php echo $_SESSION['user_username'];?></span></td>
                                        <td class="t-right"><a href="javascript:void(0);" class="btn-change">Change</a></td>    
                                    </tr>
                                </tbody>
                            </table>

                            <h3>Security settings</h3>
                            <table class=list-tab width="100%">
                                <tbody>
                                    
                                    <tr>
                                        <td class="t-left" width="120">KYC Verification</td>
                                        <?php $user_kyc_status = user_kyc_status($_SESSION['user_session']);foreach($user_kyc_status as $kyc_request){ 
                                        if($kyc_request['user_kyc']==0){ 
                                            echo '<td class="t-left"><span style="color:red"><i class="fas fa-times-circle"></i> Not verfied</span></td>'; 
                                            echo '<td class="t=left"></td>';
                                            echo '<td class="t-right"><a data-toggle="modal" data-target="#kyc_services_modal" class="i-btn --i-btn-small"> Start Verification</a></td>';
                                        } 
                                        else if($kyc_request['user_kyc']==1){ echo '<td class="t-left"><span style="color:orange"><i class="fas fa-times-circle"></i> Pending </span></td>'; } 
                                        else if($kyc_request['user_kyc']==2){ echo '<td class="t-left"><span style="color:green"><b><i class="fas fa-check-circle"></i> Verified</span></td>'; } 
                                        else if($kyc_request['user_kyc']==3){ 
                                            echo '<td class="t-left"><span style="color:red"><i class="fas fa-times-circle"></i> Denied - Reason : '.$kyc_request['user_kyc_message'].' </span></td>'; 
                                            echo '<td class="t=left"></td>';
                                            echo '<td class="t-right"><a data-toggle="modal" data-target="#kyc_services_modal" class="i-btn --i-btn-small"> Start Verification</a></td>';
                                            } 
                                        }
                                        ?>
                                        
                                    </tr>
                                    <tr>
                                        <td class="t-left" width="120">Password settings</td>
                                        <td class="t-left"></td>
                                        <td class="t-left"></td>
                                        <td class="t-right"><a href="javascript:void(0;)" class="i-btn --i-btn-small">Change password</a></td>
                                    </tr>
                                    <tr class="steam-bind"> 
                                        <td class="t-left" width="120">Steam Profile Link</td>
                                        <?php $user_kyc_status = user_kyc_status($_SESSION['user_session']);foreach($user_kyc_status as $kyc_request1){
                                        if($kyc_request1['user_steam_id']==''){?>
                                                <td class="t-left"><span style="color:black"><?php echo $kyc_request1['user_steam_id'];?></span></td>
                                                <td class="t-eft"></td>
                                                <td class="t-right"><a href="?login" class="i-btn --i-btn-small">Bind Steam Account</a></td>
                                            <?php } else { ?>
                                                <td class="t-left"><a href="<?php echo $kyc_request1['user_steam_id'];?>" target="_blank"><span style="color:black"><?php echo $kyc_request1['user_steam_id'];?> </input></span></a></td>
                                                <td class="t-left">  <input type="hidden" name="steam_id_64" id="steam_id_64" value="<?php echo $kyc_request1['user_steam_id'];?>" style="margin-right:0px;color:black"> </td>
                                                <td class="t-right"><button class="btn" type="button" value="unbind_steam_account">Unbind Steam account</button></td>
                                            <?php } } ?>


                                    </tr>
                                    <tr style="margin:10px"> 
                                        <td class="t-left" width="120">Steam Trade Link</td>
                                        <?php $user_kyc_status = user_kyc_status($_SESSION['user_session']);foreach($user_kyc_status as $kyc_request1){
                                            if($kyc_request1['user_steam_trade_link']==''){?>
                                                <td class="t-left"><input type="text" name="trade_link" id="trade_link" style="margin-right:0px;color:black"></input></td> 
                                                <td class="t-left" ><a href="https://steamcommunity.com/my/tradeoffers/privacy#trade_offer_access_url" target="_blank">Click to get link</a></td>
                                                <td class="t-right"> <button class="btn btn-secondary btn-login" type="button" value="add_steam_trade" >Save</button></td>
                                            <?php } else { ?>
                                                <td class="t-left"><a href="<?php echo $kyc_request1['user_steam_trade_link'];?>" target="_blank"><span style="color:black"><?php echo $kyc_request1['user_steam_trade_link'];?></span></a></td>
                                                <td class="t-left" > </td>
                                                <td class="t-right"> <button class="btn" type="button" value="delete_steam_trade">Delete</button></td>
                                            <?php } } ?>
                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                </tbody>
                            </table>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include('footer.php'); ?>