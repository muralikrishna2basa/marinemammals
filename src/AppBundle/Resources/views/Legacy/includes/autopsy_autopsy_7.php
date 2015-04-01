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

<h3>R&eacute;f&eacute;rences</h3>

<p>DIERAUF L. A., Hanbook of marine mammals medicine : health, disease, and rehabilitation.   CRC Press, second edition Boca Raton, 2001.</p>

<p>GERACI J. R. & LOUNSBURY V. J. Marine mammals ashore a field guide for strandings. Texas A&amp;M sea grant publication, Second edition, Galveston, 2005, p. 133.</p>

<p>JACQUES T. & LAMBERTSEN R. eds Sperm whale deaths in the North Sea : Science and Management, Bulletin de l'Institut Royal des Sciences Naturelles de Belgique, Biologie, vol. 67 - suppl&eacute;ment, 1997.</p>

<p>Jauniaux T., Garcia Hartmann M., Haelters J., Tavernier J. & Coignoul F. Echouage de mammif&egrave;res marins : guide d'intervention et proc&eacute;dures d'autopsie. Annales de M&eacute;decine V&eacute;t&eacute;rinaire, 2002, 146, 261-276.</p>

<p>Jauniaux T., Bouquegneau J.-M. & Coignoul F . eds, Marine Mammals, Seabirds and Pollution of Marine Systems, Presse de la Facult&eacute; de M&eacute;decine V&eacute;t&eacute;rinaire, Universit&eacute; de Li&egrave;ge, Li&egrave;ge, 1997.</p>

<p>KUIKEN T. & GARC&iacute;A HARTMANN M. Proceedings of the first ECS workshop on Cetacean pathology: dissection techniques and tissue sampling. ECS Newsletter #17 Special issue, 1991.</p>

<p>LAW R. J. (compiler) Collaborative UK Marine Mammal Project : summary data produced 1988-1992, Fisheries Research Technical Report n&deg; 97, Ministry of Agriculture, Fisheries and Food Directorate of Fisheries Research, Lowestoft, 1994.</p>

<p>LOCKYER C., Body composition of the sperm whales Physeter macrocephalus, with special reference to the possible functions of fat depots.   Rit Fiskideilar Journal of the Marine Research Institute Reykjavik, 12: 1-24.</p>

<p>REYNOLD, J. E. & ODELL D. K., Proceedings of the second marine mammal stranding workshop, NOAA technical report NMFS 98, U.S. Department of commerce, 1991. </p>

</div>

<?php

$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>