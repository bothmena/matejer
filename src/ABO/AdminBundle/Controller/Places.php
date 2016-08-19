<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ABO\AdminBundle\Controller;

class Places {

    public function getImages() {

        return $this->images;
    }

    public function getCountry(){
        
        $country = array(
            'data'=>$this->TN,
            'name'=>'TN',
            'code'=>216,
            'regex'=>'/^[0-9]{2} {1}[0-9]{3} {1}[0-9]{3}$/',
        );
        return $country;
    }

    private $images = array(
        'user-male'=>array(
            'entity'=>'website',
            'folder'=>'website',
            'type' => 'profile',
            'image'=>'male.png',
        ),
        'user-female'=>array(
            'entity'=>'website',
            'folder'=>'website',
            'type' => 'profile',
            'image'=>'female.png',
        ),
        'shop-logo'=>array(
            'entity'=>'website',
            'folder'=>'website',
            'type' => 'profile',
            'image'=>'shop-logo.png',
        ),
        'shop-cover'=>array(
            'entity'=>'website',
            'folder'=>'website',
            'type' => 'cover',
            'image'=>'shop-cover.jpg',
        ),
    );

    private $places = ['AF'=>'93','AL'=>'355','DZ'=>'213','AS'=>'1','AD'=>'376','AO'=>'244','AI'=>'1',
        'AQ'=>'672','AG'=>'1','AR'=>'54','AM'=>'374','AW'=>'297','AU'=>'61','AT'=>'43','AZ'=>'994',
        'BS'=>'1','BH'=>'973','BD'=>'880','BB'=>'1','BY'=>'375','BE'=>'32','BZ'=>'501','BJ'=>'229',
        'BM'=>'1','BT'=>'975','BO'=>'591','BA'=>'387','BW'=>'267','BR'=>'55','IO'=>'246','VG'=>'1',
        'BN'=>'673','BG'=>'359','BF'=>'226','BI'=>'257','KH'=>'855','CM'=>'237','CA'=>'1','CV'=>'238',
        'KY'=>'1','CF'=>'236','TD'=>'235','CL'=>'56','CN'=>'86','CX'=>'61','CC'=>'61','CO'=>'57',
        'KM'=>'269','CK'=>'682','CR'=>'506','HR'=>'385','CU'=>'53','CW'=>'599','CY'=>'357','CZ'=>'420',
        'CD'=>'243','DK'=>'45','DJ'=>'253','DM'=>'1','DO'=>'1','TL'=>'670','EC'=>'593','EG'=>'20',
        'SV'=>'503','GQ'=>'240','ER'=>'291','EE'=>'372','ET'=>'251','FK'=>'500','FO'=>'298','FJ'=>'679',
        'FI'=>'358','FR'=>'33','PF'=>'689','GA'=>'241','GM'=>'220','GE'=>'995','DE'=>'49','GH'=>'233',
        'GI'=>'350','GR'=>'30','GL'=>'299','GD'=>'1','GU'=>'1','GT'=>'502','GG'=>'44','GN'=>'224',
        'GW'=>'245','GY'=>'592','HT'=>'509','HN'=>'504','HK'=>'852','HU'=>'36','IS'=>'354','IN'=>'91',
        'ID'=>'62','IR'=>'98','IQ'=>'964','IE'=>'353','IM'=>'44','IL'=>'972','IT'=>'39','CI'=>'225',
        'JM'=>'1','JP'=>'81','JE'=>'44','JO'=>'962','KZ'=>'7','KE'=>'254','KI'=>'686','XK'=>'383',
        'KW'=>'965','KG'=>'996','LA'=>'856','LV'=>'371','LB'=>'961','LS'=>'266','LR'=>'231','LY'=>'218',
        'LI'=>'423','LT'=>'370','LU'=>'352','MO'=>'853','MK'=>'389','MG'=>'261','MW'=>'265','MY'=>'60',
        'MV'=>'960','ML'=>'223','MT'=>'356','MH'=>'692','MR'=>'222','MU'=>'230','YT'=>'262','MX'=>'52',
        'FM'=>'691','MD'=>'373','MC'=>'377','MN'=>'976','ME'=>'382','MS'=>'1','MA'=>'212','MZ'=>'258',
        'MM'=>'95','NA'=>'264','NR'=>'674','NP'=>'977','NL'=>'31','AN'=>'599','NC'=>'687','NZ'=>'64',
        'NI'=>'505','NE'=>'227','NG'=>'234','NU'=>'683','KP'=>'850','MP'=>'1','NO'=>'47','OM'=>'968',
        'PK'=>'92','PW'=>'680','PS'=>'970','PA'=>'507','PG'=>'675','PY'=>'595','PE'=>'51','PH'=>'63',
        'PN'=>'64','PL'=>'48','PT'=>'351','PR'=>'1','QA'=>'974','CG'=>'242','RE'=>'262','RO'=>'40',
        'RU'=>'7','RW'=>'250','BL'=>'590','SH'=>'290','KN'=>'1','LC'=>'1','MF'=>'590','PM'=>'508',
        'VC'=>'1','WS'=>'685','SM'=>'378','ST'=>'239','SA'=>'966','SN'=>'221','RS'=>'381','SC'=>'248',
        'SL'=>'232','SG'=>'65','SX'=>'1','SK'=>'421','SI'=>'386','SB'=>'677','SO'=>'252','ZA'=>'27',
        'KR'=>'82','SS'=>'211','ES'=>'34','LK'=>'94','SD'=>'249','SR'=>'597','SJ'=>'47','SZ'=>'268',
        'SE'=>'46','CH'=>'41','SY'=>'963','TW'=>'886','TJ'=>'992','TZ'=>'255','TH'=>'66','TG'=>'228',
        'TK'=>'690','TO'=>'676','TT'=>'1','TN'=>'216','TR'=>'90','TM'=>'993','TC'=>'1','TV'=>'688',
        'VI'=>'1','UG'=>'256','UA'=>'380','AE'=>'971','GB'=>'44','US'=>'1','UY'=>'598','UZ'=>'998','VU'=>'678',
        'VA'=>'379','VE'=>'58','VN'=>'84','WF'=>'681','EH'=>'212','YE'=>'967','ZM'=>'260','ZW'=>'263'
    ];

