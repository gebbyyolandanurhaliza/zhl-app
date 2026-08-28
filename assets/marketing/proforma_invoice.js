var proforma_invoice = function (){
	
	return {
		init: function (){
			
			$('select').select2({
				allowClear: true
			});

			$('.autonum').autoNumeric('init',{
				mDec	: 2,
				aDec	: '.',
				aSep	: ','
			});

			//select all text on focused
			$('.autofocus').on('click', function(){
				this.select();
			});
			
			$('#btn_add_misc').on('click', function(){
							
				$('#tbl_misc').find('tbody').append($(
					'<tr>'
					+'<td class="bg-editable text-center">'
						+'<input type="button" class="btn btn-xs red-stripe fontawesome-font remove_detail_add" value="&#xf014" style="margin: 1px; width: 95%;" title="Remove miscellaneous cost">'
					+'</td>'
					+'<td class="bg-editable">'
						+'<input type="hidden" name="pi_misc_id[]" value="0">'
						+'<input name="misc_cost[]" class="form-control input-xs input-table">'
					+'</td>'
					+'<td class="bg-editable">'
						+'<input name="misc_value[]" class="form-control input-xs input-table">'
					+'</td>'
					+'</tr>'
				));
		
				$('#tbl_misc .remove_detail_add').on('click', function(){
					var tr = $(this).closest('tr');

					tr.fadeOut(400, function(){
						tr.remove();
					});

					return false;    
				});
		
			});
			
			
		},
		
		startPageLoading: function(options) {
            if (options && options.animate) {
                $('.page-spinner-bar').remove();
                $('body').append('<div class="page-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
            } else {
                $('.page-loading').remove();
                $('body').append('<div class="page-loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>&nbsp;&nbsp;<span>' + (options && options.message ? options.message : 'Loading...') + '</span></div>');
//				$('body').append('<div class="page-loading"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif"/>&nbsp;&nbsp;<span>' + (options && options.message ? options.message : 'Loading...') + '</span></div>');
            }
        },
		
		stopPageLoading: function() {
            $('.page-loading, .page-spinner-bar').remove();
        }
	};
	
}();