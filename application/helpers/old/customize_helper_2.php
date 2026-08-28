<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//PESAN ALERT
function pesan_sukses()
{
  return 'success';
}

function pesan_error()
{
  return 'error';
}

function pesan_info()
{
  return 'info';
}

function pesan_peringatan()
{
  return 'warning';
}

function pesan($pesan, $tipe, $pdf_link = '', $extra_button = '', $xls_link = '')
{
  switch ($tipe) {
    case 'success':
      $class    = 'note note-success note-bordered';
      $icon    = 'fa fa-check';
      break;

    case 'info':
      $class    = 'note note-info note-bordered';
      $icon    = 'fa fa-info';
      break;

    case 'error':
      $class    = 'note note-danger note-bordered';
      $icon    = 'fa fa-exclamation-circle';
      break;

    case 'warning':
      $class    = 'note note-warning note-bordered';
      $icon    = 'fa fa-exclamation-triangle';
      break;

    default:
      $class    = 'note note-info note-bordered';
      $icon    = 'fa fa-info-sign';
      break;
  }

  $note = "<div class='$class'>"
    . "<h4 class='block'><span class='$icon'></span> <strong>" . strtoupper($tipe) . "!</strong>  "
    . "<small>$pesan</small></h4>";

  $note .= "<p>";

  if ($pdf_link) {
    $note .= "<a class='btn btn-warning' target='_blank' href='$pdf_link'><i class='fa fa-file-pdf-o'></i> View PDF</a>";
  }

  if ($xls_link) {
    $note .= "<a class='btn green-jungle' target='_blank' href='$xls_link'><i class='fa fa-file-excel-o'></i> Export Excel</a>";
  }

  if ($extra_button) {
    $note .= $extra_button;
  }

  $note .= "</p>";
  $note .= "</div>";

  return $note;
}

function pesan_old($pesan, $tipe)
{
  switch ($tipe) {
    case 'success':
      $class    = 'alert alert-success';
      $icon    = 'glyphicon glyphicon-ok-circle';
      break;

    case 'info':
      $class    = 'alert alert-info';
      $icon    = 'glyphicon glyphicon-info-sign';
      break;

    case 'error':
      $class    = 'alert alert-danger';
      $icon    = 'glyphicon glyphicon-exclamation-sign';
      break;

    case 'warning':
      $class    = 'alert alert-warning';
      $icon    = 'glyphicon glyphicon-warning-sign';
      break;

    default:
      $class    = 'alert alert-info';
      $icon    = 'glyphicon glyphicon-info-sign';
      break;
  }

  return '<div class="' . $class . '"><a class="close" data-dismiss="alert">×</a><span class="' . $icon . '" style="font-size:20px">&nbsp;</span> ' . $pesan . '</div>';
}

function valid_date($date, $format = 'd/m/Y')
{
  $d = DateTime::createFromFormat($format, $date);
  //Check for valid date in given format
  if ($d && $d->format($format) == $date) {
    return true;
  } else {
    //		$this->form_validation->set_message('valid_date', 
    //               'The %s date is not valid it should match this ('.$format.') format');
    return false;
  }
}

function left($str, $length)
{
  return substr($str, 0, $length);
}

function right($str, $length)
{
  return substr($str, -$length);
}

function show_title($title = '', $remark = '')
{
  $result = '<div class="page-head">
				<div class="container-fluid">
					<div class="page-title">
						<h1> ' . strtoupper($title) . ' <small>' . $remark . '</small></h1>
					</div>
				</div>
			</div>';
  return $result;
}