    private $TN = array(
        "Ariana" => ["Ariana Medina","Ettadhamen","Kalâat el-Andalous","Mnihla","Raoued","Sidi Thabet","La Soukra"],
        "Beja" => ["Amdoun","Beja North","Beja South","Goubellat","Mejez El Bab","Nefza","Teboursouk","Testour","Thibar"],
        "Ben Arous" => ["Ben Arous","Boumhel","El Mourouj","Ezzahra","Fouchana","Hammam Chott","Hammam Lif","M'Hamdia","Medina Jedida","Megrine","Mornag","Rades"],
        "Bizerte" => ["Bizerte North","Bizerte South","Djoumime","El Alia","Ghar El Melh","Ghezala","Mateur","Menzel Bourguiba","Menzel Jemil","Ras Jebel","Sejenane","Tinja","Utique","Zarzouna"],
        "Gabès" => ["Gabes Medina","Gabes West","Gabes South","Ghannouch","Hamma","Mareth","Matmata","New Matmata","Menzel Habib","Metouia"],
        "Gafsa" => ["Belkhir","Gafsa North","Gafsa South","Guetar","Ksar","Mdhilla","Metlaoui","Oum Larais","Redeyef","Sened","Sidi Aich"],
        "Jendouba" => ["Aïn Draham","Balta","Bousalem","Fernana","Ghardimaou","Jendouba","Jendouba Nord","Oued Mliz","Tabarka"],
        "Kairouan" => ["Alaa","Bouhajla","Chebika","Chrarda","Haffouz","Hajeb El Ayoun","Kairouan North","Kairouan South","Nasrallah","Oueslatia","Sbikha"],
        "Kasserine" => ["Ayoun","Ezzouhour","Feriana","Foussana","Hassi El Ferid","Hidra","Jedeliane","Kasserine North","Kasserine South","Majel Belabbes","Sbeitla","Sbiba","Thala"],
        "Kebili" => ["Douz North","Douz South","Faouar","Kebili North","Kebili South","Souk El Ahed"],
        "Kef" => ["Dahmani","Es Sers","Jerissa","Kalaa Khasbat","Kalaat Senane","Kef East","Kef West","Ksour","Nebeur","Sakiet Sidi Youssef","Tajerouine"],
        "Mahdia" => ["Boumerdes","Chebba","Chorbane","El Djem","Hbira","Ksour Essef","Mahdia","Melloulech","Ouled Chamekh","Sidi Alouane","Souassi"],
        "Manouba" => ["Borj El Amri","Douar Hicher","El Battan","Jedaida","Manouba","Mornaguia","Oued Ellil","Tebourba"],
        "Medenine" => ["Ben Guerdane","Beni Khedache","Djerba Ajim","Djerba Midoun","Djerba Houmt Souk","Medenine North","Medenine South","Sidi Makhlouf","Zarzis"],
        "Monastir" => ["Bekalta","Bembla","Beni Hassen","Jammel","Ksar Hellal","Ksibet El Mediouni","Moknine","Monastir","Ouerdanine","Sahline","Sayada-Lamta-Bou Hjar","Teboulba","Zeramdine"],
        "Nabeul" => ["Beni Khalled","Beni Khiar","Bou Argoub","Dar Chaabane El Fehri","El Mida","Grombalia","Hammam Ghezaz","Hammamet","Haouaria","Kelibia","Korba","Menzel Bouzelfa","Menzel Temime","Nabeul","Soliman","Takelsa"],
        "Sfax" => ["Agareb","Bir Ali Ben Khelifa","El Amra","El Ghraiba","Hencha","Jebeniana","Kerkennah","Mahres","Menzel Chaker","Sakiet Eddaier","Sakiet Ezzit","Sfax Medina","Sfax West","Sfax South","Skhira"],
        "Sidi Bou Zid" => ["Bir El Hfay","Jelma","Mazzouna","Meknassi","Menzel Bouzaiene","Ouled Haffouz","Regueb","Sabalat Ouled Asker","Sidi Ali Ben Aoun","Sidi Bouzid East","Sidi Bouzid West","Souk Jedid"],
        "Siliana" => ["Bargou","Bouarada","Bourouis","El Krib","Gaafour","Kesra","Makthar","Rouhia","Siliana North","Siliana South"],
        "Sousse" => ["Akouda","Bouficha","Enfidha","Hammam Sousse","Hergla","Kalaa Kebira","Kalaa Sghira","Kondar","M'Saken","Sidi Bou Ali","Sidi El Heni","Sousse Jaouhara","Sousse Medina","Sousse Riadh","Sousse Sidi Abdelhamid"],
        "Tataouine" => ["Bir Lahmar","Dhiba","Ghomrassen","Remada","Samar","Tataouine North","Tataouine South"],
        "Tozeur" => ["Degueche","Hazoua","Nefta","Tamaghza","Tozeur"],
        "Tunis" => ["Bab Bhar","Bab Souika","Bardo","Bouhaira","Carthage","El Khadra","El Menzah","El Ouardia","El Tahrir","Ezzouhour","Hrairia","Jebel Jelloud","Kabaria","La Goulette","La Marsa","Le Kram","Medina","Omrane","Omrane Superieur","Sidi El Bechir","Sidi Hassine","Sijoumi"],
        "Zaghouan" => ["Bir Mchergua","Fahs","Nadhour","Saouaf","Zaghouan","Zriba"],
    );
    
