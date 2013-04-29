<?php
	extract($data , EXTR_OVERWRITE);
	if($totalList > 0)
	{
		?>
			<!-- per 15 content -->
			<div class="pagination fr">
				<ul>
					<?php
						echo '<li id="myPagingPrev" class="'.($paging<=1?"disabled":"").'">';
						echo str_replace('amp;', '', $form->Html->link("&laquo;",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',($paging-1).(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')), array("class"=>"ajax_mypage")));
						echo '</li>';
						
						echo '<li id="myPagingNext" class="'.($paging>=$countPage?"disabled":"").'">';
						echo str_replace('amp;', '', $form->Html->link("&raquo;",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',($paging+1).(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')) , array("class"=>"ajax_mypage")));
						echo '</li>';
					?>
				</ul>
			</div>
		<?php
	}
?>