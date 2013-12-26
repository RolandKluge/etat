<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width" />
        <title>{$title}</title>
        <link rel="stylesheet" href="static/css/stylesheet.css">
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    </head>
    <body>
        <div id="content">
            <div id="header">
                <div id="title">
                    {$title}
                </div>
                <div id="links">
                    {if $links}
                        <div class="link">Gehe: </div>
                        <div style="float: left;"><!--Dummy--></div>
                    {/if}
                    {foreach $links as $link}
                        <div class="link">
                            <a href="{$link['url']}">
                                {$link['label']}
                            </a>
                        </div>
                    {/foreach}
                </div>
            </div>