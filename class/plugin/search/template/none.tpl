<div class="container"> 
    <div class="col-md-12">
        <h1 class="title-research">Nessun risultato per questa ricerca</h1>
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
<div class="container suggerimento">
    <div class="col-md-12">
        <div class="col-md-12">
            {if isset($array['sug'])}
                <h2>Alcuni suggerimenti per la tua ricerca</h2>
                <p>Non abbiamo trovato nessuna corrispondenza potresti provare:</p>
                <ul>
                    {foreach from=$array['sug'] item="paese"}
                    <li>
                        <a href="http://matteoenna.it/sardegnaopenbootstrap/{$paese}.html">
                            {$paese}
                        </a>
                    </li>
                {/foreach}
                </ul>
            {/if}
        </div>
        <div class="col-md-12">
            <h2>La lista completa dei paesi</h2>
            <p>Non abbiamo trovato nessuna corrispondenza potresti provare:</p>
            <ul>
            {foreach from=$array['all'] item="paese"}
                <li class="col-md-3">
                <a href="http://matteoenna.it/sardegnaopenbootstrap/{$paese}.html" >
                    {$paese}
                </a>
                </li>
            {/foreach}
            </ul>
        </div>
    </div>
</div>