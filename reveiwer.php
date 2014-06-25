<?php

add_filter('get_comment_author_link','display_commenter_info');

function display_commenter_info($return){
	global $comment;
	$ua = $comment->comment_agent;
	$ip = $comment->comment_author_IP;
	if(!$ip){return $return;}
	
	$reviewers_info = analyse_user_agent($ua);
	//Display style. You can edit.
	return $return.' was using &nbsp;<img src="' .get_bloginfo('url'). '/browser/' .$reviewers_info['os_icon']. '.png" title="'.$reviewers_info['os'].'" alt="'.$reviewers_info['os'].'"/>&nbsp;'.$reviewers_info['os'].' and ' . '<img src="' .get_bloginfo('url'). '/browser/' .$reviewers_info['browser_icon']. '.png" title="'.$reviewers_info['browser'].'" alt="'.$reviewers_info['browser'].'"/>&nbsp;'.$reviewers_info['browser'].'';
}



function analyse_user_agent($str){
	$str = strtolower($str);
	
	if(strpos($str,'msie') !== false){ //IE
	
		$pattern = '/msie ([0-9a-z\.]+);/';
		preg_match($pattern,$str,$versions);
		$version = $versions[1]; //IE VERSION
		
		//Based on IE
		$result['browser_base'] = 'ie';
		
		if(strpos($str,'maxthon') !== false){ // MAXTHON
			$result['browser_icon'] = 'maxthon';
			
			if(strpos($str,'maxthon 2.0') !== false){ // MAXTHON 2.0
				$subversion = '2.0';
			}else{ //MAXTHON 1.0
				$subversion = '1.0';
			}
			
			$result['browser'] = "Maxthon $subversion based on IE $version";
			
		}elseif(strpos($str,'theworld') !== false){ //The World
		
			$result['browser_icon'] = 'theworld';
			$result['browser'] = "TheWorld based on IE $version";
			
		}elseif(strpos($str,'greenbrowser') !== false){ // GreenBrowser
		
			$result['browser_icon'] = 'greenbrowser';
			$result['browser'] = "GreenBrowser based on IE $version";
			
		}elseif(strpos($str,'tencenttravel') !== false){ // TT
		
			$result['browser_icon'] = 'tencenttravel';
			$result['browser'] = "TencentTravel based on IE $version";
			
		}else{
		
			$result['browser_icon'] = 'ie';
			$result['browser'] = "Internet Explorer $version";
			
		}
		
	}elseif(strpos($str,'firefox') !== false){ //Firefox
	
		$pattern = '/firefox\/([A-Za-z0-9\.\-_]+)/';
		preg_match($pattern,$str,$versions);
		$version = $versions[1]; //Firefox VERSION
		$result['browser_base'] = 'firefox';
		$result['browser_icon'] = 'firefox';
		$result['browser'] = "Firefox $version";
		
	}elseif(strpos($str,'opera') !== false){ //Opera
	
		$pattern = '/opera\/([A-Za-z0-9\.\-_]+)/';
		preg_match($pattern,$str,$versions);
		$version = $versions[1]; //OPERA VERSION
		
		$result['browser_base'] = 'opera';
		$result['browser_icon'] = 'opera';
		$result['browser'] = "Opera $version";
		
	}elseif(strpos($str,'chrome') !== false){ //Chrome
	
		$pattern = '/chrome\/([A-Za-z0-9\.\-_]+)/';
		preg_match($pattern,$str,$versions);
		$version = $versions[1]; //Chrome VERSION
		
		$result['browser_base'] = 'chrome';
		$result['browser_icon'] = 'chrome';
		$result['browser'] = "Google Chrome $version";
		
	}elseif(strpos($str,'webkit') !== false){ //Safari
		
		$pattern = '/version\/\\s?([\\d\\.]+)/';
		preg_match($pattern,$str,$versions);
		$version = $versions[1]; //SAFARI VERSION
		
		if(strpos($str,'maxthon') !== false){ // MAXTHON
			$result['browser_icon'] = 'maxthon3';
			
			if(strpos($str,'maxthon 3.0') !== false){ // MAXTHON 3.0
				$subversion = '3.0';	
			}
			$result['browser'] = "Maxthon 3.0";
			
		}elseif(strpos($str,'webkit') !== false){ // SAFARI
			$result['browser_icon'] = 'safari';
			$result['browser'] = "Safari $version";
		}
	}else{
		$result['browser_base'] = 'other';
		$result['browser_icon'] = 'other';
		$result['browser'] = 'Unknow';
	}
	
	
	if(strpos($str,'windows') !== false || strpos($str,'win') !== false){
		
		$result['os_base'] = 'windows';
		$result['os_icon'] = $result['os_base'];
		
		if(strpos($str,'windows nt 5.1') !== false){
			$result['os'] = 'Windows XP';
		}elseif(strpos($str,'nt 5.0') !== false){
			$result['os'] = 'Windows 2000';
		}elseif(strpos($str,'nt 5.2') !== false){
			$result['os'] = 'Windows Server 2003';
		}elseif(strpos($str,'win 9x 4.90') !== false){
			$result['os'] = 'Windows Me';
		}elseif(strpos($str,'win98') !== false){
			$result['os'] = 'Windows 98';
		}elseif(strpos($str,'win95') !== false){
			$result['os'] = 'Windows 95';
		}elseif(strpos($str,'windows 98') !== false){
			$result['os'] = 'Windows 98';
		}elseif(strpos($str,'windows me') !== false){
			$result['os'] = 'Windows Me';
		}elseif(strpos($str,'nt 6.0') !== false){
			$result['os_base'] = 'vista';
			$result['os_icon'] = $result['os_base'];
			$result['os'] = 'Windows Vista';
		}elseif(strpos($str,'nt 6.1') !== false){
			$result['os_base'] = 'seven';
			$result['os_icon'] = $result['os_base'];
			$result['os'] = 'Windows 7';
		}elseif(strpos($str,'nt 6.2') !== false){
			$result['os_base'] = 'eight';
			$result['os_icon'] = $result['os_base'];
			$result['os'] = 'Windows 8';
		}else{
			$result['os'] = 'Windows other version';
		}
		
	}elseif(strpos($str,'mac') !== false){
		
		$result['os_base'] = 'mac';
		$result['os_icon'] = $result['os_base'];
		$result['os'] = 'Mac OS X';
		if(strpos($str, 'iPhone') !== false) {
			$pattern = '/iPhone\/([.\_0-9a-zA-Z]+)/';	
			preg_match($pattern,$str,$versions);
			$version = $versions[1];
			
			$result['os'] = 'iPhone OS';
			$result['os_icon'] = 'iphone';
		}
		
	}elseif(strpos($str,'linux') !== false){
		
		$result['os_base'] = 'linux';
		if(strpos($str,'ubuntu') !== false){
			$result['os'] = 'Ubuntu';
			$result['os_icon'] = 'ubuntu';
		}elseif(strpos($str,'debian') !== false){
			$result['os'] = 'Debian';
			$result['os_icon'] = 'debian';
		}elseif(strpos($str,'red hat') !== false){
			$result['os'] = 'Red Hat';
			$result['os_icon'] = 'linux';
		}else{
			$result['os'] = 'Linux';
			$result['os_icon'] = 'linux';
		}
		
	}else{
		
		$result['os_base'] = 'other';
		$result['os_icon'] = $result['os_base'];
		$result['os'] = 'Unknow';
		
	}
	return $result;
}

?>