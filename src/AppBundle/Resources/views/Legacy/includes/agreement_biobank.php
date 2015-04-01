<?php
/**
 *   Include File
 *   Agreement Biobank Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER:De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/agreement.css" />'));


if(isset($_GET['disagree_agreement']) && is_string($_GET['disagree_agreement']) == true && $_GET['disagree_agreement'] == 'disagree')
{
	$Layout->NavigateTo('biobank_navigation','#manage_samples');
	$tmp = ob_get_contents();
	ob_end_clean();
	return $tmp;	
}



?>
<div id ="agreement_list">
<p>The applicant agrees to the following general terms and conditions, 
for the use of marine mammal tissues held at the BMMB 
(a request from a student must be countersigned by the su-pervisor of the work or the head of the laboratory).
 The applicant must provide the requested information where appropriate (items 1, 2) </p>

<ol>
	<li>
		Tissues can be used only for scientific research and applicant must provide a concise de-scription of the research project 
		(inventory of the investigation, 250 word max.) with the research grant reference when appropriate and the expected results. 
	</li>
	<li>
 		Details of the scientific methodology applied on samples should be given and it should be stipulated if the samples will be partially or completely consumed, 
 		or if the samples will be modified or transformed (for example, DNA or RNA extraction) or if product will be derived (cell culture,...).
	</li>
	<li>
 		Exceptional specimens may carry a value for which the lender shall be required to deposit a security and to contract insurance.
	</li>
	<li>
		For some samples, there is a cost for tissues preparation. Applicant shall pay the RBINS or ULg within 30 days following invoice sending.
	</li>
	<li>
		It is understood that the samples are provided without any warranty regarding the expected results. In addition, 
		samples may represent potential health risks and accurate safety care must be applied during all the processing. 
		Applicant agrees that BMMTB, RBINS or ULg cannot be held as responsible for whatever arised from the use, handling, 
		storage and disposal of the samples.
	</li>
	<li>
		Samples remain the property of BMMB and when appropriate, samples will be returned to BMMB under the responsibility of the 
		applicant and at his costs
	</li>
	<li>
		BMMB is free to transfer samples to others, to use them for its own research projects and to publish any results obtained from samples.
	</li>
	<li>
 		Loan of a sample is made only to institutions under the name of a permanent member of that institution and samples may only be used 
 		for the aim of the research described in 1, except af-ter consultation and written approval of the curator of BMMTB.
	</li>
	<li>
		If samples have to be shipped, the applicant needs to provide details of physical mailing ad-dress including contact person(s) 
		e-mail(s) and (cell)phone(s). Shipping fees will be charged to the applicant.
	</li>
	<li>
		Parts of the samples that remain after the scientific investigation must be returned to the curator of BMMTB. 
		When appropriate, samples must be adequately packed and shipped to in-sure their safe return by registered or insured mail. 
		The curator must be contacted before ship-ping. Shipping fees are chargeable to the applicant. If no parts of samples remain 
		after the in-vestigation, the curator must be notified accordingly.
	</li>
	<li>
		Labels associated with the BMMB samples may not be removed, modified or altered.
	</li>
	<li>
		The applicant is an "end-user" meaning that no part of the samples, product of the samples and data related to the samples 
		(species, origin, age, sex, lesions, ...) may be forwarded to a third party, except after consultation and written approval 
		of the curator of BMMTB.
	</li>
	<li>
		The applicant is responsible for keeping samples preserved in the initial fixative (buffered formaline or ethanol) or stored frozen 
		( &#45 20 &#176 C or &#45 80 &#176 C). The loss or damage of samples must be reported to the curator of BMMTB.
	</li>
	<li>
		Published results should be communicated to the curator of BMMB to be included in the database associated with the tissues bank 
		and two copies of all papers should be sent to him/her. 
	</li>
	<li>
		All publications and reports should stipulate that samples were provided by the BMMB with the name of the partner who collected 
		the samples (for example: "authors aknowledge the Belgian Marine Mammal Tissues Bank and Dr. "Name" who provided the samples").
	</li>
	<li>
		The Management Unit of the North Sea Mathematical Models department (RBINS) and the department of Veterinary Pathology (ULg) 
		are scientific institutions and thus more than a sim-ple storage facility for samples collection. 
		The scientific exploitation of samples held in the collection does not necessarily imply co-authorship of publications. 
		Nevertheless, any intellec-tual co-operation in publishing a paper needs to be reflected in the co-authorship 
		or acknowl-edgements, as appropriate.
	</li>
	<li>
		Approval of the request for tissues transfer or loan is at the discretion of the curator of BMMTB.
	</li>
	<li>
		A delay of at least 2 years exists between the moment the samples are incorporated in the BMMB and the moment they are 
		available for retransfer or loan. This period will allow the partner who provided the samples to perform his/her own scientific 
		investigations.
	</li>
</ol>
</div>
<div id="agreement_confirmation">
<form>
<button value="agree" class="order_samples" name="agree_agreement" type="submit">Agree</button>
<button value="disagree" class="order_samples" name="disagree_agreement" type="submit">Disagree</button>
</form>
</div>


<?php
$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>


