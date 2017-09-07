<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/7/17.
 */


namespace ivoglent\media\manager\controllers;


use yii\web\Controller;
use yii\web\Response;

class UploadController extends Controller
{
    public function actionIndex()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;


            $this->asJson([
                'code' => 200,
                'message' => 'Success'
            ]);
        }

    }
}