function fa_list()
{
  $fa = array(
    'fa-glass' => '\f000',
    'fa-music' => '\f001',
    'fa-search' => '\f002',
    'fa-envelope-o' => '\f003',
    'fa-heart' => '\f004',
    'fa-star' => '\f005',
    'fa-star-o' => '\f006',
    'fa-user' => '\f007',
    'fa-film' => '\f008',
    'fa-th-large' => '\f009',
    'fa-th' => '\f00a',
    'fa-th-list' => '\f00b',
    'fa-check' => '\f00c',
    'fa-times' => '\f00d',
    'fa-search-plus' => '\f00e',
    'fa-search-minus' => '\f010',
    'fa-power-off' => '\f011',
    'fa-signal' => '\f012',
    'fa-cog' => '\f013',
    'fa-trash-o' => '\f014',
    'fa-home' => '\f015',
    'fa-file-o' => '\f016',
    'fa-clock-o' => '\f017',
    'fa-road' => '\f018',
    'fa-download' => '\f019',
    'fa-arrow-circle-o-down' => '\f01a',
    'fa-arrow-circle-o-up' => '\f01b',
    'fa-inbox' => '\f01c',
    'fa-play-circle-o' => '\f01d',
    'fa-repeat' => '\f01e',
    'fa-refresh' => '\f021',
    'fa-list-alt' => '\f022',
    'fa-lock' => '\f023',
    'fa-flag' => '\f024',
    'fa-headphones' => '\f025',
    'fa-volume-off' => '\f026',
    'fa-volume-down' => '\f027',
    'fa-volume-up' => '\f028',
    'fa-qrcode' => '\f029',
    'fa-barcode' => '\f02a',
    'fa-tag' => '\f02b',
    'fa-tags' => '\f02c',
    'fa-book' => '\f02d',
    'fa-bookmark' => '\f02e',
    'fa-print' => '\f02f',
    'fa-camera' => '\f030',
    'fa-font' => '\f031',
    'fa-bold' => '\f032',
    'fa-italic' => '\f033',
    'fa-text-height' => '\f034',
    'fa-text-width' => '\f035',
    'fa-align-left' => '\f036',
    'fa-align-center' => '\f037',
    'fa-align-right' => '\f038',
    'fa-align-justify' => '\f039',
    'fa-list' => '\f03a',
    'fa-outdent' => '\f03b',
    'fa-indent' => '\f03c',
    'fa-video-camera' => '\f03d',
    'fa-picture-o' => '\f03e',
    'fa-pencil' => '\f040',
    'fa-map-marker' => '\f041',
    'fa-adjust' => '\f042',
    'fa-tint' => '\f043',
    'fa-pencil-square-o' => '\f044',
    'fa-share-square-o' => '\f045',
    'fa-check-square-o' => '\f046',
    'fa-arrows' => '\f047',
    'fa-step-backward' => '\f048',
    'fa-fast-backward' => '\f049',
    'fa-backward' => '\f04a',
    'fa-play' => '\f04b',
    'fa-pause' => '\f04c',
    'fa-stop' => '\f04d',
    'fa-forward' => '\f04e',
    'fa-fast-forward' => '\f050',
    'fa-step-forward' => '\f051',
    'fa-eject' => '\f052',
    'fa-chevron-left' => '\f053',
    'fa-chevron-right' => '\f054',
    'fa-plus-circle' => '\f055',
    'fa-minus-circle' => '\f056',
    'fa-times-circle' => '\f057',
    'fa-check-circle' => '\f058',
    'fa-question-circle' => '\f059',
    'fa-info-circle' => '\f05a',
    'fa-crosshairs' => '\f05b',
    'fa-times-circle-o' => '\f05c',
    'fa-check-circle-o' => '\f05d',
    'fa-ban' => '\f05e',
    'fa-arrow-left' => '\f060',
    'fa-arrow-right' => '\f061',
    'fa-arrow-up' => '\f062',
    'fa-arrow-down' => '\f063',
    'fa-share' => '\f064',
    'fa-expand' => '\f065',
    'fa-compress' => '\f066',
    'fa-plus' => '\f067',
    'fa-minus' => '\f068',
    'fa-asterisk' => '\f069',
    'fa-exclamation-circle' => '\f06a',
    'fa-gift' => '\f06b',
    'fa-leaf' => '\f06c',
    'fa-fire' => '\f06d',
    'fa-eye' => '\f06e',
    'fa-eye-slash' => '\f070',
    'fa-exclamation-triangle' => '\f071',
    'fa-plane' => '\f072',
    'fa-calendar' => '\f073',
    'fa-random' => '\f074',
    'fa-comment' => '\f075',
    'fa-magnet' => '\f076',
    'fa-chevron-up' => '\f077',
    'fa-chevron-down' => '\f078',
    'fa-retweet' => '\f079',
    'fa-shopping-cart' => '\f07a',
    'fa-folder' => '\f07b',
    'fa-folder-open' => '\f07c',
    'fa-arrows-v' => '\f07d',
    'fa-arrows-h' => '\f07e',
    'fa-bar-chart' => '\f080',
    'fa-twitter-square' => '\f081',
    'fa-facebook-square' => '\f082',
    'fa-camera-retro' => '\f083',
    'fa-key' => '\f084',
    'fa-cogs' => '\f085',
    'fa-comments' => '\f086',
    'fa-thumbs-o-up' => '\f087',
    'fa-thumbs-o-down' => '\f088',
    'fa-star-half' => '\f089',
    'fa-heart-o' => '\f08a',
    'fa-sign-out' => '\f08b',
    'fa-linkedin-square' => '\f08c',
    'fa-thumb-tack' => '\f08d',
    'fa-external-link' => '\f08e',
    'fa-sign-in' => '\f090',
    'fa-trophy' => '\f091',
    'fa-github-square' => '\f092',
    'fa-upload' => '\f093',
    'fa-lemon-o' => '\f094',
    'fa-phone' => '\f095',
    'fa-square-o' => '\f096',
    'fa-bookmark-o' => '\f097',
    'fa-phone-square' => '\f098',
    'fa-twitter' => '\f099',
    'fa-facebook' => '\f09a',
    'fa-github' => '\f09b',
    'fa-unlock' => '\f09c',
    'fa-credit-card' => '\f09d',
    'fa-rss' => '\f09e',
    'fa-hdd-o' => '\f0a0',
    'fa-bullhorn' => '\f0a1',
    'fa-bell' => '\f0f3',
    'fa-certificate' => '\f0a3',
    'fa-hand-o-right' => '\f0a4',
    'fa-hand-o-left' => '\f0a5',
    'fa-hand-o-up' => '\f0a6',
    'fa-hand-o-down' => '\f0a7',
    'fa-arrow-circle-left' => '\f0a8',
    'fa-arrow-circle-right' => '\f0a9',
    'fa-arrow-circle-up' => '\f0aa',
    'fa-arrow-circle-down' => '\f0ab',
    'fa-globe' => '\f0ac',
    'fa-wrench' => '\f0ad',
    'fa-tasks' => '\f0ae',
    'fa-filter' => '\f0b0',
    'fa-briefcase' => '\f0b1',
    'fa-arrows-alt' => '\f0b2',
    'fa-users' => '\f0c0',
    'fa-link' => '\f0c1',
    'fa-cloud' => '\f0c2',
    'fa-flask' => '\f0c3',
    'fa-scissors' => '\f0c4',
    'fa-files-o' => '\f0c5',
    'fa-paperclip' => '\f0c6',
    'fa-floppy-o' => '\f0c7',
    'fa-square' => '\f0c8',
    'fa-bars' => '\f0c9',
    'fa-list-ul' => '\f0ca',
    'fa-list-ol' => '\f0cb',
    'fa-strikethrough' => '\f0cc',
    'fa-underline' => '\f0cd',
    'fa-table' => '\f0ce',
    'fa-magic' => '\f0d0',
    'fa-truck' => '\f0d1',
    'fa-pinterest' => '\f0d2',
    'fa-pinterest-square' => '\f0d3',
    'fa-google-plus-square' => '\f0d4',
    'fa-google-plus' => '\f0d5',
    'fa-money' => '\f0d6',
    'fa-caret-down' => '\f0d7',
    'fa-caret-up' => '\f0d8',
    'fa-caret-left' => '\f0d9',
    'fa-caret-right' => '\f0da',
    'fa-columns' => '\f0db',
    'fa-sort' => '\f0dc',
    'fa-sort-desc' => '\f0dd',
    'fa-sort-asc' => '\f0de',
    'fa-envelope' => '\f0e0',
    'fa-linkedin' => '\f0e1',
    'fa-undo' => '\f0e2',
    'fa-gavel' => '\f0e3',
    'fa-tachometer' => '\f0e4',
    'fa-comment-o' => '\f0e5',
    'fa-comments-o' => '\f0e6',
    'fa-bolt' => '\f0e7',
    'fa-sitemap' => '\f0e8',
    'fa-umbrella' => '\f0e9',
    'fa-clipboard' => '\f0ea',
    'fa-lightbulb-o' => '\f0eb',
    'fa-exchange' => '\f0ec',
    'fa-cloud-download' => '\f0ed',
    'fa-cloud-upload' => '\f0ee',
    'fa-user-md' => '\f0f0',
    'fa-stethoscope' => '\f0f1',
    'fa-suitcase' => '\f0f2',
    'fa-bell-o' => '\f0a2',
    'fa-coffee' => '\f0f4',
    'fa-cutlery' => '\f0f5',
    'fa-file-text-o' => '\f0f6',
    'fa-building-o' => '\f0f7',
    'fa-hospital-o' => '\f0f8',
    'fa-ambulance' => '\f0f9',
    'fa-medkit' => '\f0fa',
    'fa-fighter-jet' => '\f0fb',
    'fa-beer' => '\f0fc',
    'fa-h-square' => '\f0fd',
    'fa-plus-square' => '\f0fe',
    'fa-angle-double-left' => '\f100',
    'fa-angle-double-right' => '\f101',
    'fa-angle-double-up' => '\f102',
    'fa-angle-double-down' => '\f103',
    'fa-angle-left' => '\f104',
    'fa-angle-right' => '\f105',
    'fa-angle-up' => '\f106',
    'fa-angle-down' => '\f107',
    'fa-desktop' => '\f108',
    'fa-laptop' => '\f109',
    'fa-tablet' => '\f10a',
    'fa-mobile' => '\f10b'
  );

  return $fa;
}

