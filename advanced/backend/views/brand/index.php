<?php
/* @var $this yii\web\View */
?>
<div style="text-align: center"><h1>商品列表</h1></div>
<?=\yii\bootstrap\Html::a("添加品牌",['brand/add'],['class'=>'btn btn-success btn-md'])?>
<?=\yii\bootstrap\Html::a("回收站",['brand/reclaims'],['class'=>'btn btn-success btn-md'])?>
<table class="table table-bordered table-hover" style="text-align: center">
    <tr>
        <th style="text-align: center">Id</th>
        <th style="text-align: center">名称</th>
        <th style="text-align: center">简介</th>
        <th style="text-align: center">图片</th>
        <th style="text-align: center">排序</th>
        <th style="text-align: center">状态</th>
        <th style="text-align: center">操作</th>
    </tr>
    <?php foreach ($brands as $brand):?>
    <tr>
        <td><?=$brand->id?></td>
        <td><?=$brand->name?></td>
        <td><?=$brand->intro?></td>
        <td><?=\yii\bootstrap\Html::img($brand->image,['width'=>30,'height'=>30,'class'=>'img-circle'])?></td>
        <td><?=$brand->sort?></td>
        <td><?=\backend\models\Brand::$statusArray[$brand->status]?></td>
        <td>
            <?=\yii\bootstrap\Html::a("",['brand/edit','id'=>$brand->id],['class'=>'btn btn-info btn-xs glyphicon glyphicon-pencil'])?>
        <?=\yii\bootstrap\Html::a("",['brand/reclaim','id'=>$brand->id],['class'=>'btn btn-warning btn-xs glyphicon glyphicon-envelope'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>

<!--分页-->
<div style="text-align: center">
    <?=\yii\widgets\LinkPager::widget(['pagination' => $page]);?>
</div>

