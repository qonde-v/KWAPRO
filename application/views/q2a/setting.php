<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<!-- <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/data_picker.css';?>" />
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
<style>
 table td{ border-bottom:1px solid #ccc; }
 table th{ border-bottom:1px solid #ccc; }
</style>
</head>
<div class="container">
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->


		    	<!--middle content-->
				<input type="hidden" id="base" value="<?php echo $base;?>">
     
    				<div  style="text-align:center">
    					<div style="background-color:#f1f2f6;" id="basic">
    					 <table border="0">
    					   <tr>
    					   	<th><?php echo $profile_user_name;?></th>
    					   	<td ><?php echo $username; ?></td>
    					   </tr>
    					    
    					   <tr>
    					   	<th>
								<!--div class="img_avator" id="upload_area">
									<img class="thumbnail span3" src="<?php echo $base.$userphoto_path; ?>" alt=""/>
								</div-->
								<div class="setting_photo">
			  	                                	<div align="right" id="upload_area">
                                				     		<img id="user_img" border="1" style="width:45px;height:45px;" src="<?php echo $base.$userphoto_path; ?>"/>
                                 				 	</div>
                                				</div>

							</th>
    					   	<td>
								<!--form action="" method="post">
									<p><input type="file" name="user_photo" id="user_photo"/></p>
    					   		</form-->
							<div class="setting_upload" >
                              	<form action="" method="post" onsubmit="return false;">
        			            		<p>
                       						<input name="user_photo" id="user_photo" type="file"/>
                     					</p>
                  				</form>
                			</div>

				   			</td>
    					   </tr>
    					   
    					   <tr>
    					   	<th><?php echo $profile_gender; ?></th>
    					   	<td>
								<input id="gender" name="gender" type="radio" <?php if($gender == 1){echo "checked";} ?> value="1"/><?php echo $profile_gender_male; ?>
    					    	<input id="gender" name="gender" type="radio" <?php if($gender == 0){echo "checked";} ?> value="0" style="margin-left:1em;" /><?php echo $profile_gender_female; ?>
							</td>
    					   </tr>
    					    <tr>
    					   	<th><?php echo $profile_language_type;?></th>
    					   	<td>
								<select id="Language">
    					    		<option value="zh" selected="selected">中文</option>
                                    <!--<option value="en" <?php if($langCode=='en'){echo "selected='selected'";}?>>English</option>
                                    option value="de" <?php if($langCode=='de'){echo "selected='selected'";}?>>Deutsch</option>
                                    <option value="it" <?php if($langCode=='it'){echo "selected='selected'";}?>>Italiano</option-->
    					    	</select>
							</td>
    					   </tr>
    					    <tr>
	                        	<th><?php echo $profile_current_local;?></th>
								<td>
									<input type="hidden" id="location_code" value="<?php echo $location['country_code'].'|'.$location['province_code'].'|'.$location['city_code'].'|'.$location['town_code']; ?>"/>
									<input type="text" id="place_setting"  value="<?php echo $location['town_name']; ?>">
									<a href="#" id="place_setting_img"  data-controls-modal='place_setting_modal' data-backdrop='true' data-keyboard='true'><img alt="" src="<?php echo $base.'img/btn_search.png';?>"></a>
	                           </td>
                        	</tr>
							
							<tr>
	                        	<th><?php echo $profile_birthday;?></th>
								<input id="day_name_str" type="hidden" value="<?php for($i=0;$i<7;$i++){echo $day_name[$i];if($i<6)echo ",";}?>">
								<input id="month_name_str" type="hidden" value="<?php for($i=0;$i<12;$i++){echo $month_name[$i];if($i<11)echo ",";}?>">
								<td>
									<input id="birthday" type="text" value="<?php echo $birthday;?>">
	                           </td>
                        	</tr>
                        	
                        	
                        	<tr>
	                        	<th style="border-top:1px solid #ccc;"><?php echo $profile_old_password;?></th>
								<td style="border-top:1px solid #ccc;">
									<input id="old_password" type="password" AUTOCOMPLETE=OFF>
	                           </td>
                        	</tr>
                        	
                        	<tr>
	                        	<th><?php echo $profile_new_password;?></th>
								<td>
									<input id="new_password" type="password" AUTOCOMPLETE=OFF>
	                           </td>
                        	</tr>
                        	
                        	<tr>
	                        	<th><?php echo $profile_password_confirm;?></th>
								<td>
									<input id="new_passwordc" type="password" AUTOCOMPLETE=OFF>
	                           </td>
                        	</tr>
                        	<tr>
                        		<td colspan="2" style="text-align:center">
                        			<button class="btn primary" onclick="basic_info_save();" id="basic_save_btn" data-loading-text="<?php echo $profile_data_process;?>"><?php echo $profile_save;?></button>
                        		</td>
                        	</tr>
    					  </table>
    					</div>



	<?php include("footer.php");?>

	<input type="hidden" id="tag_add_prompt" value="<?php echo $profile_tag_added; ?>">
	<input type="hidden" id="select_cate" value="<?php echo $profile_select_cate; ?>">
	<input type="hidden" id="select_subcate" value="<?php echo $profile_select_subcate; ?>">
	<input type="hidden" id="name_unvalid" value="<?php echo $profile_name_unvalid; ?>">
	<input type="hidden" id="select_first" value="<?php echo $profile_select_first;?>"/>
	<input type="hidden" id="upload_wait" value="<?php echo $profile_upload_wait;?>"/>
	<div id="msg_modal" class="modal hide">
		<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
		<div class="modal-body"></div>
		<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').hide();"><?php echo $modal_ok;?></button></div>
	</div>
	<div id="upload_avatar_modal" class="modal hide">
		<div class="modal-header"><h3><?php echo $profile_crop_img_title;?></h3></div>
		<div class="modal-body">
			<table>
			<tr>
				<td style="width:520px;text-align:center;"><?php echo $profile_original_img;?></td>
				<td><?php echo $profile_thumb_preview;?></td>
			</tr>
			<tr>
				<td><div id="original_photo" style="margin-right:10px;text-align:center"></div></td>
				<td>
					<div style="float:right; position:relative; overflow:hidden; width:100px; height:100px;margin-right:10px;">
						<img style="position: relative;" id="crop_photo"/>
					</div>
				</td>
			</tr>
			</table>
			<br style="clear:both;"/>
		</div>
		<div class="modal-footer">		
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />				
				<button class="btn" onclick="crop_img_close();"><?php echo $profile_cancel_button;?></button>
				<button class="primary btn" id="save_thumb" onclick="save_thumb();" data-loading-text="<?php echo $profile_data_process;?>"><?php echo $profile_save;?></button>
		</div>
	</div>
    <div id="place_setting_modal" class="modal hide">
		<div class="modal-header"><a href="#" onclick="$('#place_setting_modal').addClass('hide');" class="close">&times;</a><h3><?php echo $profile_local_check;?></h3></div>
		<div class="modal-body">
			<table>
				<tr>
    				<td><?php echo $profile_country;?></td>
    				<td><?php echo $profile_region;?></td>
    				<td><?php echo $profile_city;?></td>
					<td><?php echo $profile_city_content;?></td>
    			</tr>
				<tr>
					<td>
						<select size="9" id="country" name="" type="text" class="place_select">
							<option id="zh">中国</option>
							<!-- <option id="en">Britain</option>
							<option id="de">Germany</option>
							<option id="it">Italy</option> -->
						</select>
					</td>
					<td>
						<select size="9" id="province" name="" type="text" class="place_select">
						</select>
					</td>
					<td>
						<select size="9" id="city" name="" type="text" class="place_select">
						</select>
					</td>
					<td>
						<select size="9" id="town" name="" type="text" class="place_select">
						</select>
					</td>
				</tr>
			</table>
		</div>
		<div class="modal-footer"><?php echo $profile_local_prompt;?></div>
	</div>
  </div>
  </body>
    <script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-tabs.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/setting.js';?>"></script>
	<script src="<?php echo $base.'js/DatePicker.js';?>"></script>
	<script src="<?php echo $base.'js/ajaxupload.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script src="<?php echo $base.'js/jquery.imgareaselect.min.js';?>" ></script>
</html>   
    