// Number To Word - Begin 
//required function trim_all & str_replace_last
function number_to_word($num = '')
{
  $num    = (string) ((int) $num);

  if ((int) ($num) && ctype_digit($num)) {
    $words  = array();

    $num    = str_replace(array(',', ' '), '', trim($num));

    $list1  = array(
      '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
      'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
      'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );

    $list2  = array(
      '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
      'seventy', 'eighty', 'ninety', 'hundred'
    );

    $list3  = array(
      '', 'thousand', 'million', 'billion', 'trillion',
      'quadrillion', 'quintillion', 'sextillion', 'septillion',
      'octillion', 'nonillion', 'decillion', 'undecillion',
      'duodecillion', 'tredecillion', 'quattuordecillion',
      'quindecillion', 'sexdecillion', 'septendecillion',
      'octodecillion', 'novemdecillion', 'vigintillion'
    );

    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num    = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);

    foreach ($num_levels as $num_part) {
      $levels--;
      $hundreds   = (int) ($num_part / 100);
      $hundreds   = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
      $tens       = (int) ($num_part % 100);
      $singles    = '';

      if ($tens < 20) {
        $tens   = ($tens ? ' ' . $list1[$tens] . ' ' : '');
      } else {
        $tens   = (int) ($tens / 10);
        $tens   = ' ' . $list2[$tens] . ' ';
        $singles    = (int) ($num_part % 10);
        $singles    = ' ' . $list1[$singles] . ' ';
      }
      $words[]    = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
    }

    $commas = count($words);

    if ($commas > 1) {
      $commas = $commas - 1;
    }

    $words  = implode(', ', $words);

    //Some Finishing Touch
    //Replacing multiples of spaces with one space
    $words  = trim(str_replace(' ,', ',', trim_all(ucwords($words))), ', ');
    if ($commas) {
      $words  = str_replace_last(',', ' and', $words);
    }

    return $words;
  } else if (!((int) $num)) {
    return 'Zero';
  }
  return '';
}

