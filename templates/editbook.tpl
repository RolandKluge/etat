{include file='header.tpl'}
        <h1>{$title}</h1>
        <form id="editBookForm" method="get" action="editbook.php">
            <label for="name">Name</label>
            <input name="name" type="text" size="30" value='{$name}'/>
            <br/>
            <label for="description">Beschreibung</label>
            <input name="description" type="text" size="50" value='{$description}'/>
            <br/>
            <input name="id" type="hidden" value="{$id}"></input>
            <input name="action" type="hidden" value="{$action}"></input>
            <button type="submit">Speichern</button>
        </form>
{include file='footer.tpl'}