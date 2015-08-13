<div id="detail">
<form id="pagerForm" method="post" action="<?php echo site_url('manage/list_broker_dialog')?>">
	<input type="hidden" name="name" value="<?php echo $name; ?>">	
	<input type="hidden" name="pageNum" value="<?php echo $pageNum;?>" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
</form>
<div class="pageHeader" id="dialog">
	<form onsubmit="return dialogSearch(this);" action="<?php echo site_url('manage/list_broker_dialog')?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td><label>业务员姓名：</label><input type="text" size="16" name="name" value="<?php echo $name;?>" /></td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">执行查询</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>

<div class="pageContent">
	<div layoutH="120" id="list_warehouse_in_print">
	<table class="list" width="100%" targetType="dialog" asc="asc" desc="desc" id="mrp_table">
		<thead>
			<tr>
				<th>业务员</th>
				<th width="80">电话</th>
				<th width="80">熟悉区域</th>
				<th width="30">选择</th>
			</tr>
		</thead>
		<tbody>
            <?php          
                if (!empty($res_list)):
            	    foreach ($res_list as $row):		               
            ?>		            
            			<tr>
            				<td><?php echo $row->rel_name; ?></td>
            				<td><?php echo $row->tel;?></td>
            				<td><?php echo $row->region_id;?></td>
            				<td>
            					<a class="btnSelect" href="javascript:$.bringBack({broker_id:'<?php echo $row->id;?>', broker_name:'<?php echo $row->rel_name;?>'})" >选择</a>
            				</td>
            			</tr>
            <?php 
            		endforeach;
            	endif;
            ?>
		</tbody>
	</table>
	</div>
	<div class="panelBar" >
		<div class="pages">
			<span>显示</span>
			<select name="numPerPage" class="combox" onchange="dialogPageBreak({numPerPage:this.value})">
				<option value="20" <?php echo $this->input->post('numPerPage')==20?'selected':''?>>20</option>
				<option value="50" <?php echo  $this->input->post('numPerPage')==50?'selected':''?>>50</option>
				<option value="100" <?php echo $this->input->post('numPerPage')==100?'selected':''?>>100</option>
				<option value="200" <?php echo $this->input->post('numPerPage')==200?'selected':''?>>200</option>
			</select>
			<span>条，共<?php  echo $countPage;?>条</span>
		</div>		
		<div class="pagination" targetType="dialog" totalCount="<?php echo $countPage;?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>
	</div>
</div>
</div>
<script>
$(".btnSelect").click(function(){     
	$(".dialog .dialogHeader .dialogHeader_r .dialogHeader_c .close").click();
}); 
</script>