function trim_all($str, $what = NULL, $with = ' ')
{
  if ($what === NULL) {
    //  Character      Decimal      Use
    //  "\0"            0           Null Character
    //  "\t"            9           Tab
    //  "\n"           10           New line
    //  "\x0B"         11           Vertical Tab
    //  "\r"           13           New Line in Mac
    //  " "            32           Space

    $what   = "\\x00-\\x20";    //all white-spaces and control chars
  }

  return trim(preg_replace("/[" . $what . "]+/", $with, $str), $what);
}

function str_replace_last($search, $replace, $str)
{
  if (($pos = strrpos($str, $search)) !== false) {
    $search_length  = strlen($search);
    $str    = substr_replace($str, $replace, $pos, $search_length);
  }
  return $str;
}

function safe_b64encode($string)
{

  $data = base64_encode($string);
  $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
  return $data;
}

function safe_b64decode($string)
{
  $data = str_replace(array('-', '_'), array('+', '/'), $string);
  $mod4 = strlen($data) % 4;
  if ($mod4) {
    $data .= substr('====', $mod4);
  }
  return base64_decode($data);
}

function encode_str($value, $gembok = '')
{
  //	$skey 	= "d0n`t-tRyth15_@h0m3";
  $skey = (trim_all($gembok) == '' ? 'd0n`t-tRyth15_@h0m3' : $gembok);

  if (!$value) {
    return false;
  }
  $text = $value;
  $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
  return trim(safe_b64encode($crypttext));
}

