jQuery(document).ready(function(){
	jQuery('.nlp-theme-del').each(function(){
		jQuery(this).click(function(e){
			e.preventDefault();
			btnOk = object.btn_ok;
			btnCancel = object.btn_cancel;
			jQuery("<div>"+object.confirm+"</div>").dialog({
				dialogClass: 'nlposts-dialog',
				modal: true,
		        buttons: [
		        	{
		        		text: btnOk,
		        		click: function() {
		        			window.location = e.srcElement.href;
			            }
		        	},
		        	{
		        		text: btnCancel,
		        		click: function() {
			                jQuery(this).dialog( "close" );
			            }
		        	}
		        ]
		    });
		})
	});
});