    private $FR = array(
        "Alsace" => ["Altkirch","Colmar","Mulhouse","Thann","Haguenau","Molsheim","Saverne","Sélestat","Strasbourg"],
        "Aquitaine" => ["Bayonne","Oloron-Sainte-Marie","Pau","Agen","Marmande","Nérac","Villeneuve-sur-Lot","Dax","Mont-de-Marsan","Arcachon","Blaye","Bordeaux","Langon","Lesparre-Médoc","Libourne","Bergerac","Nontron","Périgueux","Sarlat-la-Canéda"],
        "Auvergne" => ["Ambert","Clermont-Ferrand","Issoire","Riom","Thiers","Brioude","Le Puy-en-Velay","Yssingeaux","Aurillac","Mauriac","Saint-Flour","Montluçon","Moulins","Vichy",],
        "Basse-Normandie" => ["Alençon","Argentan","Mortagne-au-Perche","Avranches","Cherbourg-Octeville","Coutances","Saint-Lô","Bayeux","Caen","Lisieux","Vire"],
        "Bretagne" => ["Lorient","Pontivy","Vannes","Fougères","Redon","Rennes","Saint-Malo","Brest","Châteaulin","Morlaix","Quimper","Dinan","Guingamp","Lannion","Saint-Brieuc"],
        "Bourgogne" => ["Auxerre","Avallon","Sens","Autun","Chalon-sur-Saône","Charolles","Louhans","Mâcon","Château-Chinon","Clamecy","Cosne-Cours-sur-Loire","Nevers","Beaune","Dijon","Montbard"],
        "Centre-Val de Loire" => ["Montargis","Orléans","Pithiviers","Blois","Romorantin-Lanthenay","Vendôme","Chinon","Loches","Tours","Le Blanc","Châteauroux","La Châtre","Issoudun","Chartres","Châteaudun","Dreux","Nogent-le-Rotrou","Bourges","Saint-Amand-Montrond","Vierzon"],
        "Champagne-Ardenne" => ["Chaumont","Langres","Saint-Dizier","Châlons-en-Champagne","Épernay","Reims","Sainte-Menehould","Vitry-le-François","Charleville-Mézières","Rethel","Sedan","Vouziers","Bar-sur-Aube","Nogent-sur-Seine","Troyes",],
        "Franche-Comté" => ["Belfort","Lure","Vesoul","Dole","Lons-le-Saunier","Saint-Claude","Besançon","Montbéliard","Pontarlier"],
        "Île-de-France" => ["Antony","Boulogne-Billancourt","Nanterre","Bobigny","Le Raincy","Saint-Denis","Créteil","L'Haÿ-les-Roses","Nogent-sur-Marne","Argenteuil","Pontoise","Sarcelles","Étampes","Évry","Palaiseau","Mantes-la-Jolie","Rambouillet","Saint-Germain-en-Laye","Versailles","Fontainebleau","Meaux","Melun","Provins","Torcy","Paris"],
        "Languedoc-Roussillon" => ["Céret","Perpignan","Prades","Florac","Mende","Béziers","Lodève","Montpellier","Alès","Nîmes","Le Vigan","Carcassonne","Limoux","Narbonne",],
        "Limousin" => ["Bellac","Limoges","Rochechouart","Aubusson","Guéret","Brive-la-Gaillarde","Tulle","Ussel"],
        "Lorraine" => ["Épinal","Neufchâteau","Saint-Dié-des-Vosges","Château-Salins","Forbach","Metz","Sarrebourg","Sarreguemines","Thionville","Bar-le-Duc","Commercy","Verdun","Briey","Lunéville","Nancy","Toul"],
        "Midi-Pyrénées" => ["Castelsarrasin","Montauban","Albi","Castres","Argelès-Gazost","Bagnères-de-Bigorre","Tarbes","Cahors","Figeac","Gourdon","Auch","Condom","Mirande","Muret","Saint-Gaudens","Toulouse","Foix","Pamiers","Saint-Girons","Millau","Rodez","Villefranche-de-Rouergue",],
        "Nord-Pas-de-Calais" => ["Arras","Béthune","Boulogne-sur-Mer","Calais","Lens","Montreuil","Saint-Omer","Avesnes-sur-Helpe","Cambrai","Douai","Dunkerque","Lille","Valenciennes"],
        "Pays de la Loire" => ["Fontenay-le-Comte","La Roche-sur-Yon","Les Sables-d'Olonne","La Flèche","Mamers","Le Mans","Château-Gontier","Laval","Mayenne","Angers","Cholet","Saumur","Segré","Ancenis","Châteaubriant","Nantes","Saint-Nazaire"],
        "Picardie" => ["Abbeville","Amiens","Montdidier","Péronne","Beauvais","Clermont","Compiègne","Senlis","Château-Thierry","Laon","Saint-Quentin","Soissons","Vervins",],
        "Poitou-Charentes" => ["Châtellerault","Montmorillon","Poitiers","Bressuire","Niort","Parthenay","Jonzac","Rochefort","La Rochelle","Saintes","Saint-Jean-d'Angély","Angoulême","Cognac","Confolens"],
        "Provence-Alpes-Côte d'Azur" => ["Apt","Avignon","Carpentras","Brignoles","Draguignan","Toulon","Aix-en-Provence","Arles","Istres","Marseille","Barcelonnette","Castellane","Digne-les-Bains","Forcalquier","Briançon","Gap","Grasse","Nice"],
        "Rhône-Alpes" => ["Annecy","Bonneville","Saint-Julien-en-Genevois","Thonon-les-Bains","Albertville","Chambéry","Saint-Jean-de-Maurienne","Lyon","Villefranche-sur-Saône","Montbrison","Roanne","Saint-Étienne","Grenoble","La Tour-du-Pin","Vienne","Die","Nyons","Valence","Belley","Bourg-en-Bresse","Gex","Nantua","Largentière","Privas","Tournon-sur-Rhône",],
        "Haute-Normandie" => ["Dieppe","Le Havre","Rouen","Les Andelys","Bernay","Évreux"],
        "Corsica" => ["Bastia","Calvi","Corte","Ajaccio","Sartène"],
        "Guadeloupe" => ["Basse-Terre","Pointe-à-Pitre"],
        "Martinique" => ["Fort-de-France","Le Marin","Saint-Pierre","La Trinité"],
        "Guyane" => ["Cayenne","Saint-Laurent-du-Maroni"],
        "La Réunion" => ["Saint-Benoît","Saint-Denis","Saint-Paul","Saint-Pierre"],
        "Mayotte" => ["Mamoudzou"],
    );
    
