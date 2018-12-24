<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AJAX JQuery</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

</head>
<body>
    <div class="container">
        <h1 class="text-primary text-uppercase text-center">AJAX CRUD</h1>
    
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                 Open modal</button>
        </div>

        <h2 class="text-primary">All Records</h2>

        <div id="records_content">
        
        </div>

        <!-- The Modal -->
        <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">AJAX CRUD</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label> Firstname : </label>
                    <input type="text" name="" id="firstname" class="form-control" placeholder="Firstname">
                </div>
                <div class="form-group">
                    <label> Lastname : </label>
                    <input type="text" name="" id="lastname" class="form-control" placeholder="Lastname">
                </div>
                <div class="form-group">
                    <label> Email : </label>
                    <input type="text" name="" id="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label> Mobile : </label>
                    <input type="text" name="" id="mobile" class="form-control" placeholder="Mobile">
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="addRecord()">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="">Close</button>
            </div>

            </div>
        </div>
        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript">


    $(document).ready(function() {
        readRecords();
    });

    function readRecords() {
        var readrecord = "readrecord";
        $.ajax({
            url : "backend.php",
            type : "post",
            data : { readrecord : readrecord },
            success : function(data,status) {
                $('#records_content').html(data); //data Will be Stored in that 'records_content' Div
            }
        });
    }
    

    //We Have Taken Values In Variable For Adding Records
    function addRecord() {
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var mobile  = $('#mobile').val();

        //The ajax() Is Used to Perform An AJAX (AJAX Asynchronous HTTP request.)
        //Parameter specifies one Or more name/value pairs for Ajax Request

        $.ajax({
            url : "backend.php",
            type : 'post',
            data : {
                firstname : firstname,
                lastname : lastname,
                email : email,
                mobile : mobile
            },
            //If Our Query Is Success Then
            success:function(data,status) {
                readRecords();
            }
        });

        
    }

    function UpdateUserDetails() {
    var firstname = $("#update_firstname").val();
    var lastname = $("#update_lastname").val();
    var email = $("#update_email").val();
    var mobile = $("#update_mobile").val();
    var hidden_user_id = $("#hidden_user_id").val();
    $.post("backend.php", {
            hidden_user_id: hidden_user_id,
            firstname: firstname,
            lastname: lastname,
            email: email,
            mobile: mobile
        },
        function (data, status) {
            $("#update_user_modal").modal("hide");
            readRecords();
        }
    );
    }

    function GetUserDetails(id){
	  $("#hidden_user_id").val(id);
	  $.post("backend.php", {
            id: id
        },
        function (data, status) {
            //alert(data);
            //JSON.parse() parses a string, written in JSON format, and returns a JavaScript object.
            var user = JSON.parse(data);
            //alert(user);

            $("#update_firstname").val(user.firstname);
            $("#update_lastname").val(user.lastname);
            $("#update_email").val(user.email);
            $("#update_mobile").val(user.mobile);
        }
    );
    $("#update_user_modal").modal("show");
    }

    function DeleteUser(deleteid){

    var conf = confirm("Are You Sure");
    if(conf == true) {
    $.ajax({
        url:"backend.php",
        type:'POST',
        data: {  deleteid : deleteid},

        success:function(data, status){
            readRecords();
        }
    });
    }
    }

    </script>
</body>
</html>