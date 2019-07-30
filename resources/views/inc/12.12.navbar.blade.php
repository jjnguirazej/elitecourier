<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand" 
                href="{{ url('/dashboard') }}">
                {{session('courier.companyname') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <ul class="nav navbar-nav">
                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                @if(Auth::user()->usertype != 'clerk')
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administration <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->usertype == 'superadmin')
                                <li><a href="{{ route('company.index') }}">Companies</a></li>
                            @endif
                            <li><a href="{{ route('customer.index') }}">Customers</a></li>
                            <!-- <li><a href="{{ route('token.index') }}">Tokens</a></li> -->
                            <li><a href="{{ route('users.index') }}">Users</a></li>
                            <li><a href="{{ route('station.index') }}">Branches</a></li>
                            <li><a href="{{ route('parcel.index') }}">Parcel Management</a></li>
                         </ul>
                    </li>
                @endif
                
                <!-- <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reporting <span class="caret"></span></a>
                    <ul class="dropdown-menu"> 
                        <li><a href="{{ route('shipments.index') }}">Shipments</a></li>
                    </ul>
                </li> -->
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shipments <span class="caret"></span></a>
                    <ul class="dropdown-menu"> 
                        <li><a href="{{ route('shipments.index') }}">Shipments - Reports</a></li>
                        <li><a href="{{ route('shipments.booked') }}">Shipments - Operations</a></li>
                        <!-- <li><a href="{{ route('shipments.pickedtosortfacility') }}">Shipments - Picked from Customer</a></li>
                        <li><a href="{{ route('shipments.receivedatsortfacility') }}">Shipments - At Sort Facility</a></li>
                        <li><a href="{{ route('shipments.dispatchedShipments') }}">Shipments - Out of Dispatch</a></li> -->
                        <li><a href="{{ route('shipments.receivedShipments') }}">Shipments - Received</a></li>
                        <li><a href="{{ route('shipments.returnedShipments') }}">Shipments - Returned</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('shipments.awb') }}">AWB Search</a></li>
                
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('users.signin') }}">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> <?php echo Auth::user()->firstname;  ?> <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if(Auth::check())
                                <li><a href="{{ route('users.profile') }}">Profile</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('users.logout') }}">Logout</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>