<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends CI_Controller {
	private $fa;
	
	function __construct(){
		parent::__construct();
		
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
		
		$this->fa = array ( 'icon-glass' => '\f000', 'icon-music' => '\f001', 'icon-search' => '\f002', 'icon-envelope-alt' => '\f003', 'icon-heart' => '\f004', 'icon-star' => '\f005', 'icon-star-empty' => '\f006', 'icon-user' => '\f007', 'icon-film' => '\f008', 'icon-th-large' => '\f009', 'icon-th' => '\f00a', 'icon-th-list' => '\f00b', 'icon-ok' => '\f00c', 'icon-remove' => '\f00d', 'icon-zoom-in' => '\f00e', 'icon-zoom-out' => '\f010', 'icon-off' => '\f011', 'icon-signal' => '\f012', 'icon-cog' => '\f013', 'icon-trash' => '\f014', 'icon-home' => '\f015', 'icon-file-alt' => '\f016', 'icon-time' => '\f017', 'icon-road' => '\f018', 'icon-download-alt' => '\f019', 'icon-download' => '\f01a', 'icon-upload' => '\f01b', 'icon-inbox' => '\f01c', 'icon-play-circle' => '\f01d', 'icon-repeat' => '\f01e', 'icon-refresh' => '\f021', 'icon-list-alt' => '\f022', 'icon-lock' => '\f023', 'icon-flag' => '\f024', 'icon-headphones' => '\f025', 'icon-volume-off' => '\f026', 'icon-volume-down' => '\f027', 'icon-volume-up' => '\f028', 'icon-qrcode' => '\f029', 'icon-barcode' => '\f02a', 'icon-tag' => '\f02b', 'icon-tags' => '\f02c', 'icon-book' => '\f02d', 'icon-bookmark' => '\f02e', 'icon-print' => '\f02f', 'icon-camera' => '\f030', 'icon-font' => '\f031', 'icon-bold' => '\f032', 'icon-italic' => '\f033', 'icon-text-height' => '\f034', 'icon-text-width' => '\f035', 'icon-align-left' => '\f036', 'icon-align-center' => '\f037', 'icon-align-right' => '\f038', 'icon-align-justify' => '\f039', 'icon-list' => '\f03a', 'icon-indent-left' => '\f03b', 'icon-indent-right' => '\f03c', 'icon-facetime-video' => '\f03d', 'icon-picture' => '\f03e', 'icon-pencil' => '\f040', 'icon-map-marker' => '\f041', 'icon-adjust' => '\f042', 'icon-tint' => '\f043', 'icon-edit' => '\f044', 'icon-share' => '\f045', 'icon-check' => '\f046', 'icon-move' => '\f047', 'icon-step-backward' => '\f048', 'icon-fast-backward' => '\f049', 'icon-backward' => '\f04a', 'icon-play' => '\f04b', 'icon-pause' => '\f04c', 'icon-stop' => '\f04d', 'icon-forward' => '\f04e', 'icon-fast-forward' => '\f050', 'icon-step-forward' => '\f051', 'icon-eject' => '\f052', 'icon-chevron-left' => '\f053', 'icon-chevron-right' => '\f054', 'icon-plus-sign' => '\f055', 'icon-minus-sign' => '\f056', 'icon-remove-sign' => '\f057', 'icon-ok-sign' => '\f058', 'icon-question-sign' => '\f059', 'icon-info-sign' => '\f05a', 'icon-screenshot' => '\f05b', 'icon-remove-circle' => '\f05c', 'icon-ok-circle' => '\f05d', 'icon-ban-circle' => '\f05e', 'icon-arrow-left' => '\f060', 'icon-arrow-right' => '\f061', 'icon-arrow-up' => '\f062', 'icon-arrow-down' => '\f063', 'icon-share-alt' => '\f064', 'icon-resize-full' => '\f065', 'icon-resize-small' => '\f066', 'icon-plus' => '\f067', 'icon-minus' => '\f068', 'icon-asterisk' => '\f069', 'icon-exclamation-sign' => '\f06a', 'icon-gift' => '\f06b', 'icon-leaf' => '\f06c', 'icon-fire' => '\f06d', 'icon-eye-open' => '\f06e', 'icon-eye-close' => '\f070', 'icon-warning-sign' => '\f071', 'icon-plane' => '\f072', 'icon-calendar' => '\f073', 'icon-random' => '\f074', 'icon-comment' => '\f075', 'icon-magnet' => '\f076', 'icon-chevron-up' => '\f077', 'icon-chevron-down' => '\f078', 'icon-retweet' => '\f079', 'icon-shopping-cart' => '\f07a', 'icon-folder-close' => '\f07b', 'icon-folder-open' => '\f07c', 'icon-resize-vertical' => '\f07d', 'icon-resize-horizontal' => '\f07e', 'icon-bar-chart' => '\f080', 'icon-twitter-sign' => '\f081', 'icon-facebook-sign' => '\f082', 'icon-camera-retro' => '\f083', 'icon-key' => '\f084', 'icon-cogs' => '\f085', 'icon-comments' => '\f086', 'icon-thumbs-up-alt' => '\f087', 'icon-thumbs-down-alt' => '\f088', 'icon-star-half' => '\f089', 'icon-heart-empty' => '\f08a', 'icon-signout' => '\f08b', 'icon-linkedin-sign' => '\f08c', 'icon-pushpin' => '\f08d', 'icon-external-link' => '\f08e', 'icon-signin' => '\f090', 'icon-trophy' => '\f091', 'icon-github-sign' => '\f092', 'icon-upload-alt' => '\f093', 'icon-lemon' => '\f094', 'icon-phone' => '\f095', 'icon-check-empty' => '\f096', 'icon-bookmark-empty' => '\f097', 'icon-phone-sign' => '\f098', 'icon-twitter' => '\f099', 'icon-facebook' => '\f09a', 'icon-github' => '\f09b', 'icon-unlock' => '\f09c', 'icon-credit-card' => '\f09d', 'icon-rss' => '\f09e', 'icon-hdd' => '\f0a0', 'icon-bullhorn' => '\f0a1', 'icon-bell' => '\f0a2', 'icon-certificate' => '\f0a3', 'icon-hand-right' => '\f0a4', 'icon-hand-left' => '\f0a5', 'icon-hand-up' => '\f0a6', 'icon-hand-down' => '\f0a7', 'icon-circle-arrow-left' => '\f0a8', 'icon-circle-arrow-right' => '\f0a9', 'icon-circle-arrow-up' => '\f0aa', 'icon-circle-arrow-down' => '\f0ab', 'icon-globe' => '\f0ac', 'icon-wrench' => '\f0ad', 'icon-tasks' => '\f0ae', 'icon-filter' => '\f0b0', 'icon-briefcase' => '\f0b1', 'icon-fullscreen' => '\f0b2', 'icon-group' => '\f0c0', 'icon-link' => '\f0c1', 'icon-cloud' => '\f0c2', 'icon-beaker' => '\f0c3', 'icon-cut' => '\f0c4', 'icon-copy' => '\f0c5', 'icon-paper-clip' => '\f0c6', 'icon-save' => '\f0c7', 'icon-sign-blank' => '\f0c8', 'icon-reorder' => '\f0c9', 'icon-list-ul' => '\f0ca', 'icon-list-ol' => '\f0cb', 'icon-strikethrough' => '\f0cc', 'icon-underline' => '\f0cd', 'icon-table' => '\f0ce', 'icon-magic' => '\f0d0', 'icon-truck' => '\f0d1', 'icon-pinterest' => '\f0d2', 'icon-pinterest-sign' => '\f0d3', 'icon-google-plus-sign' => '\f0d4', 'icon-google-plus' => '\f0d5', 'icon-money' => '\f0d6', 'icon-caret-down' => '\f0d7', 'icon-caret-up' => '\f0d8', 'icon-caret-left' => '\f0d9', 'icon-caret-right' => '\f0da', 'icon-columns' => '\f0db', 'icon-sort' => '\f0dc', 'icon-sort-down' => '\f0dd', 'icon-sort-up' => '\f0de', 'icon-envelope' => '\f0e0', 'icon-linkedin' => '\f0e1', 'icon-undo' => '\f0e2', 'icon-legal' => '\f0e3', 'icon-dashboard' => '\f0e4', 'icon-comment-alt' => '\f0e5', 'icon-comments-alt' => '\f0e6', 'icon-bolt' => '\f0e7', 'icon-sitemap' => '\f0e8', 'icon-umbrella' => '\f0e9', 'icon-paste' => '\f0ea', 'icon-lightbulb' => '\f0eb', 'icon-exchange' => '\f0ec', 'icon-cloud-download' => '\f0ed', 'icon-cloud-upload' => '\f0ee', 'icon-user-md' => '\f0f0', 'icon-stethoscope' => '\f0f1', 'icon-suitcase' => '\f0f2', 'icon-bell-alt' => '\f0f3', 'icon-coffee' => '\f0f4', 'icon-food' => '\f0f5', 'icon-file-text-alt' => '\f0f6', 'icon-building' => '\f0f7', 'icon-hospital' => '\f0f8', 'icon-ambulance' => '\f0f9', 'icon-medkit' => '\f0fa', 'icon-fighter-jet' => '\f0fb', 'icon-beer' => '\f0fc', 'icon-h-sign' => '\f0fd', 'icon-plus-sign-alt' => '\f0fe', 'icon-double-angle-left' => '\f100', 'icon-double-angle-right' => '\f101', 'icon-double-angle-up' => '\f102', 'icon-double-angle-down' => '\f103', 'icon-angle-left' => '\f104', 'icon-angle-right' => '\f105', 'icon-angle-up' => '\f106', 'icon-angle-down' => '\f107', 'icon-desktop' => '\f108', 'icon-laptop' => '\f109', 'icon-tablet' => '\f10a', 'icon-mobile-phone' => '\f10b', 'icon-circle-blank' => '\f10c', 'icon-quote-left' => '\f10d', 'icon-quote-right' => '\f10e', 'icon-spinner' => '\f110', 'icon-circle' => '\f111', 'icon-reply' => '\f112', 'icon-github-alt' => '\f113', 'icon-folder-close-alt' => '\f114', 'icon-folder-open-alt' => '\f115', 'icon-expand-alt' => '\f116', 'icon-collapse-alt' => '\f117', 'icon-smile' => '\f118', 'icon-frown' => '\f119', 'icon-meh' => '\f11a', 'icon-gamepad' => '\f11b', 'icon-keyboard' => '\f11c', 'icon-flag-alt' => '\f11d', 'icon-flag-checkered' => '\f11e', 'icon-terminal' => '\f120', 'icon-code' => '\f121', 'icon-reply-all' => '\f122', 'icon-mail-reply-all' => '\f122', 'icon-star-half-empty' => '\f123', 'icon-location-arrow' => '\f124', 'icon-crop' => '\f125', 'icon-code-fork' => '\f126', 'icon-unlink' => '\f127', 'icon-question' => '\f128', 'icon-info' => '\f129', 'icon-exclamation' => '\f12a', 'icon-superscript' => '\f12b', 'icon-subscript' => '\f12c', 'icon-eraser' => '\f12d', 'icon-puzzle-piece' => '\f12e', 'icon-microphone' => '\f130', 'icon-microphone-off' => '\f131', 'icon-shield' => '\f132', 'icon-calendar-empty' => '\f133', 'icon-fire-extinguisher' => '\f134', 'icon-rocket' => '\f135', 'icon-maxcdn' => '\f136', 'icon-chevron-sign-left' => '\f137', 'icon-chevron-sign-right' => '\f138', 'icon-chevron-sign-up' => '\f139', 'icon-chevron-sign-down' => '\f13a', 'icon-html5' => '\f13b', 'icon-css3' => '\f13c', 'icon-anchor' => '\f13d', 'icon-unlock-alt' => '\f13e', 'icon-bullseye' => '\f140', 'icon-ellipsis-horizontal' => '\f141', 'icon-ellipsis-vertical' => '\f142', 'icon-rss-sign' => '\f143', 'icon-play-sign' => '\f144', 'icon-ticket' => '\f145', 'icon-minus-sign-alt' => '\f146', 'icon-check-minus' => '\f147', 'icon-level-up' => '\f148', 'icon-level-down' => '\f149', 'icon-check-sign' => '\f14a', 'icon-edit-sign' => '\f14b', 'icon-external-link-sign' => '\f14c', 'icon-share-sign' => '\f14d', 'icon-compass' => '\f14e', 'icon-collapse' => '\f150', 'icon-collapse-top' => '\f151', 'icon-expand' => '\f152', 'icon-eur' => '\f153', 'icon-gbp' => '\f154', 'icon-usd' => '\f155', 'icon-inr' => '\f156', 'icon-jpy' => '\f157', 'icon-cny' => '\f158', 'icon-krw' => '\f159', 'icon-btc' => '\f15a', 'icon-file' => '\f15b', 'icon-file-text' => '\f15c', 'icon-sort-by-alphabet' => '\f15d', 'icon-sort-by-alphabet-alt' => '\f15e', 'icon-sort-by-attributes' => '\f160', 'icon-sort-by-attributes-alt' => '\f161', 'icon-sort-by-order' => '\f162', 'icon-sort-by-order-alt' => '\f163', 'icon-thumbs-up' => '\f164', 'icon-thumbs-down' => '\f165', 'icon-youtube-sign' => '\f166', 'icon-youtube' => '\f167', 'icon-xing' => '\f168', 'icon-xing-sign' => '\f169', 'icon-youtube-play' => '\f16a', 'icon-dropbox' => '\f16b', 'icon-stackexchange' => '\f16c', 'icon-instagram' => '\f16d', 'icon-flickr' => '\f16e', 'icon-adn' => '\f170', 'icon-bitbucket' => '\f171', 'icon-bitbucket-sign' => '\f172', 'icon-tumblr' => '\f173', 'icon-tumblr-sign' => '\f174', 'icon-long-arrow-down' => '\f175', 'icon-long-arrow-up' => '\f176', 'icon-long-arrow-left' => '\f177', 'icon-long-arrow-right' => '\f178', 'icon-apple' => '\f179', 'icon-windows' => '\f17a', 'icon-android' => '\f17b', 'icon-linux' => '\f17c', 'icon-dribbble' => '\f17d', 'icon-skype' => '\f17e', 'icon-foursquare' => '\f180', 'icon-trello' => '\f181', 'icon-female' => '\f182', 'icon-male' => '\f183', 'icon-gittip' => '\f184', 'icon-sun' => '\f185', 'icon-moon' => '\f186', 'icon-archive' => '\f187', 'icon-bug' => '\f188', 'icon-vk' => '\f189', 'icon-weibo' => '\f18a', 'icon-renren' => '\f18b' );
			
		$this->load->model(array('m_gen_menu'));
	}
	
	function users($aksi){
		switch ($aksi) {
			case 'manage':
				$this->template->display('general/utility/users/manage');
				break;
			
			default:
				break;
		}
	}
	
	function menu($halaman, $aksi = null, $menuid = null){
		$data['message'] = $this->session->flashdata('message');
		
		switch ($halaman) {
			case 'header':
				$data['combo_app_list'] = $this->m_gen_menu->combo_app_list()->result();
				$data['record'] = $this->m_gen_menu->record_menu_header()->result();
				
				switch ($aksi) {
					case 'edit':
//						$menuid = $this->uri->segment(5);
						
						$record_detail = $this->m_gen_menu->get_menu_detail($halaman, $menuid)->result();
						foreach ($record_detail as $r) {							
							$data['menuhdr_id']		= $r->menuhdr_id;
							$data['menuhdr_title']	= $r->menuhdr_title;
							$data['app_id']			= $r->app_id;							
						}
						
						$data['menuid'] = $menuid;
						
						$this->template->display('general/utility/menu/edit_header', $data);
						break;

					default:
						$this->template->display('general/utility/menu/header', $data);
						break;
				}
				
				
				break;
			
			case 'detail':
				$data['combo_menu_header'] = $this->m_gen_menu->combo_menu_header()->result();
				$data['falist'] = fa_list();
				$data['record'] = $this->m_gen_menu->record_menu_detail()->result();
				
				switch ($aksi){
					case 'edit':
//						$menuid = $this->uri->segment(5);
						
						$record_detail = $this->m_gen_menu->get_menu_detail($halaman, $menuid)->result();
						foreach ($record_detail as $r) {							
							$data['menudtl_id']		= $r->menudtl_id;
							$data['menudtl_title']	= $r->menudtl_title;
							$data['menudtl_link']	= $r->menudtl_link;
							$data['menudtl_icon']	= $r->menudtl_icon;
							$data['menuhdr_id']		= $r->menuhdr_id;
							$data['column_group']	= $r->column_group;
						}
						
						$data['menuid'] = $menuid;						
						
						$this->template->display('general/utility/menu/edit_detail', $data);
						break;
					
					default :
						$menu = $this->M_User_Group->get_menu_union();
						$data['menu'] = $menu;
						$this->template->display('general/utility/menu/detail', $data);
						break;
				}
								
				break;
			
			case 'detailsub':
				$data['combo_menu_detail'] = $this->m_gen_menu->combo_menu_detail()->result();
				$data['falist'] = fa_list();
				$data['record'] = $this->m_gen_menu->record_menu_detailsub()->result();
				
				
				switch ($aksi){
					case 'edit':
//						$menuid = $this->uri->segment(5);
						
						$record_detail = $this->m_gen_menu->get_menu_detail($halaman, $menuid)->result();
						foreach ($record_detail as $r) {							
							$data['menudtlsub_id']		= set_value('txt_menuid', $r->menudtlsub_id);
							$data['menudtlsub_title']	= set_value('txt_menutitle', $r->menudtlsub_title);
							$data['menudtlsub_link']	= set_value('txt_menulink',$r->menudtlsub_link);
							$data['menudtlsub_icon']	= $r->menudtlsub_icon;
							$data['menudtl_id']			= set_value('txt_menudtlid', $r->menudtl_id);							
						}
						
						$data['menuid'] = $menuid;
						
						$this->template->display('general/utility/menu/edit_detailsub', $data);
						break;
					
					default :
						$menu = $this->M_User_Group->get_menu_union();
						$data['menu'] = $menu;
						$this->template->display('general/utility/menu/detailsub', $data);
						break;
				}
				
				break;

			default:
				break;
		}		
	}
	
	function menu_save($menutable){
		$this->_rules($menutable);		
		
		switch ($menutable) {
			case 'header':
				if ($this->form_validation->run() == FALSE) {
					$this->menu($menutable);
				} else {
					$info = array(
						'menuhdr_id'	=> $this->input->post('txt_menuid'),
						'menuhdr_title'	=> $this->input->post('txt_menutitle'),					
						'app_id'		=> $this->input->post('txt_appid'),
						'created_by'	=> strtoupper($this->session->userdata('userid_1')),
						'created_date'	=> date('Y-m-d H:i:s')
					);

					$success = $this->m_gen_menu->save($menutable, $info);

					if ($success){
						$message = pesan('Menu Header Berhasil Disimpan. ', pesan_sukses());
					} else {
						$message = pesan('Menu Header Gagal Disimpan. ', pesan_error());
					}

					$this->session->set_flashdata('message', $message);
					redirect('utility/menu/header');
				}

				break;
				
			case 'detail':
				if ($this->form_validation->run() == FALSE) {
					$this->menu($menutable);
				} else {
					$info = array(
						'menudtl_id'	=> $this->input->post('txt_menuid'),
						'menudtl_title' => $this->input->post('txt_menutitle'),
						'menudtl_link'	=> $this->input->post('txt_menulink'),
						'menudtl_icon'	=> $this->input->post('txt_menuicon'),
						'menuhdr_id'	=> $this->input->post('txt_menuhdrid'),
						'column_group'	=> $this->input->post('txt_columngroup'),
						'created_by'	=> strtoupper($this->session->userdata('userid_1')),
						'created_date'	=> date('Y-m-d H:i:s')
					);

					$success = $this->m_gen_menu->save($menutable, $info);

					if ($success){
						$message = pesan('Menu Detail Berhasil Disimpan. ', pesan_sukses());
					} else {
						$message = pesan('Menu Detail Gagal Disimpan. ', pesan_error());
					}

					$this->session->set_flashdata('message', $message);
					redirect('utility/menu/detail');
				}
				break;
				
			case 'detailsub':
				if ($this->form_validation->run() == FALSE) {
					$this->menu($menutable);
				} else {
					$info = array(
						'menudtlsub_id'		=> $this->input->post('txt_menuid'),
						'menudtlsub_title'	=> $this->input->post('txt_menutitle'),
						'menudtlsub_link'	=> $this->input->post('txt_menulink'),
						'menudtlsub_icon'	=> $this->input->post('txt_menuicon'),
						'menudtl_id'		=> $this->input->post('txt_menudtlid'),
						'created_by'		=> strtoupper($this->session->userdata('userid_1')),
						'created_date'		=> date('Y-m-d H:i:s')
					);

					$success = $this->m_gen_menu->save($menutable, $info);

					if ($success){
						$message = pesan('Menu Detail Submenu Berhasil Disimpan. ', pesan_sukses());
					} else {
						$message = pesan('Menu Detail Submenu Gagal Disimpan. ', pesan_error());
					}

					$this->session->set_flashdata('message', $message);
					redirect('utility/menu/detailsub');
				}

				break;

			default:
				break;
		}
	}
	
	function menu_update($menutable){
		$menuid = $this->input->post('txt_menuid');
		
		$this->_rules($menutable, 'edit');
		
		switch ($menutable) {
			case 'header':
				if ($this->form_validation->run() == FALSE) {
					$this->menu($menutable, 'edit', $menuid);					
				} else {
					$info = array(
						'menuhdr_title'	=> $this->input->post('txt_menutitle'),					
						'app_id'		=> $this->input->post('txt_appid'),
						'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
						'updated_date'	=> date('Y-m-d H:i:s')
					);

//					$menuid = $this->input->post('txt_menuid');

					$success = $this->m_gen_menu->update($menutable, $menuid, $info);

					if ($success){
						$message = pesan('Update Menu Header Berhasil.', pesan_sukses());
					} else {
						$message = pesan('Update Menu Header Gagal.', pesan_error());
					}

					$this->session->set_flashdata('message', $message);
					redirect('utility/menu/header');
				}
				break;
			
			case 'detail':
				if ($this->form_validation->run() == FALSE) {
					$this->menu($menutable, 'edit', $menuid);
				} else {
					$info = array(
						'menudtl_title' => $this->input->post('txt_menutitle'),
						'menudtl_link'	=> $this->input->post('txt_menulink'),
						'menudtl_icon'	=> $this->input->post('txt_menuicon'),
						'menuhdr_id'	=> $this->input->post('txt_menuhdrid'),
						'column_group'	=> $this->input->post('txt_columngroup'),
						'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
						'updated_date'	=> date('Y-m-d H:i:s')
					);

//					$menuid = $this->input->post('txt_menuid');

					$success = $this->m_gen_menu->update($menutable, $menuid, $info);

					if ($success === true){
						$message = pesan('Update Menu Detail Berhasil.', pesan_sukses());
					} else {
						$message = pesan('Update Menu Detail Gagal. ', pesan_error());
					}

					$this->session->set_flashdata('message', $message);
					redirect('utility/menu/detail');
				}
				break;
				
			case 'detailsub':
				if ($this->form_validation->run() == FALSE) {
					$this->menu($menutable, 'edit', $menuid);
				} else {
					$info = array(
						'menudtlsub_title'	=> $this->input->post('txt_menutitle'),
						'menudtlsub_link'	=> $this->input->post('txt_menulink'),
						'menudtlsub_icon'	=> $this->input->post('txt_menuicon'),
						'menudtl_id'		=> $this->input->post('txt_menudtlid'),
						'updated_by'		=> strtoupper($this->session->userdata('userid_1')),
						'updated_date'		=> date('Y-m-d H:i:s')
					);

//					$menuid = $this->input->post('txt_menuid');

					$success = $this->m_gen_menu->update($menutable, $menuid, $info);

					if ($success === true){
						$message = pesan('Update Sub Menu Detail Berhasil.', pesan_sukses());
					} else {
						$message = pesan('Update Sub Menu Detail Gagal. ', pesan_error());
					}

					$this->session->set_flashdata('message', $message);
					redirect('utility/menu/detailsub');
				}
				break;

			default:
				break;
		}
	}
	
	function menu_delete($menutable, $menuid){
		$this->m_gen_menu->delete($menutable, $menuid);
		$message = pesan('Hapus Menu Berhasil.', pesan_sukses());
		$this->session->set_flashdata('message', $message);
		redirect(site_url('utility/menu/'.$menutable));
	}
	
	function _rules($menutable, $aksi = null)
	{		
		$this->form_validation->set_rules('txt_menuid', 'menu ID', 'required');		
		$this->form_validation->set_rules('txt_menutitle', 'menu title', 'required');
		
		switch ($menutable) {
			case 'header':
				$this->form_validation->set_rules('txt_appid', 'application group', 'required');
				break;
			
			case 'detail':
				$this->form_validation->set_rules('txt_menuhdrid', 'header menu', 'required');
				break;
			
			case 'detailsub':
				$this->form_validation->set_rules('txt_menudtlid', 'header menu', 'required');
				$this->form_validation->set_rules('txt_menulink', 'menu link', 'required');
				break;

			default:
				break;
		}
		
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
	
}