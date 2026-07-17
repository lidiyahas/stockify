<!-- resources/views/components/sidebar/admin-sidebar.blade.php -->
<x-sidebar-dashboard>
    <div class="flex flex-col justify-between h-full">

        <ul class="space-y-2">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100
                          dark:text-white dark:hover:bg-gray-700
                          {{ request()->routeIs('dashboard') || request()->routeIs('index-practice') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>

            <!-- Dropdown Manajemen Produk -->
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'manajer_gudang')
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-gray-900 rounded-lg group hover:bg-gray-100
                           dark:text-white dark:hover:bg-gray-700 transition duration-75"
                    aria-controls="dropdown-products" data-collapse-toggle="dropdown-products">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Manajemen Produk</span>
                    <svg aria-hidden="true" class="w-6 h-6 transition-transform duration-300"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0l-4.25-4.65a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>

                <ul id="dropdown-products" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('products.index') }}"
                           class="flex items-center w-full p-2 pl-11 rounded-lg text-gray-900 hover:bg-gray-100
                                  dark:text-white dark:hover:bg-gray-700
                                  {{ request()->routeIs('products.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                            Daftar Produk
                        </a>
                    </li>
                    @if(Auth::user()->role === 'admin')
                        <li>
                            <a href="{{ route('attributes.index') }}"
                            class="flex items-center w-full p-2 pl-11 rounded-lg text-gray-900 hover:bg-gray-100
                                    dark:text-white dark:hover:bg-gray-700
                                    {{ request()->routeIs('attributes.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                                Atribut Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}"
                            class="flex items-center w-full p-2 pl-11 rounded-lg text-gray-900 hover:bg-gray-100
                                    dark:text-white dark:hover:bg-gray-700
                                    {{ request()->routeIs('categories.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                                Kategori Produk
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif

            <!-- Dropdown Manajemen Stok -->
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'manajer_gudang'  || Auth::user()->role === 'staff_gudang')
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-gray-900 rounded-lg group hover:bg-gray-100
                           dark:text-white dark:hover:bg-gray-700 transition duration-75"
                    aria-controls="dropdown-stock" data-collapse-toggle="dropdown-stock">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Manajemen Stok</span>
                    <svg aria-hidden="true" class="w-6 h-6 transition-transform duration-300"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0l-4.25-4.65a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>

                <ul id="dropdown-stock" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('transactions.index') }}"
                           class="flex items-center w-full p-2 pl-11 rounded-lg text-gray-900 hover:bg-gray-100
                                  dark:text-white dark:hover:bg-gray-700
                                  {{ request()->routeIs('transactions.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                            Transaksi Stok
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('opname.index') }}"
                        class="flex items-center w-full p-2 pl-11 rounded-lg text-gray-900 hover:bg-gray-100
                                dark:text-white dark:hover:bg-gray-700
                                {{ request()->routeIs('opname.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                            Stock Opname
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!-- Menu Laporan -->
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'manajer_gudang')
            <li>
                <a href="{{ route('reports.index') }}"
                   class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100
                          dark:text-white dark:hover:bg-gray-700
                          {{ request()->routeIs('reports.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    <span class="ml-3">Laporan</span>
                </a>
            </li>
            @endif

            <!-- Menu Manajemen Pengguna -->
            @if(Auth::user()->role === 'admin')
            <li>
                <a href="{{ route('users.index') }}"
                   class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100
                          dark:text-white dark:hover:bg-gray-700
                          {{ request()->routeIs('users.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span class="ml-3">Manajemen Pengguna</span>
                </a>
            </li>
            @endif

            <!-- Menu Manajemen Suppliers -->
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'manajer_gudang')
            <li>
                <a href="{{ route('suppliers.index') }}"
                   class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100
                          dark:text-white dark:hover:bg-gray-700
                          {{ request()->routeIs('suppliers.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 5.25v-5.25m0 0h-12" />
                    </svg>
                    <span class="ml-3">Manajemen Suppliers</span>
                </a>
            </li>
            @endif

            <!-- Menu Pengaturan (Admin only) -->
            @if(Auth::user()->role === 'admin')
            <li>
                <a href="{{ route('settings.index') }}"
                   class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100
                          dark:text-white dark:hover:bg-gray-700
                          {{ request()->routeIs('settings.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.828c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="ml-3">Pengaturan</span>
                </a>
            </li>
            @endif

        </ul>

        <!-- Logout, selalu di paling bawah -->
        <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100
                           dark:text-white dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span class="ml-3">Logout</span>
                </button>
            </form>
        </div>

    </div>
</x-sidebar-dashboard>
