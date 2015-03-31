<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head> 
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' ></meta> 
<title> Marine Mammals </title>       
<link rel="stylesheet" type="text/css" href="css/Layout/Page.css" />
<link rel="stylesheet" type="text/css" href="css/Layout/TwoColFixedFluid.css" />
<link rel="stylesheet" type="text/css" href="css/Layout/Biolibd_Layout.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.contextMenu.css"/>
<link rel="stylesheet" type="text/css" href="css/default_form.css" />
<link rel="stylesheet" type="text/css" href="css/redmond.datepick.css" />
<link rel="stylesheet" type="text/css" href="css/Jquery/ui.all.css" />
<script type="text/javascript" src="js/jquery.1.3.2.js"></script>
<script type="text/javascript" src="js/jquery.json-1.3.js"></script>
<script type="text/javascript" src="js/Layout.js"></script>
<script type="text/javascript" src="js/navigation.js"></script>
<script type="text/javascript" src="js/jquery.contextMenu.js"></script>
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.accordion.js"></script>
<link rel="stylesheet" type="text/css" href="css/Biobank.css" />
<link rel="stylesheet" type="text/css" href="css/search.css" />
<script type="text/javascript" src="js/search_plugin.js"></script>
<script type="text/javascript" src="js/Biobank.js"></script>
<link rel="stylesheet" type="text/css" href="css/agreement.css" />
<link rel="stylesheet" type="text/css" href="css/Layout/SigninRenderer.css" />
</head>    	
<body>
<div id="Layout_container">
	<div id="container_transparency_top">
		<div id ='Layout_header'>
<div id="banner">
	<div id ="banner_transparency_left">
		<div id ="banner_transparency_right">
			<div id="banner_elements"></div>
			<div id="banner_partner">
				<a class="ulg"  href="http://www.ulg.ac.be"></a>
				<a class="mumm" href="http://www.mumm.ac.be"></a>
			</div>
			<div id='banner_signin'>
	<form id='signin_form' class='logged' action = '/Biobank.php' method = 'post'>			
		<div class = 'form_section'>
			<div id ='signin_message' ><span>Welcome</span> admin</div>
		</div>
		<div class ='form_section'>
			<a href='/Biobank.php?action=logout'>Sign Out</a>
		</div>
	</form>
</div>
			<div id = "title">
			<div id="title_inner">
				<p class ="title"><span>Marine Mammal</span></p>
				<p class="subtitle"><span>Observation, Stranding & Sample Library</span></p>
			</div>	
			</div>
		</div>
	</div>
</div>
<div class ='main_menus'>
<ul class = menus_default><li ><a href = /index.php>Home</a></li><li ><a href = /Observations.php>Observations &amp; Strandings</a></li><li ><a href = /Autopsy.php>Autopsies</a></li><li class=isclicked><a href = /Biobank.php>Biobank</a></li><li ><a href = /User.php>User</a></li><li ><a href = /Import.php>Import</a></li><li ><a href = /Admin.php>Admin</a></li></ul>

								<div class='clearboth'></div>
</div></div>
<div id='Layout_wrapper'>
<div id=Layout_navigation>
<div class = 'biobank_navigation'>
<ul>
<li class='isclicked'><a  href = '#description_biobank'>Description</a></li>
<li  ><a href = '#manage_samples'>Search for Samples</a></li>
<li  style='display:none;'><a href = '#agreement_biobank'>Order ( Agreement)</a></li>
<li  style='display:none;'><a href = '#order_samples'>Order ( Review)</a></li>
</ul>
</div>

</div>
<div id='Layout_content'>
<div id = "description_biobank"><div class = "description">
<p>
The Belgian Marine Mammal Tissue collection has started in 1990 and throught collaborations, since 1995, with France and the Netherlands, 
the sample collection extended to the continental coastline of the Southern North Sea. 
Similar collections are existing for the United Kingdom, Ireland, Germany. 
</p>

<p>
The goal of the Belgian Marine Mammal Tissue Bank (BMMTB) is to provide high quality samples of marine mammals 
(small and large cetaceans as well as pinnipeds) for research purpose only, upon a non-profit scientific collaboration (see agreement).
 The tissues bank should be considered also as a tool to facilitate tissues exchange, 
 scientists and contributor can request tissues from the BMMTB following their priority 
 (selection by species, area, age, sex, tissues, lesions, year and conservation procedure). 
</p>

<p>
In addition, up to now, stranding networks in Europe were collecting samples but, most of the time, 
only part of tissues is used, the rest being long-term stored or destroyed. For example, for histopathology, 
tissue samples of 1 cm 3 or more are fixed in formalin but only 3 mm slide is necessary. 
Gathering samples of marine mammals from various European areas will also help to have a geographical 
overview and will highlight regional variations. 
Some samples being in collection since 1990, temporal evolution and trends can be investigated. 
</p>

<p>
Marine mammals are necropsied and tissues collected, 
fixed and stored following protocols of the European Cetacean Society. 
Tissues are stored at the Royal Institute of Natural History,<a href="http://www.mumm.ac.be"> Management Unit of the North Sea</a> 
department (Belgium) and at the <a href="http://www.ulg.ac.be/fmv">Department of Morphology and Pathology</a>, 
University of Liege (Belgium). Samples may be used for retrospective studies in pathology, microbiology, toxicology, life history, ... 
</p>

