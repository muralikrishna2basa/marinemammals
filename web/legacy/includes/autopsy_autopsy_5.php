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

<h3>Pinnipeds</h3>

<p>Most of pinnipeds within European waters can be easily transportable and necropsy can be organized in good facilities such as dissection and necropsy rooms.</p>

<p>Particularities and differences for pinnipeds necropsy are presented hereafter.</p>

<h3>External examination</h3>

<p>Body lengths (see annex ) are measured by placing tape next to the carcass (laying ventrally) in a straight line parallel to the longitudinal body axis.   The total body length is taken from most cranial point of the head to the extremity of the hind flipper. The blubber thickness is measured dorsally after skin and blubber incision.</p>

<p>As for cetacean, the penis is not visible and should be examined and sampled as described here in before.</p>

<h3>Abdominal and thoracic cavity opening</h3>

<p>Seals are laying <span id="dorsally">dorsally</span> before opening cavities. A first incision is made along the ventral midline from the intermandibular space to the anus and two incision from the xiphoid process of the sternum to the foreflipper (V-incision). Flap of skin and subcutaneous tissues are removed. Abdominal cavity is opened along the hypochondrium and after by two backward incision along dorsal muscles. Ribs are cut or sawed at mid-height and the thoracic breastplate is removed. A rib can be collected for toxicology. Such opening allows to have a general overview of the topography and the organs in situ.</p>

<p>The examination of <span id="thoracic1">abdominal and thoracic organs</span> and samplings of procedure are similar to what it is described in the general procedure. The stomach is single.</p>

<h3>Neck and head</h3>

<p>After examination and sampling of tissues in the neck area (tongue, esophagus, trachea, thyroid, thymus), the head is separated from the rest of the body by dissection of the atlanto-occipital articulation. The lower jaw is separated and a canine tooth is collected and stored frozen for age determination.
Brain or central nervous system tissue</p>

<p>If spinal cord sample is necessary (histology or microbiology), it can be collected after the head separation within the atlas vertebrae. To have access to the brain, the skull is sawed longitudinally. Nostril and air passage can be examined for the presence of parasite, liquid or foam. The pituitary gland (mid-ventral part of the brain, in the Sella turcica ) is sampled separately for histology. A complete cerebral hemisphere is collected for histology while the other hemisphere is sampled for virology, toxicology and bacteriology.</p>

</div>

 <div class="box_left">

<div class="pictures_box">
<a href='#dorsally' class='slimbox'><img src="/img/webimg/dorsally.jpg"alt="dorsally.jpg" ></img></a>
<a href='/img/webimg/dorsally.jpg' rel='lightbox' style='display:none;'></a>
</div>

<div class="pictures_box">
<a href='#thoracic' class='slimbox'><img src="/img/webimg/abdominal and thoracic1.jpg"  alt="abdominal and thoracic1.jpg"></img></a>
<a href='/img/webimg/abdominal and thoracic1.jpg' rel='lightbox' style='display:none;'></a>
</div>

<div class="pictures_box">
<a href='#thoracic1' class='slimbox'><img src="/img/webimg/abdominal and thoracic2.jpg"  alt="abdominal and thoracic2.jpg" ></img></a>
<a href='/img/webimg/abdominal and thoracic2.jpg' rel='lightbox' style='display:none;'></a>
</div>

<div class="pictures_box">
<a href='#thoracic' class='slimbox'><img src="/img/webimg/abdominal and thoracic3.jpg"  alt="abdominal and thoracic3.jpg" ></img></a>
<a href='/img/webimg/abdominal and thoracic3.jpg' rel='lightbox' style='display:none;'></a>
</div>


</div>

<?php

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>