<?php

$conn = mysqli_connect('localhost','root','','ajax');

//extract function is used to import variables from an Array into the current symbol table.
//It Automatically Extracts All the variable from Array into Current table
// var firstname = $_POST['firstname']; Rather Using this We USe Extract function

extract($_POST);
//We Have to USe Isset Function For Each Function Call
if (isset($_POST['readrecord'])) {
    $data = '<table class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>'; 

    $displayquery = "SELECT * FROM `crud`";
    $result = mysqli_query($conn,$displayquery);
    
    //It Will Check the numbwers of Rows 
    if(mysqli_num_rows($result) > 0) {
        $number = 1;
        while ($row = mysqli_fetch_array($result)) {

            $data .= '<tr>
                <td>'.$number.'</td>
                <td>'.$row['firstname'].'</td>
                <td>'.$row['lastname'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['mobile'].'</td>
                <td><button onClick="GetUserDetails('.$row['id'].')" class="btn btn-warning">Update</button></td>
                <td><button onClick="DeleteUser('.$row['id'].')" class="btn sbtn-warning">Delete</button></td>
                    </tr>';
                    $number++;

        }
    }

    $data .= '</table>';
    echo $data;
} 



//isset() function is used to check whether a variable is set or not.
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['mobile']))

{
    $query = " INSERT INTO 'crud'('firstname', 'lastname', 'email', 'mobile') VALUES ( '$firstname', '$lastname', '$email', '$mobile') ";
    mysqli_query($conn,$query);
}

if(isset($_POST['deleteid'])){

	$userid= $_POST['deleteid'];
	$deletequery = " delete from crud where id='$userid' ";
	mysqli_query($conn,$deletequery);
}

/// get userid for update
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    $user_id = $_POST['id'];
    $query = "SELECT * FROM crud WHERE id = '$user_id'";
    if (!$result = mysqli_query($conn,$query)) {
        exit(mysqli_error());
    }
    
    $response = array();

    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
       
            $response = $row;
        }
    }else
    {
        $response['status'] = 200;
        $response['message'] = "Data not found!";
    }
  //     PHP has some built-in functions to handle JSON.
// Objects in PHP can be converted into JSON by using the PHP function json_encode(): 
    echo json_encode($response);
}
else
{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}


///update table

if(isset($_POST['hidden_user_idupd'])){

	$hidden_user_idupd = $_POST['hidden_user_idupd'];
	$firstnameupd = $_POST['firstnameupd'];
	$lastnameupd = $_POST['lastnameupd'];
    $emailupd = $_POST['emailupd'];
    $mobileupd = $_POST['mobileupd'];

    $query = " UPDATE 'crud' SET 'firstname'='$firstnameupd','lastname'='$lastnameupd','email'='$emailupd','mobile'='$mobileupd' WHERE id= '$hidden_user_idupd' ";
     if (!$result = mysqli_query($conn,$query)) {
        exit(mysqli_error());
    }
}

?>