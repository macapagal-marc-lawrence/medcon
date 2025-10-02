    <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">

                            <li class="dropdown">
                                <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
                                    @if($totalNotifications > 0)
                                        <span>{{ $totalNotifications }}</span>
                                    @endif
                                </i>
                                <div class="dropdown-menu bell-notify-box notify-box">
                                    <span class="notify-title">You have {{ $totalNotifications }} new notifications</span>
                                    <div class="nofity-list">
                                        @if($notifications['new_users'] > 0)
                                            <a href="#" class="notify-item">
                                                <div class="notify-thumb"><i class="ti-user btn-info"></i></div>
                                                <div class="notify-text">
                                                    <p>{{ $notifications['new_users'] }} new user(s) registered</p>
                                                    <span>In the last 24 hours</span>
                                                </div>
                                            </a>
                                        @endif

                                        @if($notifications['new_drugstores'] > 0)
                                            <a href="#" class="notify-item">
                                                <div class="notify-thumb"><i class="ti-home btn-success"></i></div>
                                                <div class="notify-text">
                                                    <p>{{ $notifications['new_drugstores'] }} new drugstore(s) registered</p>
                                                    <span>In the last 24 hours</span>
                                                </div>
                                            </a>
                                        @endif

                                        @if($notifications['pending_orders'] > 0)
                                            <a href="#" class="notify-item">
                                                <div class="notify-thumb"><i class="ti-shopping-cart btn-warning"></i></div>
                                                <div class="notify-text">
                                                    <p>{{ $notifications['pending_orders'] }} pending order(s)</p>
                                                    <span>Awaiting review</span>
                                                </div>
                                            </a>
                                        @endif

                                        @if($totalNotifications === 0)
                                            <div class="notify-item">
                                                <div class="notify-text text-center">
                                                    <p>No new notifications</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>