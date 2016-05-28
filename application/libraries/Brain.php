<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brain
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function get_answer($input)
	{
		$stripped_input = str_replace("?", "", $input);
		$stripped_input = str_replace("!", "", $stripped_input);
		$stripped_input = str_replace(".", "", $stripped_input);
		$stripped_input = str_replace(",", "", $stripped_input);
		$words = explode(" ", $stripped_input);

		if ($this->CI->session->userdata('ask_for_name') == 'true')
		{
			$position = 0;
			if ($words[0] == "jag" && $words[1] == "heter") $position = 2;
			if ($words[0] == "mitt" && $words[1] == "namn") $position = 4;
			if ($words[0] == "namnet" && $words[1] == "är") $position = 2;
			
			return $this->remember_name($words[$position]);
		}

		switch($input)
		{
			//Special
			case (preg_match('/^jag heter (.*)/', $input) ? true : false): return $this->remember_name($input); break;

			case (preg_match('/(.*)[0-9]+\s[\+\-\*\/]\s[0-9]+(.*)/', $input) ? true : false): return $this->get_calc($input); break;
			case (preg_match('/^vad är (.*)(en|ett) (.*)/', $input) ? true : false): return $this->read_wikipedia($words[3]); break;
			case (preg_match('/^vad är (.*)(klockan|tiden)/', $input) ? true : false): return $this->get_time(); break;
			case (preg_match('/^(vad|vilket) är (.*)(datum|dag|månad)/', $input) ? true : false): return $this->get_date(); break;
			case (preg_match('/^(vad|vilken)(.*)vecka(.*)/', $input) ? true : false): return $this->get_week(); break;
			case (preg_match('/^(vad)(.*)heter(.*)jag/', $input) ? true : false): return $this->get_name(); break;
			case (preg_match('/^(vad)(.*)är(.*)mitt(.*)namn/', $input) ? true : false): return $this->get_name(); break;

			case (preg_match('/^(hejdå|farväl|hej då|far väl|baj baj|bye|quit)(.*)/', $input) ? true : false): return $this->read_file("hej_da"); break;
			case (preg_match('/^(hej|tjena|morrs|hallå|hejsan|halloj)(.*)/', $input) ? true : false): return $this->read_file("hej"); break;
			case (preg_match('/^välkommen(.*)tillbaka/', $input) ? true : false): return $this->read_file("valkommen_tillbaka"); break;
			case (preg_match('/^(.*)(god|trevlig)(.*)(morgon|morron)/', $input) ? true : false): return $this->read_file("god_morgon"); break;
			case (preg_match('/^(.*)(god|trevlig)(.*)(natt|kväll)/', $input) ? true : false): return $this->read_file("god_natt"); break;
			case (preg_match('/^(.*)asl(.*)/', $input) ? true : false): return $this->read_file("asl"); break;
			case (preg_match('/^(.*)cybersex(.*)/', $input) ? true : false): return $this->read_file("cybersex"); break;
			case (preg_match('/^(.*)(du|din)(.*)bitch(.*)/', $input) ? true : false): return $this->read_file("du_bitch"); break;
			case (preg_match('/^(.*)(hatar|ogillar)(.*)du(.*)/', $input) ? true : false): return $this->read_file("hatar_du"); break;
			case (preg_match('/^(.*)(du|din|ditt)(.*)duktig(.*)/', $input) ? true : false): return $this->read_file("du_duktig"); break;
			case (preg_match('/^(.*)(du|din)(.*)dum(.*)/', $input) ? true : false): return $this->read_file("du_dum"); break;
			case (preg_match('/^(.*)(du|din)(.*)fritid(.*)/', $input) ? true : false): return $this->read_file("du_fritid"); break;
			case (preg_match('/^(.*)(du|man)(.*)gjort(.*)/', $input) ? true : false): return $this->read_file("du_gjort"); break;
			case (preg_match('/^(.*)(du|din|ditt)(.*)(homo|bög|lebb|lesb)(.*)/', $input) ? true : false): return $this->read_file("du_homo"); break;
			case (preg_match('/^(.*)(du|din|ditt)(.*)(hora|fnask|lössläppt)(.*)/', $input) ? true : false): return $this->read_file("du_hora"); break;
			case (preg_match('/^(.*)(du|din|ditt)(.*)(kön|tjej|kille|man|kvinna|hona|hane)(.*)/', $input) ? true : false): return $this->read_file("du_kon"); break;
			case (preg_match('/^(.*)du kvar(.*)/', $input) ? true : false): return $this->read_file("du_kvar"); break;
			case (preg_match('/^(.*)ser(.*)du(.*)ut(.*)/', $input) ? true : false): return $this->read_file("hur_ser_du_ut"); break;
			case (preg_match('/^(.*)(jobbar|arbetar)(.*)du(.*)/', $input) ? true : false): return $this->read_file("jobbar_du"); break;
			case (preg_match('/^(.*)kram(.*)/', $input) ? true : false): return $this->read_file("kram"); break;
			case (preg_match('/^(.*)(puss|kiss|kyss)(.*)/', $input) ? true : false): return $this->read_file("puss"); break;
			case (preg_match('/^(.*)(mår du|läget|status|zup|whazup|what\'s up)(.*)/', $input) ? true : false): return $this->read_file("laget"); break;
			case (preg_match('/^(.*)måste(.*)/', $input) ? true : false): return $this->read_file("maste"); break;
			case (preg_match('/^nu(.*)/', $input) ? true : false): return $this->read_file("nu"); break;
			case (preg_match('/^(sluta|lägg av|lägg ner(.*))/', $input) ? true : false): return $this->read_file("sluta"); break;
			case (preg_match('/^(stick|dra(.*))/', $input) ? true : false): return $this->read_file("stick"); break;
			case (preg_match('/^sug(.*)/', $input) ? true : false): return $this->read_file("sug"); break;
			case (preg_match('/^tack(.*)/', $input) ? true : false): return $this->read_file("tack"); break;
			case (preg_match('/^tråkigt(.*)/', $input) ? true : false): return $this->read_file("trakigt"); break;
			case (preg_match('/^vad (tycker|anser|gillar) du/', $input) ? true : false): return $this->read_file("vad_tycker_du"); break;
			case (preg_match('/^(tycker du om|gillar du|älskar du)(.*)/', $input) ? true : false): return $this->read_file("tycker_du_om"); break;
			case (preg_match('/^tycker(.*)du/', $input) ? true : false): return $this->read_file("tycker_du"); break;
			case (preg_match('/^(.*)(väder|vädret)(.*)/', $input) ? true : false): return $this->read_file("vadret"); break;
			case (preg_match('/^(jag tänkte|tänkte)(.*)/', $input) ? true : false): return $this->read_file("jag_tankte"); break;
			case (preg_match('/^(kul|lustigt|roligt|haha)(.*)/', $input) ? true : false): return $this->read_file("kul"); break;
			case (preg_match('/^(tråkigt|trist|uselt|kass)(.*)/', $input) ? true : false): return $this->read_file("trakigt"); break;

			case (preg_match('/^(.*)din(.*)/', $input) ? true : false): return $this->read_file("din"); break;
			case (preg_match('/^(.*)ditt(.*)/', $input) ? true : false): return $this->read_file("ditt"); break;

			//Ska
			case (preg_match('/^(.*)ska(.*)du(.*)(göra|hitta på)/', $input) ? true : false): return $this->read_file("ska_du_gora"); break;
			case (preg_match('/^(.*)ska(.*)vi(.*)(pussas|kyssas|hångla|smeka)/', $input) ? true : false): return $this->read_file("ska_vi_hangla"); break;
			case (preg_match('/^(.*)ska(.*)vi(.*)(knulla|sex|porra|samlag)/', $input) ? true : false): return $this->read_file("ska_vi_knulla"); break;
			case (preg_match('/^(.*)ska(.*)vi/', $input) ? true : false): return $this->read_file("ska_vi"); break;

			//Är
			case (preg_match('/^är(.*)du(.*)veg(.*)/', $input) ? true : false): return $this->read_file("du_veg"); break;

			case (preg_match('/^är den(.*)/', $input) ? true : false): return $this->read_file("ar_den"); break;
			case (preg_match('/^är det(.*)/', $input) ? true : false): return $this->read_file("ar_det"); break;
			case (preg_match('/^är du(.*)/', $input) ? true : false): return $this->read_file("ar_du"); break;
			case (preg_match('/^är han(.*)/', $input) ? true : false): return $this->read_file("ar_han"); break;
			case (preg_match('/^är hon(.*)/', $input) ? true : false): return $this->read_file("ar_hon"); break;
			case (preg_match('/^är jag(.*)/', $input) ? true : false): return $this->read_file("ar_jag"); break;
			case (preg_match('/^är vi(.*)/', $input) ? true : false): return $this->read_file("ar_vi"); break;

			case (preg_match('/^är (.*)/', $input) ? true : false): return $this->read_file("ar"); break;

			//Har
			case (preg_match('/^har den(.*)/', $input) ? true : false): return $this->read_file("har_den"); break;
			case (preg_match('/^har det(.*)/', $input) ? true : false): return $this->read_file("har_det"); break;
			case (preg_match('/^har du(.*)/', $input) ? true : false): return $this->read_file("har_du"); break;
			case (preg_match('/^har han(.*)/', $input) ? true : false): return $this->read_file("har_han"); break;
			case (preg_match('/^har hon(.*)/', $input) ? true : false): return $this->read_file("har_hon"); break;
			case (preg_match('/^har jag(.*)/', $input) ? true : false): return $this->read_file("har_jag"); break;
			case (preg_match('/^har vi(.*)/', $input) ? true : false): return $this->read_file("har_vi"); break;
			case (preg_match('/^har (.*)/', $input) ? true : false): return $this->read_file("har"); break;

			//Kan
			case (preg_match('/^kan den(.*)/', $input) ? true : false): return $this->read_file("kan_den"); break;
			case (preg_match('/^kan det(.*)/', $input) ? true : false): return $this->read_file("kan_det"); break;
			case (preg_match('/^kan du(.*)/', $input) ? true : false): return $this->read_file("kan_du"); break;
			case (preg_match('/^kan han(.*)/', $input) ? true : false): return $this->read_file("kan_han"); break;
			case (preg_match('/^kan hon(.*)/', $input) ? true : false): return $this->read_file("kan_hon"); break;
			case (preg_match('/^kan jag(.*)/', $input) ? true : false): return $this->read_file("kan_jag"); break;
			case (preg_match('/^kan vi(.*)/', $input) ? true : false): return $this->read_file("kan_vi"); break;
			case (preg_match('/^kan (.*)/', $input) ? true : false): return $this->read_file("kan"); break;

			//Vill
			case (preg_match('/^vill den(.*)/', $input) ? true : false): return $this->read_file("vill_den"); break;
			case (preg_match('/^vill det(.*)/', $input) ? true : false): return $this->read_file("vill_det"); break;
			case (preg_match('/^vill du(.*)/', $input) ? true : false): return $this->read_file("vill_du"); break;
			case (preg_match('/^vill han(.*)/', $input) ? true : false): return $this->read_file("vill_han"); break;
			case (preg_match('/^vill hon(.*)/', $input) ? true : false): return $this->read_file("vill_hon"); break;
			case (preg_match('/^vill jag(.*)/', $input) ? true : false): return $this->read_file("vill_jag"); break;
			case (preg_match('/^vill vi(.*)/', $input) ? true : false): return $this->read_file("vill_vi"); break;
			case (preg_match('/^vill (.*)/', $input) ? true : false): return $this->read_file("vill"); break;

			//Visste
			case (preg_match('/^visste den(.*)/', $input) ? true : false): return $this->read_file("visste_den"); break;
			case (preg_match('/^visste det(.*)/', $input) ? true : false): return $this->read_file("visste_det"); break;
			case (preg_match('/^visste du(.*)/', $input) ? true : false): return $this->read_file("visste_du"); break;
			case (preg_match('/^visste han(.*)/', $input) ? true : false): return $this->read_file("visste_han"); break;
			case (preg_match('/^visste hon(.*)/', $input) ? true : false): return $this->read_file("visste_hon"); break;
			case (preg_match('/^visste jag(.*)/', $input) ? true : false): return $this->read_file("visste_jag"); break;
			case (preg_match('/^visste vi(.*)/', $input) ? true : false): return $this->read_file("visste_vi"); break;
			case (preg_match('/^visste (.*)/', $input) ? true : false): return $this->read_file("visste"); break;

			//De
			case (preg_match('/^(de|dom|dem) är(.*)/', $input) ? true : false): return $this->read_file("de_ar"); break;
			case (preg_match('/^(de|dom|dem) får(.*)/', $input) ? true : false): return $this->read_file("de_far"); break;
			case (preg_match('/^(de|dom|dem) har(.*)/', $input) ? true : false): return $this->read_file("de_har"); break;
			case (preg_match('/^(de|dom|dem) kan(.*)/', $input) ? true : false): return $this->read_file("de_kan"); break;
			case (preg_match('/^(de|dom|dem) kommer(.*)/', $input) ? true : false): return $this->read_file("de_kommer"); break;
			case (preg_match('/^(de|dom|dem) var(.*)/', $input) ? true : false): return $this->read_file("de_var"); break;
			case (preg_match('/^(de|dom|dem) vill(.*)/', $input) ? true : false): return $this->read_file("de_vill"); break;

			//Den
			case (preg_match('/^den är(.*)/', $input) ? true : false): return $this->read_file("den_ar"); break;
			case (preg_match('/^den får(.*)/', $input) ? true : false): return $this->read_file("den_far"); break;
			case (preg_match('/^den har(.*)/', $input) ? true : false): return $this->read_file("den_har"); break;
			case (preg_match('/^den kan(.*)/', $input) ? true : false): return $this->read_file("den_kan"); break;
			case (preg_match('/^den kommer(.*)/', $input) ? true : false): return $this->read_file("den_kommer"); break;
			case (preg_match('/^den var(.*)/', $input) ? true : false): return $this->read_file("den_var"); break;
			case (preg_match('/^den vill(.*)/', $input) ? true : false): return $this->read_file("den_vill"); break;

			//Det
			case (preg_match('/^det är bra(.*)/', $input) ? true : false): return $this->read_file("det_ar_bra"); break;
			case (preg_match('/^det är du(.*)/', $input) ? true : false): return $this->read_file("det_ar_du"); break;

			case (preg_match('/^det är(.*)/', $input) ? true : false): return $this->read_file("det_ar"); break;
			case (preg_match('/^det får(.*)/', $input) ? true : false): return $this->read_file("det_far"); break;
			case (preg_match('/^det har(.*)/', $input) ? true : false): return $this->read_file("det_har"); break;
			case (preg_match('/^det kan(.*)/', $input) ? true : false): return $this->read_file("det_kan"); break;
			case (preg_match('/^det kommer(.*)/', $input) ? true : false): return $this->read_file("det_kommer"); break;
			case (preg_match('/^det var(.*)/', $input) ? true : false): return $this->read_file("det_var"); break;
			case (preg_match('/^det vill(.*)/', $input) ? true : false): return $this->read_file("det_vill"); break;
			case (preg_match('/^(det samma|det samma)(.*)/', $input) ? true : false): return $this->read_file("det_samma"); break;

			//Du
			case (preg_match('/^du(.*)är(.*)(snygg|het|läcker|sexig|söt)(.*)/', $input) ? true : false): return $this->read_file("du_snygg"); break;

			case (preg_match('/^du är(.*)/', $input) ? true : false): return $this->read_file("du_ar"); break;
			case (preg_match('/^du får(.*)/', $input) ? true : false): return $this->read_file("du_far"); break;
			case (preg_match('/^du har(.*)/', $input) ? true : false): return $this->read_file("du_har"); break;
			case (preg_match('/^du kan(.*)/', $input) ? true : false): return $this->read_file("du_kan"); break;
			case (preg_match('/^du kommer(.*)/', $input) ? true : false): return $this->read_file("du_kommer"); break;
			case (preg_match('/^du var(.*)/', $input) ? true : false): return $this->read_file("du_var"); break;
			case (preg_match('/^du vill(.*)/', $input) ? true : false): return $this->read_file("du_vill"); break;

			//Han
			case (preg_match('/^han är(.*)/', $input) ? true : false): return $this->read_file("han_ar"); break;
			case (preg_match('/^han får(.*)/', $input) ? true : false): return $this->read_file("han_far"); break;
			case (preg_match('/^han har(.*)/', $input) ? true : false): return $this->read_file("han_har"); break;
			case (preg_match('/^han kan(.*)/', $input) ? true : false): return $this->read_file("han_kan"); break;
			case (preg_match('/^han kommer(.*)/', $input) ? true : false): return $this->read_file("han_kommer"); break;
			case (preg_match('/^han var(.*)/', $input) ? true : false): return $this->read_file("han_var"); break;
			case (preg_match('/^han vill(.*)/', $input) ? true : false): return $this->read_file("han_vill"); break;

			//Hon
			case (preg_match('/^hon är(.*)/', $input) ? true : false): return $this->read_file("hon_ar"); break;
			case (preg_match('/^hon får(.*)/', $input) ? true : false): return $this->read_file("hon_far"); break;
			case (preg_match('/^hon har(.*)/', $input) ? true : false): return $this->read_file("hon_har"); break;
			case (preg_match('/^hon kan(.*)/', $input) ? true : false): return $this->read_file("hon_kan"); break;
			case (preg_match('/^hon kommer(.*)/', $input) ? true : false): return $this->read_file("hon_kommer"); break;
			case (preg_match('/^hon var(.*)/', $input) ? true : false): return $this->read_file("hon_var"); break;
			case (preg_match('/^hon vill(.*)/', $input) ? true : false): return $this->read_file("hon_vill"); break;

			//Jag
			case (preg_match('/^jag är(.*)/', $input) ? true : false): return $this->read_file("jag_ar"); break;
			case (preg_match('/^jag får(.*)/', $input) ? true : false): return $this->read_file("jag_far"); break;
			case (preg_match('/^jag har(.*)/', $input) ? true : false): return $this->read_file("jag_har"); break;
			case (preg_match('/^jag kan(.*)/', $input) ? true : false): return $this->read_file("jag_kan"); break;
			case (preg_match('/^jag kommer(.*)/', $input) ? true : false): return $this->read_file("jag_kommer"); break;
			case (preg_match('/^jag var(.*)/', $input) ? true : false): return $this->read_file("jag_var"); break;
			case (preg_match('/^jag vill(.*)/', $input) ? true : false): return $this->read_file("jag_vill"); break;

			case (preg_match('/^jag(.*)(älskar|kär|tycker om)(.*)dig/', $input) ? true : false): return $this->read_file("jag_alskar_dig"); break;
			case (preg_match('/^jag(.*)(hatar|avskyr|ogillar)(.*)dig/', $input) ? true : false): return $this->read_file("jag_hatar_dig"); break;
			case (preg_match('/^(.*)jag(.*)tillbaka(.*)/', $input) ? true : false): return $this->read_file("jag_tillbaka"); break;
			case (preg_match('/^jag(.*)/', $input) ? true : false): return $this->read_file("jag"); break;

			//När
			case (preg_match('/^när är(.*)/', $input) ? true : false): return $this->read_file("nar_ar"); break;
			case (preg_match('/^när får(.*)/', $input) ? true : false): return $this->read_file("nar_far"); break;
			case (preg_match('/^när har(.*)/', $input) ? true : false): return $this->read_file("nar_har"); break;
			case (preg_match('/^när kan(.*)/', $input) ? true : false): return $this->read_file("nar_kan"); break;
			case (preg_match('/^när kommer(.*)/', $input) ? true : false): return $this->read_file("nar_kommer"); break;
			case (preg_match('/^när var(.*)/', $input) ? true : false): return $this->read_file("nar_var"); break;
			case (preg_match('/^när vill(.*)/', $input) ? true : false): return $this->read_file("nar_vill"); break;

			case (preg_match('/^när ska(.*)/', $input) ? true : false): return $this->read_file("nar_ska"); break;
			case (preg_match('/^när (.*)/', $input) ? true : false): return $this->read_file("nar"); break;

			//Vad
			case (preg_match('/^(vad|vem)(.*)är(.*)du/', $input) ? true : false): return $this->read_file("vad_ar_du"); break;
			case (preg_match('/^(vad(.*)gör(.*)du)|vad händer/', $input) ? true : false): return $this->read_file("vad_gor_du"); break;
			case (preg_match('/^(vad(.*)för(.*)dig)/', $input) ? true : false): return $this->read_file("vad_gor_du"); break;
			case (preg_match('/^vad(.*)heter(.*)du/', $input) ? true : false): return $this->read_file("vad_heter_du"); break;
			case (preg_match('/^vad(.*)heter(.*)/', $input) ? true : false): return $this->read_file("vad_heter"); break;
			case (preg_match('/^vad(.*)kan(.*)du/', $input) ? true : false): return $this->read_file("vad_kan_du"); break;
			case (preg_match('/^vad(.*)vet(.*)du/', $input) ? true : false): return $this->read_file("vad_vet_du"); break;

			case (preg_match('/^vad är(.*)/', $input) ? true : false): return $this->read_file("vad_ar"); break;
			case (preg_match('/^vad får(.*)/', $input) ? true : false): return $this->read_file("vad_far"); break;
			case (preg_match('/^vad har(.*)/', $input) ? true : false): return $this->read_file("vad_har"); break;
			case (preg_match('/^vad kan(.*)/', $input) ? true : false): return $this->read_file("vad_kan"); break;
			case (preg_match('/^vad kommer(.*)/', $input) ? true : false): return $this->read_file("vad_kommer"); break;
			case (preg_match('/^vad var(.*)/', $input) ? true : false): return $this->read_file("vad_var"); break;
			case (preg_match('/^vad vill(.*)du/', $input) ? true : false): return $this->read_file("vad_vill_du"); break;
			case (preg_match('/^vad vill(.*)/', $input) ? true : false): return $this->read_file("vad_vill"); break;

			case (preg_match('/^vad ska(.*)/', $input) ? true : false): return $this->read_file("vad_ska"); break;
			case (preg_match('/^vad (.*)/', $input) ? true : false): return $this->read_file("vad"); break;

			//Varför
			case (preg_match('/^varför är(.*)/', $input) ? true : false): return $this->read_file("varfor_ar"); break;
			case (preg_match('/^varför får(.*)/', $input) ? true : false): return $this->read_file("varfor_far"); break;
			case (preg_match('/^varför har(.*)/', $input) ? true : false): return $this->read_file("varfor_har"); break;
			case (preg_match('/^varför kan(.*)/', $input) ? true : false): return $this->read_file("varfor_kan"); break;
			case (preg_match('/^varför kommer(.*)/', $input) ? true : false): return $this->read_file("varfor_kommer"); break;
			case (preg_match('/^varför var(.*)/', $input) ? true : false): return $this->read_file("varfor_var"); break;
			case (preg_match('/^varför vill(.*)/', $input) ? true : false): return $this->read_file("varfor_vill"); break;

			case (preg_match('/^varför ska(.*)/', $input) ? true : false): return $this->read_file("varfor_ska"); break;
			case (preg_match('/^varför (.*)/', $input) ? true : false): return $this->read_file("varfor"); break;

			//Var
			case (preg_match('/^var(.*) är(.*)/', $input) ? true : false): return $this->read_file("var_ar"); break;
			case (preg_match('/^var(.*) får(.*)/', $input) ? true : false): return $this->read_file("var_far"); break;
			case (preg_match('/^var(.*) har(.*)/', $input) ? true : false): return $this->read_file("var_har"); break;
			case (preg_match('/^var(.*) kan(.*)/', $input) ? true : false): return $this->read_file("var_kan"); break;
			case (preg_match('/^var(.*) kommer(.*)/', $input) ? true : false): return $this->read_file("var_kommer"); break;
			case (preg_match('/^var(.*) vill(.*)/', $input) ? true : false): return $this->read_file("var_vill"); break;

			case (preg_match('/^var(.*) ska(.*)/', $input) ? true : false): return $this->read_file("var_ska"); break;
			case (preg_match('/^var(.*)bor(.*)du(.*)/', $input) ? true : false): return $this->read_file("var_bor_du"); break;
			case (preg_match('/^var(.*)/', $input) ? true : false): return $this->read_file("var"); break;

			//Vem
			case (preg_match('/^vem är(.*)/', $input) ? true : false): return $this->read_file("vem_ar"); break;
			case (preg_match('/^vem får(.*)/', $input) ? true : false): return $this->read_file("vem_far"); break;
			case (preg_match('/^vem har(.*)/', $input) ? true : false): return $this->read_file("vem_har"); break;
			case (preg_match('/^vem kan(.*)/', $input) ? true : false): return $this->read_file("vem_kan"); break;
			case (preg_match('/^vem kommer(.*)/', $input) ? true : false): return $this->read_file("vem_kommer"); break;
			case (preg_match('/^vem vill(.*)/', $input) ? true : false): return $this->read_file("vem_vill"); break;

			case (preg_match('/^vem ska(.*)/', $input) ? true : false): return $this->read_file("vem_ska"); break;
			case (preg_match('/^vem (.*)/', $input) ? true : false): return $this->read_file("vem"); break;

			//Vi
			case (preg_match('/^vi är(.*)/', $input) ? true : false): return $this->read_file("vi_ar"); break;
			case (preg_match('/^vi får(.*)/', $input) ? true : false): return $this->read_file("vi_far"); break;
			case (preg_match('/^vi har(.*)/', $input) ? true : false): return $this->read_file("vi_har"); break;
			case (preg_match('/^vi kan(.*)/', $input) ? true : false): return $this->read_file("vi_kan"); break;
			case (preg_match('/^vi kommer(.*)/', $input) ? true : false): return $this->read_file("vi_kommer"); break;
			case (preg_match('/^vi vill(.*)/', $input) ? true : false): return $this->read_file("vi_vill"); break;

			case (preg_match('/^vi var(.*)/', $input) ? true : false): return $this->read_file("vi_var"); break;

			//Hur
			case (preg_match('/^hur gammal(.*)du(.*)/', $input) ? true : false): return $this->read_file("hur_gammal_du"); break;
			case (preg_match('/^hur kan(.*)/', $input) ? true : false): return $this->read_file("hur_kan"); break;
			case (preg_match('/^hur var(.*)/', $input) ? true : false): return $this->read_file("hur_var"); break;
			case (preg_match('/^hur vill(.*)/', $input) ? true : false): return $this->read_file("hur_vill"); break;
			case (preg_match('/^hur(.*)/', $input) ? true : false): return $this->read_file("hur"); break;

			case (preg_match('/^(\:\)|\:\(|\:o|\:d)/', $input) ? true : false): return $this->read_file("smiley"); break;
			case (preg_match('/^(ja|japp|jao|yes|jadå|jaa)(.*)/', $input) ? true : false): return $this->read_file("ja"); break;
			case (preg_match('/^(jo|jodå|jo då|joho)(.*)/', $input) ? true : false): return $this->read_file("jo"); break;
			case (preg_match('/^(nej|nope|nje|no|nejdå|nepp)(.*)/', $input) ? true : false): return $this->read_file("nej"); break;
			
			case (preg_match('/^(.*)\?/', $input) ? true : false): return $this->read_file("question"); break;
			
			default:
				$random = rand(1,6);
				if ($random == 1) $answer = $this->send_image("cat");
				else if ($random == 2) $answer = $this->get_random_wikipedia_article();
				else $answer = $this->read_file("default_answer");
				
				return $answer;
				break;
		}
	}

	public function read_file($file, $replacement = "")
	{
		$text_file = BASEPATH . '../assets/text/answers/' . $file . '.txt';

		if (file_exists($text_file))
		{
			$handle = fopen($text_file, "r");
			$contents = fread($handle, filesize($text_file));
			fclose($handle);
			$contents = explode("\n", $contents);
			$row = $contents[rand(0, count($contents) - 1)];
			$row = str_replace("{0}", $replacement, $row);

			$output = array('answer' => $row, 'answer_id' => $file);
			return $output;
		}
		else
		{
			$output = array('answer' => "Error: Could not find file!", 'file' => "Error!");
			return $output;
		}
	}

	public function send_image($motive)
	{
		$answer = $this->read_file("bild_katt")['answer'];
		$answer .= '<br><img src="http://loremflickr.com/200/200" height="200" width="200">';
		$output = array('answer' => $answer, 'answer_id' => 'Image: ' . $motive);
		return $output;
	}

	public function read_wikipedia($word)
	{
		$url = "https://sv.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&exchars=200&titles=" . $word;

		$json = file_get_contents($url);
		$obj = json_decode($json);
		$article = (Array)$obj->query->pages;
		$extract = reset($article)->extract;

		$output = array('answer' => $extract, 'answer_id' => 'Wikipedia: ' . $word);
		return $output;
	}

	public function get_random_wikipedia_article()
	{
		$url = "https://sv.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&generator=random&exchars=200";
		
		$json = file_get_contents($url);
		$obj = json_decode($json);
		$article = (Array)$obj->query->pages;
		$extract = reset($article)->extract;
		$extract = strip_tags($extract);
		
		$output = array('answer' => $extract, 'answer_id' => 'Wikipedia: RANDOM');
		return $output;
	}

	public function get_time()
	{
		$output = $this->read_file("vad_klockan", date("H.i"));
		return $output;
	}

	public function get_date()
	{
		$output = $this->read_file("vad_datum", date("Y-m-j"));
		return $output;
	}

	public function get_week()
	{
		$output = $this->read_file("vad_vecka", date("W"));
		return $output;
	}

	public function remember_name($input)
	{
		if ($this->CI->session->userdata('ask_for_name') == 'true')
		{
			$name = ucfirst(strtolower($input));
		}
		else
		{
			preg_match_all('/[\wåäöÅÄÖ]+/', $input, $array);
			$name = ucfirst(strtolower($array[0][2]));
		}

		$this->CI->session->set_userdata('name', $name);
		$this->CI->session->set_userdata('ask_for_name', 'false');

		return array('answer' => 'Trevligt att råkas, ' . $name . '. :)', 'answer_id' => 'Remember name');
	}
	
	public function get_name()
	{
		$output = $this->read_file("vad_heter_jag", $this->CI->session->userdata('name'));
		return $output;
	}

	public function get_calc($input)
	{
		preg_match_all('/[0-9\+\-\*\/]+/', $input, $array);

		switch ($array[0][1])
		{
			case "+":
				$result = $array[0][0] + $array[0][2];
				break;
			case "-":
				$result = $array[0][0] - $array[0][2];
				break;
			case "*":
				$result = $array[0][0] * $array[0][2];
				break;
			case "/":
				$result = $array[0][0] / $array[0][2];
				break;
			default:
				$result = "Jag kan inte räkna så bra... :(";
		}

		return array('answer' => $result, 'answer_id' => 'Calculator');
	}

}

/* End of file Brain.php */