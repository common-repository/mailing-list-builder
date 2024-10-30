<form name="mlb" id="mlb" action="">
	<div class="cta">
		<?php echo $content; ?>
	</div>
	<div id="mlb-email-error" style="display: none;">Please enter a valid email address and try again</div>	
	<table class="fields">
		<tr>
			<td><label for="mlb-name">Your Name</label></td>
			<td><input id="mlb-name" type="text" name="mlb-name" /></td>
		</tr>
		<tr>
			<td><label for="mlb-email">Your Email</label></td>
			<td><input id="mlb-email" type="text" name="mlb-email" /></td>
		</tr>
	</table>
	<div class="submit">
		<input type="submit" value="Go..." class="mlb-submit" />
	</div>
	<input type="hidden" name="mlb-interests" value="<?php echo $interests; ?>" />
	<input type="hidden" name="mlb-campaign" value="<?php echo $campaign; ?>" />
	<input type="hidden" name="mlb-ref" value="<?php echo $ref; ?>" />
</form>