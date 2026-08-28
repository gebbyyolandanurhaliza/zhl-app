var si_mark = function (){
	return {
		init: function (){
			$('input:checkbox').uniform();
	
			$('.autonum').autoNumeric('init', {
				mDec	: 0
			});

			$('.autonum_inv').autoNumeric('init',{
				mDec	: 2
			});

			//select all text on focused
			$('.autonum').on('click', function(){
				this.select();
			});

			//select all text on focused
			$('.autonum_inv').on('click', function(){
				this.select();
			});

			//	autosizeme => autosize textarea
			$('textarea').each(function(){
				autosize(this);
			});

			//fungsi ini untuk menghilangkan list data di modal
			$('.modal').on('hidden.bs.modal', function(){
				$('.v-scroll').html('');
			});
		},
		
		get_invoice_price: function(){
			function getText(el) {
				if (typeof el.textContent == 'string')
					return el.textContent;
				if (typeof el.innerText == 'string')
					return el.innerText;
			}

			var chk_arr = document.getElementsByName("agent_invoice[]");
			var chk_length = chk_arr.length;

//			var inv_arr = document.getElementsByName("invoice_price[]");
//			var inv_length = inv_arr.length;

			i = 1;

			for (r = 0; r < chk_length; r++) {
				var com_percent = remove_thousand_separator(getText(document.getElementById('tbl_agent').rows[i].cells[3]));
				var com_price = remove_thousand_separator(getText(document.getElementById('tbl_agent').rows[i].cells[4]));

				if (chk_arr[r].checked == true) {
	//				for (x = 0; x < inv_length; x++){
//					var pr = 0;
					$('#tbl_shp tr').each(function() {
						var unit_price = remove_thousand_separator($(this).find("input[name='unit_price[]']").val());
						var inv_price = unit_price;
						var commision = com_price;
						
						
						if (com_percent > 0){
							if (unit_price > 0){
								commision = unit_price * com_percent / 100;
							} else {
								commision = 0;
							}
						}

						if (com_price > 0){
							if (unit_price > 0){
								commision = com_price;
							} else {
								commision = 0;
							}
						}

						if (unit_price > 0){
							inv_price = unit_price - commision;
						}else{
							inv_price = 0;
						}

						$(this).find("input[name='invoice_price[]']").val(number_format(inv_price, 2));
//						console.log(pr+' => unit_price : '+unit_price+'; inv_price : '+inv_price);
//						pr++;
					});
				} else {
					$('#tbl_shp tr').each(function() {
						var unit_price = remove_thousand_separator($(this).find("input[name='unit_price[]']").val());
						$(this).find("input[name='invoice_price[]']").val(number_format(unit_price, 2));
					});
				}
			}
		},
		
		get_invoice_price_on_add : function (){
			function getText(el) {
				if (typeof el.textContent == 'string')
					return el.textContent;
				if (typeof el.innerText == 'string')
					return el.innerText;
			}

			var chk_arr = document.getElementsByName("agent_invoice[]");
			var chk_length = chk_arr.length;
			
			i = 1;
						
			for (r = 0; r < chk_length; r++) {
				var com_percent = remove_thousand_separator(getText(document.getElementById('tbl_agent').rows[i].cells[3]));
				var com_price = remove_thousand_separator(getText(document.getElementById('tbl_agent').rows[i].cells[4]));
				
				if (chk_arr[r].checked == true) {
					$('#tbl_shp tr').each(function() {
						var unit_price = remove_thousand_separator($(this).find("input[name='unit_price[]']").val());
						var inv_price = unit_price;
						var commision = com_price;

						var on_add_product = $(this).find("input[name='on_add_product[]']").val();

						console.log('on_add_product['+r+'] : ' + on_add_product);
						
						if (on_add_product == 1){
							if (com_percent > 0){
								if (unit_price > 0){
									commision = unit_price * com_percent / 100;
								} else {
									commision = 0;
								}
							}

							if (com_price > 0){
								if (unit_price > 0){
									commision = com_price;
								} else {
									commision = 0;
								}
							}
						

							if (unit_price > 0){
								inv_price = unit_price - commision;
							}else{
								inv_price = 0;
							}
						
							$(this).find("input[name='invoice_price[]']").val(number_format(inv_price, 2));
						}
					});
				} else {
					$('#tbl_shp tr').each(function() {
						var unit_price = remove_thousand_separator($(this).find("input[name='unit_price[]']").val());
						$(this).find("input[name='invoice_price[]']").val(number_format(unit_price, 2));
					});
				}
				
			}			
			
		}
	};
}();