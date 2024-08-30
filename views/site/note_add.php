<form method="POST">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->getRequest()->csrfParam ?>">

    <input type="hidden" name="note[id]" value="<?= isset($note['id']) ? $note['id'] : '' ?>">

    <p>
        title<br>
        <input name="note[title]" value="<?= isset($note['title']) ? $note['title'] : '' ?>">
    </p>

    <p>
        text<br>
        <input name="note[text]" value="<?= isset($note['text']) ? $note['text'] : '' ?>">
    </p>

    <p>
        <input type="submit" value="<?= $submitLabel ?>">
    </p>
</form>