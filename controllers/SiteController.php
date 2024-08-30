<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Notes;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $notesList = Notes::getList();

        return $this->render('notes', ['notesList' => $notesList]);
    }

    public function actionTag($name) {
        $notesList = Notes::getList(['tag_name' => $name]);

        return $this->render('notes', ['notesList' => $notesList]);
    }

    public function actionAdd()
    {
        if (isset($_POST['note'])) {
            Notes::insert($_POST['note']);

            header('location: /');

            exit;
        }

        $data = [
            'submitLabel' => 'add'
        ];

        return $this->render('note_add', $data);
    }

    public function actionUpdate($id)
    {
        if (isset($_POST['note'])) {
            Notes::update($_POST['note']);

            header('location: /');

            exit;
        }

        $data = [
            'submitLabel' => 'update',
            'note' => Notes::get($id)
        ];

        return $this->render('note_add', $data);
    }

    public function actionDelete($id)
    {
        Notes::delete($id);

        header('location: /');

        exit;
    }

    public function actionAddtag($id)
    {
        if (isset($_POST['tag'])) {
            Notes::insertTag($_POST['tag'], $id);

            header('location: /');

            exit;
        }

        return $this->render('tag_add');
    }

    public function actionDeletetag($id)
    {
        Notes::deleteTag($id);

        header('location: /');

        exit;
    }
}
