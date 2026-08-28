
function remove_percent(sval){
	var nval = (sval + '').replace(/\s+%/g,'');
	return Number(nval);
}

function remove_thousand_separator (fnumber) {
	var s_val = fnumber + '';				// memastikan bahwa valuenya string
	var r_val = s_val.replace(/,/g, '');	// replace string, hasilnya masih string
	return Number(r_val);					// return ke tipe number
}

function add_thousand_separator(str) {
	var sRegExp = new RegExp('(-?[0-9]+)([0-9]{3})');
	var sValue = str + '';

	while (sRegExp.test(sValue)) {
		sValue = sValue.replace(sRegExp, '$1' + ',' + '$2');
	}
	var arrNum = sValue.split('.');
	if (arrNum.length > 1) {
		sValue = arrNum[0] + '.' + remove_thousand_separator(arrNum[1]);
	}
	return sValue;
}

function number_format (number, decimals, dec_point, thousands_sep) {		
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function(n, prec) {
		  var k = Math.pow(10, prec);
		  return '' + (Math.round(n * k) / k)
			.toFixed(prec);
		};
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
			.split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1)
			.join('0');
		}
		return s.join(dec);
}

//	Usage: 	number_format(123456.789, 2, '.', ',');
//	result:	123,456.79
