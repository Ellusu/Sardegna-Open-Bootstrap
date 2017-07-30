<html>
    {include file='head.tpl'}
    <body class="SardegnaOpenBootstrap">
        {literal}
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55780934-1', 'auto');
  ga('send', 'pageview');

</script>
        {/literal}
        
        {include file='header.tpl'}
            <div class="col-md-12">
            {foreach $body as $template}
                {include file=$template}
            {/foreach}
            </div>
        {include file='footer.tpl'}      
    </body>
</html>