<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Notes extends Model
{
    public static function getList($filter = []) {
        $cond = [];

        if (isset($filter['id'])) {
            $cond[] = 'notes.id = ' . (int)$filter['id'];
        }

        if (isset($filter['tag_name'])) {
            $tagId = Yii::$app->db->createCommand('
                select id from tags
                where
                    name = ' . Yii::$app->db->quoteValue($filter['tag_name']) . '
                limit 1
            ')->queryScalar();

            $cond[] = '
                (
                    select 1 from notes_tags
                    where
                        notes.id = note_id and
                        tag_id = ' . $tagId . '
                    limit 1
                )
            ';
        }

        $condString = '';

        if ($cond) {
            $condString = 'where ' . implode(' and ', $cond);
        }

        $result = Yii::$app->db->createCommand('
            select 
                notes.*, 
                notes_tags.tag_id,
                tags.name tag_name
            from notes 
            left join notes_tags on notes_tags.note_id = notes.id
            left join tags on tags.id = notes_tags.tag_id
            ' . $condString . '
            order by id, tag_id
        ')->query();

        $rows = [];

        while ($row = $result->read()) {
            if (!isset($rows[$row['id']])) {
                $rows[$row['id']] = $row;

                $rows[$row['id']]['tags'] = [];
            }

            if ($row['tag_id'] && !isset($rows[$row['id']]['tags'][$row['tag_id']])) {
                $rows[$row['id']]['tags'][$row['tag_id']] = [
                    'id' => $row['tag_id'],
                    'name' => $row['tag_name']
                ];
            }
        }

        return $rows;
    }

    public static function get($id) {
        $rows = self::getList(['id' => (int)$id]);

        return current($rows);
    }

    public static function insert($row) {
        return Yii::$app->db->createCommand()->insert('notes', $row)->execute();
    }

    public static function update($row) {
        return Yii::$app->db->createCommand()->update('notes', $row, 'id = ' . (int)$row['id'])->execute();
    }

    public static function delete($noteId) {
        $transaction = Yii::$app->db->beginTransaction();

        Yii::$app->db->createCommand()->delete('notes', 'id = ' . (int)$noteId)->execute();

        Yii::$app->db->createCommand()->delete('notes_tags', 'note_id = ' . (int)$noteId)->execute();

       return $transaction->commit();
    }

    public static function insertTag($row, $noteId) {
        $tagId = Yii::$app->db->createCommand('
            select id 
            from tags
            where
                name = ' . Yii::$app->db->quoteValue($row['name']) . '
            limit 1
        ')->queryScalar();

        $transaction = Yii::$app->db->beginTransaction();

        if (!$tagId) {
            Yii::$app->db->createCommand()->insert('tags', $row)->execute();

            $tagId = Yii::$app->db->lastInsertID;
        }

        $data = [
            'note_id' => $noteId,
            'tag_id' => $tagId
        ];

        Yii::$app->db->createCommand()->insert('notes_tags', $data)->execute();

        return $transaction->commit();
    }

    public static function deleteTag($noteId) {
        $tagId = Yii::$app->db->createCommand('
            select tag_id 
            from notes_tags 
            where
                note_id = ' . (int)$noteId . '
            order by tag_id desc
            limit 1
        ')->queryScalar();

        $transaction = Yii::$app->db->beginTransaction();

        Yii::$app->db->createCommand()->delete('tags', 'id = ' . (int)$tagId)->execute();

        Yii::$app->db->createCommand()->delete('notes_tags', 'note_id = ' . (int)$noteId . ' and tag_id = ' . (int)$tagId)->execute();

       return $transaction->commit();
    }
}
