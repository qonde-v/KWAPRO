<tr>
	<td><input type="checkbox" name="message_item" id="" value="<?php echo $message_id;?>" /></td>
	<td><?php echo $username; ?></td>
	<td><?php echo $time; ?></td>
	<?php if($is_read == 0):?>
	<td><a style="color:#0082DE" href="<?php echo $base.'message/'.$message_id;?>"><?php echo $title; ?></a></td>
	<?php else:?>
	<td><a href="<?php echo $base.'message/'.$message_id;?>"><?php echo $title; ?></a></td>
	<?php endif;?>
</tr>