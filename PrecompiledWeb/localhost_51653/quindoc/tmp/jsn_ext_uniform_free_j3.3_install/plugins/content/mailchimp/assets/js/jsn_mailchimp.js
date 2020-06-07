/**
 * @version    $Id: jsn_mailchimp.js 2014-8-28 anhnt $
 * @package    JSN.Uniform
 * @subpackage Plugins.Mailchimp
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2014 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

(function($) {
	var JSNMailchimp = {
		initialize: function()
		{
			var self = this;
			self.useMailchimp();
			$('#mailchimpKey').focusout(function() {
				if ($(this).val() !== '') {
					self.checkApiKey($(this).val());
				}
			})
			self.loadDataMailchimp();
		},
		/*
		 * Load data of Mailchimp saved
		 * 
		 * Return string HTML 
		 */
		loadDataMailchimp: function() {
			var self = this;
			var data = $('#jform_form_mailchimp').val();
			if (typeof data !== 'undefined' && data !== '') {
				$('.yes').click();
				data = $.parseJSON(data);
				$.each(data, function(k, v) {
					var listId = data['listId'];
					$('#checkListMailchimp').val(JSON.stringify(listId));
					var apiKey = data['keyApi'];
					var fieldLabel = data['fieldlabel'];
					$('#checkFieldMailchimp').val(JSON.stringify(fieldLabel));
					if (apiKey !== '') {
						$('#mailchimpKey').val(apiKey);
					}
				})
				if ($('#mailchimpKey').val() !== '') {
					$('#mailchimpKey').focusout();
				}
			}
		},
		/*
		 * Check API Key of Mailchimp
		 * @param string @key string api key
		 * @param int @list condition to action method
		 * Return void 
		 */
		checkApiKey: function(key, list) {
			var self = this;
			$.ajax({
				type: "POST",
				async: true,
				url: "index.php?option=com_uniform&view=form&task=form.Mailchimp&tmpl=component",
				data: {
					key: key,
					list: list
				},
				beforeSend: function() {
					$('.maichimploading').show();
				},
				success: function(msg) {
					var arr = $.parseJSON(msg);
					if (arr.name === 'Invalid_ApiKey') {
						$('.mailchimp_success').addClass('mailchimp_err');
						$('.mailchimp_success').removeClass('mailchimp_success');
						$('.mailchimp_err').html(arr.error);
						$('.validate_api').hide();
						$('.maichimploading').hide();
					} else {
						$('.mailchimp_err').addClass('mailchimp_success');
						$('.mailchimp_err').removeClass('mailchimp_err');
						$('.mailchimp_success').html('success');
						self.listMailchimp(key, 1);
						$('#KeyMailchimp').val(1);
						$('.maichimploading').hide();
					}
				}
			});
		},
		/*
		 * Show list on Mailchimp
		 * @param string @key string api key
		 * @param int @list condition to action method
		 * Return string HTML 
		 */
		listMailchimp: function(key, list) {
			var self = this;
			$.ajax({
				type: "POST",
				async: true,
				url: "index.php?option=com_uniform&view=form&task=form.Mailchimp&tmpl=component",
				data: {
					key: key,
					list: list
				},
				success: function(msg) {
					var arr = $.parseJSON(msg);
					var i = 0;
					var str = '';
					var sr= new Array();
					var checkList = $('#checkListMailchimp').val();
					if(checkList !==''){
					checkList = JSON.parse(checkList);
						$.each(checkList, function (a, it) {
							sr[a]=it;
						})
					}
					$.each(arr.data, function(value, key) {
						i++;
						str += '<tr><td><input type="checkbox" id="chkList' + i + '" name="chkList[]" '+ ( $.inArray(arr.data[value].id,sr) !== -1 ? "checked" : "") +' value="' + arr.data[value].id + '"></td><td>' + arr.data[value].name + '</td><td>' + arr.data[value].date_created + '</td></tr>';
					})
					$('.listmailchimp').html(str);
					$('.validate_api').show();
				}
			});
		},
		/*
		 * Select Yes/No to ues Mailchimp
		 * 
		 * Return void 
		 */
		useMailchimp: function() {
			$('.use_mailchimp').click(function() {
				if ($(this).text() === 'No') {
					$('.choiseYes').removeClass('choiseYes');
					$(this).addClass('choiseNo');
					$('.usemailchimp').hide();
					$('#hidUseMailchimp').val(0);
				}
				if ($(this).text() === 'Yes') {
					$('.choiseNo').removeClass('choiseNo');
					$(this).addClass('choiseYes');
					$('.usemailchimp').show();
					$('#hidUseMailchimp').val(1);
				}
			})
		}
	}
	window.addEvent('domready', function() {
		JSNMailchimp.initialize();
	});
})(jQuery);

