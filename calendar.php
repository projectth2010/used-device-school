<?php
session_start();
if (isset($_SESSION['email']) and isset($_SESSION['user_type']) and isset($_SESSION['key']))
    echo " ";
else {
    header("location:index.php");

}


?>


<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shop Information</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="plugins/jquery.min/jquery.min.js"></script>
    <!--Preloader-->
    <link rel="stylesheet" href="dist/css/preloader.css">
    <script src="dist/js/preloader.js"></script>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>


</head>
<body class="hold-transition sidebar-mini">
<div class="se-pre-con"></div>

<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

        </ul>

    </nav>
    <!-- /.navbar -->


    <!-- Main Sidebar Container -->
    <?php include_once('lside_menu.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">


                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">


                

                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ปฎิทินใช้งาน</h3>

                        </div>


                        <!-- /.card-header -->
                        <div class="card-body" style="height: 700px;">
                        <iframe src="chart_event.php" width="100%" height="100%" style="border: none;"></iframe>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- page script -->


 

<script>

$(document).ready(function() {
    $('#calendar').fullCalendar({
        editable: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: 'load.php', // PHP script to fetch events
        selectable: true,
        selectHelper: true,
        select: function(start, end) {
            var title = prompt('Event Title:');
            if (title) {
                var start = moment(start).format('YYYY-MM-DD');
                var end = moment(end).format('YYYY-MM-DD');
                $.ajax({
                    url: 'insert.php',
                    type: 'POST',
                    data: {
                        title: title,
                        start: start,
                        end: end
                    },
                    success: function() {
                        $('#calendar').fullCalendar('refetchEvents');
                        alert('Event Added');
                    }
                });
            }
        },
        editable: true,
        eventResize: function(event) {
            var start = moment(event.start).format('YYYY-MM-DD');
            var end = moment(event.end).format('YYYY-MM-DD');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url: 'update.php',
                type: 'POST',
                data: {
                    title: title,
                    start: start,
                    end: end,
                    id: id
                },
                success: function() {
                    $('#calendar').fullCalendar('refetchEvents');
                    alert('Event Updated');
                }
            });
        },
        eventDrop: function(event) {
            var start = moment(event.start).format('YYYY-MM-DD');
            var end = moment(event.end).format('YYYY-MM-DD');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url: 'update.php',
                type: 'POST',
                data: {
                    title: title,
                    start: start,
                    end: end,
                    id: id
                },
                success: function() {
                    $('#calendar').fullCalendar('refetchEvents');
                    alert('Event Updated');
                }
            });
        },
        eventClick: function(event) {
            if (confirm('Are you sure you want to remove it?')) {
                var id = event.id;
                $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function() {
                        $('#calendar').fullCalendar('refetchEvents');
                        alert('Event Removed');
                    }
                });
            }
        }
    });
});


</script>


</body>
</html>
