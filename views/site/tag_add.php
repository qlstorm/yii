<form method="POST">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->getRequest()->csrfParam ?>">

    <p>
        title<br>
        <input name="tag[name]">
    </p>

    <input type="submit" value="add">
</form>