    private $DZ = array(
        "Adrar"=>[ "Adrar" , "Aoulef" , "Aougrout" , "Bordj Badji Mokhtar" , "Charouine" , "Fenoughil" , "Reggane" , "Timimoun" , "Tinerkouk" , "Tsabit" , "Zaouiet Kounta"],
        "Chlef"=>[ "Abou El Hassan" , "Aïn Merane" , "Beni Haoua" , "Boukadir" , "Chlef" , "El Karimia" , "El Marsa" , "Oued Fodda" , "Ouled Ben Abdelkader" , "Ouled Fares" , "Taougrit" , "Tenès" , "Zeboudja"],
        "Laghouat"=>["Aflou" , "Aïn Mahdi" , "Brida" , "El Ghicha" , "Gueltet Sidi Saâd" , "Hassi R'Mel" , "Ksar El Hirane" , "Laghouat" , "Oued Morra" , "Sidi Makhlouf"],
        "Oum el-Bouaghi"=>["Oum El Bouaghi" , "Ain Babouche" , "Ksar Sbahi" , "Ain El Beida" , "Fkirina" , "Ain M’Lila" , "Souk Naamane" ,"Ain Fakroun" , "Sigus" , "Ain Kercha" , "Meskiana" , "Dhalaa"],
        "Batna"=>["Ain Djasser" , "Aïn Touta" , "Arris" , "Barika" , "Batna" , "Bouzina" , "Chemora" , "Djezzar" , "El Madher" , "Ichmoul" , "Menaa" , "Merouana" , "N'Gaous" , "Ouled Si Slimane" , "Ras El Aioun" , "Seggana" , "Seriana" , "Tazoult" , "Teniet El Abed" , "Timgad" , "T'kout"],
        "Béjaïa"=>["Adekar" , "Akbou" , "Amizour" , "Aokas" , "Barbacha" , "Béjaïa" , "Beni Maouche" , "Chemini" , "Darguina" , "El Kseur" , "Ighil Ali" , "Kherrata" , "Ouzellaguen" , "Seddouk" , "Sidi-Aïch" , "Souk El Ténine" , "Tazmalt" , "Tichy" , "Timezrit"],
        "Biskra"=>["Biskra" , "Djemorah" , "El Kantara" , "M’Chounech" , "Sidi Okba" , "Zeribet El Oued" , "Ourlal" , "Tolga" , "Ouled Djellal" , "Sidi Khaled" , "Foughala" , "El Outaya"],
        "Béchar"=>["Béchar" , "Beni Ounif" , "Lahmar" , "Kenadsa" , "Taghit" , "Abadla" , "Tabelbala" , "Igli" , "Beni Abbes" , "El Ouata" , "Kerzaz" , "Ouled Khoudir"],
        "Blida"=>["Blida","Boufarik","Bougara","Bouinan","El Affroun","Larbaa","Meftah","Mouzaïa","Oued Alleug","Ouled Yaich"],
        "Bouira"=>["Bouira" , "Haizer" , "Bechloul" , "M'Chedallah" , "Kadiria" , "Lakhdaria" , "Bir Ghbalou" , "Ain Bessam" , "Souk El Khemis" , "El Hachimia ", "Souk El Ghozlane" , "Bordj Okhriss"],
        "Tamanghasset"=>[ "Abalessa" , "In Ghar" , "In Guezzam" , "In Salah" , "Tamanghasset" , "Tazrouk" , "Tinzaouten"],
        "Tébessa"=>["Tébessa" , "El Kouif" , "Morsott" , "El Ma Labiodh" , "El Aouinet" , "Ouenza" , "Bir Mokkadem" , "Bir El-Ater" , "El Ogla" , "Oum Ali" , "Negrine" , "Cheria"],
        "Tlemcen"=>["Aïn Tallout","Bab El Assa","Beni Boussaid","Beni Snous","Bensekrane","Chetouane","Fellaoucene","Ghazaouet","Hennaya","Honaïne","Maghnia","Mansourah","Marsa Ben M'Hidi","Nedroma","Ouled Mimoun","Remchi","Sabra","Sebdou","Sidi Djillali","Tlemcen"],
        "Tiaret"=>[ "Tiaret" , "Sougueur" , "Aïn Deheb" , "Aïn Kermes" , "Frenda" , "Dahmouni" , "Mahdia" , "Hamadia" , "Ksar Chellala" , "Medroussa" , "Mechraa Safa" , "Rahouia" , "Oued Lilli" , "Meghila"],
        "Tizi Ouzou"=>[ "Ain El Hammam" , "Azazga" , "Azeffoun" , "Beni Douala" , "Beni Yenni" , "Boghni" , "Bouzeguène" , "Draâ Ben Khedda" , "Draâ El Mizan" , "Iferhounène" , "Larbaâ Nath Irathen" , "Mâatkas" , "Makouda" , "Mekla" , "Ouacif" , "Ouadhia" , "Ouaguenoun" , "Tigzirt" , "Tizi Gheniff","Tizi Ouzou" , "Tizi Rached"],
        "Alger"=>[ "Zéralda" , "Chéraga" , "Draria" , "Bir Mourad Raïs" , "Birtouta" , "Bouzareah" , "Bab El Oued" , "Sidi M'Hamed" , "Hussein Dey" , "El Harrach" , "Baraki" , "Dar El Beïda" , "Rouïba"],
        "Djelfa"=>["Djelfa","Aïn El Bell","Aïn Oussara","Birine","Charef","Dar Chioukh","El Idrissia","Faidh El Botma","Had-Sahary","Hassi Bahbah","Messaad","Sidi Ladjel"],
        "Jijel"=>[ "Chekfa" , "Djimla" , "El Ancer" , "El Aouana" , "El Milia" , "Jijel" , "Settara" , "Sidi Maarouf" , "Taher" , "Texenna" , "Ziama Mansouriah"],
        "Sétif"=>["Aïn Arnat","Aïn Azel","Aïn El Kebira","Aïn Oulmene","Amoucha","Babor","Beni Aziz","Beni Ourtilane","Bir El Arch","Bouandas","Bougaa","Djemila","El Eulma","Guidjel","Guenzet","Hammam Guergour","Hammam Soukhna","Maoklane","Salah Bey","Sétif"],
        "Saïda"=>[ "Saida" , "Aïn El Hadjar" , "Sidi Boubekeur" , "El Hassasna" , "Ouled Brahim" , "Youb"],
        "Skikda"=>["Aïn Kechra","Azzaba","Ben Azzouz","Collo","El Hadaiek","El Harrouch","Ouled Attia","Oum Toub","Ramdane Djamel","Sidi Mezghiche","Skikda","Tamalous","Zitouna"],
        "Sidi Bel Abbes"=>["Sidi Bel Abbès","Ain El Berd","Ben Badis","Marhoum","Merine","Mostefa Ben Brahim","Moulay Slissen","Ras El Ma","Sfisef","Sidi Ali Benyoub","Sidi Ali Boussidi","Sidi Lahcene","Telagh","Tenira","Tessala"],
        "Annaba"=>["Annaba" , "Aïn Berda" , "El Hadjar" , "Barrahel" , "Chetaïbi" , "El Bouni"],
        "Guelma"=>["Guelma","Khezarra","Guelaat BouSbâa","Héliopolis","Oued Zenati","Ain Makhlouf","Hammam Debagh","Bouchegouf","Hammam N’Bails","Ain Hessaïnia"],
        "Constantine"=>[ "Constantinen","El Khroub","Aïn Abid","Zighoud Youcef","Hamma Bouziane","Ibn Ziad"],
        "Médéa"=>["Aïn Boucif","Aziz","Beni Slimane","Berrouaghia","Chahbounia","Chellalet El Adhaoura","El Azizia","El Guelb El Kebir","El Omaria","Ksar Boukhari","Médéa","Ouamri","Ouled Antar","Ouzera","Seghouane","Sidi Naâmane","Si Mahdjoub","Souagui" ,"Tablat"],
        "Mostaganem"=>["Achaacha","Ain Nouissi","Ain Tadles","Bouguirat","Hassi Mameche","Khiredine","Mesra","Mostaganem","Sidi Ali","Sidi Lakhdar"],
        "M'Sila"=>["M'Sila","Hammam Dalaa","Ouled Derradj","Sidi Aissa","Aïn El Melh","Ben Srour","Bou Saada","Ouled sidi Brahim","Sidi Ameur","Magra" ,"Chellal","Khoubana","Medjedel","Aïn El Hadjel","Djebel Messaad"],
        "Mascara"=>["Aïn Fares","Aïn Fekan","Aouf","Bou Hanifia","El Bordj","Ghriss","Hachem","Mascara","Mohammadia","Oggaz","Oued El Abtal","Oued Taria","Sig","Tighennif","Tizi","Zahana"],
        "Ouargla"=>["El Borma","El Hadjira","Hassi Messaoud", "Megarine","N'Goussa","Ouargla" ,"Sidi Khouiled","Taibet","Tamacine","Touggourt"],
        "Oran"=>["Oran","Aïn El Turk","Arzew","Bethioua","Es Sénia","Bir El Djir","Boutlélis","Oued Tlelat","Gdyel"],
        "El Bayadh"=>["El Bayadh","Rogassa", "Brezina" ,"El Abiodh Sidi Cheikh","Bougtoub","Chellala","Boussemghoun","Boualem"],
        "Illizi"=>["Illizi","Djanet","In Amenas"],
        "Bordj Bou Arréridj"=>[ "Bordj Bou Arreridj", "Aïn Taghrout", "Ras El Oued","Bordj Ghedir", "Bir Kasdali", "El Hamadia","Mansoura", "Medjana", "Bordj Zemoura","Djaafra"],
        "Boumerdès"=>[ "Baghlia","Boudouaou","Daïra de Bordj Ménaïel","Boumerdès", "Dellys", "Khemis El Kechna", "Isser", "Naciria" ,"Thenia"],
        "El Taref"=>[ "El Tarf","El Kala" ,"Ben Mehidi","Besbes","Dréan","Bouhadjar","Bouteldja"],
        "Tindouf"=>["Tindouf"],
        "Tissemsilt"=>[ "Ammari" , "Bordj Bou Naama" , "Bordj El Emir Abdelkader" , "Khemisti" , "Lardjem" , "Lazharia" , "Theniet El Had" , "Tissemsilt"],
        "El Oued"=>["Bayadha","Debila","Djamaa","El M'Ghair","El Oued","Guemar","Hassi Khalifa","Magrane","Mih Ouansa","Reguiba","Robbah","Taleb Larbi"],
        "Khenchela"=>["Khenchela" , "Babar" , "Bouhmama" , "Cherchar" , "El Hamma" , "Kais" , "Ouled Rechache" , "Ain Touila"],
        "Souk Ahras"=>[ "Bir Bou Haouch" , "Heddada" , "M'daourouch" , "Mechroha" , "Merahna" , "Ouled Driss" , "Oum El Adhaim" , "Sedrata" , "Souk Ahras" , "Taoura"],
        "Tipasa"=>["Ahmar El Ain","Bou Ismail","Cherchell","Damous","Fouka","Gouraya","Hadjout","Koléa","Sidi Amar","Tipaza"],
        "Mila"=>["Mila" , "Chelghoum Laid" , "Ferdjioua" , "Grarem Gouga" , "Oued Endja" , "Rouached" , "Terrai Bainen" , "Tassadane Haddada" , "Aïn Beida Harriche" , "Sidi Merouane" , "Teleghma" , "Bouhatem" , "Tadjenanet"],
        "Aïn Defla"=>[ "Aïn Defla" , "Aïn Lechiekh" , "Bathia" , "Bordj Emir Khaled" , "Boumedfaa" , "Djelida" , "Djendel" , "El Abadia" , "El Amra" , "El Attaf" , "Hammam Righa" , "Khemis Miliana" , "Miliana" , "Rouina"],
        "Naama"=>[ "Naama" , "Ain Sefra" , "Assela" , "Makman Ben Amer" , "Mecheria" , "Moghrar" , "Sfissifa"],
        "Aïn Témouchent"=>["Aïn El Arbaa" , "Ain Kihal" , "Aïn Témouchent" , "Beni Saf" , "El Amria" , "El Malah" , "Hammam Bou Hadjar" , "Oulhaça El Gheraba"],
        "Ghardaïa"=>["Ghardaïa" ,"El Meniaa" ,"Metlili" ,"Berriane" ,"Daïa Ben Dahoua" ,"Mansoura" ,"Zelfana" ,"Guerrara" ,"Bounoura"],
        "Relizane"=>["Aïn Tarek","Ammi Moussa","Djidioua","El Hamadna","El Matmar","Mazouna","Mendes","Oued Rhiou","Ramka","Relizane","Sidi M'Hamed Ben Ali","Yellel","Zemmora"],
    );
    
