<?php

class generate
{

  static public function alerts($data, $subarray = "", $columns = "col-sm-6") {

    if(!empty($subarray)) {
      if(isset($data["alerts"][$subarray])) $data = $data["alerts"][$subarray]; else return false;
      if(!empty($data)) {
        echo "<div class='row'>";
        switch ($subarray) {
          case "error": $alert_type_class = "danger"; break;
          case "warning": $alert_type_class = "warning"; break;
          case "info": $alert_type_class = "info"; break;
          case "success": $alert_type_class = "success"; break;
          default: return false; break;
        }
        foreach ($data as $input => $message) {
            echo "<div class='$columns'>";
            echo "<div class='alert alert-$alert_type_class'>";
            echo $message;
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
      } else return false;
      return true;
    }

    if(!empty($data["alerts"])) {
      foreach ($data["alerts"] as $alert_type => $alert_list) {
        switch ($alert_type) {
          case "error": $alert_type_class = "danger"; break;
          case "warning": $alert_type_class = "warning"; break;
          case "info": $alert_type_class = "info"; break;
          case "success": $alert_type_class = "success"; break;
          default: return false; break;
        }
        echo "<div class='row'>";
        foreach ($alert_list as $input => $message) {
          echo "<div class='$columns'>";
          echo "<div class='alert alert-$alert_type_class'>";
          echo $message;
          echo "</div>";
          echo "</div>";
        }
        echo "</div>";
      }
    } else return false;
    return true;

  }



  static public function table($data, $numbering = false, $adds = [], $show_id = true) {

    $i = 1; // для нумерации
    $table = "";
    $table .= "<table class='table table-hover'>";
    $table .= "<thead>" ;
    $table .= "<tr>";
    if($numbering === true) $table .= "<th>#</th>";
    foreach($data[0] as $column => $value) {
      if($show_id === false) { if($column == "id") continue; }
      $table .="<th>$column</th>";
    }
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach($data as $key => $row) {
      $table .="<tr>";
      if($numbering === true) { $table .= "<th>$i</th>"; $i++; }
      foreach($row as $column => $value) {
        if($show_id === false) { if($column == "id") continue; }
        $table .= "<td>$value</td>";
      }
      foreach($adds as $add) {
        if(preg_match("{{*}}", $add)) { // маленькая шаблонизация в adds'ах
          $column = explode("}}", explode("{{", $add)[1])[0];
          $value = $row[$column];
          $add = str_replace("{{".$column."}}", $value, $add);
          $table .= "<td>$add</td>";
        } else $table .= "<td>$add</td>";
      }
      $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .="</table>";

    echo $table;

  }

}