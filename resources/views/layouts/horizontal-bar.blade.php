
            <div class="header-topnav">
                <div class="container-fluid">
                    <div class=" topnav rtl-ps-none" id="" data-perfect-scrollbar data-suppress-scroll-x="true">
                        <ul class="menu float-left">
                            <li class="{{ request()->is('dashboard/*') ? 'active' : '' }}">

                                <div>


                                    <div>
                                        <label class="toggle" for="drop-2">

                                        Dashboard
                                    </label>
                                        <a href="{{route('dashboard')}}">
                                            <i class="nav-icon mr-2 i-Bar-Chart"></i>
                                             Dashboard
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="{{ request()->is('uikits/*') ? 'active' : '' }}">

                                <div>


                                    <div>
                                        <label class="toggle" for="drop-2">

Sales
                                        </label>
                                        <a href="#">
                                            <i class="nav-icon mr-2 i-Suitcase"></i>Sales
                                        </a>
                                    <ul>
                                        <li class="nav-item">
                    <a class="{{ Route::currentRouteName()=='alerts' ? 'open' : '' }}" href="#">
                            <i class="nav-icon mr-2 i-Bell1"></i>
                            <span class="item-name">Alerts</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='badges' ? 'open' : '' }}" href="#">
                            <i class="nav-icon mr-2 i-Medal-2"></i>
                            <span class="item-name">Badges</span>
                        </a>
                    </li>
                      <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='bootstrap-tab' ? 'open' : '' }}" href="#">
                            <i class="nav-icon mr-2 i-Cursor-Click"></i>
                            <span class="item-name">Bootstrap tab</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='buttons' ? 'open' : '' }}" href="#">
                            <i class="nav-icon mr-2 i-Cursor-Click"></i>
                            <span class="item-name">Buttons</span>
                        </a>
                    </li>
                          <li class="nav-item">
                        <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="#">
                            <i class="nav-icon mr-2 i-Split-Horizontal-2-Window"></i>
                            <span class="item-name">Accordion</span>
                        </a>
                    </li>
                                    
                        </ul>
                                    </div>
                                </div>
                            </li>
                            <!-- end ui kits -->

                            <li class="{{ request()->is('extrakits/*') ? 'active' : '' }}">

                                <div>


                                    <div>
                                        <label class="toggle" for="drop-2">

                Finance
            </label>
                                        <a href="#">
                                            <i class="nav-icon i-Library mr-2"></i> Finance
                                        </a>
                                        
                                    </div>
                                </div>
                            </li>
                            <!-- end extra uikits -->

                            <li class="{{ request()->is('apps/*') ? 'active' : '' }}">

                                <div>


                                    <div>
                                        <label class="toggle" for="drop-2">

Marketing
            </label>
                                        <a href="#">
                                            <i class="nav-icon mr-2 i-Computer-Secure"></i> Marketing
                                        </a>
                                        
                                    </div>
                                </div>
                            </li>
                            <!-- end apps -->

                            <li class="{{ request()->is('forms/*') ? 'active' : '' }}">

                                <div>


                                    <div>
                                        <label class="toggle" for="drop-2">

Profit
            </label>
                                        <a href="#">
                                            <i class="nav-icon mr-2 i-File-Clipboard-File--Text"></i> Profit
                                        </a><input type="checkbox" id="drop-2">
                                    </div>
                                </div>
                            </li>
                            <!-- end Forms -->


                                <li class="{{ request()->is('charts/*') ? 'active' : '' }}">

                                <div>


                                    <div>
                                        <label class="toggle" for="drop-2">

Users
            </label>
                                        <a href="#">
                                            <i class="nav-icon mr-2 i-Bar-Chart-5"></i> Users
                                        </a><input type="checkbox" id="drop-2">
                                        
                                    </div>
                                </div>
                            </li>
                            <!-- end charts -->



                        </ul>


                    </div>
                </div>
            </div>
        <!--=============== Horizontal bar End ================-->