    private $AU = ["New South Wales","Victoria","Queensland","Western Australia","South Australia",
    "Tasmania","Australian Capital Territory","Northern Territory","Norfolk Island","Christmas Island",
    "Australian Antarctic Territory","Jervis Bay Territory","Cocos (Keeling) Islands","Coral Sea Islands",
    "Ashmore and Cartier Islands","Heard Island and McDonald Islands"];
    
    private $BH = ["Capital","Muharraq","Northern","Southern"];
    
    private $BE = ["Antwerp","East Flanders","Flemish Brabant","Limburg","West Flanders","Hainaut","Liège",
    "Luxembourg","Namur","Walloon Brabant"];
    
    private $BA = ["Una-Sana","Posavina","Tuzla","Zenica-Doboj","Bosnian Podrinje","Central Bosnia",
    "Herzegovina-Neretva","West Herzegovina","Sarajevo"];
    
    private $CA = ["Ontario","Quebec","Nova Scotia","New Brunswick","Manitoba","British Columbia",
    "Prince Edward Island","Saskatchewan","Alberta","Newfoundland and Labrador"];
    
    private $EG = ["Alexandrie","Assouan","Assiout","Beheira","Beni Souef","Le Caire","Dakahleya","Damiette","Fayoum",
    "Gharbeya","Gizeh","Ismaïlia","Kafr el-Cheik","Marsa-Matruh","Minya","Menufeya","Nouvelle-Vallée",
    "Sinaï Nord","Port-Saïd","Qalyubiya","Qena","Mer-Rouge","Ach-Charqiya","Sohag","Sinaï Sud","Suez","Louxor"];
    