<p>
The collection of the BMMTB is maintained and continuously feed by collaborations between national stranding networks. 
People will be informed every year (annual report on the state of the BMMTB ) 
about the use of the samples that they collected and on the results and publications generated by the researches. 
</p>
</div>
</div>
<div id = "agreement_biobank"><div id ="agreement_list">
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
		It is understood that the samples are provided without any warranty regarding the expected results. In addition, 
		samples may represent potential health risks and accurate safety care must be applied during all the processing. 
		Applicant agrees that BMMTB, RBINS or ULg cannot be held as responsible for whatever arised from the use, handling, 
		storage and disposal of the samples.
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


</div>
<div id = "manage_samples"><div id = "search_samples">
<div class = "samples_results"><table class = tab_output >

    					<thead><tr>
<th><a class='sort' href = /Biobank.php?sort=Availability>Availability</a></th>
<th><a class='sort' href = /Biobank.php?sort=Conservation%20Mode>Conservation Mode</a></th>
<th><a class='sort' href = /Biobank.php?sort=Analyze%20Dest>Analyze Dest</a></th>
<th><a class='sort' href = /Biobank.php?sort=Taxa>Taxa</a></th>
<th><a class='sort' href = /Biobank.php?sort=Organs>Organs</a></th>
<th><a class='unsort' ><input type="checkbox" class="sample_select"/></a></th>
</tr>
</thead>

    					<tfoot><tr><td colspan=6><div class='search'><input class = 'searchornot' name='search tool' type ='button' value='Show Filter'></input></div><div class='board'>| page 1 | 1904 pages | 19033 records | <select class='rpp'><option>5</option><option selected ='selected'>10</option><option>15</option><option>20</option><option>25</option><option>30</option><option>35</option><option>40</option><option>45</option></select> rows per page | <span class='samplesnotselected'><b><p style=margin-top:7px> no samples selected</p></b></span> </div><div class = "navigation_bar"><a class = 'previous_page' href =/Biobank.php?page=0 >PREV</a> <select><option selected>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option><option>32</option><option>33</option><option>34</option><option>35</option><option>36</option><option>37</option><option>38</option><option>39</option><option>40</option><option>41</option><option>42</option><option>43</option><option>44</option><option>45</option><option>46</option><option>47</option><option>48</option><option>49</option><option>50</option><option>51</option><option>52</option><option>53</option><option>54</option><option>55</option><option>56</option><option>57</option><option>58</option><option>59</option><option>60</option><option>61</option><option>62</option><option>63</option><option>64</option><option>65</option><option>66</option><option>67</option><option>68</option><option>69</option><option>70</option><option>71</option><option>72</option><option>73</option><option>74</option><option>75</option><option>76</option><option>77</option><option>78</option><option>79</option><option>80</option><option>81</option><option>82</option><option>83</option><option>84</option><option>85</option><option>86</option><option>87</option><option>88</option><option>89</option><option>90</option><option>91</option><option>92</option><option>93</option><option>94</option><option>95</option><option>96</option><option>97</option><option>98</option><option>99</option><option>100</option><option>101</option><option>102</option><option>103</option><option>104</option><option>105</option><option>106</option><option>107</option><option>108</option><option>109</option><option>110</option><option>111</option><option>112</option><option>113</option><option>114</option><option>115</option><option>116</option><option>117</option><option>118</option><option>119</option><option>120</option><option>121</option><option>122</option><option>123</option><option>124</option><option>125</option><option>126</option><option>127</option><option>128</option><option>129</option><option>130</option><option>131</option><option>132</option><option>133</option><option>134</option><option>135</option><option>136</option><option>137</option><option>138</option><option>139</option><option>140</option><option>141</option><option>142</option><option>143</option><option>144</option><option>145</option><option>146</option><option>147</option><option>148</option><option>149</option><option>150</option><option>151</option><option>152</option><option>153</option><option>154</option><option>155</option><option>156</option><option>157</option><option>158</option><option>159</option><option>160</option><option>161</option><option>162</option><option>163</option><option>164</option><option>165</option><option>166</option><option>167</option><option>168</option><option>169</option><option>170</option><option>171</option><option>172</option><option>173</option><option>174</option><option>175</option><option>176</option><option>177</option><option>178</option><option>179</option><option>180</option><option>181</option><option>182</option><option>183</option><option>184</option><option>185</option><option>186</option><option>187</option><option>188</option><option>189</option><option>190</option><option>191</option><option>192</option><option>193</option><option>194</option><option>195</option><option>196</option><option>197</option><option>198</option><option>199</option><option>200</option><option>201</option><option>202</option><option>203</option><option>204</option><option>205</option><option>206</option><option>207</option><option>208</option><option>209</option><option>210</option><option>211</option><option>212</option><option>213</option><option>214</option><option>215</option><option>216</option><option>217</option><option>218</option><option>219</option><option>220</option><option>221</option><option>222</option><option>223</option><option>224</option><option>225</option><option>226</option><option>227</option><option>228</option><option>229</option><option>230</option><option>231</option><option>232</option><option>233</option><option>234</option><option>235</option><option>236</option><option>237</option><option>238</option><option>239</option><option>240</option><option>241</option><option>242</option><option>243</option><option>244</option><option>245</option><option>246</option><option>247</option><option>248</option><option>249</option><option>250</option><option>251</option><option>252</option><option>253</option><option>254</option><option>255</option><option>256</option><option>257</option><option>258</option><option>259</option><option>260</option><option>261</option><option>262</option><option>263</option><option>264</option><option>265</option><option>266</option><option>267</option><option>268</option><option>269</option><option>270</option><option>271</option><option>272</option><option>273</option><option>274</option><option>275</option><option>276</option><option>277</option><option>278</option><option>279</option><option>280</option><option>281</option><option>282</option><option>283</option><option>284</option><option>285</option><option>286</option><option>287</option><option>288</option><option>289</option><option>290</option><option>291</option><option>292</option><option>293</option><option>294</option><option>295</option><option>296</option><option>297</option><option>298</option><option>299</option><option>300</option><option>301</option><option>302</option><option>303</option><option>304</option><option>305</option><option>306</option><option>307</option><option>308</option><option>309</option><option>310</option><option>311</option><option>312</option><option>313</option><option>314</option><option>315</option><option>316</option><option>317</option><option>318</option><option>319</option><option>320</option><option>321</option><option>322</option><option>323</option><option>324</option><option>325</option><option>326</option><option>327</option><option>328</option><option>329</option><option>330</option><option>331</option><option>332</option><option>333</option><option>334</option><option>335</option><option>336</option><option>337</option><option>338</option><option>339</option><option>340</option><option>341</option><option>342</option><option>343</option><option>344</option><option>345</option><option>346</option><option>347</option><option>348</option><option>349</option><option>350</option><option>351</option><option>352</option><option>353</option><option>354</option><option>355</option><option>356</option><option>357</option><option>358</option><option>359</option><option>360</option><option>361</option><option>362</option><option>363</option><option>364</option><option>365</option><option>366</option><option>367</option><option>368</option><option>369</option><option>370</option><option>371</option><option>372</option><option>373</option><option>374</option><option>375</option><option>376</option><option>377</option><option>378</option><option>379</option><option>380</option><option>381</option><option>382</option><option>383</option><option>384</option><option>385</option><option>386</option><option>387</option><option>388</option><option>389</option><option>390</option><option>391</option><option>392</option><option>393</option><option>394</option><option>395</option><option>396</option><option>397</option><option>398</option><option>399</option><option>400</option><option>401</option><option>402</option><option>403</option><option>404</option><option>405</option><option>406</option><option>407</option><option>408</option><option>409</option><option>410</option><option>411</option><option>412</option><option>413</option><option>414</option><option>415</option><option>416</option><option>417</option><option>418</option><option>419</option><option>420</option><option>421</option><option>422</option><option>423</option><option>424</option><option>425</option><option>426</option><option>427</option><option>428</option><option>429</option><option>430</option><option>431</option><option>432</option><option>433</option><option>434</option><option>435</option><option>436</option><option>437</option><option>438</option><option>439</option><option>440</option><option>441</option><option>442</option><option>443</option><option>444</option><option>445</option><option>446</option><option>447</option><option>448</option><option>449</option><option>450</option><option>451</option><option>452</option><option>453</option><option>454</option><option>455</option><option>456</option><option>457</option><option>458</option><option>459</option><option>460</option><option>461</option><option>462</option><option>463</option><option>464</option><option>465</option><option>466</option><option>467</option><option>468</option><option>469</option><option>470</option><option>471</option><option>472</option><option>473</option><option>474</option><option>475</option><option>476</option><option>477</option><option>478</option><option>479</option><option>480</option><option>481</option><option>482</option><option>483</option><option>484</option><option>485</option><option>486</option><option>487</option><option>488</option><option>489</option><option>490</option><option>491</option><option>492</option><option>493</option><option>494</option><option>495</option><option>496</option><option>497</option><option>498</option><option>499</option><option>500</option><option>501</option><option>502</option><option>503</option><option>504</option><option>505</option><option>506</option><option>507</option><option>508</option><option>509</option><option>510</option><option>511</option><option>512</option><option>513</option><option>514</option><option>515</option><option>516</option><option>517</option><option>518</option><option>519</option><option>520</option><option>521</option><option>522</option><option>523</option><option>524</option><option>525</option><option>526</option><option>527</option><option>528</option><option>529</option><option>530</option><option>531</option><option>532</option><option>533</option><option>534</option><option>535</option><option>536</option><option>537</option><option>538</option><option>539</option><option>540</option><option>541</option><option>542</option><option>543</option><option>544</option><option>545</option><option>546</option><option>547</option><option>548</option><option>549</option><option>550</option><option>551</option><option>552</option><option>553</option><option>554</option><option>555</option><option>556</option><option>557</option><option>558</option><option>559</option><option>560</option><option>561</option><option>562</option><option>563</option><option>564</option><option>565</option><option>566</option><option>567</option><option>568</option><option>569</option><option>570</option><option>571</option><option>572</option><option>573</option><option>574</option><option>575</option><option>576</option><option>577</option><option>578</option><option>579</option><option>580</option><option>581</option><option>582</option><option>583</option><option>584</option><option>585</option><option>586</option><option>587</option><option>588</option><option>589</option><option>590</option><option>591</option><option>592</option><option>593</option><option>594</option><option>595</option><option>596</option><option>597</option><option>598</option><option>599</option><option>600</option><option>601</option><option>602</option><option>603</option><option>604</option><option>605</option><option>606</option><option>607</option><option>608</option><option>609</option><option>610</option><option>611</option><option>612</option><option>613</option><option>614</option><option>615</option><option>616</option><option>617</option><option>618</option><option>619</option><option>620</option><option>621</option><option>622</option><option>623</option><option>624</option><option>625</option><option>626</option><option>627</option><option>628</option><option>629</option><option>630</option><option>631</option><option>632</option><option>633</option><option>634</option><option>635</option><option>636</option><option>637</option><option>638</option><option>639</option><option>640</option><option>641</option><option>642</option><option>643</option><option>644</option><option>645</option><option>646</option><option>647</option><option>648</option><option>649</option><option>650</option><option>651</option><option>652</option><option>653</option><option>654</option><option>655</option><option>656</option><option>657</option><option>658</option><option>659</option><option>660</option><option>661</option><option>662</option><option>663</option><option>664</option><option>665</option><option>666</option><option>667</option><option>668</option><option>669</option><option>670</option><option>671</option><option>672</option><option>673</option><option>674</option><option>675</option><option>676</option><option>677</option><option>678</option><option>679</option><option>680</option><option>681</option><option>682</option><option>683</option><option>684</option><option>685</option><option>686</option><option>687</option><option>688</option><option>689</option><option>690</option><option>691</option><option>692</option><option>693</option><option>694</option><option>695</option><option>696</option><option>697</option><option>698</option><option>699</option><option>700</option><option>701</option><option>702</option><option>703</option><option>704</option><option>705</option><option>706</option><option>707</option><option>708</option><option>709</option><option>710</option><option>711</option><option>712</option><option>713</option><option>714</option><option>715</option><option>716</option><option>717</option><option>718</option><option>719</option><option>720</option><option>721</option><option>722</option><option>723</option><option>724</option><option>725</option><option>726</option><option>727</option><option>728</option><option>729</option><option>730</option><option>731</option><option>732</option><option>733</option><option>734</option><option>735</option><option>736</option><option>737</option><option>738</option><option>739</option><option>740</option><option>741</option><option>742</option><option>743</option><option>744</option><option>745</option><option>746</option><option>747</option><option>748</option><option>749</option><option>750</option><option>751</option><option>752</option><option>753</option><option>754</option><option>755</option><option>756</option><option>757</option><option>758</option><option>759</option><option>760</option><option>761</option><option>762</option><option>763</option><option>764</option><option>765</option><option>766</option><option>767</option><option>768</option><option>769</option><option>770</option><option>771</option><option>772</option><option>773</option><option>774</option><option>775</option><option>776</option><option>777</option><option>778</option><option>779</option><option>780</option><option>781</option><option>782</option><option>783</option><option>784</option><option>785</option><option>786</option><option>787</option><option>788</option><option>789</option><option>790</option><option>791</option><option>792</option><option>793</option><option>794</option><option>795</option><option>796</option><option>797</option><option>798</option><option>799</option><option>800</option><option>801</option><option>802</option><option>803</option><option>804</option><option>805</option><option>806</option><option>807</option><option>808</option><option>809</option><option>810</option><option>811</option><option>812</option><option>813</option><option>814</option><option>815</option><option>816</option><option>817</option><option>818</option><option>819</option><option>820</option><option>821</option><option>822</option><option>823</option><option>824</option><option>825</option><option>826</option><option>827</option><option>828</option><option>829</option><option>830</option><option>831</option><option>832</option><option>833</option><option>834</option><option>835</option><option>836</option><option>837</option><option>838</option><option>839</option><option>840</option><option>841</option><option>842</option><option>843</option><option>844</option><option>845</option><option>846</option><option>847</option><option>848</option><option>849</option><option>850</option><option>851</option><option>852</option><option>853</option><option>854</option><option>855</option><option>856</option><option>857</option><option>858</option><option>859</option><option>860</option><option>861</option><option>862</option><option>863</option><option>864</option><option>865</option><option>866</option><option>867</option><option>868</option><option>869</option><option>870</option><option>871</option><option>872</option><option>873</option><option>874</option><option>875</option><option>876</option><option>877</option><option>878</option><option>879</option><option>880</option><option>881</option><option>882</option><option>883</option><option>884</option><option>885</option><option>886</option><option>887</option><option>888</option><option>889</option><option>890</option><option>891</option><option>892</option><option>893</option><option>894</option><option>895</option><option>896</option><option>897</option><option>898</option><option>899</option><option>900</option><option>901</option><option>902</option><option>903</option><option>904</option><option>905</option><option>906</option><option>907</option><option>908</option><option>909</option><option>910</option><option>911</option><option>912</option><option>913</option><option>914</option><option>915</option><option>916</option><option>917</option><option>918</option><option>919</option><option>920</option><option>921</option><option>922</option><option>923</option><option>924</option><option>925</option><option>926</option><option>927</option><option>928</option><option>929</option><option>930</option><option>931</option><option>932</option><option>933</option><option>934</option><option>935</option><option>936</option><option>937</option><option>938</option><option>939</option><option>940</option><option>941</option><option>942</option><option>943</option><option>944</option><option>945</option><option>946</option><option>947</option><option>948</option><option>949</option><option>950</option><option>951</option><option>952</option><option>953</option><option>954</option><option>955</option><option>956</option><option>957</option><option>958</option><option>959</option><option>960</option><option>961</option><option>962</option><option>963</option><option>964</option><option>965</option><option>966</option><option>967</option><option>968</option><option>969</option><option>970</option><option>971</option><option>972</option><option>973</option><option>974</option><option>975</option><option>976</option><option>977</option><option>978</option><option>979</option><option>980</option><option>981</option><option>982</option><option>983</option><option>984</option><option>985</option><option>986</option><option>987</option><option>988</option><option>989</option><option>990</option><option>991</option><option>992</option><option>993</option><option>994</option><option>995</option><option>996</option><option>997</option><option>998</option><option>999</option><option>1000</option><option>1001</option><option>1002</option><option>1003</option><option>1004</option><option>1005</option><option>1006</option><option>1007</option><option>1008</option><option>1009</option><option>1010</option><option>1011</option><option>1012</option><option>1013</option><option>1014</option><option>1015</option><option>1016</option><option>1017</option><option>1018</option><option>1019</option><option>1020</option><option>1021</option><option>1022</option><option>1023</option><option>1024</option><option>1025</option><option>1026</option><option>1027</option><option>1028</option><option>1029</option><option>1030</option><option>1031</option><option>1032</option><option>1033</option><option>1034</option><option>1035</option><option>1036</option><option>1037</option><option>1038</option><option>1039</option><option>1040</option><option>1041</option><option>1042</option><option>1043</option><option>1044</option><option>1045</option><option>1046</option><option>1047</option><option>1048</option><option>1049</option><option>1050</option><option>1051</option><option>1052</option><option>1053</option><option>1054</option><option>1055</option><option>1056</option><option>1057</option><option>1058</option><option>1059</option><option>1060</option><option>1061</option><option>1062</option><option>1063</option><option>1064</option><option>1065</option><option>1066</option><option>1067</option><option>1068</option><option>1069</option><option>1070</option><option>1071</option><option>1072</option><option>1073</option><option>1074</option><option>1075</option><option>1076</option><option>1077</option><option>1078</option><option>1079</option><option>1080</option><option>1081</option><option>1082</option><option>1083</option><option>1084</option><option>1085</option><option>1086</option><option>1087</option><option>1088</option><option>1089</option><option>1090</option><option>1091</option><option>1092</option><option>1093</option><option>1094</option><option>1095</option><option>1096</option><option>1097</option><option>1098</option><option>1099</option><option>1100</option><option>1101</option><option>1102</option><option>1103</option><option>1104</option><option>1105</option><option>1106</option><option>1107</option><option>1108</option><option>1109</option><option>1110</option><option>1111</option><option>1112</option><option>1113</option><option>1114</option><option>1115</option><option>1116</option><option>1117</option><option>1118</option><option>1119</option><option>1120</option><option>1121</option><option>1122</option><option>1123</option><option>1124</option><option>1125</option><option>1126</option><option>1127</option><option>1128</option><option>1129</option><option>1130</option><option>1131</option><option>1132</option><option>1133</option><option>1134</option><option>1135</option><option>1136</option><option>1137</option><option>1138</option><option>1139</option><option>1140</option><option>1141</option><option>1142</option><option>1143</option><option>1144</option><option>1145</option><option>1146</option><option>1147</option><option>1148</option><option>1149</option><option>1150</option><option>1151</option><option>1152</option><option>1153</option><option>1154</option><option>1155</option><option>1156</option><option>1157</option><option>1158</option><option>1159</option><option>1160</option><option>1161</option><option>1162</option><option>1163</option><option>1164</option><option>1165</option><option>1166</option><option>1167</option><option>1168</option><option>1169</option><option>1170</option><option>1171</option><option>1172</option><option>1173</option><option>1174</option><option>1175</option><option>1176</option><option>1177</option><option>1178</option><option>1179</option><option>1180</option><option>1181</option><option>1182</option><option>1183</option><option>1184</option><option>1185</option><option>1186</option><option>1187</option><option>1188</option><option>1189</option><option>1190</option><option>1191</option><option>1192</option><option>1193</option><option>1194</option><option>1195</option><option>1196</option><option>1197</option><option>1198</option><option>1199</option><option>1200</option><option>1201</option><option>1202</option><option>1203</option><option>1204</option><option>1205</option><option>1206</option><option>1207</option><option>1208</option><option>1209</option><option>1210</option><option>1211</option><option>1212</option><option>1213</option><option>1214</option><option>1215</option><option>1216</option><option>1217</option><option>1218</option><option>1219</option><option>1220</option><option>1221</option><option>1222</option><option>1223</option><option>1224</option><option>1225</option><option>1226</option><option>1227</option><option>1228</option><option>1229</option><option>1230</option><option>1231</option><option>1232</option><option>1233</option><option>1234</option><option>1235</option><option>1236</option><option>1237</option><option>1238</option><option>1239</option><option>1240</option><option>1241</option><option>1242</option><option>1243</option><option>1244</option><option>1245</option><option>1246</option><option>1247</option><option>1248</option><option>1249</option><option>1250</option><option>1251</option><option>1252</option><option>1253</option><option>1254</option><option>1255</option><option>1256</option><option>1257</option><option>1258</option><option>1259</option><option>1260</option><option>1261</option><option>1262</option><option>1263</option><option>1264</option><option>1265</option><option>1266</option><option>1267</option><option>1268</option><option>1269</option><option>1270</option><option>1271</option><option>1272</option><option>1273</option><option>1274</option><option>1275</option><option>1276</option><option>1277</option><option>1278</option><option>1279</option><option>1280</option><option>1281</option><option>1282</option><option>1283</option><option>1284</option><option>1285</option><option>1286</option><option>1287</option><option>1288</option><option>1289</option><option>1290</option><option>1291</option><option>1292</option><option>1293</option><option>1294</option><option>1295</option><option>1296</option><option>1297</option><option>1298</option><option>1299</option><option>1300</option><option>1301</option><option>1302</option><option>1303</option><option>1304</option><option>1305</option><option>1306</option><option>1307</option><option>1308</option><option>1309</option><option>1310</option><option>1311</option><option>1312</option><option>1313</option><option>1314</option><option>1315</option><option>1316</option><option>1317</option><option>1318</option><option>1319</option><option>1320</option><option>1321</option><option>1322</option><option>1323</option><option>1324</option><option>1325</option><option>1326</option><option>1327</option><option>1328</option><option>1329</option><option>1330</option><option>1331</option><option>1332</option><option>1333</option><option>1334</option><option>1335</option><option>1336</option><option>1337</option><option>1338</option><option>1339</option><option>1340</option><option>1341</option><option>1342</option><option>1343</option><option>1344</option><option>1345</option><option>1346</option><option>1347</option><option>1348</option><option>1349</option><option>1350</option><option>1351</option><option>1352</option><option>1353</option><option>1354</option><option>1355</option><option>1356</option><option>1357</option><option>1358</option><option>1359</option><option>1360</option><option>1361</option><option>1362</option><option>1363</option><option>1364</option><option>1365</option><option>1366</option><option>1367</option><option>1368</option><option>1369</option><option>1370</option><option>1371</option><option>1372</option><option>1373</option><option>1374</option><option>1375</option><option>1376</option><option>1377</option><option>1378</option><option>1379</option><option>1380</option><option>1381</option><option>1382</option><option>1383</option><option>1384</option><option>1385</option><option>1386</option><option>1387</option><option>1388</option><option>1389</option><option>1390</option><option>1391</option><option>1392</option><option>1393</option><option>1394</option><option>1395</option><option>1396</option><option>1397</option><option>1398</option><option>1399</option><option>1400</option><option>1401</option><option>1402</option><option>1403</option><option>1404</option><option>1405</option><option>1406</option><option>1407</option><option>1408</option><option>1409</option><option>1410</option><option>1411</option><option>1412</option><option>1413</option><option>1414</option><option>1415</option><option>1416</option><option>1417</option><option>1418</option><option>1419</option><option>1420</option><option>1421</option><option>1422</option><option>1423</option><option>1424</option><option>1425</option><option>1426</option><option>1427</option><option>1428</option><option>1429</option><option>1430</option><option>1431</option><option>1432</option><option>1433</option><option>1434</option><option>1435</option><option>1436</option><option>1437</option><option>1438</option><option>1439</option><option>1440</option><option>1441</option><option>1442</option><option>1443</option><option>1444</option><option>1445</option><option>1446</option><option>1447</option><option>1448</option><option>1449</option><option>1450</option><option>1451</option><option>1452</option><option>1453</option><option>1454</option><option>1455</option><option>1456</option><option>1457</option><option>1458</option><option>1459</option><option>1460</option><option>1461</option><option>1462</option><option>1463</option><option>1464</option><option>1465</option><option>1466</option><option>1467</option><option>1468</option><option>1469</option><option>1470</option><option>1471</option><option>1472</option><option>1473</option><option>1474</option><option>1475</option><option>1476</option><option>1477</option><option>1478</option><option>1479</option><option>1480</option><option>1481</option><option>1482</option><option>1483</option><option>1484</option><option>1485</option><option>1486</option><option>1487</option><option>1488</option><option>1489</option><option>1490</option><option>1491</option><option>1492</option><option>1493</option><option>1494</option><option>1495</option><option>1496</option><option>1497</option><option>1498</option><option>1499</option><option>1500</option><option>1501</option><option>1502</option><option>1503</option><option>1504</option><option>1505</option><option>1506</option><option>1507</option><option>1508</option><option>1509</option><option>1510</option><option>1511</option><option>1512</option><option>1513</option><option>1514</option><option>1515</option><option>1516</option><option>1517</option><option>1518</option><option>1519</option><option>1520</option><option>1521</option><option>1522</option><option>1523</option><option>1524</option><option>1525</option><option>1526</option><option>1527</option><option>1528</option><option>1529</option><option>1530</option><option>1531</option><option>1532</option><option>1533</option><option>1534</option><option>1535</option><option>1536</option><option>1537</option><option>1538</option><option>1539</option><option>1540</option><option>1541</option><option>1542</option><option>1543</option><option>1544</option><option>1545</option><option>1546</option><option>1547</option><option>1548</option><option>1549</option><option>1550</option><option>1551</option><option>1552</option><option>1553</option><option>1554</option><option>1555</option><option>1556</option><option>1557</option><option>1558</option><option>1559</option><option>1560</option><option>1561</option><option>1562</option><option>1563</option><option>1564</option><option>1565</option><option>1566</option><option>1567</option><option>1568</option><option>1569</option><option>1570</option><option>1571</option><option>1572</option><option>1573</option><option>1574</option><option>1575</option><option>1576</option><option>1577</option><option>1578</option><option>1579</option><option>1580</option><option>1581</option><option>1582</option><option>1583</option><option>1584</option><option>1585</option><option>1586</option><option>1587</option><option>1588</option><option>1589</option><option>1590</option><option>1591</option><option>1592</option><option>1593</option><option>1594</option><option>1595</option><option>1596</option><option>1597</option><option>1598</option><option>1599</option><option>1600</option><option>1601</option><option>1602</option><option>1603</option><option>1604</option><option>1605</option><option>1606</option><option>1607</option><option>1608</option><option>1609</option><option>1610</option><option>1611</option><option>1612</option><option>1613</option><option>1614</option><option>1615</option><option>1616</option><option>1617</option><option>1618</option><option>1619</option><option>1620</option><option>1621</option><option>1622</option><option>1623</option><option>1624</option><option>1625</option><option>1626</option><option>1627</option><option>1628</option><option>1629</option><option>1630</option><option>1631</option><option>1632</option><option>1633</option><option>1634</option><option>1635</option><option>1636</option><option>1637</option><option>1638</option><option>1639</option><option>1640</option><option>1641</option><option>1642</option><option>1643</option><option>1644</option><option>1645</option><option>1646</option><option>1647</option><option>1648</option><option>1649</option><option>1650</option><option>1651</option><option>1652</option><option>1653</option><option>1654</option><option>1655</option><option>1656</option><option>1657</option><option>1658</option><option>1659</option><option>1660</option><option>1661</option><option>1662</option><option>1663</option><option>1664</option><option>1665</option><option>1666</option><option>1667</option><option>1668</option><option>1669</option><option>1670</option><option>1671</option><option>1672</option><option>1673</option><option>1674</option><option>1675</option><option>1676</option><option>1677</option><option>1678</option><option>1679</option><option>1680</option><option>1681</option><option>1682</option><option>1683</option><option>1684</option><option>1685</option><option>1686</option><option>1687</option><option>1688</option><option>1689</option><option>1690</option><option>1691</option><option>1692</option><option>1693</option><option>1694</option><option>1695</option><option>1696</option><option>1697</option><option>1698</option><option>1699</option><option>1700</option><option>1701</option><option>1702</option><option>1703</option><option>1704</option><option>1705</option><option>1706</option><option>1707</option><option>1708</option><option>1709</option><option>1710</option><option>1711</option><option>1712</option><option>1713</option><option>1714</option><option>1715</option><option>1716</option><option>1717</option><option>1718</option><option>1719</option><option>1720</option><option>1721</option><option>1722</option><option>1723</option><option>1724</option><option>1725</option><option>1726</option><option>1727</option><option>1728</option><option>1729</option><option>1730</option><option>1731</option><option>1732</option><option>1733</option><option>1734</option><option>1735</option><option>1736</option><option>1737</option><option>1738</option><option>1739</option><option>1740</option><option>1741</option><option>1742</option><option>1743</option><option>1744</option><option>1745</option><option>1746</option><option>1747</option><option>1748</option><option>1749</option><option>1750</option><option>1751</option><option>1752</option><option>1753</option><option>1754</option><option>1755</option><option>1756</option><option>1757</option><option>1758</option><option>1759</option><option>1760</option><option>1761</option><option>1762</option><option>1763</option><option>1764</option><option>1765</option><option>1766</option><option>1767</option><option>1768</option><option>1769</option><option>1770</option><option>1771</option><option>1772</option><option>1773</option><option>1774</option><option>1775</option><option>1776</option><option>1777</option><option>1778</option><option>1779</option><option>1780</option><option>1781</option><option>1782</option><option>1783</option><option>1784</option><option>1785</option><option>1786</option><option>1787</option><option>1788</option><option>1789</option><option>1790</option><option>1791</option><option>1792</option><option>1793</option><option>1794</option><option>1795</option><option>1796</option><option>1797</option><option>1798</option><option>1799</option><option>1800</option><option>1801</option><option>1802</option><option>1803</option><option>1804</option><option>1805</option><option>1806</option><option>1807</option><option>1808</option><option>1809</option><option>1810</option><option>1811</option><option>1812</option><option>1813</option><option>1814</option><option>1815</option><option>1816</option><option>1817</option><option>1818</option><option>1819</option><option>1820</option><option>1821</option><option>1822</option><option>1823</option><option>1824</option><option>1825</option><option>1826</option><option>1827</option><option>1828</option><option>1829</option><option>1830</option><option>1831</option><option>1832</option><option>1833</option><option>1834</option><option>1835</option><option>1836</option><option>1837</option><option>1838</option><option>1839</option><option>1840</option><option>1841</option><option>1842</option><option>1843</option><option>1844</option><option>1845</option><option>1846</option><option>1847</option><option>1848</option><option>1849</option><option>1850</option><option>1851</option><option>1852</option><option>1853</option><option>1854</option><option>1855</option><option>1856</option><option>1857</option><option>1858</option><option>1859</option><option>1860</option><option>1861</option><option>1862</option><option>1863</option><option>1864</option><option>1865</option><option>1866</option><option>1867</option><option>1868</option><option>1869</option><option>1870</option><option>1871</option><option>1872</option><option>1873</option><option>1874</option><option>1875</option><option>1876</option><option>1877</option><option>1878</option><option>1879</option><option>1880</option><option>1881</option><option>1882</option><option>1883</option><option>1884</option><option>1885</option><option>1886</option><option>1887</option><option>1888</option><option>1889</option><option>1890</option><option>1891</option><option>1892</option><option>1893</option><option>1894</option><option>1895</option><option>1896</option><option>1897</option><option>1898</option><option>1899</option><option>1900</option><option>1901</option><option>1902</option><option>1903</option><option>1904</option></select> <a class ='next_page' href =/Biobank.php?page=2 >NEXT</a></div></td>
