<?php
	extract($data , EXTR_OVERWRITE);
	if($totalList > 0 && $countPage >= 2)
	{
		?>
			<!-- per 15 content -->
			<div class="pagination fr">
				<ul>
					<?php
						echo '<li id="myPagingFirst" class="'.($paging<=1?"disabled":"").'">';
						echo $form->Html->link("First",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',(1).(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')) , array("class"=>"ajax_mypage"));
						echo '</li>';
						
						echo '<li id="myPagingPrev" class="'.($paging<=1?"disabled":"").'">';
						echo str_replace('amp;', '', $form->Html->link("&laquo;",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',($paging-1).(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')), array("class"=>"ajax_mypage")));
						echo '</li>';
						
						for ($i = $left_limit , $index = 1; $i <= $right_limit; $i++ , $index++)
						{
							echo '<li id="myPagingNum'.$index.'" class="'.($i==$paging?"active":"").'">';
							echo $form->Html->link($i,array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',$i.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')) , array("class"=>"ajax_mypage"));				
							echo '</li>';
						}
					
						echo '<li id="myPagingNext" class="'.($paging>=$countPage?"disabled":"").'">';
						echo str_replace('amp;', '', $form->Html->link("&raquo;",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',($paging+1).(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')) , array("class"=>"ajax_mypage")));
						echo '</li>';
						
						echo '<li id="myPagingLast" class="'.($paging>=$countPage?"disabled":"").'">';
						echo $form->Html->link("Last",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',$countPage.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')), array("class"=>"ajax_mypage"));
						echo '</li>';
					?>
				</ul>
			</div>
		<?php
	}
?>