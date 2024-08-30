<?php
    $this->title = 'Notes';
?>

<a href="/add"><button>add</button></a>

<table>
    <tr>
        <th>note</th>
        <th>tags</th>
    </tr>
    <?php foreach ($notesList as $note) { ?>
        <tr>
            <td><a href="<?= $note['id'] ?>"><?= $note['title'] ?></td>
            <td>
                <?php foreach ($note['tags'] as $tag) { ?>
                    <a href="/<?= $tag['name'] ?>"><?= $tag['name'] ?></a>
                <?php } ?>
            </td>
            <td>
                <a href="/delete/<?= $note['id'] ?>">delete</a>
            </td>
            <td>
                <a href="/tag/add/<?= $note['id'] ?>">add tag</a>
            </td>
            <td>
                <a href="/tag/delete/<?= $note['id'] ?>">delete tag</a>
            </td>
        </tr>
    <?php } ?>
</table>