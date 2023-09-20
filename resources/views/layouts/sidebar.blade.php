<aside class="app-navbar">
    <!-- begin sidebar-nav -->
    <div class="sidebar-nav scrollbar scroll_light">
        <ul class="metismenu" id="sidebarNav">
            {{-- <li class="nav-static-title"><span>Get Started</span></li> --}}
            <li class="{{ checkActive('/') }}">
                <a class="" href="{{ url('/') }}" aria-expanded="false">
                    <span class="iw-icon-with-title">
                        <img class="nav-img" src="{{ asset('assets/img/dashboard.png') }}" alt="" />
                        <span class="nav-title">Dashboard</span>
                    </span>
                </a>
            </li>
            {{-- <li class="nav-static-title"><span>Munshi Management System</span></li> --}}


            @canany(['real-estate-agent-list', 'employees-list', 'cities-list', 'contacts-list',
                'transaction-types-list', 'brokerage-list', 'solicitor-list', 'law-firms-list'])
                <li
                    class="{{ checkActive(['real-estate-agents','employees','cities','transaction-types','contacts','brokerages','solicitors','law-firms','city-departments']) }}">
                    <a href="#" aria-expanded="false">
                        <span class="iw-icon-with-title">
                            <img class="nav-img" src="{{ asset('assets/img/maintenance.png') }}" alt="" />
                            <span class="nav-title">Maintenance</span>
                        </span>
                        <i class="nav-icon fe fe-chevron-down"></i>
                    </a>
                    <ul aria-expanded="false">

                        @can('employees-list')
                            <li class="{{ checkActive(['employees']) }}"><a href="{{ url('employees') }}">Firm Details</a>
                            </li>
                        @endcan
                        @can('real-estate-agent-list')
                            <li class="{{ checkActive(['real-estate-agents']) }}"><a
                                    href="{{ url('real-estate-agents') }}">Real Estate Agent</a></li>
                        @endcan
                        @can('cities-list')
                            <li class="{{ checkActive(['cities', 'city-departments']) }}"><a
                                    href="{{ url('cities') }}">Cities</a></li>
                        @endcan
                        @can('contacts-list')
                            <li class="{{ checkActive(['contacts']) }}"><a href="{{ url('contacts') }}">Mortgagee</a></li>
                        @endcan
                        @can('brokerage-list')
                            <li class="{{ checkActive(['brokerages']) }}"><a href="{{ url('brokerages') }}">Brokerages</a>
                            </li>
                        @endcan
                        @can('transaction-type-list')
                            <li li class="{{ checkActive(['transaction-types']) }}"><a
                                    href="{{ url('transaction-types') }}">Credit Types</a></li>
                        @endcan
                        @can('solicitor-list')
                            <li class="{{ checkActive(['solicitors']) }}"><a href="{{ url('solicitors') }}">Solicitors</a>
                            </li>
                        @endcan
                        @can('law-firms-list')
                            <li li class="{{ checkActive(['law-firms']) }}"><a href="{{ url('law-firms') }}">Law Firms</a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcanany
            @can('file-openings')
                <li class="{{ checkActive(['file-openings']) }}">
                    <a href="#" aria-expanded="false">
                        <span class="iw-icon-with-title">
                            <img class="nav-img" src="{{ asset('assets/img/matters.png') }}" alt="" />
                            <span class="nav-title">Matter</span>
                        </span>
                        <i class="nav-icon fe fe-chevron-down"></i>
                    </a>
                    <ul aria-expanded="false">
                        <li class="  {{ checkActive(['file-page']) }}"><a href="{{ url('file-page') }}">Open New
                                File</a></li>
                    </ul>
                    <ul aria-expanded="false">
                        <li class="  {{ checkActive(['file-openings']) }}"><a href="{{ url('file-openings') }}">File
                                Openings</a></li>
                    </ul>
                </li>
            @endcan
            @can('make-payment')
             <li class="{{ checkActive('payments') }}">
                <a class="" href="{{ url('payments')}}" aria-expanded="false">
                    <span class="iw-icon-with-title">
                        <img class="nav-img" src="{{asset('assets/img/dashboard.png')}}" alt=""/>
                        <span class="nav-title">Payments</span>
                    </span>
                </a>
            </li>
            @endcan
            <li class="{{ checkActive('file-fee-report') }}">
                <a class="" href="#" aria-expanded="false">
                    <span class="iw-icon-with-title">
                        <img class="nav-img" src="{{asset('assets/img/report.png')}}" alt=""/>
                        <span class="nav-title">Reports</span>
                    </span>
                    <i class="nav-icon fe fe-chevron-down"></i>
                </a>
                <ul aria-expanded="false">
                    <li class="{{ checkActive(['file-fee-report']) }}"><a href="{{ url('file-fee-report') }}">File Fee Report</a></li>
                </ul>
            </li>
            @can('manage-users')
                <li class="{{ checkActive(['users', 'roles']) }}">
                    <a href="#" aria-expanded="false">
                        <span class="iw-icon-with-title">
                            <img class="nav-img" src="{{ asset('assets/img/users.png') }}" alt="" />
                            <span class="nav-title">Users</span>
                        </span>
                        <i class="nav-icon fe fe-chevron-down"></i>
                    </a>
                    <ul aria-expanded="false">
                        <li class="{{ checkActive(['users']) }}"><a href="{{ url('users') }}">Users</a></li>
                        <li class="{{ checkActive(['roles']) }}"><a href="{{ url('roles') }}">Manage Roles &
                                Permissions</a></li>
                    </ul>
                </li>
            @endcan
        </ul>
        {{-- <div class="iw-theme-changer px-2">
            <h6>Admin Color Schemes</h6>
            <ul>
                <li class="iw-default-theme"><span class="iw-color-square"></span><span>Default Theme</span></li>
                <li class="iw-dark-theme"><span class="iw-color-square"></span><span>Dark Theme</span></li>
                <li class="iw-light-theme"><span class="iw-color-square"></span><span>Blue Theme</span></li>
            </ul>
        </div> --}}
    </div>
    <!-- end sidebar-nav -->
</aside>
