<?php

class Pagination {
		public function pagination_links($data, $per_page, $current_page){
			$no_of_pages =ceil( ($data)/ $per_page );
			//
			$itemsINCurrPage = 0;

			//
			$page_prev = ($current_page == 1 || (!isset($current_page)))? 1 :( $current_page -1) ;
			$page_next = ($current_page == $no_of_pages )? $no_of_pages :( $current_page + 1) ;

			//Grab current page url and filter
			$isSecured = 'http://';
			if(isset($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] == 'on'){
				$isSecured = 'https://';
			}
			$currentPageURL = $isSecured.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			//echo $currentPageURL;exit();

			//-Previous Link
			$customPreLink = str_replace('/page/'.$current_page, '', $currentPageURL).'/page/'.$page_prev;

			//-Next Link
			$customNextLink = str_replace('/page/'.$current_page, '', $currentPageURL).'/page/'.$page_next;

			//TO-DO
			$linkStatus = '';
			if(($page_prev == $current_page)){
				$linkStatus = 'btn disabled';
			}
			else{				
				$linkStatus = '';
			}


			$linkStatus2 = '';
			if(($page_next == $current_page)){
				$linkStatus2 = 'btn disabled';
			}
			else{				
				$linkStatus2 = '';
			}



			$showFromTo = '';//"<li class='page-item pull-left ' style='padding: 5px 20px;'>Showing  $itemsINCurrPage of ".count($data)." entries</li>";
			$prev_page = "<li class='page-item'><a class='page-link $linkStatus' href='$customPreLink'>Prev</a></li>";
			$next_page = "<li class='page-item'><a class='page-link $linkStatus2' href='$customNextLink'>Next</a></li>";

			//
			$link = '';
			for ($i=1; $i <= $no_of_pages; $i++) { 

				if($current_page == $i){ 
					$active = 'btn active disabled';
				}elseif(!  isset($current_page) && ($i == 1)) { 
					$active = 'btn active disabled';
				}else{ 
					$active = '';
				}

				//-Pages Link
				$customPageLink = str_replace('/page/'.$current_page, '', $currentPageURL).'/page/'.$i;

				$link .= "<li class='page-item $active'><a class='page-link' href='$customPageLink'>$i</a></li>";
			}

			$link = $showFromTo.$prev_page.$link.$next_page;
							
			return  $link ;
		}

		public function adminPagLinks($data, $per_page, $current_page){
			$no_of_pages =ceil( ($data)/ $per_page );
			//
			$itemsINCurrPage = 0;

			//
			$page_prev = ($current_page == 1 || (!isset($current_page)))? 1 :( $current_page -1) ;
			$page_next = ($current_page == $no_of_pages )? $no_of_pages :( $current_page + 1) ;

			//Grab current page url and filter
			$isSecured = 'http://';
			if(isset($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] == 'on'){
				$isSecured = 'https://';
			}
			$currentPageURL = $isSecured.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			//echo $currentPageURL;exit();

			//-Previous Link
			$customPreLink = str_replace('/page/'.$current_page, '', $currentPageURL).'/page/'.$page_prev;

			//-Next Link
			$customNextLink = str_replace('/page/'.$current_page, '', $currentPageURL).'/page/'.$page_next;

			//TO-DO
			$linkStatus = '';
			if(($page_prev == $current_page)){
				$linkStatus = 'btn disabled';
			}
			else{				
				$linkStatus = '';
			}


			$linkStatus2 = '';
			if(($page_next == $current_page)){
				$linkStatus2 = 'btn disabled';
			}
			else{				
				$linkStatus2 = '';
			}



			$showFromTo = '';//"<li class='page-item pull-left ' style='padding: 5px 20px;'>Showing  $itemsINCurrPage of ".count($data)." entries</li>";
			$prev_page = "<li class='page-item'><a class='page-link $linkStatus' href='$customPreLink'>Prev</a></li>";
			$next_page = "<li class='page-item'><a class='page-link $linkStatus2' href='$customNextLink'>Next</a></li>";

			//
			$link = '';
			for ($i=1; $i <= $no_of_pages; $i++) { 

				if($current_page == $i){ 
					$active = 'btn active disabled';
				}elseif(!  isset($current_page) && ($i == 1)) { 
					$active = 'btn active disabled';
				}else{ 
					$active = '';
				}

				//-Pages Link
				$customPageLink = str_replace('/page/'.$current_page, '', $currentPageURL).'/page/'.$i;

				$link .= '';//"<li class='page-item $active'><a class='page-link' href='$customPageLink'>$i</a></li>";
			}

			$link = $showFromTo.$prev_page.$link.$next_page;
							
			return  $link ;
		}
	}
?>