<?php

    /** 
     * Standard HTTP headers for cross-communication between client and server.
     * Ignore for the purpose of this tutorial! :)
     */
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    function debugToConsole($msg) {
            echo "<script>console.log(".json_encode($msg).")</script>";
    }

    /** 
     * Method to build return message.
     */
    function msg($success, $status, $message, $extra = []){
        return array_merge([
            'success' => $success,
            'status' => $status,
            'message' => $message
        ], $extra);
    }

    require __DIR__.'/call-api.php'; // import callAPI() method
    require __DIR__.'/classes/JwtHandler.php'; // import JwtHandler to encode data

    $data = json_decode(file_get_contents("php://input")); // decode input data
    $returnData = [];

    if($_SERVER["REQUEST_METHOD"] != "POST"){ 
        $returnData = msg(0, 404, 'Page Not Found!'); // exception for non-POST requests
    }

    // Empty field check
    elseif(!isset($data->username) || !isset($data->password) || empty(trim($data->username)) || empty(trim($data->password))) { 
            $fields = ['fields' => ['username','password']];
            $returnData = msg(0, 422, 'Please fill in all required fields!', $fields);
    } 

    else { 
        // Fetch and parse username and password
        $username = trim($data->username); 
        $password = trim($data->password);

        // Error printing if password length exceeds limit
        if (strlen($password) < 8) { 
            $returnData = msg(0, 422, 'Your password must be at least 8 characters long!');
        } else { 
            $get_data = callAPI("GET", "https://6126bc4fc2e8920017bc0a07.mockapi.io/ReactIntro?username=".$username, false);
            $response = json_decode($get_data, true);
            $check_password = $password == $response[0]['password'];
            $check_username = $username == $response[0]['username'];
            $meal = 'Dumplings';

            if(!$check_username) {
            $returnData = [
                'success' => false,
                'message' => 'Username is invalid',
                'token' => null,
                'status' => 'Username is invalid', 
            ];
            } elseif ($check_password){ 
                $jwt = new JwtHandler();
                $token = $jwt->_jwt_encode_data(
                    'http://localhost/apimock/',
                    array("user_id"=> $response['id'])
                );

                $returnData = [
                    'success' => 1,
                    'message' => 'You have succesfully logged in!',
                ];
            } else { 
                // TODO: Is this safe? Reflect why this might be a problem by yourself.
                $returnData = [
                    'success' => false,
                    'message' => 'Password is invalid',
                    'token' => null,
                    'status' => 'Password is invalid',    
                ];
                    //msg($response['password'], $password, 'Invalid password!');
                }

            // TODO: What if the username is invalid? 
            // YOUR CODE HERE, cannot put the code here because it doesn't make sense with the if, elseif, else loops
            
        }
    }

    echo json_encode($returnData);
?>
