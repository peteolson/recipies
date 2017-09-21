<?php 
if (!isset($id) || $id == "") :include("new_header.php");?>
<h3>Add New Record</h3>
<form method="POST" action="process.php?add">
   
<input type='text' name='name'/>
<div id="content">
<p><textarea cols=45 name="ingredient" ></textarea></p>
<p><textarea cols=45 name="method" ></textarea></p>
</div>
<input type="submit" value="Save"/>
</form>

<?php else:?>

<form method="POST" action="process.php?update_recipie">
<input type='hidden' name='id' value='<?php echo $recipie->id;?>'/>
<p><input id="name" name="name" type="text" size="35" value="<?php echo $recipie->name ?>" maxlength="45"></p>

<div id="content">
<p><textarea cols=45 name="ingredient" ><?php echo $recipie->ingredient ?></textarea></p>
<p><textarea cols=45 name="method" ><?php echo $recipie->method ?></textarea></p>
</div>

<input type="submit" value="Save"/>
</form>
<script src='dist/autosize.js'></script>
	<script>
		autosize(document.querySelectorAll('textarea'));
	</script>	
    
<?php endif;?>