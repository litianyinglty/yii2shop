<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;

class BrandController extends \yii\web\Controller
{


//    public function actions() {
//        return [
//            's-upload' => [
//                'class' => UploadAction::className(),
//                'basePath' => '@webroot/upload/brand',
//                'baseUrl' => '@web/upload/brand',
//                'enableCsrf' => true, // default
//                'postFieldName' => 'Filedata', // default
//                //BEGIN METHOD
//                'format' => [$this, 'methodName'],
//                //END METHOD
//                //BEGIN CLOSURE BY-HASH
//                'overwriteIfExist' => true,
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filename = sha1_file($action->uploadfile->tempName);
//                    return "{$filename}.{$fileext}";
//                },
//                //END CLOSURE BY-HASH
//                //BEGIN CLOSURE BY TIME
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filehash = sha1(uniqid() . time());
//                    $p1 = substr($filehash, 0, 2);
//                    $p2 = substr($filehash, 2, 2);
//                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
//                },
//                //END CLOSURE BY TIME
//                'validateOptions' => [
//                    'extensions' => ['jpg', 'png'],
//                    'maxSize' => 1 * 1024 * 1024, //file size
//                ],
//                'beforeValidate' => function (UploadAction $action) {
//                    //throw new Exception('test error');
//                },
//                'afterValidate' => function (UploadAction $action) {},
//                'beforeSave' => function (UploadAction $action) {},
//                'afterSave' => function (UploadAction $action) {
//                    $action->output['fileUrl'] = $action->getWebUrl();
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
//                },
//            ],
//        ];
//    }

    /**
     * 商品列表
     * @return string
     */
    public function actionIndex()
    {
        //分页
//        1、总页数
        $count=Brand::find()->where(['!=','status','-1'])->count();
//        2、每页显示条数
        $pageSize=2;
//        3、创建分页对象
        $page=new Pagination([
            'pageSize'=>$pageSize,
            'totalCount'=>$count,
        ]);
        $brands=Brand::find()->where(['!=','status','-1'])->limit($page->limit)->offset($page->offset)->all();
        return $this->render('index',['brands'=>$brands,'page'=>$page]);
    }

    /**
     * 添加品牌
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $brand=new Brand();
        $request=\Yii::$app->request;
        if($brand->load($request->post())){
//            创建图片上传对象
            $brand->image=UploadedFile::getInstance($brand,'image');
//            判断是否是图片文件
            if($brand->image){
//                拼接路径
                $filePath='images/'.time().rand(100,999).'.'.$brand->image->extension;
//                保存图片地址
                $brand->image->saveAs($filePath,false);
                $brand->logo=$filePath;
            }
            if($brand->validate()){
//                赋值给数据表的字段
                $brand->save();
                \Yii::$app->session->setFlash("success",'添加商品成功');
                return $this->redirect(['brand/index']);
            }
        }
        $brand->status=1;
        return $this->render("add",['brand'=>$brand]);
    }

    /**
     * 编辑品牌
     * @return string|\yii\web\Response
     */
    public function actionEdit($id)
    {
        $brand=Brand::findOne($id);
        $img=$brand->logo;
        if($brand->status=="1") {
            $request = \Yii::$app->request;
            if ($brand->load($request->post())) {
//            创建图片上传对象
                $brand->image = UploadedFile::getInstance($brand, 'image');
//            判断是否是图片文件
                if ($brand->image) {
//                拼接路径
                    $filePath = 'images/' . time() . rand(100, 999) . '.' . $brand->image->extension;
//                保存图片地址
                    $brand->image->saveAs($filePath, false);
                    $brand->logo = $filePath;
                }else{
                    $brand->logo=$img;
                }
                if ($brand->validate()) {
//                赋值给数据表的字段
                    $brand->save();
                    \Yii::$app->session->setFlash("success", '编辑商品成功');
                    return $this->redirect(['brand/index']);
                }
            }
        }
        return $this->render("add",['brand'=>$brand]);
    }

    /**
     * 删除品牌
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDel($id)
    {
        if(Brand::findOne($id)->delete()){
            \Yii::$app->session->setFlash("success","彻底删除成功");
            return $this->redirect(['brand/reclaims']);
        }
    }

    public function actionReclaim($id)
    {
        if (Brand::updateAll(['status' => -1], ['id' => $id])) {
            \Yii::$app->session->setFlash("success", "删除成功");
            return $this->redirect(['brand/index']);
        }
    }

    public function actionReclaims()
    {
        $brands=Brand::find()->where(['status'=>"-1"])->all();
        return $this->render('reclaims',['brands'=>$brands]);
    }

    public function actionReduction($id)
    {
        if (Brand::updateAll(['status' => 1], ['id' => $id])) {
            \Yii::$app->session->setFlash("success", "还原成功");
            return $this->redirect(['brand/reclaims']);
        }
    }
}
