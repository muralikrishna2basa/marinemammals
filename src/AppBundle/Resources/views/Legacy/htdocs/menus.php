<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Menus list </title>
<style>
 body { margin:0; padding:0; border:0;width:100%;background:#E6E6E6;font-size:90%;width:85%;margin-left:auto;margin-right:auto;}
 h2 {padding-top:30px;}
 
div.main_menu {padding:0;background:#96CBCA url(img/tmp.png) top repeat-x;font-family:Verdana, sans-serif;height:40px;border-top:1px solid #12316a;
border-left:1px solid #12316a;border-bottom:1px solid #12316a;
}
 
div.main_menu ul {margin:0;padding:0;list-style:none;position:relative;text-align:center;overflow:hidden;margin-left:150px;}
 
div.main_menu ul li {float:left;list-style:none;margin:0;padding:0;position:relative;}

 div.main_menu ul li a {display:block;margin:0;padding:20px 10px 6px 10px;
           text-decoration:none;color:white;font-size:.8em;font-weight:bold;text-transform:uppercase;line-height:1.3em;}
 
 div.main_menu ul li a:hover {color:#00008c;background:#96CBCA url(img/tmp_hover.png) top repeat-x;border-left:1px solid #fff;padding-top:18px;padding-bottom:8px;}
 
 div#banner {padding:0;margin-top:50px;background:#96CBCA url(img/banner_tmp2-1-200.png) top repeat-x;width:100%;font-family:Verdana, sans-serif;height:200px;overflow:hidden;}
div#banner_transparency { height:100%;width:100%;}
div#banner_signin { float:right;margin-right:5px;background-color:transparent;width:300px;height:65px; margin-top:120px;padding:5px;}

form#signin_form{     overflow:hidden;width:100%;}
form#signin_form div.formsection {	float:left;width:100%;margin-bottom:0.3em;}
form#signin_form label {	float:left;width:25%; margin-top:.4em;color:#000;font-size:.8em; margin-left:20px;
             font-family: "Adobe Caslon Pro", "Hoefler Text", Georgia, Garamond, Times, serif;
color:#12316a;font-weight: bold;}
form#signin_form div.formsection input.submit { color:#12316a;}
div#banner_partner { float:left;margin-left:20px;margin-top:20px;}
div#banner_ulg {float:left;background:transparent url(img/tmp_ulg_tr80.png) top no-repeat;height:80px;width:74px;margin-top:50px;margin-left:160px;}
div#banner_ugmm{width:107px;height:80px;background:transparent url(img/MUMM-rgb.png) top no-repeat;margin-top:50px;margin-left:20px;}
div#banner div.title {font-family: "Century Schoolbook", Georgia, Times, serif;color: #12316a;position:absolute;top:50px;left:52%;}

div#Layout_footer {width:85%; margin:0 auto; bottom:0;font-size:11px;height:25px;padding:0;position:fixed;z-index:99;}
div#Layout_header {height:235px;z-index:-1;}
div#Layout_content,div#Layout_navigation,div#Layout_container  {min-height:600px;padding-top:15px;}
div#Layout_navigation {width:150px;float:left;}


div#Layout_content {background-color:white;border-left:1px solid #12316a;border-right:1px solid #12316a;}
div#Layout_navigation {background-color:#F0F8FF;border-left:1px solid #12316a;}
div#Layout_header,div#Layout_footer  {background:#96CBCA url(img/tmp.png) top repeat-x;}

div#Layout_footer { font-weight:bold;}
div#Layout_footer div.footer_ulg { float:right;color:white;margin:0 0 0 10px;}
div#Layout_footer div.footer_ugmm {float:left;color:white;margin:0 0 10px 0;}

div#Layout_navigation ul { padding:0;text-align:center;}
div#Layout_navigation ul li { width:100%;list-style:none;height:30px;}
</style>
</head>
<body>
<div id = "banner">
<div id = "banner_transparency">
<div id="banner_partner">
<a href ="http://www.ulg.ac.be"><div id = "banner_ulg"></div></a>
<a href="http://www.mumm.ac.be"><div id = "banner_ugmm"></div></a>
</div>
<div class="title">
<h1>Marine Mammal</h1>
<h3>Observation, Stranding & Sample library</h3>
</div>
<div id = "banner_signin">
<form id = "signin_form">
<div class = "formsection">
<label for='sign_in_username'>User Name</label>
<input id='sign_in_username' type='text' name='login' size='10'></input>
</div>
<div class = "formsection">
<label for='sign_in_password'>Password</label>
<input id='sign_in_password' type='password' name='password' size='10'></input>
<input class = submit type='submit' value='Sign-in'></input>
</div>
</form>
</div>
</div>
</div>
<div class='main_menu'>
<ul>
<li><a href ="#">Home</a></li>
<li><a href ="#">Observations</a></li>
<li><a href ="#">Biobank</a></li>
</ul>
</div>
<div id = "Layout_navigation">
<ul>
<li><a href="Observations">General</a></li>
<li><a href=""> Samples search</a></li>
<li><a href="">Agreement</a></li>
</ul>
</div>
<div id="Layout_content"></div>
<div id="Layout_footer">
<div class="footer_ugmm">
<p>Unité de Gestion du Modèle Mathématique de la mer du Nord</p>
</div>
<div class ="footer_ulg"><p>Université Libre de Liège</p></div>

</div>
</body>
</html>