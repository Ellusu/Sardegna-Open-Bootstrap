<?php

    class searchPlugin {
        
        public $monster = array(
            'order'         =>  0,
            'list'          => array()
        );
        public $search ='';
        
        public function __construct() {
            $lista = array();
            if(isset($_POST["search"])||isset($_GET["search"])) {
                if(isset($_POST["search"])) {
                    $this->search = $_POST["search"];
                    
                    header('Location: http://matteoenna.it/sardegnaopenbootstrap/'.$_POST["search"].'.html');
                    exit;
                } elseif(isset($_GET["search"])){
                    $this->search = $_GET["search"];
                    if($this->search=='tutti') {
                        $this->monster['list']      = $this->getPoiCorrettore();
                        $this->monster['template']  = '../class/plugin/search/template/all.tpl';
                        
                        return FALSE;
                    }
                }
                $this->monster['template'] = '../class/plugin/search/template/result.tpl';
                $poi = $this->getPoidata();
                if(!$poi) {
                    $this->monster['list']      = $this->getPoiCorrettore();
                    $this->monster['template'] = '../class/plugin/search/template/none.tpl';
                    return FALSE;
                }
                //if($_SERVER["REMOTE_ADDR"]=='95.239.208.246')
                //    $this->getBlogData();
                $lista = array_merge($lista, $poi);
                $lista = array_merge($lista, $this->getBlogData());
                $lista = array_merge($lista, $this->getWikidata());
                $lista = array_merge($lista, $this->getInstagramData());
                $this->monster['list'] = $lista;
            } else {
                $this->search = 'Sardegna';
                $lista = array_merge($lista, $this->getWikidata());
                $lista = array_merge($lista, $this->getInstagramData());
                $this->monster['list'] = $lista;
                $this->monster['template'] = '../class/plugin/search/template/search.tpl';
            } 
        }
        
        public function go() {
            return $this->monster;
        }
        
        public function getWikidata() {
            $opt_search= str_replace(' ', '_', $this->search);
            if(strtolower($opt_search)=='santa_giusta') {
                $opt_search='Santa_Giusta_(Italia)';
            }
            if(strtolower($opt_search)=="nughedu_di_san_nicolo'") {
                $opt_search='Nughedu_San_Nicolò';
            }
            if(stripos($opt_search,'(')) {
                $temp = explode('(',$opt_search);
                $opt_search = $temp[0];
                $opt_search= str_replace('_', '', $opt_search);
               
            }
            
            $url = 'https://it.wikipedia.org/w/api.php?action=opensearch&limit=10&format=xml&search='.$opt_search;
            $myxmlfilecontent = file_get_contents($url);
            
            $xml = simplexml_load_string($myxmlfilecontent, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
           
            if(isset($array['Section']['Item'][0])) {
                return array(
                    'wikipedia' => array(                
                        'citta'         =>  $array['Section']['Item'][0]['Text'],
                        'url'           =>  $array['Section']['Item'][0]['Url'],
                        'description'   =>  $array['Section']['Item'][0]['Description']
                    ),
                    'description'   => $array['Section']['Item'][0]['Description']
                );
            }else {
                return array(
                    'wikipedia' => array(                
                        'citta'         =>  $array['Section']['Item']['Text'],
                        'url'           =>  $array['Section']['Item']['Url'],
                        'description'   =>  $array['Section']['Item']['Description']
                    ),
                    'title'         => $array['Section']['Item']['Text'],
                    'description'   => $array['Section']['Item']['Description']
                );
                
            }
        }
        
        public function getPoiCorrettore() {
            $array = array();
            $array_r = array();
            $data = file_get_contents('data/poi.csv');
            $righe = explode(chr(10),$data);
            unset($righe[0]);
            natcasesort($righe);
            foreach ($righe as $riga) {
                $colonne = explode(';', $riga);
                $cerca = str_replace('"', '', $colonne[0]);
                array_push($array,$cerca);
                $array = array_unique($array);                
            }
            
            foreach ($array as $paese) {
                $one = explode(' ', strtolower($paese));
                $two = explode(' ', strtolower($this->search));
                $result = array_intersect_assoc($one, $two);
                if (count($result)>0 || stripos(strtolower($paese),strtolower($this->search))!==FALSE)
                    array_push($array_r,$paese);
            }
            
            return array(
                'all' => $array,
                'sug' => $array_r       
            );
        }
        
        public function getPoidata() {
            $check = FALSE;
            $array = array();
            $nome = '';
            $data = file_get_contents('data/poi.csv');
            $righe = explode(chr(10),$data);
            foreach ($righe as $riga) {
                $colonne = explode(';', $riga);
                $cerca = str_replace('"', '', $colonne[0]);
                if(strtolower($cerca) == strtolower($this->search)) {
                    if($colonne[4]=='"Città e paesi"') {
                        $check = TRUE;
                        //continue;
                    }
                    $nome = $colonne[0];
                    $tipologia = str_replace('"', '', $colonne[4]);
                    if(!isset($array[$tipologia])) {
                        $array[$tipologia] = array();
                    }
                    $array[$tipologia][] = array(
                        'zona'      =>  $colonne[3],
                        'tipologia' =>  $colonne[5],
                        'sito'      =>  $colonne[6],
                        'lat'       =>  str_replace('"', '', $colonne[8]),
                        'long'      =>  str_replace('"', '', $colonne[9]),
                    );
                }
            }
            if($check) {
                return array(
                    'poi'   => $array,
                    'title' => str_replace('"', '', $nome)
                );
            } else {
                return FALSE;
            }
        }
        
        public function getInstagramData() {
            $opt_search= str_replace(' ', '', $this->search);
            $opt_search= str_replace("'", '', $opt_search);
            
            
            if(stripos($opt_search,'(')) {
                $temp = explode('(',$opt_search);
                $opt_search = $temp[0];
                $opt_search= str_replace('_', '', $opt_search);
               
            }
            
            if($opt_search=="NughedudiSanNicolo") {
                $opt_search='nughedusannicolò';
            }
            
            $array = array();            
            
            $insta_source = file_get_contents('https://www.instagram.com/explore/tags/'.$opt_search.'/'); // instagrame tag url
            $shards = explode('window._sharedData = ', $insta_source);
            $insta_json = explode(';</script>', $shards[1]); 
            $insta_array = json_decode($insta_json[0], TRUE);
            
            $insta_array = $insta_array['entry_data']['TagPage'][0]['tag']['media']['nodes'];
            
            foreach ($insta_array as $k => $insta) {
                
                $array[] = array(
                    'id'=>$insta['id'],
                    'code'=>$insta['code'],
                    'thumbnail_src'=>$insta['thumbnail_src']
                );
                
            }
            
            return array(
                'instagram' => $array
            );
        }
        
        
        
        public function getBlogData() {
            $array = array();
            $javascript_loop = 0;
            $timeout = 5;
            $opt_search = $this->search;
            if(stripos($opt_search,'(')) {
                $temp = explode('(',$opt_search);
                $opt_search = $temp[0];
                $opt_search= str_replace('_', '', $opt_search);
               
            }
            
            $url = 'http://matteoenna.it/api/get_tag_posts/';
            $var = array('slug' => $opt_search);
            $url = str_replace( "&amp;", "&", urldecode(trim($url)) );
        
            $cookie = tempnam ("/tmp", "CURLCOOKIE");
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_ENCODING, "" );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
            curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
            
            if($var) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $var);
            }
            
            $content = curl_exec( $ch );
            $response = curl_getinfo( $ch );
            curl_close ( $ch );
        
            if ($response['http_code'] == 301 || $response['http_code'] == 302) {
                ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
        
                if ( $headers = get_headers($response['url']) ) {
                    foreach( $headers as $value ) {
                        if ( substr( strtolower($value), 0, 9 ) == "location:" )
                            return get_url( trim( substr( $value, 9, strlen($value) ) ) );
                    }
                }
            }
            
            $result = json_decode($content);
            if($result->status=='error') {
                return array(
                    'blog' => FALSE             
                );
            } else {
                foreach($result->posts as $post) {
                    $array[] = array(
                        'url'=>$post->url,
                        'title'=>$post->title,
                        'img'=>$post->attachments[0]->url
                    );
                }
            }
            return array(
                'blog' => $array             
            );
            if (    ( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) && $javascript_loop < 5) {
                return get_url( $value[1], $javascript_loop+1 );
            } else {
                return array( $content, $response );
            }
        }
        
    }
