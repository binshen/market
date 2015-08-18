<form id="pagerForm" method="post" action="<?php echo site_url('manage/list_house')?>">
	<input type="hidden" name="pageNum" value="<?php echo $pageNum;?>" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
	<input type="hidden" name="orderField" value="<?php echo $this->input->post('orderField');?>" />
	<input type="hidden" name="orderDirection" value="<?php echo $this->input->post('orderDirection');?>" />
</form>

<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="<?php echo site_url('manage/add_house')?>" target="navTab" rel="add_house" title="新建"><span>新建</span></a></li>
			<li><a class="delete" href="<?php echo site_url('manage/delete_house')?>/{id}" target="ajaxTodo"  title="确定要删除？" warn="请选择一条记录"><span>删除</span></a></li>
			<li><a class="edit" href="<?php echo site_url('manage/edit_house/{id}')?>" target="navTab" rel="edit_house" warn="请选择一条记录" title="查看"><span>查看</span></a></li>
		</ul>
	</div>

	<div layoutH="54" id="list_warehouse_in_print">
	<table class="list" width="100%" targetType="navTab" asc="asc" desc="desc">
		<thead>
			<tr>
				<th>楼盘名称</th>
				<th width="120px">均价</th>
				<th width="180px">开盘时间</th>
				<th>地址</th>
				<th width="180px">联系电话</th>
			</tr>
		</thead>
		<tbody>
            <?php          
                if (!empty($res_list)):
            	    foreach ($res_list as $row):		               
            ?>		            
            			<tr target="id" rel=<?php echo $row->id; ?>>
            				<td><?php echo $row->name;?></td>
            				<td><?php echo $row->avg_price;?></td>
            				<td><?php echo $row->kp_date;?></td>
            				<td><?php echo $row->address;?></td>
            				<td><?php echo $row->tel;?></td>
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
			<select name="numPerPage" class="combox" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20" <?php echo $this->input->post('numPerPage')==20?'selected':''?>>20</option>
				<option value="50" <?php echo  $this->input->post('numPerPage')==50?'selected':''?>>50</option>
				<option value="100" <?php echo $this->input->post('numPerPage')==100?'selected':''?>>100</option>
				<option value="200" <?php echo $this->input->post('numPerPage')==200?'selected':''?>>200</option>
			</select>
			<span>条，共<?php  echo $countPage;?>条</span>
		</div>		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $countPage;?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>
	</div>
</div>