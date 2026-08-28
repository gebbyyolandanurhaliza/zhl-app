<?php
														 
	$extra_yn = 'class="form-control input-sm input-table" data-placeholder="Y / N"';
	$option_yn[''] = '';	
	$option_yn['Y'] = 'YES';
	$option_yn['N'] = 'NO';	
	echo form_dropdown($cbo_name.'[]', $option_yn, '', $extra_yn);