<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $profile_page_title;?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/data_picker.css';?>" />
	<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
	
    <style type="text/css">
      body {
        padding-top: 50px;
      }
    </style>
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo $base.'img/kwapro.ico';?>">
  </head>

  <body>

    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">Kwapro</a>
          <?php include("header.php"); ?>
        </div>
      </div>
    </div>

 <div id="main_area" class="container">
     <div class="row">
        <div class="span16">
          <div class="row">
            
        	<div class="span12">
		    	<!--middle content-->
				<input type="hidden" id="base" value="<?php echo $base;?>">
				
		    	<ul class="tabs" data-tabs="tabs">
    			        <li><a href="#empty"></a></li>
    			        <li><a href="#empty"></a></li>
    					<li class="active"><a href="#basic"><?php echo $profile_basic_data;?></a></li>
    					<li><a href="#tag"><?php echo $profile_advanced_data;?></a></li>
    					<li><a href="#interaction"><?php echo $profile_interact_setting;?></a></li>
    					<li><a href="#privacy"><?php echo $profile_private_setting;?></a></li>
    				</ul>
     
    				<div class="tab-content">
    					<div class="active tab-pane" id="basic">
    					 <table border="0" >
    					   <tr>
    					   	<th><?php echo $profile_user_name;?></th>
    					   	<td><?php echo $username; ?></td>
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
							<div class="setting_upload">
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
    					    		<option value="zh" <?php if($langCode=='zh'){echo "selected='selected'";}?>>中文</option>
                                    <option value="en" <?php if($langCode=='en'){echo "selected='selected'";}?>>English</option>
                                    <!--option value="de" <?php if($langCode=='de'){echo "selected='selected'";}?>>Deutsch</option>
                                    <option value="it" <?php if($langCode=='it'){echo "selected='selected'";}?>>Italiano</option-->
    					    	</select>
							</td>
    					   </tr>
    					    
    					    <tr>
	                        	<th><?php echo $profile_current_local;?></th>
								<td>
									<input type="hidden" id="location_code" value="<?php echo $location['country_code'].'|'.$location['province_code'].'|'.$location['city_code'].'|'.$location['town_code']; ?>"/>
									<input type="text" id="place_setting" data-controls-modal='place_setting_modal' data-backdrop='true' data-keyboard='true' value="<?php echo $location['town_name']; ?>">
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

    					<div class="tab-pane"  id="tag">
    					  	<h4><?php echo $profile_tag_result;?></h4>
    					  	<div id="tag_area">
								<?php if(count($tag) > 0): ?>
                            	<?php foreach($tag as $tag_item): ?>
                            		<span>
										<span class="select_tag_name" id="<?php echo $tag_item['category_id'].'_'.$tag_item['sub_cate_id'].'_'.$tag_item['tag_id'];?>"><?php echo $tag_item['tag_name']?></span>
										<img class="tag_delete" src="<?php echo $base.'img/delete0.png';?>" />
									</span>
                            	<?php endforeach;?>
                            	<?php endif; ?>
    					  	</div>
    					  	<h4><?php echo $profile_tags;?></h4>
    					  	
    					  	<table>
    					  		<tr>
    					  			<td><input class="txt_search" id="search_cate" type="text" placeholder="<?php echo $profile_filter_cate;?>" oninput="search_category()" onpropertychange="search_category()"></td>
    					  			<td><input class="txt_search" id="search_subcate" type="text" placeholder="<?php echo $profile_filter_subcate;?>" oninput="search_sub_cate()" onpropertychange="search_sub_cate()"></td>
    					  			<td><input class="txt_search" id="search_tag" type="text" placeholder="<?php echo $profile_filter_tag;?>" oninput="search_tags()" onpropertychange="search_tags()"></td>
    					  		</tr>
    					  		<tr>
    					  			<td>
    					  				<select size="9" id="tags_one" type="text" class="tag_select">
											<?php foreach($category_data as $category):?>
												<option class="tag_add_list_one" value="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></option>
											<?php endforeach;?>
    					  				</select>
    					  			</td>
    					  			<td>
    					  				<select size="9" id="tags_two" type="text" class="tag_select"></select><br/>
										<div class="add_manual" onclick="add_sub_cate();"><?php echo $profile_add_sub_cate; ?></div>
    					  			</td>
    					  			<td>
    					  				<select size="9" id="tags_three" type="text" class="tag_select"></select><br/>
										<div class="add_manual" onclick="addtag();"><?php echo $profile_tags_add; ?></div>
    					  			</td>
    					  		</tr>
								<tr>
									<td colspan="3">
										<p id="sub_cate_input" style="display:none">
			                        		<span><?php echo $profile_add_sub_cate_label1; ?><span id='cate_name' style="width:auto"></span><?php echo $profile_add_sub_cate_label2; ?></span>
			                        		<input type="text" id="sub_cate_input_area"/>
			                        	</p>
									</td>
								</tr>	
								<tr>
									<td colspan="3">
										<p id="tag_input" style="display:none">
			                        		<span><?php echo $profile_add_tag_label1; ?><span id='tag_name' style="width:auto"></span><?php echo $profile_add_tag_label2; ?></span>
			                        		<input type="text" id="tag_input_area"/>
			                        	</p>
									</td>
								</tr>
								<tr>
									<td colspan="3" style="text-align:center">
										<button class="btn primary" onclick="tag_info_save();" id="tag_save_btn" data-loading-text="<?php echo $profile_data_process;?>"><?php echo $profile_save;?></button>
									</td>
								</tr>					
    					  	</table>
    					</div>
    					
    					<div class="tab-pane" id="interaction">
    					    <table border="0" >
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td><?php echo $profile_mostly_used;?></td>
								</tr>
								<?php foreach($sendtype_info as $id => $sendtype_text): ?>
				                <?php
				                    $account = "";
				                    $is_selected = 0;
				                    if(isset($interact_data[$id]))
				                    {
				                       $account = $interact_data[$id]['account'];
				                       $is_selected = $interact_data[$id]['isSelected'];
				                    }
				                ?>
				                <tr>
		    					   	<th class="span4"><?php echo $sendtype_text;?>:</th>
		    					   	<td class="span5"><input type="text" id="<?php echo $sendtype_text;?>" value="<?php echo $account;?>"></td>
		    					   	<td class="span3"><input style="margin-left:1em;" name="interact_method" type="radio" value="<?php echo $id;?>" id="interact_method" <?php if($is_selected){echo "checked";}?>/></td>
	    					   </tr>
				             	<?php endforeach;?>
	    					   <tr>
                        		<td colspan="3" style="text-align:center">
                        			<button class="btn primary" onclick="interact_data_save();" id="interact_save_btn" data-loading-text="<?php echo $profile_data_process;?>"><?php echo $profile_save;?></button>
                        		</td>
                        	</tr>
    					    </table>
    					</div>
    					
    					<div class="tab-pane" id="privacy">
    					  <table border="0" >
    					  	<tr>
	    					   	<th class="span3"><?php echo $profile_private_gender;?>：</th>
	    					   	<td class="span1 offset1">
									<input name="privacy_gender" id="gender_visible" type="radio" <?php if($privacy_data[GENDER] == 1){echo "checked";}?>/><?php echo $profile_public?>
								</td>
	    					    <td class="span3 offset1">
									<input name="privacy_gender" id="gender_visible" type="radio" <?php if($privacy_data[GENDER] == 0){echo "checked";}?> /><?php echo $profile_private?>
								</td>
    					   </tr> 					   
    					   <tr>
	    					   	<th class="span3"><?php echo $profile_private_birthday;?>：</th>
	    					   	<td class="span1 offset1">
									<input name="privacy_birth" id="birthday_visible" type="radio" <?php if($privacy_data[BIRTHDAY] == 1){echo "checked";}?>/><?php echo $profile_public?>
								</td>
	    					    <td class="span3 offset1">
									<input name="privacy_birth" id="birthday_visible" type="radio" <?php if($privacy_data[BIRTHDAY] == 0){echo "checked";}?>/><?php echo $profile_private?>
								</td>
    					   </tr>					   
    					   <tr>
	    					   	<th class="span3"><?php echo $profile_private_location;?>：</th>
	    					   	<td class="span1 offset1">
									<input name="privacy_place" id="location_visible" type="radio" <?php if($privacy_data[CURRENT_LOCATION] == 1){echo "checked";}?>/><?php echo $profile_public?>
								</td>
	    					    <td class="span3 offset1">
									<input name="privacy_place" id="location_visible" type="radio" <?php if($privacy_data[CURRENT_LOCATION] == 0){echo "checked";}?>/><?php echo $profile_private?>
								</td>
    					   </tr>
						   
						   <?php $account_type=array(EMAIL=>'Email',GTALK=>'Gtalk',QQ=>'QQ',SMS=>'SMS',MSN=>'MSN'); foreach($account_type as $key=>$item):?>
			                <tr>
			                    <th class="span3"><?php echo $item;?>：</th>
			                    <td class="span1 offset1">
			                    	<input type="radio" name="<?php echo $item;?>_visible" id="<?php echo $item;?>_visible" value=1 <?php if($privacy_data[$key] == 1){echo "checked";}?>/><?php echo $profile_public?>
								</td>
								<td class="span3 offset1">
			                    	<input type="radio" name="<?php echo $item;?>_visible" id="<?php echo $item;?>_visible" value=0 <?php if($privacy_data[$key] == 0){echo "checked";}?>/><?php echo $profile_private?>
			                 	</td>
			                </tr>
			                <?php endforeach; ?>
			   
    					   <tr>
                        		<th colspan="3" style="text-align:center">
                        			<button class="btn primary" onclick="privacy_data_save();" id="privacy_save_btn" data-loading-text="<?php echo $profile_data_process;?>"><?php echo $profile_save;?></button>
                        		</th>
                        	</tr>
    					  </table>
    					</div>
    			  </div>
		    </div>
            
            <div class="span4">
                <!--right content-->   
              	<?php include("right.php");?>    
            </div>
          </div>
        </div>
      </div>
   </div>
    <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
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
		<div class="modal-header"><a href="#" class="close">&times;</a><h3><?php echo $profile_local_check;?></h3></div>
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
							<option id="en">Britain</option>
							<option id="de">Germany</option>
							<option id="it">Italy</option>
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
  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
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
    
