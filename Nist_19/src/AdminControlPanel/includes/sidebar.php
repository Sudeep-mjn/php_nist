<div class="sidebar bg-white shadow-lg fixed h-full w-64 z-10">
    <div class="p-4 flex items-center border-b">
        <div class="w-10 h-10 rounded-full mr-3 bg-primary flex items-center justify-center">
            <i class="fas fa-chart-line text-white"></i>
        </div>
        <span class="logo-text font-bold text-lg">NIST19 Admin</span>
    </div>
    <div class="p-4">
        <div class="mb-8">
            <p class="text-gray-500 text-sm sidebar-text">MAIN MENU</p>
            <ul class="mt-4 space-y-2">
                <li>
                    <a href="dashboard.php" class="nav-link flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active-nav' : ''; ?>">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="notices.php" class="nav-link flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 <?php echo (basename($_SERVER['PHP_SELF']) == 'notices.php') ? 'active-nav' : ''; ?>">
                        <i class="fas fa-bell mr-3"></i>
                        <span class="sidebar-text">Notices</span>
                    </a>
                </li>
                <li>
                    <a href="activities.php" class="nav-link flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 <?php echo (basename($_SERVER['PHP_SELF']) == 'activities.php') ? 'active-nav' : ''; ?>">
                        <i class="fas fa-calendar-alt mr-3"></i>
                        <span class="sidebar-text">Activities</span>
                    </a>
                </li>
                <li>
                    <a href="users.php" class="nav-link flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 <?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active-nav' : ''; ?>">
                        <i class="fas fa-users mr-3"></i>
                        <span class="sidebar-text">Users</span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <p class="text-gray-500 text-sm sidebar-text">SETTINGS</p>
            <ul class="mt-4 space-y-2">
                <li>
                    <a href="profile.php" class="nav-link flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active-nav' : ''; ?>">
                        <i class="fas fa-user mr-3"></i>
                        <span class="sidebar-text">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="nav-link flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span class="sidebar-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <button id="toggle-sidebar" class="absolute -right-3 top-1/2 bg-white p-2 rounded-full shadow-md">
        <i class="fas fa-chevron-left"></i>
    </button>
</div>
