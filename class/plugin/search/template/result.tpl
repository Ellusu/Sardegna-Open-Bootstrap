<div class="container"> 
    <div class="col-md-12">
        <h1 class="title-research">Ricerche per {$h1}</h1>
    </div>
    <div class="col-md-12 search-home">  
        <div class="col-md-12">
            <div class="col-md-6">
                <a href="index.php" class="logo-home col-md-4">
                    <img src="template/img/logo-web.png">
                </a>
                <div class="col-md-8">
                    <h2>Sardegna</h1>
                    <h2>Open Bootstrap</h2>
                </div>
            </div>
            <div class="col-md-6">
                    <form method="post" action="index.php" class="form-group">
                        <div class="col-md-8">
                            <input type="text" name="search" class="search inputtext form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="submit" value="cerca" class="search bottom form-control">
                        </div>
                    </form>
            </div>
            
        </div>
    </div>
</div>
<div class="container result">
    <div class="col-md-12"> 
    {if isset($array['wikipedia'])}    
        <div class="col-md-12 wikipedia">  
            <div class="col-md-12">
                <div class="col-md-12">
                    <h2>{$array['wikipedia']['citta']} su Wikipedia </h2>
                </div>
                <div class="col-md-12">
                    {$array['wikipedia']['description']}
                </div>
                <div class="col-md-12">
                    <a href="{$array['wikipedia']['url']}" target="_blank">Visita wikipedia</a>
                </div>
            </div>
        </div>
    {/if}
    {if isset($array['instagram'])}
        <div class="col-md-12 instagram"> 
            <div class="col-md-12">  
                <div class="col-md-12">
                    <h2>Instagram: #{$array['wikipedia']['citta']}</h2>
                </div>
                <div class="col-md-12">            
                    {foreach from=$array['instagram'] key="tipologia" item="elementi"}

                        <a href="https://www.instagram.com/p/{$elementi['code']}/" class="col-md-4" target="_blank">
                            <img src="{$elementi['thumbnail_src']}" class="col-md-12">
                        </a>
                    {/foreach}
                </div>  
                <div class="col-md-12">
                    <a href="https://www.instagram.com/explore/tags/{$array['wikipedia']['citta']}/" target="_blank">Tutte le immagini</a>
                </div> 
            </div>
        </div>
    {/if}
    {if isset($array['poi'])}    
        <div class="col-md-12 poi"> 
              
            <div class="col-md-12">
                <div class="col-md-12">
                    <h2>{$array['wikipedia']['citta']} sugli Open Data </h2>
                </div>
                <div class="col-md-12">
                    {foreach from=$array['poi'] key="tipologia" item="elementi"}
                        <div class="col-md-12"><h3>{$tipologia}</h3></div>
                        <div class="col-md-12">
                            {foreach from=$elementi key="tip" item="uno"}
                                <div class="col-md-6 single-poi">
                                    <ul>
                                        <li>Tipologia: {$uno['tipologia']}</li>
                                        <li>Zona: {$uno['zona']}</li>
                                        <li><a href="{$uno['sito']}">Sito</a></li>
                                        <li>
                                            <a href="https://www.openstreetmap.org/#map=16/{$uno['lat']}/{$uno['long']}" target="_blank">
                                                OpenStreetMaps
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.google.com/maps/@{$uno['lat']},{$uno['long']},19z" target="_blank">
                                                gMaps
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            {/foreach}
                        </div>
                    {/foreach}
                    <div class="col-md-12">
                        <a href="http://www.datiopen.it/it/opendata/Regione_Sardegna_Luoghi_di_interesse_turistico_culturale_naturalistico" target="_blank">Fonte Open Data</a>
                    </div>
                </div>
            </div>
        </div>
    {/if}
    {if isset($array['blog']) && $array['blog']==TRUE}    
        <div class="col-md-12 poi"> 
              
            <div class="col-md-12">
                <div class="col-md-12">
                    <h2>{$array['wikipedia']['citta']} dal Blog </h2>
                </div>
                
                <div class="col-md-12">
                    {foreach from=$array['blog'] item="elemento"}
                        <span class="col-md-3 blog-el">
                            <a href="{$elemento['url']}" class="col-md-12" target="_blank">
                                <img src="{$elemento['img']}">
                                <p>{$elemento['title']}</p>
                            </a>
                        </span>
                    {/foreach}
                    <div class="col-md-12">
                        <a href="http://matteoenna.it" target="_blank">Il blog di Matteo Enna</a>
                    </div>
                </div>
            </div>
        </div>
    {/if}
    </div>
</div>