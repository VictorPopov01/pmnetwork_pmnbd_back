<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\pmnbd\models\siteobject;

use common\utility\FileData;
use Yii;

/**
 * This is the base-model class for table "site_object".
 *
 * @property integer $id
 * @property string $table_name
 * @property integer $row_id
 *
 * @property backend\modules\pmnbd\models\siteobject\SiteObjectMedia[] $siteObjectMedia
 * @property backend\modules\pmnbd\models\siteobject\SiteObjectMediaTarget[] $mediaTargets
 * @property backend\modules\pmnbd\models\siteobject\SiteObjectSeo[] $siteObjectSeos
 * @property string $aliasModel
 */
abstract class BaseSiteObject extends \yii\db\ActiveRecord
{

    private $mediaEnumClass;

    public function __construct()
    {
        //в каждом модуле своя реализация MediaEnum
        $this->mediaEnumClass = \Yii::$app->params['mediaEnumClass'] ?? BaseMediaEnum::class;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteObject()
    {
        return $this->hasOne(SiteObject::className(), ['row_id' => 'id'])->andOnCondition(['table_name' => $this->tableName()]);
    }

    /* *
     * @return \yii\db\ActiveQuery
     */
    public function getMediaTargets()
    {
        return $this->hasMany(SiteObjectMediaTarget::className(), ['site_object_id' => 'id'])->via('siteObject');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeoObject()
    {
        return $this->hasOne(SiteObjectSeo::className(), ['site_object_id' => 'id'])->via('siteObject');
    }

    public static function createSiteObjects() {
        foreach (self::findWithRelations()->all() as $obj) {
            $obj->createSiteObject();
        }
    }

    public function createSiteObject() {
        if (empty($this->siteObject)) {
            $newSiteObject = new SiteObject();
            $newSiteObject->table_name = $this->tableName();
            $newSiteObject->row_id = $this->id;
            if (!$newSiteObject->save()) {
                $this->addError('newSiteObject', 'Не удалось создать объект');
                return false;
            }
        }

        if (empty($this->seoObject) && $siteObject = $this->getSiteObject()->one()) {
            $newSeoObject = new SiteObjectSeo();
            $newSeoObject->site_object_id = $siteObject->id;
            if (!$newSeoObject->save()) {
                $newSiteObject->delete();
                $this->addError('newSeoObject', 'Не удалось создать объект');
                return false;
            }
        }
        $this->createMediaTargets();
        $this->refresh();
    }

    public function afterSave($insert, $changed)
    {
        parent::afterSave($insert, $changed);
        $this->createSiteObject();
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        if ($this->siteObject) {
            return $this->siteObject->delete();
        }
        return true;
    }

    private function createMediaTargets()
    {
        $existingMediaTargets = array_map(
            function ($target) {
                return $target->type;
            },
            $this->mediaTargets
        );
        foreach ($this->mediaEnumClass::getForSiteObject($this) as $type) {
            if (!in_array($type, $existingMediaTargets)) {
                $newMediaTarget = new SiteObjectMediaTarget([
                    'site_object_id' => $this->getSiteObject()->one()->id,
                    'type' => $type,
                    'index' => 1 //TODO more instances
                ]);
                if ($newMediaTarget->save()) {
                };
            }
        }
    }

    public function getFileData($type, $config = [], $position = 0, $index = 1)
    {
        $fileData = new FileData();
        if (in_array($type, $this->mediaEnumClass::getForSiteObject($this))) {

            $filtered = array_filter($this->mediaTargets, function ($mediaTarget) use ($type, $index) {
                return $mediaTarget->type == $type && $mediaTarget->index == $index;
            });

            if (($mediaTarget = reset($filtered)) && isset($mediaTarget->siteObjectMedia[$position])) {
                $fileData->setSrc($mediaTarget->siteObjectMedia[$position]->media->getWebFileLink($config));
                $fileData->setAlt($mediaTarget->siteObjectMedia[$position]->description);
            }
        }

        return $fileData;
    }

    public function getFilesData($type, $config = [], $index = 1)
    {
        $filesData = [];
        if (in_array($type, $this->mediaEnumClass::getForSiteObject($this))) {

            $filtered = array_filter($this->mediaTargets, function ($mediaTarget) use ($type, $index) {
                return $mediaTarget->type == $type && $mediaTarget->index == $index;
            });

            if (($mediaTarget = reset($filtered)) && !empty($mediaTarget->siteObjectMedia)) {
                foreach ($mediaTarget->siteObjectMedia as $siteObjectMedia) {
                    $src = $siteObjectMedia->media->getWebFileLink($config);
                    $alt = $siteObjectMedia->description;
                    $filesData[] = new FileData($src, $alt);
                }
            }
        }

        return $filesData;
    }

    public static function findWithMedia()
    {
        return static::find()
            ->with('mediaTargets')
            ->with('mediaTargets.siteObjectMedia')
            ->with('mediaTargets.siteObjectMedia.media');
    }

    public static function findWithSeo()
    {
        return static::find()->with('seoObject');
    }

    public static function findWithRelations() {
        return static::find()
            ->with('mediaTargets')
            ->with('mediaTargets.siteObjectMedia')
            ->with('mediaTargets.siteObjectMedia.media')
            ->with('seoObject');
    }
}
