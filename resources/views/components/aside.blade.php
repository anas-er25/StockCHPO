  <aside id="application-sidebar-brand"
      class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full  transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed top-0 with-vertical h-screen z-[999] flex-shrink-0 border-r-[1px] w-[270px] border-gray-400  bg-white left-sidebar   transition-all duration-300">
      <div class="p-5">
          <a href="{{route('dashboard')}}" class="text-nowrap">
              <b class="text-2xl">StockPro</b>
          </a>
      </div>
      <div class="scroll-sidebar" data-simplebar="">
          <div class="px-6 mt-8">
              <nav class=" w-full flex flex-col sidebar-nav">
                  <ul id="sidebarnav" class="text-gray-600 text-sm">
                      {{-- <li class="text-xs font-bold pb-4">
                                        <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                                        <span>HOME</span>
                                    </li> --}}

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md  w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('dashboard') }}">
                              <i class="ti ti-layout-dashboard  text-xl"></i> <span>Tableau de bord</span>
                          </a>
                      </li>

                      {{-- <li class="text-xs font-bold mb-4 mt-8">
                          <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                          <span>UI COMPONENTS</span>
                      </li> --}}

                      {{-- <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('materiels.index') }}">
                              <i class="ti ti-article  text-xl"></i> <span>Matériels</span>
                          </a>
                      </li>--}}

                         <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('services.index') }}">
                              <i class="ti ti-article  text-xl"></i> <span>Services</span>
                          </a>
                      </li>

                      {{-- <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="./components/alerts.html">
                              <i class="ti ti-alert-circle  text-xl"></i> <span>Alerts</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="./components/cards.html">
                              <i class="ti ti-cards  text-xl"></i> <span>Card</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="./components/forms.html">
                              <i class="ti ti-file-description  text-xl"></i> <span>Forms</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="./components/typography.html">
                              <i class="ti ti-typography text-xl"></i> <span>Typography</span>
                          </a>
                      </li>

                      <li class="text-xs font-bold mb-4 mt-8">
                          <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                          <span>AUTH</span>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="./pages/authentication-login.html">
                              <i class="ti ti-login  text-xl"></i> <span>Login</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="./pages/authentication-register.html">
                              <i class="ti ti-user-plus  text-xl"></i> <span>Register</span>
                          </a>
                      </li>

                      <li class="text-xs font-bold mb-4 mt-8">
                          <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                          <span>EXTRA</span>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="./pages/icons.html">
                              <i class="ti ti-mood-happy  text-xl"></i> <span>Icons</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="./pages/sample-page.html">
                              <i class="ti ti-aperture  text-xl"></i> <span>Sample Page</span>
                          </a>
                      </li> --}}

                  </ul>
              </nav>
          </div>
      </div>
      <!-- </aside> -->
  </aside>
