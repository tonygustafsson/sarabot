<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
			$name = $this->parse_name($words);
			return $this->remember_name($name);
		}

		// Look for unusual words, and save to to have something to talk about
		$this->save_unusual_words($input);

		//Special
		if (preg_match('/^jag heter (.*)/', $input)) return $this->remember_name($input);

		else if (preg_match('/(.*)[0-9]+\s[\+\-\*\/]\s[0-9]+(.*)/', $raw_input)) return $this->get_calc($raw_input);
 
		else if (preg_match('/^(vad|vilket) är (.*)(datum|dag|månad)/', $input)) return $this->get_date();
		else if (preg_match('/^(vad|vilken)(.*)vecka(.*)/', $input)) return $this->get_week();
		else if (preg_match('/^(vad)(.*)heter(.*)jag/', $input)) return $this->get_name();
		else if (preg_match('/^(vad)(.*)är(.*)mitt(.*)namn/', $input)) return $this->get_name();

		else if (preg_match('/^(hejdå|farväl|hej då|far väl|baj baj|bye|quit)(.*)/', $input)) return $this->read_file("hej_da");
		else if (preg_match('/^(hej|tjena|morrs|hallå|hejsan|halloj)(.*)/', $input)) return $this->read_file("hej");
		else if (preg_match('/^välkommen(.*)tillbaka/', $input)) return $this->read_file("valkommen_tillbaka");
		else if (preg_match('/^(.*)(god|trevlig)(.*)(morgon|morron)/', $input)) return $this->read_file("god_morgon");
		else if (preg_match('/^(.*)(god|trevlig)(.*)(natt|kväll)/', $input)) return $this->read_file("god_natt");
		else if (preg_match('/^(.*)asl(.*)/', $input)) return $this->read_file("asl");
		else if (preg_match('/^(.*)cybersex(.*)/', $input)) return $this->read_file("cybersex");
		else if (preg_match('/^(.*)(herregud|herre gud|omg|oh my god|shit)(.*)/', $input)) return $this->read_file("herre_gud");
		else if (preg_match('/^(.*)(du|din)(.*)bitch(.*)/', $input)) return $this->read_file("du_bitch");
		else if (preg_match('/^(.*)(hatar|ogillar)(.*)du(.*)/', $input)) return $this->read_file("hatar_du");
		else if (preg_match('/^(.*)(du|din|ditt)(.*)duktig(.*)/', $input)) return $this->read_file("du_duktig");
		else if (preg_match('/^(.*)(du|din)(.*)dum(.*)/', $input)) return $this->read_file("du_dum");
		else if (preg_match('/^(.*)(du|din)(.*)fritid(.*)/', $input)) return $this->read_file("du_fritid");
		else if (preg_match('/^(.*)(du|man)(.*)gjort(.*)/', $input)) return $this->read_file("du_gjort");
		else if (preg_match('/^(.*)(du|din|ditt)(.*)(homo|bög|lebb|lesb)(.*)/', $input)) return $this->read_file("du_homo");
		else if (preg_match('/^(.*)(du|din|ditt)(.*)(hora|fnask|lössläppt)(.*)/', $input)) return $this->read_file("du_hora");
		else if (preg_match('/^(.*)(du|din|ditt)(.*)(kön|tjej|kille|man|kvinna|hona|hane)(.*)/', $input)) return $this->read_file("du_kon");
		else if (preg_match('/^(.*)du kvar(.*)/', $input)) return $this->read_file("du_kvar");
		else if (preg_match('/^(.*)ser(.*)du(.*)ut(.*)/', $input)) return $this->read_file("hur_ser_du_ut");
		else if (preg_match('/^(.*)(jobbar|arbetar)(.*)du(.*)/', $input)) return $this->read_file("jobbar_du");
		else if (preg_match('/^(.*)kram(.*)/', $input)) return $this->read_file("kram");
		else if (preg_match('/^(.*)(puss|kiss|kyss)(.*)/', $input)) return $this->read_file("puss");
		else if (preg_match('/^(.*)(mår du|läget|status|zup|whazup|what\'s up)(.*)/', $input)) return $this->read_file("laget");
		else if (preg_match('/^(.*)måste(.*)/', $input)) return $this->read_file("maste");
		else if (preg_match('/^nu(.*)/', $input)) return $this->read_file("nu");
		else if (preg_match('/^(sluta|lägg av|lägg ner(.*))/', $input)) return $this->read_file("sluta");
		else if (preg_match('/^(stick|dra(.*))/', $input)) return $this->read_file("stick");
		else if (preg_match('/^sug(.*)/', $input)) return $this->read_file("sug");
		else if (preg_match('/^tack(.*)/', $input)) return $this->read_file("tack");
		else if (preg_match('/^tråkigt(.*)/', $input)) return $this->read_file("trakigt");
		else if (preg_match('/^vad (tycker|anser|gillar) du/', $input)) return $this->read_file("vad_tycker_du");
		else if (preg_match('/^(tycker du om|gillar du|älskar du)(.*)/', $input)) return $this->read_file("tycker_du_om");
		else if (preg_match('/^tycker(.*)du/', $input)) return $this->read_file("tycker_du");
		else if (preg_match('/^(.*)(väder|vädret)(.*)/', $input)) return $this->read_file("vadret");
		else if (preg_match('/^(jag tänkte|tänkte)(.*)/', $input)) return $this->read_file("jag_tankte");
		else if (preg_match('/^(kul|lustigt|roligt|haha)(.*)/', $input)) return $this->read_file("kul");
		else if (preg_match('/^(tråkigt|trist|uselt|kass)(.*)/', $input)) return $this->read_file("trakigt");

		//Ska
		else if (preg_match('/^(.*)ska(.*)du(.*)(göra|hitta på)/', $input)) return $this->read_file("ska_du_gora");
		else if (preg_match('/^(.*)ska(.*)vi(.*)(pussas|kyssas|hångla|smeka)/', $input)) return $this->read_file("ska_vi_hangla");
		else if (preg_match('/^(.*)ska(.*)vi(.*)(knulla|sex|porra|samlag)/', $input)) return $this->read_file("ska_vi_knulla");
		else if (preg_match('/^(.*)ska(.*)vi/', $input)) return $this->read_file("ska_vi");

		//Är
		else if (preg_match('/^är(.*)du(.*)veg(.*)/', $input)) return $this->read_file("du_veg");

		else if (preg_match('/^är den(.*)/', $input)) return $this->read_file("ar_den");
		else if (preg_match('/^är det(.*)/', $input)) return $this->read_file("ar_det");
		else if (preg_match('/^är du(.*)/', $input)) return $this->read_file("ar_du");
		else if (preg_match('/^är han(.*)/', $input)) return $this->read_file("ar_han");
		else if (preg_match('/^är hon(.*)/', $input)) return $this->read_file("ar_hon");
		else if (preg_match('/^är jag(.*)/', $input)) return $this->read_file("ar_jag");
		else if (preg_match('/^är vi(.*)/', $input)) return $this->read_file("ar_vi");

		else if (preg_match('/^är (.*)/', $input)) return $this->read_file("ar");

		//Har
		else if (preg_match('/^har den(.*)/', $input)) return $this->read_file("har_den");
		else if (preg_match('/^har det(.*)/', $input)) return $this->read_file("har_det");
		else if (preg_match('/^har(.*)du(.*)känslor/', $input)) return $this->read_file("du_kanslor");
		else if (preg_match('/^har du(.*)/', $input)) return $this->read_file("har_du");
		else if (preg_match('/^har han(.*)/', $input)) return $this->read_file("har_han");
		else if (preg_match('/^har hon(.*)/', $input)) return $this->read_file("har_hon");
		else if (preg_match('/^har jag(.*)/', $input)) return $this->read_file("har_jag");
		else if (preg_match('/^har vi(.*)/', $input)) return $this->read_file("har_vi");
		else if (preg_match('/^har (.*)/', $input)) return $this->read_file("har");

		//Kan
		else if (preg_match('/^kan den(.*)/', $input)) return $this->read_file("kan_den");
		else if (preg_match('/^kan det(.*)/', $input)) return $this->read_file("kan_det");
		else if (preg_match('/^kan du(.*)/', $input)) return $this->read_file("kan_du");
		else if (preg_match('/^kan han(.*)/', $input)) return $this->read_file("kan_han");
		else if (preg_match('/^kan hon(.*)/', $input)) return $this->read_file("kan_hon");
		else if (preg_match('/^kan jag(.*)/', $input)) return $this->read_file("kan_jag");
		else if (preg_match('/^kan vi(.*)/', $input)) return $this->read_file("kan_vi");
		else if (preg_match('/^kan (.*)/', $input)) return $this->read_file("kan");

		//Vill
		else if (preg_match('/^vill den(.*)/', $input)) return $this->read_file("vill_den");
		else if (preg_match('/^vill det(.*)/', $input)) return $this->read_file("vill_det");
		else if (preg_match('/^vill du(.*)/', $input)) return $this->read_file("vill_du");
		else if (preg_match('/^vill han(.*)/', $input)) return $this->read_file("vill_han");
		else if (preg_match('/^vill hon(.*)/', $input)) return $this->read_file("vill_hon");
		else if (preg_match('/^vill jag(.*)/', $input)) return $this->read_file("vill_jag");
		else if (preg_match('/^vill vi(.*)/', $input)) return $this->read_file("vill_vi");
		else if (preg_match('/^vill (.*)/', $input)) return $this->read_file("vill");

		//Vilken
		else if (preg_match('/^vilken(.*)är(.*)din/', $input)) return $this->read_file("vilken_ar_din");
		else if (preg_match('/^vilken/', $input)) return $this->read_file("vilken");

		//Visste
		else if (preg_match('/^visste den(.*)/', $input)) return $this->read_file("visste_den");
		else if (preg_match('/^visste det(.*)/', $input)) return $this->read_file("visste_det");
		else if (preg_match('/^visste du(.*)/', $input)) return $this->read_file("visste_du");
		else if (preg_match('/^visste han(.*)/', $input)) return $this->read_file("visste_han");
		else if (preg_match('/^visste hon(.*)/', $input)) return $this->read_file("visste_hon");
		else if (preg_match('/^visste jag(.*)/', $input)) return $this->read_file("visste_jag");
		else if (preg_match('/^visste vi(.*)/', $input)) return $this->read_file("visste_vi");
		else if (preg_match('/^visste (.*)/', $input)) return $this->read_file("visste");

		//De
		else if (preg_match('/^(de|dom|dem) är(.*)/', $input)) return $this->read_file("de_ar");
		else if (preg_match('/^(de|dom|dem) får(.*)/', $input)) return $this->read_file("de_far");
		else if (preg_match('/^(de|dom|dem) har(.*)/', $input)) return $this->read_file("de_har");
		else if (preg_match('/^(de|dom|dem) kan(.*)/', $input)) return $this->read_file("de_kan");
		else if (preg_match('/^(de|dom|dem) kommer(.*)/', $input)) return $this->read_file("de_kommer");
		else if (preg_match('/^(de|dom|dem) var(.*)/', $input)) return $this->read_file("de_var");
		else if (preg_match('/^(de|dom|dem) vill(.*)/', $input)) return $this->read_file("de_vill");

		//Den
		else if (preg_match('/^den är(.*)/', $input)) return $this->read_file("den_ar");
		else if (preg_match('/^den får(.*)/', $input)) return $this->read_file("den_far");
		else if (preg_match('/^den har(.*)/', $input)) return $this->read_file("den_har");
		else if (preg_match('/^den kan(.*)/', $input)) return $this->read_file("den_kan");
		else if (preg_match('/^den kommer(.*)/', $input)) return $this->read_file("den_kommer");
		else if (preg_match('/^den var(.*)/', $input)) return $this->read_file("den_var");
		else if (preg_match('/^den vill(.*)/', $input)) return $this->read_file("den_vill");

		//Det
		else if (preg_match('/^det är bra(.*)/', $input)) return $this->read_file("det_ar_bra");
		else if (preg_match('/^(cool|coolt|grymt|fett|nice|awesome|vad bra)(.*)/', $input)) return $this->read_file("det_ar_bra");
		else if (preg_match('/^det är du(.*)/', $input)) return $this->read_file("det_ar_du");

		else if (preg_match('/^det är(.*)/', $input)) return $this->read_file("det_ar");
		else if (preg_match('/^det får(.*)/', $input)) return $this->read_file("det_far");
		else if (preg_match('/^det har(.*)/', $input)) return $this->read_file("det_har");
		else if (preg_match('/^det kan(.*)/', $input)) return $this->read_file("det_kan");
		else if (preg_match('/^det kommer(.*)/', $input)) return $this->read_file("det_kommer");
		else if (preg_match('/^det var(.*)/', $input)) return $this->read_file("det_var");
		else if (preg_match('/^det vill(.*)/', $input)) return $this->read_file("det_vill");
		else if (preg_match('/^(det samma|det samma|detsamma|desamma)(.*)/', $input)) return $this->read_file("det_samma");

		//Du
		else if (preg_match('/^du(.*)är(.*)(snygg|het|läcker|sexig|söt)(.*)/', $input)) return $this->read_file("du_snygg");
		else if (preg_match('/^vad(.*)(snygg|het|läcker|sexig|söt)(.*)/', $input)) return $this->read_file("du_snygg");

		else if (preg_match('/^du är(.*)/', $input)) return $this->read_file("du_ar");
		else if (preg_match('/^du får(.*)/', $input)) return $this->read_file("du_far");
		else if (preg_match('/^du har(.*)/', $input)) return $this->read_file("du_har");
		else if (preg_match('/^du kan(.*)/', $input)) return $this->read_file("du_kan");
		else if (preg_match('/^du kommer(.*)/', $input)) return $this->read_file("du_kommer");
		else if (preg_match('/^du var(.*)/', $input)) return $this->read_file("du_var");
		else if (preg_match('/^du vill(.*)/', $input)) return $this->read_file("du_vill");

		//Han
		else if (preg_match('/^han är(.*)/', $input)) return $this->read_file("han_ar");
		else if (preg_match('/^han får(.*)/', $input)) return $this->read_file("han_far");
		else if (preg_match('/^han har(.*)/', $input)) return $this->read_file("han_har");
		else if (preg_match('/^han kan(.*)/', $input)) return $this->read_file("han_kan");
		else if (preg_match('/^han kommer(.*)/', $input)) return $this->read_file("han_kommer");
		else if (preg_match('/^han var(.*)/', $input)) return $this->read_file("han_var");
		else if (preg_match('/^han vill(.*)/', $input)) return $this->read_file("han_vill");

		//Hon
		else if (preg_match('/^hon är(.*)/', $input)) return $this->read_file("hon_ar");
		else if (preg_match('/^hon får(.*)/', $input)) return $this->read_file("hon_far");
		else if (preg_match('/^hon har(.*)/', $input)) return $this->read_file("hon_har");
		else if (preg_match('/^hon kan(.*)/', $input)) return $this->read_file("hon_kan");
		else if (preg_match('/^hon kommer(.*)/', $input)) return $this->read_file("hon_kommer");
		else if (preg_match('/^hon var(.*)/', $input)) return $this->read_file("hon_var");
		else if (preg_match('/^hon vill(.*)/', $input)) return $this->read_file("hon_vill");

		//Jag
		else if (preg_match('/^jag är(.*)/', $input)) return $this->read_file("jag_ar");
		else if (preg_match('/^jag får(.*)/', $input)) return $this->read_file("jag_far");
		else if (preg_match('/^jag har(.*)/', $input)) return $this->read_file("jag_har");
		else if (preg_match('/^jag kan(.*)/', $input)) return $this->read_file("jag_kan");
		else if (preg_match('/^jag kommer(.*)/', $input)) return $this->read_file("jag_kommer");
		else if (preg_match('/^jag var(.*)/', $input)) return $this->read_file("jag_var");
		else if (preg_match('/^jag vill(.*)/', $input)) return $this->read_file("jag_vill");

		else if (preg_match('/^jag(.*)(älskar|kär|tycker om)(.*)dig/', $input)) return $this->read_file("jag_alskar_dig");
		else if (preg_match('/^jag(.*)(hatar|avskyr|ogillar)(.*)dig/', $input)) return $this->read_file("jag_hatar_dig");
		else if (preg_match('/^(.*)jag(.*)tillbaka(.*)/', $input)) return $this->read_file("jag_tillbaka");
		else if (preg_match('/^jag(.*)/', $input)) return $this->read_file("jag");

		//När
		else if (preg_match('/^när är(.*)/', $input)) return $this->read_file("nar_ar");
		else if (preg_match('/^när får(.*)/', $input)) return $this->read_file("nar_far");
		else if (preg_match('/^när har(.*)/', $input)) return $this->read_file("nar_har");
		else if (preg_match('/^när kan(.*)/', $input)) return $this->read_file("nar_kan");
		else if (preg_match('/^när kommer(.*)/', $input)) return $this->read_file("nar_kommer");
		else if (preg_match('/^när var(.*)/', $input)) return $this->read_file("nar_var");
		else if (preg_match('/^när vill(.*)/', $input)) return $this->read_file("nar_vill");

		else if (preg_match('/^när ska(.*)/', $input)) return $this->read_file("nar_ska");
		else if (preg_match('/^när (.*)/', $input)) return $this->read_file("nar");

		//Vad
		else if (preg_match('/^vad är (.*)(en|ett) (.*)/', $input)) return $this->read_wikipedia($words[3]);
		else if (preg_match('/^vad är (.*)/', $input)) return $this->read_wikipedia($words[2]);
		else if (preg_match('/^vad är (.*)(klockan|tiden)/', $input)) return $this->get_time();

		else if (preg_match('/^(vad|vem)(.*)är(.*)du/', $input)) return $this->read_file("vad_ar_du");
		else if (preg_match('/^(vad|vem)(.*)(skapat|skapare)(.*)/', $input)) return $this->read_file("vem_skapat_dig");
		else if (preg_match('/^(vad(.*)gör(.*)du)|vad händer/', $input)) return $this->read_file("vad_gor_du");
		else if (preg_match('/^(vad(.*)för(.*)dig)/', $input)) return $this->read_file("vad_gor_du");
		else if (preg_match('/^vad(.*)heter(.*)du/', $input)) return $this->read_file("vad_heter_du");
		else if (preg_match('/^vad(.*)heter(.*)/', $input)) return $this->read_file("vad_heter");
		else if (preg_match('/^vad(.*)kan(.*)du/', $input)) return $this->read_file("vad_kan_du");
		else if (preg_match('/^vad(.*)vet(.*)om(.*)mig/', $input)) return $this->get_knowledge();
		else if (preg_match('/^vad(.*)trevligt/', $input)) return $this->read_file("vad_trevligt");
		else if (preg_match('/^vad(.*)vet(.*)du/', $input)) return $this->read_file("vad_vet_du");

		else if (preg_match('/^vad är(.*)/', $input)) return $this->read_file("vad_ar");
		else if (preg_match('/^vad får(.*)/', $input)) return $this->read_file("vad_far");
		else if (preg_match('/^vad har(.*)/', $input)) return $this->read_file("vad_har");
		else if (preg_match('/^vad kan(.*)/', $input)) return $this->read_file("vad_kan");
		else if (preg_match('/^vad kommer(.*)/', $input)) return $this->read_file("vad_kommer");
		else if (preg_match('/^vad var(.*)/', $input)) return $this->read_file("vad_var");
		else if (preg_match('/^vad vill(.*)du/', $input)) return $this->read_file("vad_vill_du");
		else if (preg_match('/^vad vill(.*)/', $input)) return $this->read_file("vad_vill");

		else if (preg_match('/^vad ska(.*)/', $input)) return $this->read_file("vad_ska");
		else if (preg_match('/^vad (.*)/', $input)) return $this->read_file("vad");

		//Varför
		else if (preg_match('/^varför är(.*)/', $input)) return $this->read_file("varfor_ar");
		else if (preg_match('/^varför får(.*)/', $input)) return $this->read_file("varfor_far");
		else if (preg_match('/^varför har(.*)/', $input)) return $this->read_file("varfor_har");
		else if (preg_match('/^varför kan(.*)/', $input)) return $this->read_file("varfor_kan");
		else if (preg_match('/^varför kommer(.*)/', $input)) return $this->read_file("varfor_kommer");
		else if (preg_match('/^varför var(.*)/', $input)) return $this->read_file("varfor_var");
		else if (preg_match('/^varför vill(.*)/', $input)) return $this->read_file("varfor_vill");

		else if (preg_match('/^varför ska(.*)/', $input)) return $this->read_file("varfor_ska");
		else if (preg_match('/^varför (.*)/', $input)) return $this->read_file("varfor");

		//Var
		else if (preg_match('/^var(.*) är(.*)/', $input)) return $this->read_file("var_ar");
		else if (preg_match('/^var(.*) får(.*)/', $input)) return $this->read_file("var_far");
		else if (preg_match('/^var(.*) har(.*)/', $input)) return $this->read_file("var_har");
		else if (preg_match('/^var(.*) kan(.*)/', $input)) return $this->read_file("var_kan");
		else if (preg_match('/^var(.*) kommer(.*)/', $input)) return $this->read_file("var_kommer");
		else if (preg_match('/^var(.*) vill(.*)/', $input)) return $this->read_file("var_vill");

		else if (preg_match('/^var(.*) ska(.*)/', $input)) return $this->read_file("var_ska");
		else if (preg_match('/^var(.*)bor(.*)du(.*)/', $input)) return $this->read_file("var_bor_du");
		else if (preg_match('/^var(.*)/', $input)) return $this->read_file("var");

		//Vem
		else if (preg_match('/^vem är (.*)/', $input)) return $this->read_wikipedia($words[2]);

		else if (preg_match('/^vem är(.*)/', $input)) return $this->read_file("vem_ar");
		else if (preg_match('/^vem får(.*)/', $input)) return $this->read_file("vem_far");
		else if (preg_match('/^vem har(.*)/', $input)) return $this->read_file("vem_har");
		else if (preg_match('/^vem kan(.*)/', $input)) return $this->read_file("vem_kan");
		else if (preg_match('/^vem kommer(.*)/', $input)) return $this->read_file("vem_kommer");
		else if (preg_match('/^vem vill(.*)/', $input)) return $this->read_file("vem_vill");
		else if (preg_match('/^vem ska(.*)/', $input)) return $this->read_file("vem_ska");

		else if (preg_match('/^vem (.*)/', $input)) return $this->read_file("vem");

		//Vi
		else if (preg_match('/^vi är(.*)/', $input)) return $this->read_file("vi_ar");
		else if (preg_match('/^vi får(.*)/', $input)) return $this->read_file("vi_far");
		else if (preg_match('/^vi har(.*)/', $input)) return $this->read_file("vi_har");
		else if (preg_match('/^vi kan(.*)/', $input)) return $this->read_file("vi_kan");
		else if (preg_match('/^vi kommer(.*)/', $input)) return $this->read_file("vi_kommer");
		else if (preg_match('/^vi vill(.*)/', $input)) return $this->read_file("vi_vill");

		else if (preg_match('/^vi var(.*)/', $input)) return $this->read_file("vi_var");

		//Hur
		else if (preg_match('/^hur gammal(.*)du(.*)/', $input)) return $this->read_file("hur_gammal_du");
		else if (preg_match('/^hur kan(.*)/', $input)) return $this->read_file("hur_kan");
		else if (preg_match('/^hur var(.*)/', $input)) return $this->read_file("hur_var");
		else if (preg_match('/^hur vill(.*)/', $input)) return $this->read_file("hur_vill");
		else if (preg_match('/^hur(.*)/', $input)) return $this->read_file("hur");

		else if (preg_match('/^(\:\)|\:\(|\:o|\:d)/', $input)) return $this->read_file("smiley");
		else if (preg_match('/^(ja|japp|jao|yes|jadå|jaa)(.*)/', $input)) return $this->read_file("ja");
		else if (preg_match('/^(jo|jodå|jo då|joho)(.*)/', $input)) return $this->read_file("jo");
		else if (preg_match('/^(nej|nope|nja|no|nejdå|nepp)(.*)/', $input)) return $this->read_file("nej");

		// Din / Ditt
		else if (preg_match('/^(.*)din(.*)/', $input)) return $this->read_file("din");
		else if (preg_match('/^(.*)ditt(.*)/', $input)) return $this->read_file("ditt");

		else if ($is_question === TRUE) return $this->read_file("question");

		else {
			$random = rand(1,8);
			if ($random == 1) $answer = $this->send_image("cat");
			else if ($random == 2 || $random == 3) $answer = $this->get_talked_about();
			else if ($random == 4) $answer = $this->get_random_wikipedia_article();
			else $answer = $this->read_file("default_answer");

			return $answer;
		}
	}

	public function read_file($file, $first_var = "")
	{
		$text_file = BASEPATH . '../assets/text/answers/' . $file . '.txt';

		if (file_exists($text_file))
		{
			// Get file contents
			$handle = fopen($text_file, "r");
			$contents = fread($handle, filesize($text_file));
			fclose($handle);
			
			// Get a random answer
			$contents = explode("\n", $contents);
			$row = $contents[rand(0, count($contents) - 1)];
			
			// Replace variables
			$name = ($this->CI->session->userdata('name') != "") ? $this->CI->session->userdata('name') : 'Främling';
			$row = str_replace("{name}", $name, $row);
			$row = str_replace("{0}", $first_var, $row);

			$output = array('answer' => $row, 'answer_id' => $file);
			return $output;
		}
		else
		{
			$output = array('answer' => "Error: Could not find file!", 'file' => "Error!");
			return $output;
		}
	}

	public function get_knowledge()
	{
		$name = $this->CI->session->userdata('name');
		$remembered_words = $this->CI->session->userdata('unusual_words');

		$answer = "";

		if (!empty($name))
		{
			$answer .= "Ditt namn är " . $name . ".";
		}

		if (count($remembered_words) > 0)
		{
			$answer .= " Du gillar att prata om ";

			for ($x = 0; $x < count($remembered_words); $x++)
			{
				$answer .= $remembered_words[$x];
				if ($x == count($remembered_words) - 2)
				{
					$answer .= " och ";
				}
				else if ($x < count($remembered_words) - 1)
				{
					$answer .= ", ";
				}
				else
				{
					$answer .= ".";
				}
			}
		}

		return array('answer' => $answer, 'answer_id' => 'Get knowledge');
	}

	public function get_talked_about()
	{
		$word = "kebab";
		$remembered_words = $this->CI->session->userdata('unusual_words');

		if (count($remembered_words) > 0)
		{
			shuffle($remembered_words);
			$word = array_slice($remembered_words, 0, 1);
			$word = $word[0];
		}

		$answer = $this->read_file("du_namnde", $word);

		return array('answer' => $answer['answer'], 'answer_id' => 'Talked about');
	}

	public function save_unusual_words($words)
	{
		$text_file = BASEPATH . '../assets/text/lists/usual_words.txt';

		$handle = fopen($text_file, "r");
		$contents = fread($handle, filesize($text_file));
		fclose($handle);

		$usual_words = explode("\r\n", $contents);
		$words = preg_replace("/[^A-Za-z0-9\-åäöÅÄÖ ]/", "", $words);
		$words = strtolower($words);
		$word_array = explode(" ", $words);

		$remembered_words = array();

		if ($this->CI->session->userdata('unusual_words') !== NULL)
		{
			$remembered_words = $this->CI->session->userdata('unusual_words');
		}

		foreach ($word_array as $word)
		{
			if (!in_array($word, $remembered_words) && !in_array($word, $usual_words))
			{
				$remembered_words[] = $word;
			}
		}

		$this->CI->session->set_userdata('unusual_words', $remembered_words);
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

		if (count($article) == 0)
			return $this->read_file("default_answer");

		$article = reset($article);

		if (!isset($article->extract))
			return $this->read_file("default_answer");

		$extract = $article->extract;

		if (empty(str_replace(".", "", $extract)))
			return $this->read_file("default_answer");

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

	public function parse_name($words)
	{
		$position = 0;

		$ignored_words = array('jag', 'heter', 'mitt', 'namn', 'är', 'namnet', 'hej');

		foreach ($words as $key => $word)
		{
			if (in_array($word, $ignored_words))
			{
				unset($words[$key]);
			}
		}

		if (count($words) < 1)
		{
			return "Främling";
		}

		$name = array_values($words)[0];

		return $name;
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