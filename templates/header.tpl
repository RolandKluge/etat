<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <meta charset="UTF-8">
        <title>{$title}</title>
        <link rel="stylesheet" href="static/css/stylesheet.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    </head>
    <body>
        <div class="header">
            <ul>
                {foreach $links as $link}
                    <li>
                        <a href="{$link['url']}">
                            <div class="link">{$link['label']}</div>
                        </a>
                    </li>
                {/foreach}
            </ul>
        </div>