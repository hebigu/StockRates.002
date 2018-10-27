	
<link rel="stylesheet" href="../plugins/content/mailchimp/assets/css/mailchimp.css" type="text/css" />
<script src="../plugins/content/mailchimp/assets/js/jsn_mailchimp.js" type="text/javascript"></script>
<div class="mailchimp">
	<fieldset id="mailchimp">
		<legend>
			<i class="logoMailchimp"></i><?php echo JText::_('JSN_UNIFORM_FORM_MAILCHIMP_SETTING'); ?>
		</legend>
		<div class="control-group jsn-items-list-container">
			<label class="control-label jsn-label-des-tipsy">
				Use Mailchimp:
			</label>
			<div class="controls">
				<span class="btn use_mailchimp no choiseNo"><?php echo JText::_('JSN_UNIFORM_SELECT_CHOICE_NO'); ?></span>
				<span class="btn use_mailchimp yes"><?php echo JText::_('JSN_UNIFORM_SELECT_CHOICE_YES'); ?></span>
				<input type="hidden" id="hidUseMailchimp">
			</div>
		</div>
		<div class="usemailchimp">
			<div class="control-group jsn-items-list-container">
				<label class="control-label jsn-label-des-tipsy">
					Mailchimp API Key:
				</label>
				<div class="controls">
					<input type="text" name="mailchimKey" id="mailchimpKey">
					<span class="maichimploading">loadding....</span>
					<span class="mailchimp_err"></span>
					<input type="hidden" id="KeyMailchimp">
				</div>
			</div>
			<div class="validate_api">
				<div class="control-group jsn-items-list-container">
					<label class="control-label jsn-label-des-tipsy">
						Mailchimp List ID:
					</label>
					<div class="controls">
						<table class="jsn-items-list-mailchimp">
							<thead>
								<tr>
									<th>#</th>
									<th width="50%">Name</th>
									<th>Created at</th>
								</tr>
							</thead>
							<tbody class="listmailchimp"></tbody>
						</table>
					</div>
				</div>
				<div class="control-group jsn-items-list-container">
					<label class="control-label jsn-label-des-tipsy">
						<?php echo JText::_('JSN_UNIFORM_LIST_FIELD_MAILCHIMP'); ?>:
					</label>
					<div class="controls">
						<table class="jsn-items-list-mailchimp">
							<thead>
								<tr>
									<th width="8%">#</th>
									<th width="50%">Field Label</th>
									<th>Field Label On Mailchimp Server</th>
								</tr>
							</thead>
							<tbody class="listfieldmailchimp">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<input type="hidden" name="form_mailchimp"  id ="jform_form_mailchimp" value=<?=$mailchimp?>>
</div>
