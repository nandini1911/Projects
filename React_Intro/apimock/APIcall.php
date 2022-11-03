<?php
   /** 
    * Helper function to call the API 
    *
    * $method: Type of request (GET, POST, PATCH etc.)
    * $url: URL of API 
    * $data: Data to be sent in the case of POST/PUT request.  
    */
    function callAPI($method, $url, $data) {
      
      $curl = curl_init();
      
      switch ($method) {
         case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
               curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
         case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
               curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
         default:
            if ($data)
               $url = sprintf("%s?%s", $url, http_build_query($data));
      }

      // Config for the request — ignore for the purpose of this tutorial! :)
      curl_setopt($curl, CURLOPT_URL, $url);
      
      // Headers needed for Mock API authentication
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
         'APIKEY: 111111111111111111111',
         'Content-Type: application/json',
      ));
      
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

      // Making the call and fetching the result
      $result = curl_exec($curl);
      
      if(!$result) {
         die("Connection Failure");
      }
      
      curl_close($curl);
      return $result;
   }

      //call the callAPI function 
      $result = callAPI("GET", "https://6126bc4fc2e8920017bc0a07.mockapi.io/ReactIntro?search=nandini.sharma", false);

      //decode the response 
      $response = json_decode($result, true);

      //set the favorite meal variable 
      $favmeal = "Dumplings";
      //create an empty array 
      $array = NULL;

      //for loop that will add to the array
      for ($x = 0; $x < count($response); $x++) { 
         $array = $response[$x];
      }

      //setting the key and value for the favmeal 
      $array["Favorite Meal"] = $favmeal;

      //remove the password
      unset($array["password"]);

      //make it the first element 
      $response[0] = $array;

      //encode it again for presenting 
      echo json_encode($response);



?>
