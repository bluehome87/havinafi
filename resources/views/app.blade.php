<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Welcome - Transportation</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/css/datetimepicker.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/leaflet.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/header.css">

    <script src="/js/system/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<header class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#top-navbar" aria-controls="top-navbar" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            @if (Auth::check())
                <button id="mobile-switcher" type="button" onclick="toggleSidebar('mobile')">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                </button>
            @endif

            <a class="navbar-toggle navbar-brand collapsed" href="/">
                <img src="/img/logo-inverse.png" width="140" height="20" />
            </a>
        </div>

        <nav id="top-navbar" class="navbar-collapse collapse" aria-expanded="false">
            <ul class="nav navbar-nav navbar-left col-xs-5">
                <li><a onclick="showAboutUsBlock()">About Us</a></li>
                <li><a onclick="showFAQBlock()">F.A.Q.</a></li>

                @if (Auth::guest())
                    <li><a onclick="showLoginBlock()">Login</a></li>
                    <li><a onclick="showRegisterBlock()">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{Auth::user()->name}} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a onclick="showProfileBlock()">Profile</a></li>
                            <li><a href="/logout">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            <div class="col-xs-2">
                <a class="navbar-brand" href="/">
                    <img src="/img/logo-inverse.png" width="140" height="20" />
                </a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li><a onclick="showAboutUsBlock()">About Us</a></li>
                <li><a onclick="showFAQBlock()">F.A.Q.</a></li>

                @if (Auth::guest())
                    <li><a onclick="showLoginBlock()">Login</a></li>
                    <li><a onclick="showRegisterBlock()">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{Auth::user()->name}} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a onclick="showProfileBlock()">Profile</a></li>
                            <li><a href="/logout">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<div id="main">
    <div id="system-message">
        <div class="container-fluid">
            <div class="row">
                @if (Session::has('message-success'))
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {{Session::get('message-success')}}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (Auth::guest())
        <div class="guest">
            <div id="map" class="map"></div>

            <div id="sections">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div id="section-one" class="section well well-lg">
                                <div class="row">
                                    @include('guest.welcome')
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-0 col-sm-6 col-xs-12">
                            <div id="section-three" class="section well well-lg">
                                <div class="row">
                                    <button type="button" class="close" data-dismiss="well" aria-label="Close" onclick="hideSectionThree()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                    @include('guest.register')
                                    @include('guest.login')
                                    @include('guest.forgotPassword')

                                    @if (Request::is('reset-password/*'))
                                        @include('guest.resetPassword')
                                    @endif

                                    @include('common.aboutUs')
                                    @include('common.faq')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="user">
            <div id="sidebar">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation">
                            <a href="#my-vehicles" aria-controls="my-vehicles" role="tab" data-toggle="tab">
                                My Vehicles
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#my-tasks" aria-controls="my-tasks" role="tab" data-toggle="tab">
                                My Tasks
                            </a>
                        </li>

                        <li role="presentation" class="active">
                            <a href="#transports" aria-controls="transports" role="tab" data-toggle="tab">
                                Transports
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">
                                Messages
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="my-vehicles">
                            @include('user.my-vehicles')
                        </div>

                        <div role="tabpanel" class="tab-pane" id="my-tasks">
                            @include('user.my-tasks')
                        </div>

                        <div role="tabpanel" class="tab-pane active" id="transports">
                            @include('user.jobs')
                        </div>

                        <div role="tabpanel" class="tab-pane" id="messages">
                            @include('user.messages')
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12" id="general">
                <div id="map" class="map"></div>

                <div id="sidebar-toggle" onclick="toggleSidebar()">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </div>

                <div class="row">
                    <div id="sections">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4 col-lg-offset-8 col-md-6 col-md-offset-6 col-sm-8 col-sm-offset-2">
                                    <div id="section-three" class="section well well-lg">
                                        <button type="button" class="close" data-dismiss="well" aria-label="Close" onclick="hideSectionThree()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                        @include('user.profile')

                                        @include('common.aboutUs')
                                        @include('common.faq')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/system/jquery-1.11.2.min.js"><\/script>')</script>
<script src="/js/system/bootstrap.min.js"></script>
<script src="/js/system/bootstrap-select.min.js"></script>
<script src="/js/system/datetimepicker.full.min.js"></script>
<script src="/js/system/leaflet.js"></script>
<script src="/js/main.js"></script>
</body>
</html>
