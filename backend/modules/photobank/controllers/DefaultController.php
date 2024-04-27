<?php

namespace app\modules\photobank\controllers;

use app\modules\photobank\models\Photobank;
use app\modules\photobank\models\PhotobankSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\modules\photobank\models\PhotobankForm;
use yii\web\ServerErrorHttpException;

/**
 * PhotobankController implements the CRUD actions for Photobank model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Photobank models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PhotobankSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Photobank model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Photobank model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Photobank();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Photobank model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Photobank model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Photobank model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Photobank the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photobank::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * Lists all Photobank models.
     *
     * @return string
     */
    public function actionIndexView()
    {
        $searchModel = new PhotobankSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        return $this->render('index-view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionUpload()
    {
        
        $model = new PhotobankForm();
        if ($this->request->isPost) {

            $model->files = UploadedFile::getInstances($model, 'files');
            foreach ($model->files as $file) {
                $photo = new Photobank();
                $photo->file = new UploadedFile($file);
                if (!$photo->save()) {
                    \Yii::$app->session->setFlash('error', $photo->getErrors());
                    break;
                }
            }
            \Yii::$app->session->setFlash('success', 'Ok');
            return $this->refresh();
        }
        return $this->render('upload', ['model' => $model]);
    }


    public function actionDownload($model_id)
    {
        try {
            $model = $this->findModel($model_id);
            $zip = new \ZipArchive();
            $tmpFile = $model->getPathFileName() . '.zip';
            if (!$zip->open($tmpFile, \ZipArchive::CREATE)) {
                throw new ServerErrorHttpException('Cannot create a zip file');
            }
            if (!$model->getPathFileName()) {
                throw new NotFoundHttpException('Not set filename');
            }
            // $model->filename_origin ?
            $zip->addFile($model->getPathFileName(), $model->filename);
            $zip->close();
    
            \Yii::$app->response->sendFile($tmpFile)->send();
            unlink($tmpFile);
        } catch (\Exception $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }


    public function actionTestApi()
    {
        if ($this->request->isPost) {
            $id = $this->request->post()['id'];
            $model = $this->findModel($id);
            return json_encode($model->getAttributes());

        }
        return $this->render('test-api');
    }
}
