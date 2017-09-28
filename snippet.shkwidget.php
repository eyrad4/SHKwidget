<?php
//<?php
/**
 * SHKwidget
 *  
 * Snippet to create widgets for Shopkeeper
 *  
 * @category 	   snippet
 * @version 	   1.3.2
 * @license 	   http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal	   @properties 
 * @internal	   @modx_category Shop
[[SHKwidget? &docid=`[*id*]` &format=`select` &tvname=`weight` &wraptag=`` &first_selected=`true`]]
 */

$docid = isset($docid) ? $docid : $modx->documentIdentifier;
$format = isset($format) ? $format : 'select'; //select | radio | checkbox | radioimage
$tvname = isset($tvname) ? $tvname : '';
$first_selected = isset($first_selected) ? $first_selected : false;
$wraptag = isset($wraptag) ? $wraptag : false;
$function = isset($function) ? $function : 'jQuery.additOpt(this)';

$tvout = $modx->getTemplateVarOutput(array($tvname),$docid,1);

$output = '';

switch($format){

  case "select":
	  $options = "";
	  $count = 0;
	  $value = !empty($tvout[$tvname]) ? explode("||",$tvout[$tvname]) : array();
	  if(count($value)>0){
      foreach($value as $val){
  	    list($item,$itemvalue) = explode("==",$val);
  	    $selected = $count==0 && $first_selected ? ' selected="selected"' : '';
  	    $options .= "\n\t".'<option value="'.$count.'__'.$itemvalue.'"'.$selected.'>'.$item.'</option>';
  	    $count++;
      }
  	  $output .= "\n".'<select class="addparam" name="'.$tvname.'__'.$docid.'" onchange="'.$function.'">'.$options.'</select>'."\n";
	  }
  break;

  case "radio":
	  $otag = $wraptag ? "<$wraptag>" : "";
	  $ctag = $wraptag ? "</$wraptag>" : "";
	  $value = !empty($tvout[$tvname]) ? explode("||",$tvout[$tvname]) : array();
	  $count = 0;
	  foreach($value as $val){
	    list($item,$itemvalue) = explode("==",$val);
	    $selected = $count==0 && $first_selected ? ' checked="checked"' : '';
	    $output .= "\n".$otag.'<input class="addparam" type="radio" name="'.$tvname.'__'.$docid.'" value="'.$count.'__'.$itemvalue.'" id="'.$tvname.$docid.$count.'"'.$selected.' onclick="'.$function.'" /> <label for="'.$tvname.$docid.$count.'">'.$item.'</label>'.$ctag;
	    $count++;
    }
  break;

  case "checkbox":
	  $otag = $wraptag ? "<$wraptag>" : "";
	  $ctag = $wraptag ? "</$wraptag>" : "";
	  $value = !empty($tvout[$tvname]) ? explode("||",$tvout[$tvname]) : array();
	  $count = 0;
	  foreach($value as $val){
	    list($item,$itemvalue) = explode("==",$val);
	    $selected = $count==0 && $first_selected ? ' checked="checked"' : '';
	    $output .= "\n".$otag.'<input class="addparam" type="checkbox" name="'.$tvname.'__'.$docid.'__'.$count.'" value="'.$count.'__'.$itemvalue.'" id="'.$tvname.$docid.$count.'"'.$selected.' onclick="'.$function.'" /> <label for="'.$tvname.$docid.$count.'">'.$item.'</label>'.$ctag;
	    $count++;
    }
  break;
  
  case "radioimage":
	  $otag = $wraptag ? "<$wraptag>" : "";
	  $ctag = $wraptag ? "</$wraptag>" : "";
	  $tvc_id = $tvout[$tvname];
	  if(!empty($tvc_id)){
      $res1 = $modx->db->select("cnt.pagetitle, tvc.value", $modx->getFullTableName('site_content')." cnt, ".$modx->getFullTableName('site_tmplvar_contentvalues')." tvc", "tvc.id IN ($tvc_id) AND tvc.contentid = cnt.id", "", "");
  	  $count = 0;
  	  while($tvImg = $modx->db->getRow($res1)){
  	    $selected = $count==0 && $first_selected ? ' checked="checked"' : '';
        list($name,$src) = array($tvImg['pagetitle'],$tvImg['value']);
        $output .= "\n  ".$otag.'<input class="addparam" type="radio" name="'.$tvname.'__'.$docid.'" value="'.$count.'__0__'.$name.'" id="'.$tvname.$docid.$count.'"'.$selected.' onclick="'.$function.'" />';
        $output .= '<label for="'.$tvname.$docid.$count.'" title="'.$name.'"><img src="'.$src.'" alt="'.$name.'" /></label>'.$ctag;
        $count++;
  	  }
	  }
  break;

}

return $output;
?>