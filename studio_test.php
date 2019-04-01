<?php

// Initialize cURL
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sightmap.com/v1/assets/1273/multifamily/units?per-page=100",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "username=$username&password=$password",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
    "api-key: 7d64ca3869544c469c3e7a586921ba37"  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
  $results = '';
} else {
  // Convert Results
  $results = json_decode($response, true);
}

// If we have results, let's parse them out
if($results != ''){

  // Setup a holder for the lists
  $first_list = '<table class="list_data"><caption>Units with 1 Area Measurement</caption><tr><th>Unit Number</th><th >Area <span class="small_text">(SqFt)</span></th><th>Last Updated</th></tr>';
  $second_list = $first_list;

// Parse through the arrays within the array
  foreach($results['data'] as $i => $arr_val){
      // format the date
      $formatted_date = date("n/j/Y", strtotime($arr_val['updated_at']));

      // Add area of 1 to one list, all others to the other list
      if($arr_val['area'] == '1'){
        $first_list .= '<tr><td>' . $arr_val['unit_number'] . '</td><td>' . $arr_val['area'] . '</td><td>' . $formatted_date . '</td></tr>';
      } else {
        $second_list .= '<tr><td>' . $arr_val['unit_number'] . '</td><td>' . $arr_val['area'] . '</td><td>' . $formatted_date . '</td></tr>';
      }
  }

  // Close out the tables
  $first_list .= "</table>";
  $second_list .= "</table>";
}

?>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <style>

    body{
      background-image: linear-gradient(135deg, red , orange);
      background-image: radial-gradient(orange 25%, red);
      font-family: 'Montserrat', sans-serif;
      color: white;
    }
    .outer_container{
      width: 100%;
    }
    .middle_container{
      width: 75%;
      margin: 0 auto;
    }
    .data_container {
      border-radius: 5px;
      background-color: rgba(0,0,0,.8);
      color: white;
      width: 45%;
      border: solid red 1px;
      text-align: center;
    }
    .container_left {
      float: left;
      margin-right: 2%;
    }
    .container_right{
      float: right;
    }
    .small_text div{
      font-size: .8em;
      font-weight: 200;
    }
    table{
      text-align: center;
      width: 95%;
      padding: 5px;
      margin: 5% auto
    }
    th{
      font-size: 1.2em;
      font-weight: 600;
      margin-bottom: 5px;
    }
    td{
      padding: 0 10px 3px 10px;
    }
    caption{
      font-size: 1.5em;
      font-weight: 900;
      margin: 10px 0px 20px 0;
    }

 @media screen and (max-width: 1400px ) {
      .data-container{
        width: 45%;
        color: black;
      }
      .middle_container{
        width: 90%;
        margin: 0 auto;
      }
    }

 @media screen and (max-width: 1150px) {
      .data_container {
        width: 80%;
        color: black;
        float: none;
      }
      .middle_container{
        width: 100%;
      }
      .container_left, .container_right{
        float: none;
        margin: 0 auto;
      }
      .container_left{
        margin-bottom: 10px;
      }
      table{
        width: 80%;
      }
      caption{
        font-size: 1.3em;
      }
      th{
        font-size: 1.1em;
      }
    }
  </style>
</head>
<body>
  <div class="outer_container">
  <div class="middle_container">
  <div class="data_container container_left"><?php echo $first_list; ?></div>
  <div class="data_container container_right"><?php echo $second_list; ?></div>
</div>
</div>
</body>
</html>
