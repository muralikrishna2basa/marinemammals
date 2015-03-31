<?php
/**
 *   Include File
 *   Autopsy test file
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:22/03/2010 
 */
ob_start();

?>

<div class="autopsy">

<h3>Introduction</h3>

<p>Single or mass strandings of whales and dolphins have always intrigued people and must have occurred from the time cetaceans have been 
present in the oceans. Seals, having also a terrestrial behaviour, are well known and perhaps less intriguing. Mass stranding can be defined 
as an event where two or more animals run ashore alive at roughly the same place and time. Many theories have attempted to explain that phenomenon. 
In most cases, it cannot be attributed to a single cause, but is the result of a complex interaction of physical and biological factors such as 
ocean currents, tides and coastal configuration, the animals' migratory and social behavior, food availability, echolocation or orientation failure,
 and diseases which have debilitating effects.</p>

<p> All those considerations must be taken into account for the evaluation of the cause of the 
 stranding. Emergence of new diseases such as morbillivirus-related or new theories of strandings such as linked with anthropogenic activities 
 (pollution, sonar) justify to perform post-mortem evaluation of all stranded animals and multidisciplinary investigations to understand the process, 
 the health status of marine mammals population.</p>
 
 <p>The aim of the present document is to provide a guideline for post-mortem investigations for marine mammal necropsies 
 (cetaceans and seals) while the necropsy worshop (third edition in 2009) should be considered as a training to dissect marine mammals placing 
 emphasis on the cetaceans inner ear extraction and fixation. </p>
 
 </div>
 
  <div class="box_left">

<div class="pictures_box">
	<a href='#reference' class='slimbox'>
		<img src="/img/Photo/DSC_0001.JPG"alt="DSC_0001.JPG" ></img>
	</a>
	<a href='/img/Photo/DSC_0001.JPG' rel='lightbox' style='display:none;'></a>
</div>

<div class="pictures_box">
	<a href='#reference' class='slimbox'>
		<img src="/img/Photo/DSC_0002.JPG"  alt="DSC_0002.JPG"></img>
	</a>
	<a href='/img/Photo/DSC_0002.JPG' rel='lightbox' style='display:none;'></a>
</div>

<div class="pictures_box">
	<a href='#mouth' class='slimbox'>
		<img src="/img/Photo/DSC_0003.JPG"  alt="DSC_0003.JPG" ></img>
	</a>
	<a href='/img/Photo/DSC_0003.JPG' rel='lightbox' style='display:none;'></a>
</div>





</div>
 
<?php

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>