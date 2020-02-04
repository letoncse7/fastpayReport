    <div class="main-header">
            <div class="logo">
                <img src="{{asset('assets/images/logo.png')}}" alt="">
            </div>

            <div class="d-flex align-items-center">
                <!-- Mega menu -->
                @include('layouts.horizontal-bar')
                <!-- / Mega menu -->
                
            </div>

            <div class="header-part-right">
                <!-- Full screen toggle -->
                <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
                

                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div  class="user col align-self-end">
                        <img src="{{asset('assets/images/faces/1.jpg')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> Timothy Carlson
                            </div>
                            <a class="dropdown-item">Account settings</a>
							<a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Sign out') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- header top menu end -->
