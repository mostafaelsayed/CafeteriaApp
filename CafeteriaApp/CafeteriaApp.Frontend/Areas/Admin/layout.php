<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="/CafeteriaApp.Frontend/javascript/jquery-3.2.1.min.js"></script>
<!--         <script src="/CafeteriaApp.Frontend/Scripts/libs/bootstrap.min.js"></script>
 -->
        <script src="/CafeteriaApp.Frontend/javascript/angular.min.js"></script>
        <script src="/CafeteriaApp.Frontend/javascript/myapp.js"></script>

        <script src="/CafeteriaApp.Frontend/javascript/ui-bootstrap-2.5.0.js"></script>

        <script src="/CafeteriaApp.Frontend/javascript/ui-bootstrap-tpls-2.5.0.js"></script>
        <script src="/CafeteriaApp.Frontend/javascript/angular-modal-service.js"></script>
        <!-- Bootstrap Core CSS -->
        <link href="/CafeteriaApp.Frontend/css/bootstrap.min.css" rel="stylesheet">
        <link href="/CafeteriaApp.Frontend/css/form_validation.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="/CafeteriaApp.Frontend/css/metisMenu.min.css" rel="stylesheet">
        <!-- DataTables CSS -->
        <link href="/CafeteriaApp.Frontend/css/dataTables.bootstrap.css" rel="stylesheet">
        <!-- DataTables Responsive CSS -->
        <link href="/CafeteriaApp.Frontend/css/dataTables.responsive.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/CafeteriaApp.Frontend/css/sb-admin-2.css" rel="stylesheet">
        <!-- Morris Charts CSS -->
        <link href="/CafeteriaApp.Frontend/css/morris.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <!-- <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/fonts/fontawesome-webfont.woff" rel="font-woff">
        <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/fonts/fontawesome-webfont.woff2" rel="octet-stream">
        <link href="/CafeteriaApp.Frontend/Scripts/adminTheme/font-awesome/fonts/fontawesome-webfont.ttf" rel="x-font-ttf"> -->
        <script src="/CafeteriaApp.Frontend/javascript/metisMenu.min.js"></script>
        <!-- DataTables JavaScript -->
        <script src="/CafeteriaApp.Frontend/javascript/jquery.dataTables.min.js"></script>
        <script src="/CafeteriaApp.Frontend/javascript/dataTables.bootstrap.min.js"></script>
        <script src="/CafeteriaApp.Frontend/javascript/dataTables.responsive.js"></script>
        <!-- Morris Charts JavaScript -->
        <script src="/CafeteriaApp.Frontend/javascript/raphael.min.js"></script>
        <script src="/CafeteriaApp.Frontend/javascript/morris.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="/CafeteriaApp.Frontend/javascript/sb-admin-2.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                <a class="navbar-brand" href="/admin/Dashboard/Index">Cafeteria Admin Panel</a>
                </div>
                <!-- /.navbar-header -->
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                            <span class="pull-right text-muted small">12 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-alerts -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a onclick="gotologout()"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    <!-- /.dropdown-user -->
                    </li>
                <!-- /.dropdown -->
                </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="/Home/Index"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="/admin/Dashboard/Index"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="/admin/cafeteria/Index"><i class="fa fa-apple fa-fw"></i> Cafeteria Manager</a>
                        </li>
                        <li>
                            <a href="/admin/category/Index"><i class="fa fa-check-square-o fa-fw"></i> Category Manager</a>
                        </li>
                        <li>
                            <a href="/admin/menuitem/Index"><i class="fa fa-lemon-o fa-fw"></i> Menu Items Manager</a>
                        </li>
                        <li>
                            <a href="/admin/addition/Index"><i class="fa fa-lemon-o fa-fw"></i> Additions Manager</a>
                        </li>
                        <li>
                            <a href="/admin/user/Index"><i class="fa fa-lemon-o fa-fw"></i> Users Manager</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper"></div>
        <!-- /#page-wrapper -->
        </div>
    </body>
</html>