</tr></tfoot>

    					<tbody><tr class = 'even' pk = '{"Seqno":13391}'>
<td ><img width="20" height="20" align="center" src="/img/green.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Accessory genital glands</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
<tr class = 'odd' pk = '{"Seqno":13392}'>
<td ><img width="20" height="20" align="center" src="/img/red.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Muscle</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
<tr class = 'even' pk = '{"Seqno":13393}'>
<td ><img width="20" height="20" align="center" src="/img/red.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Prescapulary LN</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
<tr class = 'odd' pk = '{"Seqno":13394}'>
<td ><img width="20" height="20" align="center" src="/img/green.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Skin</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
<tr class = 'even' pk = '{"Seqno":13395}'>
<td ><img width="20" height="20" align="center" src="/img/green.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Skin</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
<tr class = 'odd' pk = '{"Seqno":13396}'>
<td ><img width="20" height="20" align="center" src="/img/green.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Lung</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
<tr class = 'even' pk = '{"Seqno":13397}'>
<td ><img width="20" height="20" align="center" src="/img/green.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Biliary ducts</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
<tr class = 'odd' pk = '{"Seqno":13398}'>
<td ><img width="20" height="20" align="center" src="/img/green.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Lung</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
<tr class = 'even' pk = '{"Seqno":13399}'>
<td ><img width="20" height="20" align="center" src="/img/red.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Prescapulary LN</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
<tr class = 'odd' pk = '{"Seqno":13400}'>
<td ><img width="20" height="20" align="center" src="/img/green.png"/></td>
<td >Formaline fixed</td>
<td >Histopathology</td>
<td >Phocoena phocoena(Linnaeus 1758)</td>
<td >Peripheral nervous system</td>
<td ><input type="checkbox" class="sample_select"/></td>
</tr>
 </tbody>

    				  </table></div>
