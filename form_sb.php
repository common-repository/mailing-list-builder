<form name="mlbs" id="mlbs" action="">
	<div class="cta">
		<?php echo $cta; ?>
	</div>
	<div id="mlbs-email-error" style="display: none;">Please enter a valid email address and try again</div>	
	<table class="fields">
		<tr>
			<td><label for="mlbs-name">Your Name</label></td>
			<td><input id="mlbs-name" type="text" name="mlbs-name" /></td>
		</tr>
		<tr>
			<td><label for="mlbs-email">Your Email</label></td>
			<td><input id="mlbs-email" type="text" name="mlbs-email" /></td>
		</tr>
	</table>
	<div class="submit">
		<input type="submit" value="Go..." class="mlbs-submit" />
	</div>
	<input type="hidden" name="mlbs-interests" value="<?php echo $interests; ?>" />
	<input type="hidden" name="mlbs-campaign" value="<?php echo $campaign; ?>" />
	<input type="hidden" name="mlbs-ref" value="<?php echo $ref; ?>" />
</form>