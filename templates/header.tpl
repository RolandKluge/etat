<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width" />
        <title>{$title}</title>
        <link rel="stylesheet" href="static/css/stylesheet.css">
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.min.css">
    </head>
    <body>
        <div id="content">
            <div id="links">
                {foreach $links as $link}
                    <div class="linkSeparator"></div>
                    <div class="link">
                        <a href="{$link['url']}">
                            {$link['label']}
                        </a>
                    </div>
                {/foreach}
            </div>
            <div id="header">
                <div id="title">
                    {$title}
                </div>

            </div>
            {if {$hasErrors}}
                <div class="errorMessage">{$errorMessage}</div>
                <div style="display: none">
                {/if}