    private $DE = ["Baden-Württemberg","Bavaria","Berlin","Brandenburg","Bremen","Hamburg","Hesse","Lower Saxony",
    "Mecklenburg-Vorpommern","North Rhine-Westphalia","Rhineland-Palatinate","Saarland","Saxony",
    "Saxony-Anhalt","Schleswig-Holstein","Thuringia"];
    
    private $IQ = ["Al Anbar","Babil","Baghdad","Basra","Dhi Qar","Al Diwaniyah","Diyala","Dohuk","Erbil","Halabja",
    "Karbala","Kirkuk","Maysan","Muthana","Najaf","Nineveh","Saladin","Sulaymaniyah","Wasit"];
    
    private $IT = ["Agrigento","Alessandria","Ancona","Aosta","Arezzo","Ascoli Piceno","Asti","Avellino","Bari",
    "Barletta-Andria-Trani","Belluno","Benevento","Bergamo","Biella","Bologna","Bolzano","Brescia","Brindisi",
    "Cagliari","Caltanissetta","Campobasso","Carbonia-Iglesias","Caserta","Catania","Catanzaro","Chieti","Como",
    "Cosenza","Cremona","Crotone","Cuneo","Enna","Fermo","Ferrara","Florence","Foggia","Forlì-Cesena","Frosinone","Genoa",
    "Gorizia","Grosseto","Imperia","Isernia","La Spezia","L'Aquila","Latina","Lecce","Lecco","Livorno","Lodi","Lucca",
    "Macerata","Mantua","Massa and Carrara","Matera","Medio Campidano","Messina","Milan","Modena","Monza and Brianza",
    "Naples","Novara","Nuoro","Ogliastra","Olbia-Tempio","Oristano","Padua","Palermo","Parma","Pavia","Perugia",
    "Pesaro and Urbino","Pescara","Piacenza","Pisa","Pistoia","Pordenone","Potenza","Prato","Ragusa","Ravenna",
    "Reggio Calabria","Reggio Emilia","Rieti","Rimini","Rome","Rovigo","Salerno","Sassari","Savona","Siena","Sondrio",
    "Syracuse","Taranto","Teramo","Terni","Trapani","Trento","Treviso","Trieste","Turin","Udine","Varese","Venice",
    "Verbano-Cusio-Ossola","Vercelli","Verona","Vibo Valentia","Vicenza","Viterbo"];
    