function decode_str($value, $gembok = '')
{
  //	$skey 	= "d0n`t-tRyth15_@h0m3";
  $skey = (trim_all($gembok) == '' ? 'd0n`t-tRyth15_@h0m3' : $gembok);
  if (!$value) {
    return false;
  }
  $crypttext = safe_b64decode($value);
  $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
  return trim($decrypttext);
}

function remove_thousand_separator($str_number)
{
  return str_replace(',', '', $str_number);
}

function remove_percent($p_value)
{
  return preg_replace('/\s+%/', '', $p_value);
}

function align_text($align)
{
  if ($align == 'L' || $align == 'l')
    return 'text-left';
  elseif ($align == 'R' || $align == 'r')
    return 'text-right';
  else
    return 'text-center';
}

// CURRENCY TO WORD - BEGIN
// Fungsi terbilang CURRENCY menggunakan koma
// http://stackoverflow.com/questions/19308102/how-to-convert-decimal-number-to-words-money-format-using-php
// function currency_to_word($number)
// {
//   list($integer, $fraction) = explode(".", (string) $number);

//   $output = "";

//   if ($integer{
//     0} == "-") {
//     $output = "negative ";
//     $integer    = ltrim($integer, "-");
//   } else if ($integer{
//     0} == "+") {
//     $output = "positive ";
//     $integer    = ltrim($integer, "+");
//   }

//   if ($integer{
//     0} == "0") {
//     $output .= "zero";
//   } else {
//     $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
//     $group   = rtrim(chunk_split($integer, 3, " "), " ");
//     $groups  = explode(" ", $group);

//     $groups2 = array();
//     foreach ($groups as $g) {
//       $groups2[] = convertThreeDigit($g{
//         0}, $g{
//         1}, $g{
//         2});
//     }

//     for ($z = 0; $z < count($groups2); $z++) {
//       if ($groups2[$z] != "") {
//         $output .= $groups2[$z] . convertGroup(11 - $z) . ($z < 11
//           && !array_search('', array_slice($groups2, $z + 1, -1))
//           && $groups2[11] != ''
//           && $groups[11]{
//             0} == '0'
//           ? " and "
//           : ", "
//         );
//       }
//     }

