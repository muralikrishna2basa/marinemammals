<?php
/**
 *   Include File
 *   Release Observations Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();

include_once(Functions.'Fixcoding.php');

?>
<div class ='home_observation'>
<h3> The Belgian marine mammal database</h3>

<p>
This website contains information about marine mammals in Belgium: from sightings to strandings and the results of scientific research.  
It includes data about dolphins, whales and seals from Belgian waters, but also some data from neighbouring countries (France, the Netherlands) is included. </p>

<p>
The marinemammals.be database was set up as a joint venture between the Royal Belgian Institute of Natural Sciences (RBINS), department Management Unit of the North Sea Mathematical Models (MUMM), and the department of Veterinary Pathology (VP) of the University of Li&egrave;ge. 
RBINS coordinates, together with the department Veterinary Pathology of the University of Li&egrave;ge, the Marine Animals Research and Intervention Network (MARIN), that deals with the scientific research of stranded and bycaught marine mammals.  Besides the RBINS and the Univesity of Li&egrave;ge, other scientific institutes, administrations and volunteers throughout Belgium play a role in this network.
</p>

<p> 
Collecting data on strandings and sightings of marine mammals is important; such data can can provide us with a lot of information about marine mammals, their population trends, problems they face, and eventually on the condition of the marine environment in general.  
Until some decades ago, only few data were collected from stranded animals.  Nowadays, full necropsies are performed, and tissue samples are collected for research purposes.
</p>
<p>
Two access levels exist in this website:  
</p>
<ul class='txt_list'>
<li>An open access level, with contains the data on strandings and observations in which the general public will be interested.</li>
<li>A restricted access level, that leads to the tissue collection; the data available here will mostly be of interest to researchers; information is presented about the availability of tissue samples for dedicated research purposes, and the way to obtain these. </li>
</ul>

<p>The main contents of the different web pages are:</p>

<ul class='txt_list'>
<li>(Open access): Observations and strandings of marine mammals in Belgium; queries can be made of species, year, circumstances, etc.  Pictures and video images are available in some cases.
</li>
<li>
(Open access): A description of the methodology for the post-mortem investigation of stranded and bycaught animals.
</li>
<li>
(Restricted access): The tissue bank page provides for access to more than 25.000 (mostly) tissue samples taken from marine mammals. Queries can be performed for species, type of tissue, method of storage, etc.  In order to access this page, you need to be a registered user.
</li>
<!--<li>
Register page gives the access the scientific level necessary to order data or samples. 
When registered first time, the register page is replaced by the user page.
</li>-->
</ul>

<!--<p>The Royal Belgian Institute of Natural Sciences (RBINS) is famous for its museum, and the extensive collection of whale skeletonds.  Its Department Management Unit of the North Sea Mathematical Models (MUMM) collects all stranding and sighting records in a database dating back to the middle ages. Part of the database can be consulted online: all strandings since 2000, and the most remarkable sightings.</p>

<p>MUMM also coordinates an intervention network dealing with the scientific research of stranded and bycaught marine mammals.  This research focuses on the problems encountered by these animals, such as pollution and
overfishing, but can also put more light on ecology and life history aspects of the populations. Next to this, MUMM investigates effects on marine mammals of human activities at sea, such as the construction of offshore windfarms.</p>

<p>MUMM is the competent authority in the national legislation specifically
protecting certain marine mammal species (Royal Decree of 21 December 2001).
Protecting these magnificent creatures is a commitment, or even an obligation in the framework of international conventions and treaties Belgium adheres to, such as the European Habitats Directive, ASCOBANS and the OSPAR Convention. </p>

<p>The protection status means that these animals may not be disturbed on purpose, and may not be caught or killed.  Stranded or bycaught animals need to be notified to the authorities.</p>

<p>In case you observe a seal or a dolphin, or a group of them, you can notify this to MUMM by <a href='mailto:dolphin@mumm.ac.be'>email</a>. In case of strandings you can contact a local authority (police or fire brigade). Live stranded seals - in difficulty - are being dealt with by SeaLife Blankenberge.</p>  
-->
<div class='video'>
<object type="application/x-shockwave-flash" data="video/player_flv_maxi.swf" width="320" height="240">
	<param name="wmode" value="transparent"></param>
	<param name="movie" value="video/player_flv_maxi.swf"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="FlashVars" value="flv=echouage2.flv&showfullscreen=1"></param>
</object>
<!--
<object type="application/x-shockwave-flash" data="video/player_flv.swf" width="320" height="240">
	<param name="movie" value="video/player_flv.swf" />
	<param name="allowFullScreen" value="true" />
	<param name="FlashVars" value="flv=echouage_marsouin.flv" />
</object>-->
</div>
</div>
<?php
//echo "<br>internal decoding : ".mb_internal_encoding("UTF-8");
//echo "<br>internal decoding : ".mb_internal_encoding();
//$db = $Layout->getDatabase();
//
//$sql = "select RV_ABBREVIATION from cg_ref_codes where rv_domain = 'CONSERVATION_MODE'";
//
//$res = $db->query($sql);
//
//while($row = $res->fetch())
//{
//	echo mb_detect_encoding($row['RV_ABBREVIATION'])==false?'problem':mb_detect_encoding($row['RV_ABBREVIATION']);
//}
//
//$test = "°";
//echo '<br> test '.$test.'<br>';
//
//echo mb_detect_encoding('20°C')==false?'problem':mb_detect_encoding('20°C');

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>