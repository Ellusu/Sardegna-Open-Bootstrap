<?php

    class mainClass {
        
        public function main(){
            $this->controller();
            
        }
        
        public function controller () {
            $smarty = new Smarty;

            $smarty->force_compile = true;
            //$smarty->debugging = true;
            $smarty->caching = true;
            $smarty->cache_lifetime = 120;
            $smarty->setTemplateDir('template');
            
            $plug_body = $this->plugin();
            $body = array("search.tpl", "result_page.tpl");
            
            $smarty->assign("body", $plug_body['template']);
            $smarty->assign("array", $plug_body['array']);
            if(isset($_POST["search"])||isset($_GET["search"])) {
                if(!isset($plug_body['array']['title'])){                
                    $smarty->assign("title", 'Nessun Risultato - '.PAGE_TITLE);
                    $smarty->assign("description", PAGE_TITLE.' - Nessun risultato');
                } else {
                    $smarty->assign("title", $plug_body['array']['title'].' - '.PAGE_TITLE);
                    $smarty->assign("h1", $plug_body['array']['title']);
                    $smarty->assign("description", PAGE_TITLE.' - '.$plug_body['array']['description']);

                }
            } else {                
                $smarty->assign("title", 'Cerca in Sardegna - '.PAGE_TITLE);
                $smarty->assign("description", PAGE_TITLE.' - Motore di ricerca in Sardegna');
            }
            
            $smarty->display('page.tpl');
        }
        
        public function plugin () {
            
            $array = array();
            $array['array'] = array();
            $dir = "class/plugin";
            $list_plugins = scandir($dir);
            unset($list_plugins[1]);
            unset($list_plugins[0]);
            
            foreach ($list_plugins as $plugin) {
                $plugin_url = $dir.'/'.$plugin.'/index.php';
                $class_name = $plugin.'Plugin';
                include ($plugin_url);
                
                $class = new $class_name();
                $single = $class->go();
                
                $array['template'][$single['order']] = $single['template'];
                $array['array'] = array_merge($array['array'], $single['list']);
            }
            return $array;
        }
        
    }