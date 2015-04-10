<?php
/**
 *   Include File
 *   Description Biobank Home Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER : De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();
?>
<h3>A marine mammal tissue collection</h3>

<p>The Belgian Marine Mammal Tissue Bank (BMMTB) was set up in 1990. It originally contained tissue samples from marine mammals washed ashore and bycaught in Belgium. Through a collaboration, since 1995, with stranding networks in neighbouring countries, tissue samples from animals that washed ashore in northern France and in The Netherlands were added. Similar collections exist in the United Kingdom, Ireland and Germany.</p>

<p>The goal of the BMMTB is to provide high quality tissue samples of marine mammals (small and large cetaceans, as well as pinnipeds) for dedicated research purposes, both in the near and in the distant future. The tissue bank, and the web application you are currently using, can be considered as a tool to facilitate such dedicated research.  This initiative, and similar initiatives in other countries, can allow for more efficient studies of regional and temporal variations in life history, ecology, toxicology and pathology of marine mammals. </p>
 
<p>The tissues in the BMMTB were collected, fixed and stored according to protocols established by the European Cetacean Society (ECS); the earlier samples were collected, fixed and stored in a similar way. They are stored at the Royal Belgian Institute of Natural History (RBINS), Brussels and Ostend, and at the University of Li&egrave;ge, Department of Morphology and Pathology. The BMMTB is continuously fed with samples from animals washed ashore in Belgium, northern France and The Netherlands. </p>


<p>Information about the collection and the use of samples will be distributed on a yearly basis. Whenever possible, results of the investigations, in the form of reports of publications, will be communicated.</p>


<!--
<p>The Belgian Marine Mammal Tissue sample collection was set up in has started in 1990. T and through a t collaborations, since 1995, with French and Dutch stranding networks, ance and the Netherlands, the sample collection extended to marine mammal tissue samples from the Dutch coast to the northern French coast.the continental coastline of the Southern North Sea. Similar collections are existing in for the United Kingdom, Ireland and, Germany.</p>
<p>The goal of the Belgian Marine Mammal Tissue Bank (BMMTB) is to provide high quality tissue samples of marine mammals (small and large cetaceans, as well as pinnipeds) for research purposes only, inupon a non-profit scientific collaboration (see the agreement). The tissues bank should be considered also as a tool to facilitate tissuesamples exchange:, scientists and contributor can request tissues from the BMMTB following their priority selection criteria (selection by species, area, age, sex, tissues, lesions, year, cause of death and conservation procedure). This initiative, and similar initiatives in other countries, can allow for more efficient studies of regional variations in life history, ecological, toxicological or pathology studies of marine mammals. Given that some of the tissues were already collected in the early 1990s, temporal trends can be investigated.</p>
 
<p>In addition, up to now, stranding networks in Europe were collecting samples but, most of the time, only part of tissues is used, the rest being long-term stored or destroyed. For example, for histopathology, tissue samples of 1 cm 3 or more are fixed in formalin but only 3 mm slide is necessary. Gathering samples of marine mammals from various European areas will also help to have a geographical overview and will highlight regional variations. Some samples being in collection since 1990, temporal evolution and trends can be investigated.</p>
<p>Marine mammals are necropsied and tissues are collected, fixed and stored following protocols established byof the European Cetacean Society (ECS). Tissues are stored at the Royal Belgian Institute of Natural History (RBINS), Management Unit of the North Sea department (Belgium) and at the University of Liege, Department of Morphology and Pathology, University of Liege (Belgium). Samples may be used for retrospective studies in pathology, microbiology, toxicology, life history, ...</p>

<p>The collection of the BMMTB is maintained, and continuously supplied with samples feed throughby collaborations between national stranding networks in Belgium, northern France and The Netherlands. Information will be distributed on a yearly basis on  People will be informed every year (annual report on the state of the BMMTB ) about tthe use of the samples that they collected, and on the results and publications generated by the researchesinvestigations.</p>
-->
<?php
$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>