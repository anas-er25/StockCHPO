  <aside id="application-sidebar-brand"
      class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full  transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed top-0 with-vertical h-screen z-[999] flex-shrink-0 border-r-[1px] w-[270px] border-gray-400  bg-white left-sidebar   transition-all duration-300">
      <x-logo />
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

                      <li class="text-xs font-bold mb-4 mt-4">
                          {{-- <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                          <span>UI COMPONENTS</span> --}}
                          <hr>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('materiels.index') }}">
                              <i class="ti ti-tools text-xl"></i> <span>Matériels</span>

                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('services.index') }}">
                              <i class="ti ti-briefcase text-xl"></i> <span>Services</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('societies.index') }}">
                              <i class="ti ti-briefcase text-xl"></i> <span>Sociétés</span>
                          </a>
                      </li>


                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('bondecharge.allbondecharge') }}">
                              <i class="fa-solid fa-eject"></i> <span>Bon de Décharge</span>
                          </a>
                      </li>

                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('avismvt.allavismvt') }}">
                              <i class="fas fa-exchange-alt"></i> <span>Avis de mouvement</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3 rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('reforme.allreforme') }}">
                              <i class="fas fa-recycle"></i> <span>Matériel réformé</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a class="sidebar-link gap-3 py-2 px-3 rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                              href="{{ route('materiels.stock') }}">
                              <i class="fas fa-shopping-cart"></i> <span>Gestion de stock</span>

                          </a>
                      </li>
                      @can('manage-users')
                          <li class="sidebar-item">
                              <a href="{{ route('profile.userlist') }}"
                                  class="sidebar-link gap-3 py-2 px-3 rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500">
                                  <i class="ti ti-users"></i>
                                  <span>Gestion des utilisateurs</span>
                              </a>
                          </li>
                      @endcan


                  </ul>
              </nav>
          </div>
      </div>
      <!-- </aside> -->
  </aside>