<div class = "Search_search_tool" style="display:none;"> 
		<div class = "Search">
		<span>
			<div class = "Search_Box" style = "display:none">
				<div class="delSearch_Box"><a href=""><span class="ui_icon"></span></a></div>
				<div class = "filters"><p>Filter</p><select></select></div>
				<div class = "tokens"><p>Token</p><select></select></div>
				<div class = "fields"><p>Field</p><select></select></div>
				<div class = "fields" style="display:none"><p>Field</p><input ></input></div>
			</div><!--end search_box_upd-->
			<div class = "Search_Box" >
				<div class="delSearch_Box"><a href=""><span class="ui_icon"></span></a></div>
				<div class = "filters"><p>Filter</p><select></select></div>
				<div class = "tokens"><p>Token</p><select></select></div>
				<div class = "fields"><p>Field</p><select></select></div>
				<div class = "fields" style="display:none"><p>Field</p><input></input></div>
			</div><!--end search_box_upd-->
		</span>
		</div><!--end of Search-->
	<div class = "search_tool">
				<a class="Search_for" href = "" ><span class ="search" title="search for filtered samples"></span></a>
				<a class="addSearch_Box" href = "" ><span class ="add" title = "Add filter"></span></a>
		
			
			
		</div><!-- end search tool-->
