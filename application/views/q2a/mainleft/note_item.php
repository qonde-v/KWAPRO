<tr>
	<td><input type="checkbox" name="note_item" id="<?php echo 'del_note_'.$noteId;?>" value="<?php echo $noteId;?>" /></td>
	<td><?php echo $time; ?></td>
	<td><a href="<?php echo $base.'note/'.$noteId;?>"><?php echo $subject; ?></a></td>
	<td><a href="<?php echo $base.'note/note_edit/'.$noteId;?>"><?php echo $notes_edit_button;?></a>
	<!--&nbsp;<a href="#" onclick="del_note_confirm('<?php echo $noteId;?>');"><?php echo $notes_delete_button;?></a>--></td>
</tr>