    private $JP = ["Hokkaidō","Aomori","Iwate","Miyagi","Akita","Yamagata","Fukushima","Ibaraki","Tochigi","Gunma",
    "Saitama","Chiba","Tōkyō","Kanagawa","Niigata","Toyama","Ishikawa","Fukui","Yamanashi","Nagano","Gifu","Shizuoka",
    "Aichi","Mie","Shiga","Kyōto","Ōsaka","Hyōgo","Nara","Wakayama","Tottori","Shimane","Okayama","Hiroshima","Yamaguchi"];
    
    private $JO = ["Irbid","Ajloun","Jerash","Mafraq","Balqa","Amman","Zarqa","Madaba","Karak","Tafilah","Ma'an","Aqaba"];
    
    private $KW = ["Al Ahmadi","Al Asimah","Al Farwaniyah","Al Jahra","Hawalli","Mubarak Al-Kabeer"];
    
    private $LB = ["Beirut","Mount Lebanon","North","Beqaa","Nabatiye","South"];
    
    private $LY = ["Al Boutnan","Darnah","Al Djabal al Akhdar","Al Marj","Benghazi","Al Wahat","Al Koufrah",
    "Syrte", "Misratah", "Al Mourqoub","Tripoli","Al Djfara","Az Zaouiyah","An Nouqat al Khams",
    "Al Djabal al Gharbi","Nalout","Al Djoufrah","Wadi ach Chatii","Sebha","Wadi al Hayaat", "Ghat", "Mourzouq"];
    
    private $MY = ["Kuala Lumpur","Labuan","Putrajaya","Johor Darul Ta'zim","Kedah Darul Aman",
    "Kelantan Darul Naim","Malacca","Negeri Sembilan Darul Khusus","Pahang Darul Makmur","Perak Darul Ridzuan",
    "Perlis Indera Kayangan","Penang","Sabah","Sarawak","Selangor Darul Ehsan","Terengganu Darul Iman"];
    
    private $MR = ["Adrar","Assaba","Brakna","Dakhlet Nouadhibou","Gorgol","Guidimakha","Hodh Ech Chargui",
    "Hodh El Gharbi","Inchiri","Nouakchott","Tagant","Tiris Zemmour","Trarza"];
    
