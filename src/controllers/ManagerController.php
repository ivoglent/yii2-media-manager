<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/7/17.
 */


namespace ivoglent\media\manager\controllers;


use ivoglent\media\manager\components\UploadOptions;
use ivoglent\media\manager\components\UploadResult;
use ivoglent\media\manager\models\Media;
use ivoglent\media\manager\models\MediaFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class ManagerController extends Controller
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws UnauthorizedHttpException
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->user->isGuest){
            throw new UnauthorizedHttpException("Reuquired logged in user");
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionDialog()
    {
        $user = \Yii::$app->user->identity;
        $model = new Media();
        $model->created_by = $user->getId();
        $dataProvider = new ActiveDataProvider([
            'query' => Media::find()->where(['created_by' => $user->getId()])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
        return $this->renderPartial('dialog', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionUpload()
    {
        if (\Yii::$app->request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $options = isset($_POST['options']) ? $_POST['options'] : [];
            $model = new MediaFile();
            $model->file = UploadedFile::getInstanceByName( 'file');
            if (!empty($model->file)) {
                $options['file'] = $model->file;
                $model->options = new UploadOptions($options);
                if ($result = $model->upload()) {
                    /** @var UploadResult $result */
                    // file is uploaded successfully
                    if ($result->success) {
                        $media = new Media();
                        $media->created_by = \Yii::$app->user->getId();
                        $media->type = $model->options->type;
                        $media->thumb = $result->thumbnailName;
                        $media->folder = Media::currentDir();
                        $media->name =$result->fileName;
                        $media->size = ($result->size);
                        $media->title = $result->fileName;

                        if ( $media->save() ) {
                            $result->id = $media->id;
                            return $result;
                        } else {
                            return [
                                'success' => 0,
                                'errors' => $media->getErrors()
                            ];
                        }
                    }
                }
            }

            return [
                'success' => 0,
                'errors' => 'Your file could not upload. <br />Errors : <br/>' . $result->error
            ];
        }
    }

    /**
     * Delete stored item after user confirmed
     * 1 - Delete stored record
     * 2 - Delete related files
     */
    public function actionDelete()
    {
        if (isset($_POST['id'])) {
            $id =  $_POST['id'];
            $model = Media::findOne($id);
            if (!empty($model) &&  $model->delete()) {
               \Yii::$app->response->format = Response::FORMAT_JSON;
               return [
                   'code' => 200,
                   'message' => \Yii::t('app',  "The file {$model->name} has been deleted successfully!")
               ];
            }
        }
        return [
            'code' => 404,
            'message' => \Yii::t('app', 'Selected file could not be found')
        ];
    }
}