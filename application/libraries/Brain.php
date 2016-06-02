<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brain
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function get_answer($input)
	{
		$is_question = strpos($input, "?") !== FALSE;
		$raw_input = $input;
		$input = strtolower($input);
		$input = str_replace("ÅÄÖ", "åäö", $input);
		$input = preg_replace("/[^A-Za-z0-9\-åäö ]/", "", $input);
		$words = explode(" ", $input);

		if ($this->CI->session->userdata('ask_for_name') == 'true')
		{
			$name = $this->CI->namememory->parse($words);
			return $this->CI->namememory->remember($name);
		}

		// Look for unusual words, and save to to have something to talk about
		$this->CI->wordmemory->remember_words($input);

		//Special
		if (preg_match('/^jag heter (.*)/', $input)) return $this->CI->namememory->remember($input);

		else if (preg_match('/(.*)[0-9]+\s[\+\-\*\/]\s[0-9]+(.*)/', $raw_input)) return $this->CI->calc->get($raw_input);
 
 		else if (preg_match('/^vad är (.*)(klockan|tiden)/', $input)) return $this->CI->file->read("vad_klockan", date("H.i"));
		else if (preg_match('/^(vad|vilket) är (.*)(datum|dag|månad)/', $input)) return $this->CI->file->read("vad_datum", date("Y-m-d"));
		else if (preg_match('/^(vad|vilken)(.*)vecka(.*)/', $input)) return  $this->CI->file->read("vad_vecka", date("W"));
		
		else if (preg_match('/^(vad)(.*)heter(.*)jag/', $input)) return $this->CI->namememory->retrieve();
		else if (preg_match('/^(vad)(.*)är(.*)mitt(.*)namn/', $input)) return $this->CI->namememory->retrieve();

		else if (preg_match('/^(hejdå|farväl|hej då|far väl|baj baj|bye|quit)(.*)/', $input)) return $this->CI->file->read("hej_da");
		else if (preg_match('/^(hej|tjena|morrs|hallå|hejsan|halloj)(.*)/', $input)) return $this->CI->file->read("hej");
		else if (preg_match('/^välkommen(.*)tillbaka/', $input)) return $this->CI->file->read("valkommen_tillbaka");
		else if (preg_match('/^(.*)(god|trevlig)(.*)(morgon|morron)/', $input)) return $this->CI->file->read("god_morgon");
		else if (preg_match('/^(.*)(god|trevlig)(.*)(natt|kväll)/', $input)) return $this->CI->file->read("god_natt");
		else if (preg_match('/^(.*)asl(.*)/', $input)) return $this->CI->file->read("asl");
		else if (preg_match('/^(.*)cybersex(.*)/', $input)) return $this->CI->file->read("cybersex");
		else if (preg_match('/^(.*)(herregud|herre gud|omg|oh my god|shit)(.*)/', $input)) return $this->CI->file->read("herre_gud");
		else if (preg_match('/^(.*)(du|din)(.*)bitch(.*)/', $input)) return $this->CI->file->read("du_bitch");
		else if (preg_match('/^(.*)(hatar|ogillar)(.*)du(.*)/', $input)) return $this->CI->file->read("hatar_du");
		else if (preg_match('/^(.*)(du|din|ditt)(.*)duktig(.*)/', $input)) return $this->CI->file->read("du_duktig");
		else if (preg_match('/^(.*)(du|din)(.*)dum(.*)/', $input)) return $this->CI->file->read("du_dum");
		else if (preg_match('/^(.*)(du|din)(.*)fritid(.*)/', $input)) return $this->CI->file->read("du_fritid");
		else if (preg_match('/^(.*)(du|man)(.*)gjort(.*)/', $input)) return $this->CI->file->read("du_gjort");
		else if (preg_match('/^(.*)(du|din|ditt)(.*)(homo|bög|lebb|lesb)(.*)/', $input)) return $this->CI->file->read("du_homo");
		else if (preg_match('/^(.*)(du|din|ditt)(.*)(hora|fnask|lössläppt)(.*)/', $input)) return $this->CI->file->read("du_hora");
		else if (preg_match('/^(.*)(du|din|ditt)(.*)(kön|tjej|kille|man|kvinna|hona|hane)(.*)/', $input)) return $this->CI->file->read("du_kon");
		else if (preg_match('/^(.*)du kvar(.*)/', $input)) return $this->CI->file->read("du_kvar");
		else if (preg_match('/^(.*)ser(.*)du(.*)ut(.*)/', $input)) return $this->CI->file->read("hur_ser_du_ut");
		else if (preg_match('/^(.*)(jobbar|arbetar)(.*)du(.*)/', $input)) return $this->CI->file->read("jobbar_du");
		else if (preg_match('/^(.*)kram(.*)/', $input)) return $this->CI->file->read("kram");
		else if (preg_match('/^(.*)(puss|kiss|kyss)(.*)/', $input)) return $this->CI->file->read("puss");
		else if (preg_match('/^(.*)(mår du|läget|status|zup|whazup|what\'s up)(.*)/', $input)) return $this->CI->file->read("laget");
		else if (preg_match('/^(.*)måste(.*)/', $input)) return $this->CI->file->read("maste");
		else if (preg_match('/^nu(.*)/', $input)) return $this->CI->file->read("nu");
		else if (preg_match('/^(sluta|lägg av|lägg ner(.*))/', $input)) return $this->CI->file->read("sluta");
		else if (preg_match('/^(stick|dra(.*))/', $input)) return $this->CI->file->read("stick");
		else if (preg_match('/^sug(.*)/', $input)) return $this->CI->file->read("sug");
		else if (preg_match('/^tack(.*)/', $input)) return $this->CI->file->read("tack");
		else if (preg_match('/^tråkigt(.*)/', $input)) return $this->CI->file->read("trakigt");
		else if (preg_match('/^vad (tycker|anser|gillar) du/', $input)) return $this->CI->file->read("vad_tycker_du");
		else if (preg_match('/^(tycker du om|gillar du|älskar du)(.*)/', $input)) return $this->CI->file->read("tycker_du_om");
		else if (preg_match('/^tycker(.*)du/', $input)) return $this->CI->file->read("tycker_du");
		else if (preg_match('/^(.*)(väder|vädret)(.*)/', $input)) return $this->CI->file->read("vadret");
		else if (preg_match('/^(jag tänkte|tänkte)(.*)/', $input)) return $this->CI->file->read("jag_tankte");
		else if (preg_match('/^(kul|lustigt|roligt|haha)(.*)/', $input)) return $this->CI->file->read("kul");
		else if (preg_match('/^(tråkigt|trist|uselt|kass)(.*)/', $input)) return $this->CI->file->read("trakigt");

		//Ska
		else if (preg_match('/^(.*)ska(.*)du(.*)(göra|hitta på)/', $input)) return $this->CI->file->read("ska_du_gora");
		else if (preg_match('/^(.*)ska(.*)vi(.*)(pussas|kyssas|hångla|smeka)/', $input)) return $this->CI->file->read("ska_vi_hangla");
		else if (preg_match('/^(.*)ska(.*)vi(.*)(knulla|sex|porra|samlag)/', $input)) return $this->CI->file->read("ska_vi_knulla");
		else if (preg_match('/^(.*)ska(.*)vi/', $input)) return $this->CI->file->read("ska_vi");

		//Är
		else if (preg_match('/^är(.*)du(.*)veg(.*)/', $input)) return $this->CI->file->read("du_veg");

		else if (preg_match('/^är den(.*)/', $input)) return $this->CI->file->read("ar_den");
		else if (preg_match('/^är det(.*)/', $input)) return $this->CI->file->read("ar_det");
		else if (preg_match('/^är du(.*)/', $input)) return $this->CI->file->read("ar_du");
		else if (preg_match('/^är han(.*)/', $input)) return $this->CI->file->read("ar_han");
		else if (preg_match('/^är hon(.*)/', $input)) return $this->CI->file->read("ar_hon");
		else if (preg_match('/^är jag(.*)/', $input)) return $this->CI->file->read("ar_jag");
		else if (preg_match('/^är vi(.*)/', $input)) return $this->CI->file->read("ar_vi");

		else if (preg_match('/^är (.*)/', $input)) return $this->CI->file->read("ar");

		//Har
		else if (preg_match('/^har den(.*)/', $input)) return $this->CI->file->read("har_den");
		else if (preg_match('/^har det(.*)/', $input)) return $this->CI->file->read("har_det");
		else if (preg_match('/^har(.*)du(.*)känslor/', $input)) return $this->CI->file->read("du_kanslor");
		else if (preg_match('/^har du(.*)/', $input)) return $this->CI->file->read("har_du");
		else if (preg_match('/^har han(.*)/', $input)) return $this->CI->file->read("har_han");
		else if (preg_match('/^har hon(.*)/', $input)) return $this->CI->file->read("har_hon");
		else if (preg_match('/^har jag(.*)/', $input)) return $this->CI->file->read("har_jag");
		else if (preg_match('/^har vi(.*)/', $input)) return $this->CI->file->read("har_vi");
		else if (preg_match('/^har (.*)/', $input)) return $this->CI->file->read("har");

		//Kan
		else if (preg_match('/^kan den(.*)/', $input)) return $this->CI->file->read("kan_den");
		else if (preg_match('/^kan det(.*)/', $input)) return $this->CI->file->read("kan_det");
		else if (preg_match('/^kan du(.*)/', $input)) return $this->CI->file->read("kan_du");
		else if (preg_match('/^kan han(.*)/', $input)) return $this->CI->file->read("kan_han");
		else if (preg_match('/^kan hon(.*)/', $input)) return $this->CI->file->read("kan_hon");
		else if (preg_match('/^kan jag(.*)/', $input)) return $this->CI->file->read("kan_jag");
		else if (preg_match('/^kan vi(.*)/', $input)) return $this->CI->file->read("kan_vi");
		else if (preg_match('/^kan (.*)/', $input)) return $this->CI->file->read("kan");

		//Vill
		else if (preg_match('/^vill den(.*)/', $input)) return $this->CI->file->read("vill_den");
		else if (preg_match('/^vill det(.*)/', $input)) return $this->CI->file->read("vill_det");
		else if (preg_match('/^vill du(.*)/', $input)) return $this->CI->file->read("vill_du");
		else if (preg_match('/^vill han(.*)/', $input)) return $this->CI->file->read("vill_han");
		else if (preg_match('/^vill hon(.*)/', $input)) return $this->CI->file->read("vill_hon");
		else if (preg_match('/^vill jag(.*)/', $input)) return $this->CI->file->read("vill_jag");
		else if (preg_match('/^vill vi(.*)/', $input)) return $this->CI->file->read("vill_vi");
		else if (preg_match('/^vill (.*)/', $input)) return $this->CI->file->read("vill");

		//Vilken
		else if (preg_match('/^vilken(.*)är(.*)din/', $input)) return $this->CI->file->read("vilken_ar_din");
		else if (preg_match('/^vilken/', $input)) return $this->CI->file->read("vilken");

		//Visste
		else if (preg_match('/^visste den(.*)/', $input)) return $this->CI->file->read("visste_den");
		else if (preg_match('/^visste det(.*)/', $input)) return $this->CI->file->read("visste_det");
		else if (preg_match('/^visste du(.*)/', $input)) return $this->CI->file->read("visste_du");
		else if (preg_match('/^visste han(.*)/', $input)) return $this->CI->file->read("visste_han");
		else if (preg_match('/^visste hon(.*)/', $input)) return $this->CI->file->read("visste_hon");
		else if (preg_match('/^visste jag(.*)/', $input)) return $this->CI->file->read("visste_jag");
		else if (preg_match('/^visste vi(.*)/', $input)) return $this->CI->file->read("visste_vi");
		else if (preg_match('/^visste (.*)/', $input)) return $this->CI->file->read("visste");

		//De
		else if (preg_match('/^(de|dom|dem) är(.*)/', $input)) return $this->CI->file->read("de_ar");
		else if (preg_match('/^(de|dom|dem) får(.*)/', $input)) return $this->CI->file->read("de_far");
		else if (preg_match('/^(de|dom|dem) har(.*)/', $input)) return $this->CI->file->read("de_har");
		else if (preg_match('/^(de|dom|dem) kan(.*)/', $input)) return $this->CI->file->read("de_kan");
		else if (preg_match('/^(de|dom|dem) kommer(.*)/', $input)) return $this->CI->file->read("de_kommer");
		else if (preg_match('/^(de|dom|dem) var(.*)/', $input)) return $this->CI->file->read("de_var");
		else if (preg_match('/^(de|dom|dem) vill(.*)/', $input)) return $this->CI->file->read("de_vill");

		//Den
		else if (preg_match('/^den är(.*)/', $input)) return $this->CI->file->read("den_ar");
		else if (preg_match('/^den får(.*)/', $input)) return $this->CI->file->read("den_far");
		else if (preg_match('/^den har(.*)/', $input)) return $this->CI->file->read("den_har");
		else if (preg_match('/^den kan(.*)/', $input)) return $this->CI->file->read("den_kan");
		else if (preg_match('/^den kommer(.*)/', $input)) return $this->CI->file->read("den_kommer");
		else if (preg_match('/^den var(.*)/', $input)) return $this->CI->file->read("den_var");
		else if (preg_match('/^den vill(.*)/', $input)) return $this->CI->file->read("den_vill");

		//Det
		else if (preg_match('/^det är bra(.*)/', $input)) return $this->CI->file->read("det_ar_bra");
		else if (preg_match('/^(cool|coolt|grymt|fett|nice|awesome|vad bra)(.*)/', $input)) return $this->CI->file->read("det_ar_bra");
		else if (preg_match('/^det är du(.*)/', $input)) return $this->CI->file->read("det_ar_du");

		else if (preg_match('/^det är(.*)/', $input)) return $this->CI->file->read("det_ar");
		else if (preg_match('/^det får(.*)/', $input)) return $this->CI->file->read("det_far");
		else if (preg_match('/^det har(.*)/', $input)) return $this->CI->file->read("det_har");
		else if (preg_match('/^det kan(.*)/', $input)) return $this->CI->file->read("det_kan");
		else if (preg_match('/^det kommer(.*)/', $input)) return $this->CI->file->read("det_kommer");
		else if (preg_match('/^det var(.*)/', $input)) return $this->CI->file->read("det_var");
		else if (preg_match('/^det vill(.*)/', $input)) return $this->CI->file->read("det_vill");
		else if (preg_match('/^(det samma|det samma|detsamma|desamma)(.*)/', $input)) return $this->CI->file->read("det_samma");

		//Du
		else if (preg_match('/^du(.*)är(.*)(snygg|läcker|sexig|söt)(.*)/', $input)) return $this->CI->file->read("du_snygg");
		else if (preg_match('/^vad(.*)(snygg|läcker|sexig|söt)(.*)/', $input)) return $this->CI->file->read("du_snygg");

		else if (preg_match('/^du är(.*)/', $input)) return $this->CI->file->read("du_ar");
		else if (preg_match('/^du får(.*)/', $input)) return $this->CI->file->read("du_far");
		else if (preg_match('/^du har(.*)/', $input)) return $this->CI->file->read("du_har");
		else if (preg_match('/^du kan(.*)/', $input)) return $this->CI->file->read("du_kan");
		else if (preg_match('/^du kommer(.*)/', $input)) return $this->CI->file->read("du_kommer");
		else if (preg_match('/^du var(.*)/', $input)) return $this->CI->file->read("du_var");
		else if (preg_match('/^du vill(.*)/', $input)) return $this->CI->file->read("du_vill");

		//Han
		else if (preg_match('/^han är(.*)/', $input)) return $this->CI->file->read("han_ar");
		else if (preg_match('/^han får(.*)/', $input)) return $this->CI->file->read("han_far");
		else if (preg_match('/^han har(.*)/', $input)) return $this->CI->file->read("han_har");
		else if (preg_match('/^han kan(.*)/', $input)) return $this->CI->file->read("han_kan");
		else if (preg_match('/^han kommer(.*)/', $input)) return $this->CI->file->read("han_kommer");
		else if (preg_match('/^han var(.*)/', $input)) return $this->CI->file->read("han_var");
		else if (preg_match('/^han vill(.*)/', $input)) return $this->CI->file->read("han_vill");

		//Hon
		else if (preg_match('/^hon är(.*)/', $input)) return $this->CI->file->read("hon_ar");
		else if (preg_match('/^hon får(.*)/', $input)) return $this->CI->file->read("hon_far");
		else if (preg_match('/^hon har(.*)/', $input)) return $this->CI->file->read("hon_har");
		else if (preg_match('/^hon kan(.*)/', $input)) return $this->CI->file->read("hon_kan");
		else if (preg_match('/^hon kommer(.*)/', $input)) return $this->CI->file->read("hon_kommer");
		else if (preg_match('/^hon var(.*)/', $input)) return $this->CI->file->read("hon_var");
		else if (preg_match('/^hon vill(.*)/', $input)) return $this->CI->file->read("hon_vill");

		//Jag
		else if (preg_match('/^jag är(.*)/', $input)) return $this->CI->file->read("jag_ar");
		else if (preg_match('/^jag får(.*)/', $input)) return $this->CI->file->read("jag_far");
		else if (preg_match('/^jag har(.*)/', $input)) return $this->CI->file->read("jag_har");
		else if (preg_match('/^jag kan(.*)/', $input)) return $this->CI->file->read("jag_kan");
		else if (preg_match('/^jag kommer(.*)/', $input)) return $this->CI->file->read("jag_kommer");
		else if (preg_match('/^jag var(.*)/', $input)) return $this->CI->file->read("jag_var");
		else if (preg_match('/^jag vill(.*)/', $input)) return $this->CI->file->read("jag_vill");

		else if (preg_match('/^jag(.*)(älskar|kär|tycker om)(.*)dig/', $input)) return $this->CI->file->read("jag_alskar_dig");
		else if (preg_match('/^jag(.*)(hatar|avskyr|ogillar)(.*)dig/', $input)) return $this->CI->file->read("jag_hatar_dig");
		else if (preg_match('/^(.*)jag(.*)tillbaka(.*)/', $input)) return $this->CI->file->read("jag_tillbaka");
		else if (preg_match('/^jag(.*)/', $input)) return $this->CI->file->read("jag");

		//När
		else if (preg_match('/^när är(.*)/', $input)) return $this->CI->file->read("nar_ar");
		else if (preg_match('/^när får(.*)/', $input)) return $this->CI->file->read("nar_far");
		else if (preg_match('/^när har(.*)/', $input)) return $this->CI->file->read("nar_har");
		else if (preg_match('/^när kan(.*)/', $input)) return $this->CI->file->read("nar_kan");
		else if (preg_match('/^när kommer(.*)/', $input)) return $this->CI->file->read("nar_kommer");
		else if (preg_match('/^när var(.*)/', $input)) return $this->CI->file->read("nar_var");
		else if (preg_match('/^när vill(.*)/', $input)) return $this->CI->file->read("nar_vill");

		else if (preg_match('/^när ska(.*)/', $input)) return $this->CI->file->read("nar_ska");
		else if (preg_match('/^när (.*)/', $input)) return $this->CI->file->read("nar");

		//Vad
		else if (preg_match('/^vad är (.*)(en|ett) (.*)/', $input)) return $this->CI->wikipedia->read($words[3]);
		else if (preg_match('/^vad är (.*)/', $input)) return $this->CI->wikipedia->read($words[2]);

		else if (preg_match('/^(vad|vem)(.*)är(.*)du/', $input)) return $this->CI->file->read("vad_ar_du");
		else if (preg_match('/^(vad|vem)(.*)(skapat|skapare)(.*)/', $input)) return $this->CI->file->read("vem_skapat_dig");
		else if (preg_match('/^(vad(.*)gör(.*)du)|vad händer/', $input)) return $this->CI->file->read("vad_gor_du");
		else if (preg_match('/^(vad(.*)för(.*)dig)/', $input)) return $this->CI->file->read("vad_gor_du");
		else if (preg_match('/^vad(.*)heter(.*)du/', $input)) return $this->CI->file->read("vad_heter_du");
		else if (preg_match('/^vad(.*)heter(.*)/', $input)) return $this->CI->file->read("vad_heter");
		else if (preg_match('/^vad(.*)kan(.*)du/', $input)) return $this->CI->file->read("vad_kan_du");
		else if (preg_match('/^vad(.*)vet(.*)om(.*)mig/', $input)) return $this->CI->wordmemory->retrieve();
		else if (preg_match('/^vad(.*)trevligt/', $input)) return $this->CI->file->read("vad_trevligt");
		else if (preg_match('/^vad(.*)vet(.*)du/', $input)) return $this->CI->file->read("vad_vet_du");

		else if (preg_match('/^vad är(.*)/', $input)) return $this->CI->file->read("vad_ar");
		else if (preg_match('/^vad får(.*)/', $input)) return $this->CI->file->read("vad_far");
		else if (preg_match('/^vad har(.*)/', $input)) return $this->CI->file->read("vad_har");
		else if (preg_match('/^vad kan(.*)/', $input)) return $this->CI->file->read("vad_kan");
		else if (preg_match('/^vad kommer(.*)/', $input)) return $this->CI->file->read("vad_kommer");
		else if (preg_match('/^vad var(.*)/', $input)) return $this->CI->file->read("vad_var");
		else if (preg_match('/^vad vill(.*)du/', $input)) return $this->CI->file->read("vad_vill_du");
		else if (preg_match('/^vad vill(.*)/', $input)) return $this->CI->file->read("vad_vill");

		else if (preg_match('/^vad ska(.*)/', $input)) return $this->CI->file->read("vad_ska");
		else if (preg_match('/^vad (.*)/', $input)) return $this->CI->file->read("vad");

		//Varför
		else if (preg_match('/^varför är(.*)/', $input)) return $this->CI->file->read("varfor_ar");
		else if (preg_match('/^varför får(.*)/', $input)) return $this->CI->file->read("varfor_far");
		else if (preg_match('/^varför har(.*)/', $input)) return $this->CI->file->read("varfor_har");
		else if (preg_match('/^varför kan(.*)/', $input)) return $this->CI->file->read("varfor_kan");
		else if (preg_match('/^varför kommer(.*)/', $input)) return $this->CI->file->read("varfor_kommer");
		else if (preg_match('/^varför var(.*)/', $input)) return $this->CI->file->read("varfor_var");
		else if (preg_match('/^varför vill(.*)/', $input)) return $this->CI->file->read("varfor_vill");

		else if (preg_match('/^varför ska(.*)/', $input)) return $this->CI->file->read("varfor_ska");
		else if (preg_match('/^varför (.*)/', $input)) return $this->CI->file->read("varfor");

		//Var
		else if (preg_match('/^var(.*) är(.*)/', $input)) return $this->CI->file->read("var_ar");
		else if (preg_match('/^var(.*) får(.*)/', $input)) return $this->CI->file->read("var_far");
		else if (preg_match('/^var(.*) har(.*)/', $input)) return $this->CI->file->read("var_har");
		else if (preg_match('/^var(.*) kan(.*)/', $input)) return $this->CI->file->read("var_kan");
		else if (preg_match('/^var(.*) kommer(.*)/', $input)) return $this->CI->file->read("var_kommer");
		else if (preg_match('/^var(.*) vill(.*)/', $input)) return $this->CI->file->read("var_vill");

		else if (preg_match('/^var(.*) ska(.*)/', $input)) return $this->CI->file->read("var_ska");
		else if (preg_match('/^var(.*)bor(.*)du(.*)/', $input)) return $this->CI->file->read("var_bor_du");
		else if (preg_match('/^var(.*)/', $input)) return $this->CI->file->read("var");

		//Vem
		else if (preg_match('/^vem är (.*)/', $input)) return $this->CI->wikipedia->read($words[2]);

		else if (preg_match('/^vem är(.*)/', $input)) return $this->CI->file->read("vem_ar");
		else if (preg_match('/^vem får(.*)/', $input)) return $this->CI->file->read("vem_far");
		else if (preg_match('/^vem har(.*)/', $input)) return $this->CI->file->read("vem_har");
		else if (preg_match('/^vem kan(.*)/', $input)) return $this->CI->file->read("vem_kan");
		else if (preg_match('/^vem kommer(.*)/', $input)) return $this->CI->file->read("vem_kommer");
		else if (preg_match('/^vem vill(.*)/', $input)) return $this->CI->file->read("vem_vill");
		else if (preg_match('/^vem ska(.*)/', $input)) return $this->CI->file->read("vem_ska");

		else if (preg_match('/^vem (.*)/', $input)) return $this->CI->file->read("vem");

		//Vi
		else if (preg_match('/^vi är(.*)/', $input)) return $this->CI->file->read("vi_ar");
		else if (preg_match('/^vi får(.*)/', $input)) return $this->CI->file->read("vi_far");
		else if (preg_match('/^vi har(.*)/', $input)) return $this->CI->file->read("vi_har");
		else if (preg_match('/^vi kan(.*)/', $input)) return $this->CI->file->read("vi_kan");
		else if (preg_match('/^vi kommer(.*)/', $input)) return $this->CI->file->read("vi_kommer");
		else if (preg_match('/^vi vill(.*)/', $input)) return $this->CI->file->read("vi_vill");

		else if (preg_match('/^vi var(.*)/', $input)) return $this->CI->file->read("vi_var");

		//Hur
		else if (preg_match('/^hur gammal(.*)du(.*)/', $input)) return $this->CI->file->read("hur_gammal_du");
		else if (preg_match('/^hur kan(.*)/', $input)) return $this->CI->file->read("hur_kan");
		else if (preg_match('/^hur var(.*)/', $input)) return $this->CI->file->read("hur_var");
		else if (preg_match('/^hur vill(.*)/', $input)) return $this->CI->file->read("hur_vill");
		else if (preg_match('/^hur(.*)/', $input)) return $this->CI->file->read("hur");

		else if (preg_match('/^(\:\)|\:\(|\:o|\:d)/', $input)) return $this->CI->file->read("smiley");
		else if (preg_match('/^(ja|japp|jao|yes|jadå|jaa)(.*)/', $input)) return $this->CI->file->read("ja");
		else if (preg_match('/^(jo|jodå|jo då|joho)(.*)/', $input)) return $this->CI->file->read("jo");
		else if (preg_match('/^(nej|nope|nja|no|nejdå|nepp)(.*)/', $input)) return $this->CI->file->read("nej");

		// Din / Ditt
		else if (preg_match('/^(.*)din(.*)/', $input)) return $this->CI->file->read("din");
		else if (preg_match('/^(.*)ditt(.*)/', $input)) return $this->CI->file->read("ditt");

		else if ($is_question === TRUE) return $this->CI->file->read("question");

		else {
			$random = rand(1,8);
			if ($random == 1) $answer = $this->CI->images->send();
			else if ($random == 2 || $random == 3) $answer = $this->CI->wordmemory->mention_memory();
			else if ($random == 4) $answer = $this->CI->wikipedia->read_random();
			else $answer = $this->CI->file->read("default_answer");

			return $answer;
		}
	}
}

/* End of file Brain.php */