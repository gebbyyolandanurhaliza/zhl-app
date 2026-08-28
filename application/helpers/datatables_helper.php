<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function tombol_edit($link)
{
	return anchor(site_url($link),'<span class="fa fa-fw fa-pencil-square-o"></span>','class="btn btn-xs btn-warning"');
}

function tombol_delete($link)
{
	return anchor(site_url($link),'<span class="fa fa-fw fa-trash-o"></span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')" class="btn btn-xs btn-danger"');
}
