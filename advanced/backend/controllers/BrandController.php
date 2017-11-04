<?php

namespace backend\controllers;

use backend\models\Brand;
use flyok666\qiniu\Qiniu;
use yii\data\Pagination;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
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
            //var_dump($request->post());exit;
//            创建图片上传对象
            //$brand->image=UploadedFile::getInstance($brand,'image');
//            判断是否是图片文件
            //if($brand->image){
//                拼接路径
                //$filePath='images/'.time().rand(100,999).'.'.$brand->image->extension;
//                保存图片地址
                //$brand->image->saveAs($filePath,false);
                //$brand->logo=$filePath;
            //}
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
                //$brand->image = UploadedFile::getInstance($brand, 'image');
//            判断是否是图片文件
                //if ($brand->image) {
//                拼接路径
                    //$filePath = 'images/' . time() . rand(100, 999) . '.' . $brand->image->extension;
//                保存图片地址
                    //$brand->image->saveAs($filePath, false);
                    //$brand->logo = $filePath;
                //}else{
                    //$brand->logo=$img;
                //}
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
     * 彻底删除品牌
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

    /**
     * 删除品牌
     * @param $id
     * @return \yii\web\Response
     */
    public function actionReclaim($id)
    {
        if (Brand::updateAll(['status' => -1], ['id' => $id])) {
            \Yii::$app->session->setFlash("success", "删除成功");
            return $this->redirect(['brand/index']);
        }
    }

    /**
     * 显示回收站
     * @return string
     */
    public function actionReclaims()
    {
        $brands=Brand::find()->where(['status'=>"-1"])->all();
        return $this->render('reclaims',['brands'=>$brands]);
    }

    /**
     * 还原品牌
     * @param $id
     * @return \yii\web\Response
     */
    public function actionReduction($id)
    {
        if (Brand::updateAll(['status' => 1], ['id' => $id])) {
            \Yii::$app->session->setFlash("success", "还原成功");
            return $this->redirect(['brand/reclaims']);
        }
    }

    /**
     * 上传图片到七牛云
     */
    public function actionUpload()
    {
        //var_dump($_FILES['file']['tmp_name']);exit;
//        配置
        $config = [
            'accessKey'=>'Hy-VyRINX9t6kU2TNURfGP1TYs6Xc0E_eg2lh81F',                      'secretKey'=>'kUU1g3oltnhBSR_knK7sDhrRUyYZWZ9gmP3GPhRd',
            'domain'=>'http://oyvirytup.bkt.clouddn.com/',
            'bucket'=>'yii2shop',
            'area'=>Qiniu::AREA_HUANAN
        ];
//        实例化对象
        $qiniu = new Qiniu($config);
        $key = time();
//        调用上传方法
        $qiniu->uploadFile($_FILES['file']['tmp_name'],$key);
        $url = $qiniu->getLink($key);

        $info=[
            'code'=>0,
            'url'=>$url,
            'attachment'=>$url,
        ];
        //exit($url);
        exit(json_encode($info));
    }

    /**
     * 删除七牛云图片
     */
    public function actionDelQi()
    {
        $qiNiu=new Qiniu($config = [
            'accessKey'=>'Hy-VyRINX9t6kU2TNURfGP1TYs6Xc0E_eg2lh81F',                      'secretKey'=>'kUU1g3oltnhBSR_knK7sDhrRUyYZWZ9gmP3GPhRd',
            'domain'=>'http://oyvirytup.bkt.clouddn.com/',
            'bucket'=>'yii2shop',
            'area'=>Qiniu::AREA_HUANAN
        ]);
        $qiNiu->delete('','yii2shop');
    }
}
