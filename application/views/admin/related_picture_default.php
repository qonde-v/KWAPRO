<?php if(isset($picture_array)&&!empty($picture_array)):?>
							<?php if(count($picture_array)>0):?>
							<input type="hidden" id="picture_num" value="<?php echo count($picture_array);?>">
						
								<?php foreach($picture_array as $key=>$picture):?>
								
								<div class="pictureshow">
									<img  src="<?php echo $base.'upload/uploadimages/'.$picture;?>"><br />
									<a class="home_top_del" href="#" onclick="return delete_picture(<?php echo $key;?>,<?php echo $id;?>);">删除</a><br />
								</div>
								<?php endforeach;?>							
							<?php endif;?>
							<?php else:?>
							
						<input type="hidden" id="picture_num" value="0">
						<?php endif;?>