//     $output = rtrim($output, ", ");
//   }

//   if ($fraction > 0) {
//     $output .= " point";
//     for ($i = 0; $i < strlen($fraction); $i++) {
//       $output .= " " . convertDigit($fraction{
//         $i});
//     }
//   }

//   return $output;
// }

// function convertGroup($index)
// {
//   switch ($index) {
//     case 11:
//       return " decillion";
//     case 10:
//       return " nonillion";
//     case 9:
//       return " octillion";
//     case 8:
//       return " septillion";
//     case 7:
//       return " sextillion";
//     case 6:
//       return " quintrillion";
//     case 5:
//       return " quadrillion";
//     case 4:
//       return " trillion";
//     case 3:
//       return " billion";
//     case 2:
//       return " million";
//     case 1:
//       return " thousand";
//     case 0:
//       return "";
//   }
// }

// function convertThreeDigit($digit1, $digit2, $digit3)
// {
//   $buffer = "";

//   if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0") {
//     return "";
//   }

//   if ($digit1 != "0") {
//     $buffer .= convertDigit($digit1) . " hundred";
//     if ($digit2 != "0" || $digit3 != "0") {
//       $buffer .= " and ";
//     }
//   }

//   if ($digit2 != "0") {
//     $buffer .= convertTwoDigit($digit2, $digit3);
//   } else if ($digit3 != "0") {
//     $buffer .= convertDigit($digit3);
//   }

//   return $buffer;
// }

// function convertTwoDigit($digit1, $digit2)
// {
//   if ($digit2 == "0") {
//     switch ($digit1) {
//       case "1":
//         return "ten";
//       case "2":
//         return "twenty";
//       case "3":
//         return "thirty";
//       case "4":
//         return "forty";
//       case "5":
//         return "fifty";
//       case "6":
//         return "sixty";
//       case "7":
//         return "seventy";
//       case "8":
//         return "eighty";
//       case "9":
//         return "ninety";
//     }
//   } else if ($digit1 == "1") {
//     switch ($digit2) {
//       case "1":
//         return "eleven";
//       case "2":
//         return "twelve";
//       case "3":
//         return "thirteen";
//       case "4":
//         return "fourteen";
//       case "5":
//         return "fifteen";
//       case "6":
//         return "sixteen";
//       case "7":
//         return "seventeen";
//       case "8":
//         return "eighteen";
//       case "9":
//         return "nineteen";
//     }
//   } else {
//     $temp = convertDigit($digit2);
//     switch ($digit1) {
//       case "2":
//         return "twenty-$temp";
//       case "3":
//         return "thirty-$temp";
//       case "4":
//         return "forty-$temp";
//       case "5":
//         return "fifty-$temp";
//       case "6":
//         return "sixty-$temp";
//       case "7":
//         return "seventy-$temp";
//       case "8":
//         return "eighty-$temp";
//       case "9":
//         return "ninety-$temp";
//     }
//   }
// }

// function convertDigit($digit)
// {
//   switch ($digit) {
//     case "0":
//       return "zero";
//     case "1":
//       return "one";
//     case "2":
//       return "two";
//     case "3":
//       return "three";
//     case "4":
//       return "four";
//     case "5":
//       return "five";
//     case "6":
//       return "six";
//     case "7":
//       return "seven";
//     case "8":
//       return "eight";
//     case "9":
//       return "nine";
//   }
// }

// CURRENCY TO WORD - END

//function convert_number_to_words($string_number){
//	$result_convert = do_convert_number_to_words($string_number);
//	$and_count = substr_count($result_convert, 'And');
//	if ($and_count > 1){
//		for($i = 1; $i < $and_count; $i++) {
//			$result_convert = substr_replace(' And ', ' ', $result_convert);
//		}
//	}
//	return $result_convert;
//}

// function convert_number_to_words($number)
// {

