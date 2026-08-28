var po_mark = function (){
	return {
		init: function (){
			
			$('#factory_list').select2();

			$('#destination_id').select2({
				allowClear	: true
			});

			$('#rev_value').select2({
				allowClear	: true
			});
			
			$('#local_currency').select2({
				allowClear	: true
			});

			$('#container_list').select2({
				allowClear	: true
			});

			$('#sales_marketing_id').select2({
				allowClear	: true
			});

			$('#rate_usd').autoNumeric('init',{
				mDec	: 6
			});

			$('#rate_sgd').autoNumeric('init',{
				mDec	: 6
			});

			//select all text on focused
			$('.autofocus').on('click', function(){
				this.select();
			});

			$('.autonum_price').autoNumeric('init',{
				mDec	: 2
			});

			$('.autonum_fcl').autoNumeric('init',{
				mDec	: 2
			});

			$('.autonumber').on('click', function(){
				this.select();
			});

			$('.autonum_qty').autoNumeric('init',{
				mDec	: 0
			});

			$('.autonum_fob').autoNumeric('init',{
				mDec	: 2
			});

			$('.autonumber').autoNumeric('init');

			//	autosizeme => autosize textarea
			$('.autosizeme').each(function(){
				autosize(this);
			});

			//fungsi ini untuk menghilangkan list data di modal
			$('.modal').on('hidden.bs.modal', function(){
				$('.v-scroll').html('');
			});
			
		}
	};
}();