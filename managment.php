<?php
session_start();
require_once("f.php");
if (!prijavljen()) {
    header("Location: http://localhost/engy/index.php"); //HARDCODE PATH
    exit;
}
$db = mysqli_connect("localhost", "root", "", "engy");

if (!$db) {
    echo "ERROR WITH DB CONNECTION" . mysqli_connect_errno();
    echo "<br>" . mysqli_connect_error();
    exit();
}
mysqli_query($db, "SET NAMES utf8");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- MDB icon -->
    <link rel="icon" href="engy.png" type="image/x-icon" />
    <title>Managment</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/metricacss.css" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">




    <script src="jquary/jquary.js"></script>
    <script src="jquary/jquary.form.js"></script>
    <script src="jquary/functions.js"></script>


</head>
<style>
    body {
        background: #25316D;
    }
</style>

<body>
    <?php
    navbar();
    ?>
    <br>

    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalreport">Launch demo modal</button>  -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalreport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaltitle_for_report">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id='modal_for_report'>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exempleScroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal_heading" class="modal-title">Private Message</h5>

                </div>
                <div id="globalMessagesForUser" class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id='privateMessageHeader'>New </h5>

                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="privateMessageText"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="sendPrivateMessage" class="btn btn-primary" data-dismiss="modal">Send message</button>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 col-lg-4" style="position:relative;left:34%">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title" style="text-align:center">Global Message</h4>
                <div class="form-group row">

                </div>
                <div class="form-group">
                    <textarea class="form-control" id="globalMessageText" rows="4" placeholder="Your message"></textarea>
                </div>

                <button type="submit" id="sendGlobalMessage" class="btn btn-primary btn-block px-4" style="background:purple;color:white">Send Message</button>
                <button type="button" id='checkGlobalMessages' class="btn btn-primary btn-block px-4" data-toggle="modal" data-target="#exempleScroll" style="background:darkred">
                    Remove your Global Messages
                </button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    </div>
    <!--end row-->
    <br>


    <div class="container-fluid">
        <!--TABLE -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- <div class="card-body"> -->

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="thead-light" style="background:purple;color:white">
                                <tr>
                                    <th>Users</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Message User</th>
                                    <th>Visit Page</th>
                                </tr>
                            </thead>
                            <tbody id="users_table">
                            </tbody>
                        </table>
                        <!--end /table-->
                    </div>
                    <!--end /tableresponsive-->
                    <!-- </div>end card-body -->
                </div>
                <!--end card-->
            </div> <!-- end col -->
        </div>
        <!--end row-->
        <div style="visibility:hidden" id="clickedUserId">TEST2</div>



        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Reports for all users</h4>
                    <p class="text-muted mb-3">Add <code>.table-bordered</code> for
                        borders on all sides of the table and cells.
                    </p>

                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-centered">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th>Week 1</th>
                                    <th>Week 2</th>
                                    <th>Week 3</th>
                                    <th>Week 4</th>
                                </tr>
                            </thead>
                            <tbody id='reports_table'>
                                <tr>
                                    <td>User</td>
                                    <td>25/11/2018</td>
                                    <td>$321</td>
                                    <td><span class="badge badge-soft-success">Approved</span></td>
                                    <td>
                                        <div class="dropdown d-inline-block float-right">
                                            <a class="nav-link dropdown-toggle arrow-none" id="dLabel8" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v font-20 text-muted"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel8">
                                                <a class="dropdown-item" href="#">Creat Project</a>
                                                <a class="dropdown-item" href="#">Open Project</a>
                                                <a class="dropdown-item" href="#">Tasks Details</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end /table-->
                    </div>
                    <!--end /tableresponsive-->
                </div>



            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
    </div> <!-- end row -->
    <div id="user_report_div"></div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/waves.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>

<script type="text/javascript" src="js/mdb.min.js"></script>
<script type="text/javascript" src="js/loginscript.js"></script>
<script>
    //<h4 id = 'privateMessageHeader' class="mt-0 header-title" style = "text-align:center">Private Message to USER</h4>
    function saveClickedUserInfo(clickedUser, userId) {
        document.getElementById("privateMessageHeader").innerHTML = "Private Message to " + clickedUser;
        document.getElementById("clickedUserId").innerHTML = userId;
    }

    function saveClickedUserRemove(clickedUser, userId) {
        document.getElementById("clickedUserId").innerHTML = userId;
        fillPrivateMessageModal(userId);

    }

    function viewReportForUser(week, userID) {
        $.post("ajax.php?f=viewReportForUser", {
            week: week,
            userID,
            userID
        }, function(response) {
            $("#modal_for_report").html(response);
        })
    }

    function deletePrivateMessageFrom(id, usr) {
        if (usr == 0) {
            $.post("ajax.php?f=deletePrivateMessageFrom", {
                id: id
            }, function(response) {
                fillGlobalMessagesModal();
            })
        } else {
            $.post("ajax.php?f=deletePrivateMessageFrom", {
                id: id
            }, function(response) {
                fillPrivateMessageModal(usr);
            })
        }
    }
</script>

</html>