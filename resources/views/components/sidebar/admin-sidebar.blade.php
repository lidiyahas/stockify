<!-- resources/views/components/sidebar/admin-sidebar.blade.php -->
<x-sidebar-dashboard>
    <ul class="space-y-2">

        <!-- Dropdown Manajemen Produk -->
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'manajer_gudang')
        <li>
            <button type="button"
                class="flex items-center w-full p-2 text-gray-900 rounded-lg group hover:bg-gray-100
                       dark:text-white dark:hover:bg-gray-700 transition duration-75"
                aria-controls="dropdown-products" data-collapse-toggle="dropdown-products">
                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9V5h4v4H8zm0 2h4v4H8v-4z"></path>
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
                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9V5h4v4H8zm0 2h4v4H8v-4z"></path>
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
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'manajer_gudang' || Auth::user()->role === 'staff_gudang')
                <li>
                    <a href="{{ route('opname.index') }}"
                    class="flex items-center w-full p-2 pl-11 rounded-lg text-gray-900 hover:bg-gray-100
                            dark:text-white dark:hover:bg-gray-700
                            {{ request()->routeIs('opname.*') ? 'bg-gray-200 dark:bg-gray-600 font-semibold' : '' }}">
                        Stock Opname
                    </a>
                </li>
                @endif
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
                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9V5h4v4H8zm0 2h4v4H8v-4z"></path>
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
                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9V5h4v4H8zm0 2h4v4H8v-4z"></path>
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
                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 3h12a1 1 0 011 1v2a1 1 0 01-.293.707L10 12l-6.707-5.293A1 1 0 013 6V4a1 1 0 011-1zM3 8l7 5 7-5v7a1 1 0 01-1 1H4a1 1 0 01-1-1V8z"/>
                </svg>
                <span class="ml-3">Manajemen Suppliers</span>
            </a>
        </li>
        @endif
    </ul>
</x-sidebar-dashboard>
