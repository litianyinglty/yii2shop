<table class="table table-bordered table-hover" style="text-align: center">
    <tr>
        <th style="text-align: center">文章名称</th>
        <th style="text-align: center">作者</th>
        <th style="text-align: center">简介</th>
        <th style="text-align: center">文章内容</th>
        <th style="text-align: center">操作</th>
    </tr>
    <tr>
        <td><?=$article->name?></td>
        <td><?=$article->author?></td>
        <td><?=$article->intro?></td>
        <td><?=$articleDetail->content?></td>
        <td>
            <?=\yii\bootstrap\Html::a("",['article/index'],['class'=>'btn btn-success btn-xs glyphicon-arrow-down
glyphicon glyphicon-share-alt'])?>
        </td>
    </tr>
</table>