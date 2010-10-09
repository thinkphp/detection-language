<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Making Twitter multilingual with a hack of the Google Translation API</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
   <style type="text/css">
   #ft{font-size:80%;color:#111;text-align:left;margin:2em 0;font-size: 12px}
   #ft p a{color:#393;}
   html,body{font-family: georgia,helvetica,arial,sans-serif,verdana;color: #000;font-size: 15px}
   h1{background:none repeat scroll 0 0 #447E40;color:#FFFFFF;padding:14px;text-align:left;font-size: 20px;-moz-border-radius:5px;-border-radius:5px;-webkit-border-radius:5px;}
   .en{color: #0000ff}
   ul li span {font-weight: bold}
   </style>
</head>
<body>
<div id="doc2" class="yui-t7">
   <div id="hd" role="banner"><h1>Adding natural language attributes to a twitter feed using the Google translation API</h1></div>
   <div id="bd" role="main">
	<div class="yui-g"><ul>   
<?php

$url = 'http://twitter.com/statuses/public_timeline.rss';

$twitterdata = get($url);

preg_match_all("/<description>([^<]+)<\/description>/msi",$twitterdata,$descriptions);

$descriptions[1] = preg_replace("/^([\w]+)\:/","<strong>$1</strong>",$descriptions[1]);

foreach($descriptions[1] as $key=>$desc) {

     if($key == 0) {
             continue;
     }

     //assemble REST call and curl the result
     $url = 'http://www.google.com/uds/GlangDetect?callback=' .
            'feedresult&context='. $key  . '&q=' . urlencode($desc) . 
             '&key=notsupplied&v=1.0';

     //get the language
     $language = get($url);

     preg_match("/\"language\":\"([^\"]+)\"/",$language,$resp);

     echo" <!-- ";
     print_r($language); 
     echo' -->';

     //write out the list item
     echo'<li class="'.$resp[1].'">'.$desc.' is <span>'.$resp[1].'</span></li>';


}


function get($url) {
     $ch = curl_init();
     curl_setopt($ch,CURLOPT_URL,$url);
     curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
     curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
     $data = curl_exec($ch);
     curl_close($ch);
     if(empty($data)) {return 'Error Sytem!';}
               else {return $data;}
}

?>
	</ul>
        </div>
	</div>
<div id="ft" role="contentinfo"><p>Created by <a href="http://thinkphp.ro">Adrian Statescu</a> | follow me @<a href="http://twitter.com/thinkphp">thinkphp</a> using YUI and <a href="http://code.google.com/apis/ajaxlanguage/documentation/reference.html">Google Translation API</a> | <a href="index.phps">source</a></p></div>
</div>
</script>
</body>
</html>
