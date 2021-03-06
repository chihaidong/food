<?php if (!defined('THINK_PATH')) exit();?><div class="sui-msg msg-info">
    <div class="msg-con">状态为1表示该分类启用，状态为0表示该分类下架</div>
    <s class="msg-icon"></s>
</div>
<br><br>
<ul class="sui-breadcrumb">
  <li><a href="javascript:;" id="allzifenlei">全部子分类</a></li>
  <li class="active"></li>
</ul>


<table class="sui-table table-bordered" id="zifenlei">
  <thead>
    <tr>
      <th>分类id</th>
      <th>分类名称</th>
      <th>上级分类id</th>
      <th>上级分类名称</th>
      <th>路径</th>
      <th>状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody id="">
    <?php if(is_array($data)): foreach($data as $key=>$data): ?><tr>
        <td><?php echo ($data["id"]); ?></td>
        <td><a href="javascript:;" data-id="<?php echo ($data["id"]); ?>"class="zifenleilist"><?php echo ($data["name"]); ?></a></td>
        <td><?php echo ($data["pid"]); ?></td>
        <td><?php echo ($data["parent"]["name"]); ?></td>
        <td><?php echo ($data["path"]); ?></td>
        <td class="fenlei-status"><?php echo ($data["status"]); ?></td>
        <td>
          <!-- <button class="sui-btn btn-lg edit-zifenlei-btn" data-id="<?php echo ($data["id"]); ?>">编辑</button> -->
          <button class="sui-btn btn-lg del-zifenlei-btn2" data-id="<?php echo ($data["id"]); ?>">删除</button>
          <button class="sui-btn btn-lg on-zifenlei-btn" data-id="<?php echo ($data["id"]); ?>">下架</button>
        </td>
      </tr><?php endforeach; endif; ?>
  </tbody>
</table>

<script>
$(".fenlei-status").each(function(){
  if($(this).html() == 0){
    $(this).parent().find(".on-zifenlei-btn").html("启用");
  }
  else{
    $(this).parent().find(".on-zifenlei-btn").html("下架");
  }
});
$("body").on("click",".del-zifenlei-btn2",function(){
  var delId = $(this).attr("data-id");
  var that = $(this);
  if(confirm("删除子分类，子分类下的菜品将全部删除，确定删除？")){
    $.ajax({
      type: 'POST',
      url: "/food/index.php/Admin/Caipu/delzifenlei",
      data:{
        "id":delId,
      },
      beforeSend:function(){
        $("#loading").show();
      },
      success:function(data){
        $("#loading").hide();
        alert(data.info);
        that.parent().parent().remove()
      }
    });
  }
});

$("body").on("click",".on-zifenlei-btn",function(){
  var id = $(this).attr("data-id");
  var that = $(this);
  if($(this).html() == "下架"){
    $.ajax({
      type: 'POST',
      url: "/food/index.php/Admin/Caipu/status",
      data:{
        "id":id,
        "status":0,
      },
      beforeSend:function(){
        $("#loading").show();
      },
      success:function(data){
        $("#loading").hide();
        that.html("启用");
        that.parent().parent().find(".fenlei-status").html("0");
      }
    });
  }
  else{
    $.ajax({
      type: 'POST',
      url: "/food/index.php/Admin/Caipu/status",
      data:{
        "id":id,
        "status":1,
      },
      beforeSend:function(){
        $("#loading").show();
      },
      success:function(data){
        $("#loading").hide();
        that.html("下架");
        that.parent().parent().find(".fenlei-status").html("1");
      }
    });
  }
});


</script>