    private $MA = ["Chaouia-Ouardigha","Doukkala-Abda","Fès-Boulemane","Gharb-Chrarda-Beni Hssen",
    "Grand Casablanca","Guelmim-Es Semara","Laâyoune-Boujdour-Sakia el Hamra","Marrakech-Tensift-Al Haouz",
    "Meknès-Tafilalet","L'Oriental","Oued ed Dahab-Lagouira","Rabat-Salé-Zemmour-Zaër","Souss-Massa-Drâa",
    "Tadla-Azilal","Tanger-Tétouan","Taza-Al Hoceïma-Taounate"];
    
    private $OM = ["Ad Dākhilīyah","Adh-Dhahira","Al-Batina","Al Wusta","Ach-Charqiya","Al Buraymi","Dhofar",
    "Moussandam","Masqat"];
    
    private $PS = ["North Gaza","Gaza","Deir al-Balah","Khan Yunis","Rafah"];
    
    private $QA = ["Ad Dawhah","Al Ghuwariyah","Al Jumaliyah","Al Khawr","Al Wakrah","Al Rayyan",
    "Jariyan al Batnah","Ash Shamal","Umm Salal","Mesaieed"];
    
    private $SA = ["Al Bahah","Northern Borders","Al Jawf","Al Madinah Al Monawarah","Al-Qassim","Al Riyadh",
    "'Asir","Ash Sharqiyah","Ha'il","Jizan","Mecca","Najran","Tabuk"];
    
    private $ES = ["Madrid","Barcelona","Valencia","Sevilla","Málaga","Murcia","Cádiz","Biscay","La Coruña",
    "Balearic Islands","Las Palmas","Asturias","Santa Cruz de Tenerife","Zaragoza","Pontevedra","Granada",
    "Tarragona","Córdoba","Girona","Gipuzkoa","Toledo","Almería","Badajoz","Jaén","Navarre","Castellón","Cantabria",
    "Valladolid","Ciudad Real","Huelva","León","Lleida","Cáceres","Albacete","Burgos","Lugo","Salamanca","Ourense",
    "La Rioja","Álava","Guadalajara","Huesca","Cuenca","Zamora","Palencia","Ávila","Segovia","Teruel","Soria","Ceuta","Melilla"];
    
    private $SD = ["Blue Nile","Central Darfur","East Darfur","Gedarif","Gezira","Kassala","Khartoum",
    "North Darfur","Northern","North Kordofan","Red Sea","River Nile","Sennar","South Darfur","South Kordofan",
    "West Darfur","West Kordofan","White Nile"];
    
    private $SY = ["Aleppo","Al Hasakah","Ar Raqqah","As Suwayda","Damascus","Dar`a","Dayr az Zawr","Hama","Hims",
    "Idlib","Latakia","Quneitra","Rif Dimashq","Tartus"];
    
    private $TR = ["Adana","Adıyaman","Afyonkarahisar","Ağrı","Aksaray","Amasya","Ankara","Antalya","Ardahan",
    "Artvin","Aydın","Balıkesir","Bartın","Batman","Bayburt","Bilecik","Bingöl","Bitlis","Bolu","Burdur","Bursa",
    "Çanakkale","Çankırı","Çorum","Denizli","Diyarbakır","Düzce","Edirne","Elazığ","Erzincan","Erzurum","Eskişehir",
    "Gaziantep","Giresun","Gümüşhane","Hakkari","Hatay","Iğdır","Isparta","İstanbul","İzmir","Kahramanmaraş","Karabük",
    "Karaman","Kars","Kastamonu","Kayseri","Kilis","Kırıkkale","Kırklareli","Kırşehir","Kocaeli","Konya","Kütahya",
    "Malatya","Manisa","Mardin","Mersin","Muğla","Muş","Nevşehir","Niğde","Ordu","Osmaniye","Rize","Sakarya","Samsun",
    "Şanlıurfa","Siirt","Sinop","Şırnak","Sivas","Tekirdağ","Tokat","Trabzon","Tunceli","Uşak","Van","Yalova","Yozgat","Zonguldak"];
    
    private $AE = ["Ajman","Abu Dhabi","Dubai","Fujairah","Ras al-Khaimah","Sharjah","Umm al-Quwain"];
    
    private $GB = ["Bedfordshire","Berkshire","Buckinghamshire", "Cambridgeshire", "Cheshire", "Cornwall", 
    "Cumbria","Derbyshire", "Devon", "Dorset", "Durham", "Essex", "Gloucestershire","Hampshire", "Hertfordshire",
    "Huntingdonshire","Kent", "Lancashire", "Leicestershire", "Lincolnshire","Middlesex", "Norfolk", "Northamptonshire", "Northumberland",
    "Nottinghamshire", "Oxfordshire","Shropshire","Somerset", "Staffordshire","Suffolk", "Surrey", "Sussex","Warwickshire","Westmoreland", "Wiltshire", 
    "Worcestershire","Yorkshire"];
    
    private $US = ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida",
    "Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Mississippi","Minnesota","Michigan","Massachusetts","Maryland",
    "Maine","Louisiana","Kentucky","Kansas","North Carolina","New York","New Mexico","New Jersey","New Hampshire",
    "Nevada","Nebraska","Montana","Missouri","Tennessee","South Dakota","South Carolina","Rhode Island","Pennsylvania",
    "Oregon","Oklahoma","Ohio","North Dakota","Wyoming","Wisconsin","West Virginia","Washington","Virginia","Vermont",
    "Utah","Texas"];
    
}
