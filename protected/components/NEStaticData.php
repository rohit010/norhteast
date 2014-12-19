<?php 
class NEStaticData
{
	public function getLeadStatus($needEcho = FALSE, $displayAs = "", $name="lead_status", $selectIndex=0)
	{
		$arrAccountType = array(	
								array(
									'id'			=> 	0,
									'displayText'	=> 'Pending',
									'slug'			=> 'ls_pending'
									),
								array(
									'id'			=> 	1,
									'displayText'	=> 'Purchased',
									'slug'			=> 'ls_purchased'
									),
								array(
									'id'			=> 	2,
									'displayText'	=> 'On Hold',
									'slug'			=> 'ls_on_hold'
									),
								array(
									'id'			=> 	3,
									'displayText'	=> 'Rejected',
									'slug'			=> 'ls_rejected'
									),
								array(
									'id'			=> 	4,
									'displayText'	=> 'Not Responding',
									'slug'			=> 'ls_not_respond'
									),
								array(
									'id'			=> 	5,
									'displayText'	=> 'Visited',
									'slug'			=> 'ls_visited'
									),
								array(
									'id'			=> 	6,
									'displayText'	=> 'Others',
									'slug'			=> 'ls_others'
									),
							);
		if (!$needEcho)
		{
			return $arrAccountType;
		}else
		{
			self::echoArray($arrAccountType, $displayAs, $name, $selectIndex);
		}
	}

	private function echoArray($arrToEcho, $displayAs = "", $name="job_type", $selectIndex=0)
	{
		if ($displayAs == "") echo  "<span style='color: red;'>@param: displayAs missing.<span>";
		if ($displayAs != "radio" && $displayAs != "checkbox" && $displayAs != "select" && $displayAs != "text") echo  "<span style='color: red;'>Invalid @param:displayAs. Allowed vlaue: <em>radio</em> | <em>checkbox</em> | <em>select</em>.</span>";
		
		if($displayAs == 'checkbox' || $displayAs == 'radio')
		{
			$currentCount = 0;
			foreach ($arrToEcho as $key => $value) {
				echo '<label id="'.$value['slug'].'"><input type="'.$displayAs.'" value="'.$value['id'].'" name="'.$name.'" id="'.$value['slug'].'" '.($currentCount==$selectIndex?'checked="checked"':'').' />'.$value['displayText'].'</label>';
				$currentCount++;
			}
		}elseif($displayAs == 'select')
		{
			$currentCount = 0;
			foreach ($arrToEcho as $key => $value) {
				echo '<option value="'.$value['id'].'" '.($currentCount==$selectIndex?'selected="selected"':'').'>'.$value['displayText'].'</option>';
				$currentCount++;
			}
		}elseif($displayAs == 'text')
		{
			$currentCount = 0;
			foreach ($arrToEcho as $key => $value) {
				echo ($currentCount==$selectIndex?$value['displayText']:'');
				$currentCount++;
			}
		}
	}
}
?>