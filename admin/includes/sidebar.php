        <!-- Sidebar -->
        <div class="col-auto col-md-3 col-xl-2 px-0 sidebar d-none d-md-block">
            <div class="d-flex flex-column align-items-center align-items-sm-start min-vh-100">
                <div class="brand px-4 d-flex align-items-center w-100">
                    <i class="bi bi-ui-radios-grid"></i>
                    <span class="fs-5 fw-bold">Admin Web</span>
                </div>
                
                <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                    <li class="w-100 mb-2">
                        <a href="index.php" class="nav-link">
                            <i class="bi bi-grid-1x2-fill"></i> <span class="d-none d-sm-inline">Beranda Dasbor</span>
                        </a>
                    </li>
                    <li class="w-100 mb-2">
                        <a href="menus.php" class="nav-link">
                            <i class="bi bi-card-checklist"></i> <span class="d-none d-sm-inline">Daftar Menu</span>
                        </a>
                    </li>
                    <li class="w-100 mb-2">
                        <a href="events.php" class="nav-link">
                            <i class="bi bi-calendar2-star-fill"></i> <span class="d-none d-sm-inline">Daftar Acara</span>
                        </a>
                    </li>
                    <li class="w-100 mb-2">
                        <a href="chefs.php" class="nav-link">
                            <i class="bi bi-person-badge-fill"></i> <span class="d-none d-sm-inline">Daftar Koki</span>
                        </a>
                    </li>
                    <li class="w-100 mb-2">
                        <a href="testimonials.php" class="nav-link">
                            <i class="bi bi-chat-left-quote-fill"></i> <span class="d-none d-sm-inline">Testimoni</span>
                        </a>
                    </li>
                    <li class="w-100 mb-2">
                        <a href="gallery.php" class="nav-link">
                            <i class="bi bi-images"></i> <span class="d-none d-sm-inline">Galeri Foto</span>
                        </a>
                    </li>
                    <li class="w-100 mb-4">
                        <a href="settings_home.php" class="nav-link">
                            <i class="bi bi-layout-text-window-reverse"></i> <span class="d-none d-sm-inline">Teks Website</span>
                        </a>
                    </li>
                    
                    <hr class="w-100 bg-light opacity-50 my-2">
                    
                    <li class="w-100 mt-2">
                        <a href="../index.php" target="_blank" class="nav-link">
                            <i class="bi bi-globe2"></i> <span class="d-none d-sm-inline">Lihat Website</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="logout.php" class="nav-link">
                            <i class="bi bi-box-arrow-left"></i> <span class="d-none d-sm-inline">Keluar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col py-4 px-4 px-lg-5 content" style="overflow-y: auto; height: 100vh;">
            
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-search">
                    <i class="bi bi-search"></i>
                    <input type="text" class="search-bar" placeholder="Pencarian...">
                </div>
                <div class="topbar-right">
                    <span class="topbar-date d-none d-md-inline" id="topdate"></span>
                    <div class="topbar-icons">
                        <i class="bi bi-gear"></i>
                        <i class="bi bi-bell"></i>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin&background=5c4dff&color=fff" alt="Admin" class="topbar-profile">
                </div>
            </div>
            
            <script>
                // Format date to Indonesian
                const options = { weekday: 'long', day: 'numeric', month: 'long' };
                document.getElementById('topdate').innerText = 'Hari ini, ' + new Date().toLocaleDateString('id-ID', options);
            </script>
