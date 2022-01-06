<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            @if (Route::has('login'))
                <li class="nav-label first">Main Menu</li>
                <li><a href="/beranda" aria-expanded="false"><i class="icon icon-home"></i><span
                            class="nav-text">Dashboard</span></a></li>
                <li class="nav-label">Sales</li>
                <li><a href="/transaksi" aria-expanded="false"><i class="icon icon-tag"></i><span
                            class="nav-text">Transaksi</span></a></li>
                <li><a href="/pembayaran" aria-expanded="false"><i class=" icon-wallet"></i><span
                            class="nav-text">Data Penjualan</span></a></li>

                </li>
                <li class="nav-label">Database</li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                            class=" icon-notebook"></i><span class="nav-text">Data Master</span></a>
                    <ul aria-expanded="false">
                        <li><a href="/barang">Data Barang</a></li>
                        <li><a href="/pembeli">Data Pembeli</a></li>
                        <li><a href="/supplier">Data Supplier</a></li>
                    </ul>
                </li>
                <li class="nav-label">User Managament</li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                            class="icon icon-settings"></i><span class="nav-text">Setting</span></a>
                    <ul aria-expanded="false">
                        <li><a href="./page-login.html">Profil</a></li>
                        <li><a href="./page-register.html">Ganti Password</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        aria-expanded="false"><i class="icon-logout"></i><span
                            class="nav-text">Logout</span></a>
                </li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                    @csrf
                </form>
            @endif
        </ul>
    </div>
</div>
