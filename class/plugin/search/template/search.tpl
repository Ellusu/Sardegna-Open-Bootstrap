<div class="container"> 
    <div class="col-md-12 search-home">  
        <div class="col-md-12">
            <div class="col-md-6">
                <a href="index.php" class="logo-home col-md-4">
                    <img src="template/img/logo-web.png">
                </a>
                <div class="col-md-8">
                    <h1>Sardegna</h1>
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

<div class="container suggerimento">
    <div class="col-md-12">
        <div class="col-md-12  lista-sardegna">
            <a href="http://matteoenna.it/sardegnaopenbootstrap/tutti.html" class="first-time">
                    <span>Prima volta in questo sito? Guarda tutti i paesi della Sardegna!</span>
            </a>
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

                        <a href="https://www.instagram.com/p/{$elementi['code']}/" class="col-md-2" target="_blank">
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
    </div>
</div>