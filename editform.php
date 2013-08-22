<ul>
<? if ($errors) 
	foreach ($errors as $_err) { ?>
	<li><?=htmlspecialchars($_err)?></li>
<? } ?>
</ul>

<form method="post" enctype="multipart/form-data">
<table>
	
	<tr>
		<td>Title</td>
		<td><input type="text" name="title" size="80" value="<?=htmlspecialchars($title)?>"/></td>
	</tr>

<? if ($is_image) { ?>
	<tr>
		<td>&nbsp:</td>
		<td><img src="/<?=htmlspecialchars($title)?>"></td>
	</tr>
<? } ?>

	<tr>
		<td>Content</td>
		<td><textarea name="content" cols="120" rows="30">
<? if ($is_text) echo htmlspecialchars( $content); ?>
</textarea></td>
	</tr>
	
	<tr>
		<td>or file</td>
		<td><input type="file" name="file" size="80" /></td>
	</tr>

	<tr>
		<td>&nbsp:</td>
		<td>
			<input type="submit" name="edit" value="Save" />
			<input type="reset" value="Reset" />
		</td>
	</tr>

</table>
</form>