</div><!-- end Search_search tool-->
</div>
<div id = "order_div">
<form>
<button value="order" class="order_samples" name="order_samples" type="submit">Confirm Order</button>
<button value="clean" class="clean_samples" name="clean_samples" type="submit">Clean Selection</button>
<button value="add" class="add_samples" name="add_samples" type="submit">Update Basket</button>
</form>
</div>		<form method="POST" action='functions/export_samples.php'>
		<button type="submit" name="testsubmit">Download</button>
		<select name="download_format"><option>XLS</option><option>XML</option><option>CSV</option></select>
		</form></div>
<div id = "order_samples"><div id = "search_selected_samples">
<div class = "search_selected_results"></div>
<div class = "Search_search_tool" style="display:none;">
<div class = "search_tool">
<a class="Search_for" href = "" ><span class ="search" title="search for filtered samples"></span></a>
</div>
</div>
</div> <form id="Order_form" method="post" action="/Biobank.php" class="default_form">
<div style="display: none;"><input type="hidden" name="_qf__Order_form" id="_qf__Order_form-0" /></div>
<fieldset id="qfauto-0">
<legend>Order</legend>
<div class="qfrow"><label class="qflabel" for="Study_Description-0"><span class="required">*</span>Study Description :</label> <div class="qfelement"><textarea ="" name="Study_Description" id="Study_Description-0"></textarea></div></div>
</fieldset>
<div class="footer"><button type="submit" name="submit" class="submit_form" value="Add">Submit</button><button type="submit" name="submit" class="submit_form" value="Update"style="display:none;">Update</button><button type="submit" name="submit" class="submit_form" value="Delete"style="display:none;">Delete</button><button value="goback" class="order_samples" name="goback" type="submit">Go Back</button></div></form></div></div>
</div>
<div id = 'Layout_footer'>
<div class ='error init'><p></p>
</div></div>
    </div>	
</div>    	
</body>
</html>