//     $hyphen      = ' ';
//     $conjunction = ' and ';
//     $separator   = ' ';
//     $negative    = 'negative ';
//     $decimal     = ' and Cents ';
//     $dictionary  = array(
//         0                   => '',
//         1                   => 'One',
//         2                   => 'Two',
//         3                   => 'Three',
//         4                   => 'Four',
//         5                   => 'Five',
//         6                   => 'Six',
//         7                   => 'Seven',
//         8                   => 'Eight',
//         9                   => 'Nine',
//         10                  => 'Ten',
//         11                  => 'Eleven',
//         12                  => 'Twelve',
//         13                  => 'Thirteen',
//         14                  => 'Fourteen',
//         15                  => 'Fifteen',
//         16                  => 'Sixteen',
//         17                  => 'Seventeen',
//         18                  => 'Eighteen',
//         19                  => 'Nineteen',
//         20                  => 'Twenty',
//         30                  => 'Thirty',
//         40                  => 'Forty',
//         50                  => 'Fifty',
//         60                  => 'Sixty',
//         70                  => 'Seventy',
//         80                  => 'Eighty',
//         90                  => 'Ninety',
//         100                 => 'Hundred',
//         1000                => 'Thousand',
//         1000000             => 'Million',
//         1000000000          => 'Billion',
//         1000000000000       => 'Trillion',
//         1000000000000000    => 'Quadrillion',
//         1000000000000000000 => 'Quintillion'
//     );

//     if (!is_numeric($number)) {
//         return false;
//     }

//     if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
//         // overflow
//         trigger_error(
//             'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
//             E_USER_WARNING
//         );
//         return false;
//     }

//     if ($number < 0) {
//         return $negative . convert_number_to_words(abs($number));
//     }

//     $string = $fraction = null;
//     $angka_desimal = 0;

//     if (strpos($number, '.') !== false) {
//         list($number, $fraction) = explode('.', $number);
//     }

//     switch (true) {
//         case $number < 21:
//             $string = $dictionary[$number];
//             break;
//         case $number < 100:
//             $tens   = ((int) ($number / 10)) * 10;
//             $units  = $number % 10;
//             $string = $dictionary[$tens];
//             if ($units) {
//                 $string .= $hyphen . $dictionary[$units];
//             }
//             break;
//         case $number < 1000:
//             $hundreds  = $number / 100;
//             $remainder = $number % 100;
//             $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
//             if ($remainder) {
//                 $string .= $conjunction . convert_number_to_words($remainder);
//             }
//             break;
//         default:
//             $baseUnit = pow(1000, floor(log($number, 1000)));
//             $numBaseUnits = (int) ($number / $baseUnit);
//             $remainder = $number % $baseUnit;
//             $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
//             if ($remainder) {
//                 $string .= ($remainder < 100) ? $conjunction : $separator;
//                 $string .= convert_number_to_words($remainder);
//             }
//             break;
//     }

//     if (null !== $fraction && is_numeric($fraction)) {
//         $string = str_replace(' and ', ' ', $string);
//         $fraction = str_pad($fraction, 2, '0', STR_PAD_RIGHT);    // convert jadi 2 digit, tambah 0 dibelakang jika 1 digit
//         $string .= $decimal . convert_number_to_words($fraction);
//         //        $words = array();
//         //        foreach (str_split((string) $fraction) as $number) {
//         //            $words[] = $dictionary[$number];
//         //        }		
//         //        $string .= implode(' ', $words);		
//     } else {
//         $total_and = substr_count($string, ' and ');
//         $arr_word = explode(' ', $string);
//         $word = array();
//         $a = 1;
//         foreach ($arr_word as $n) {
//             if (trim($n) == 'and') {
//                 $word[] = ($a < $total_and) ? '' : 'and';
//                 $a++;
//             } else {
//                 $word[] = $n;
//             }
//         }
//         $string = implode(' ', $word);
//     }

//     return $string;
// }
