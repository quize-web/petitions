<?php

class alerts
{

  static public function show($data, $columns = "col-sm-6") {

    if(!empty($data)) {

      foreach ($data as $alert_type => $alert_list) {

        switch ($alert_type) {
          case "error": $alert_type_class = "danger"; break;
          case "info": $alert_type_class = "info"; break;
          default: $alert_type_class = "info"; break;
        }

        echo "<div class='row'>";

        foreach ($alert_list as $input => $mesasge) {
          echo "<div class='$columns'>";
          echo "<div class='alert alert-$alert_type_class'>";
          echo $mesasge;
          echo "</div>";
          echo "</div>";
        }

        echo "</div>";

      }

    }

  }

}