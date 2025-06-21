<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIST19 Admin Panel</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
    <link rel="stylesheet" href="/styles.css">
    <style>
        /* Custom styles */
        .sidebar {
            transition: all 0.3s;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        .sidebar.collapsed .logo-text {
            display: none;
        }
        .main-content {
            transition: all 0.3s;
        }
        .sidebar.collapsed + .main-content {
            margin-left: 70px;
        }
        .active-nav {
            background-color: #37517E;
            color: white;
        }
        .active-nav:hover {
            background-color: #37517E !important;
        }
        .image-preview {
            max-height: 200px;
            width: auto;
        }
        .notice-container {
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Admin Layout -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-white shadow-lg fixed h-full w-64 z-10">
            <div class="p-4 flex items-center border-b">
                <img src="../images/logo.jpg" alt="NIST19 Logo" class="w-10 h-10 rounded-full mr-3">
                <span class="logo-text font-bold text-lg">NIST19 Admin</span>
            </div>
            <div class="p-4">
                <div class="mb-8">
                    <p class="text-gray-500 text-sm sidebar-text">MAIN MENU</p>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="dashboard.php" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                <span class="sidebar-text">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="notices.php" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 active-nav">
                                <i class="fas fa-bell mr-3"></i>
                                <span class="sidebar-text">Notices</span>
                            </a>
                        </li>
                        <li>
                            <a href="activities.php" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
                                <i class="fas fa-calendar-alt mr-3"></i>
                                <span class="sidebar-text">Activities</span>
                            </a>
                        </li>
                        <li>
                            <a href="users.php" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
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
                            <a href="profile.php" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
                                <i class="fas fa-user mr-3"></i>
                                <span class="sidebar-text">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="logout.php" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
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

        <!-- Main Content -->
        <div class="main-content flex-1 ml-64 p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Manage Notices</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-500 cursor-pointer"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </div>
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/40" alt="User" class="w-8 h-8 rounded-full mr-2">
                        <span class="text-gray-700">Admin User</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center mb-6">
                <div class="relative w-64">
                    <input type="text" placeholder="Search notices..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <button id="add-notice-btn" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add New Notice
                </button>
            </div>

            <!-- Notices Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Market Holiday</div>
                                <div class="text-sm text-gray-500">The stock market will remain closed on November 23rd</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">2023-11-15</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3 edit-notice-btn">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 delete-notice-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">New Trading Policy</div>
                                <div class="text-sm text-gray-500">SEBON has introduced new trading policies</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">2023-11-10</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3 edit-notice-btn">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 delete-notice-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">System Maintenance</div>
                                <div class="text-sm text-gray-500">Our online trading platform will be unavailable</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">2023-11-05</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3 edit-notice-btn">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 delete-notice-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Investor Workshop</div>
                                <div class="text-sm text-gray-500">Join our free investor education workshop</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">2023-10-28</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3 edit-notice-btn">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 delete-notice-btn">
                                    <i class="fas fa-trash"></i> 
                                </button>
                            </td>
                        </tr>
                    </tbody> 
                </table>
                <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Previous</a>
                        <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Next</a>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">4</span> of <span class="font-medium">12</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="#" aria-current="page" class="z-10 bg-primary border-primary text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">1</a>
                                <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">2</a>
                                <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">3</a>
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Notice Modal -->
    <div id="notice-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold" id="modal-title">Add New Notice</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="notice-form" class="p-6">
                <input type="hidden" id="notice-id" value="">
                <div class="mb-4">
                    <label for="notice-title" class="block text-gray-700 text-sm font-medium mb-2">Title</label>
                    <input type="text" id="notice-title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
                <div class="mb-4">
                    <label for="notice-description" class="block text-gray-700 text-sm font-medium mb-2">Description</label>
                    <textarea id="notice-description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="notice-date" class="block text-gray-700 text-sm font-medium mb-2">Date</label>
                    <input type="date" id="notice-date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
                <div class="mb-4">
                    <label for="notice-status" class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                    <select id="notice-status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancel-notice" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">Save Notice</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold">Confirm Deletion</h3>
                <button id="close-delete-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-6">Are you sure you want to delete this notice? This action cannot be undone.</p>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancel-delete" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">Cancel</button>
                    <button type="button" id="confirm-delete" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        const toggleSidebar = document.getElementById('toggle-sidebar');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            const isCollapsed = sidebar.classList.contains('collapsed');
            toggleSidebar.innerHTML = isCollapsed ? '<i class="fas fa-chevron-right"></i>' : '<i class="fas fa-chevron-left"></i>';
        });

        // Notice Modal Handling
        const addNoticeBtn = document.getElementById('add-notice-btn');
        const noticeModal = document.getElementById('notice-modal');
        const closeModal = document.getElementById('close-modal');
        const cancelNotice = document.getElementById('cancel-notice');
        const noticeForm = document.getElementById('notice-form');
        const modalTitle = document.getElementById('modal-title');
        const noticeId = document.getElementById('notice-id');
        const noticeTitle = document.getElementById('notice-title');
        const noticeDescription = document.getElementById('notice-description');
        const noticeDate = document.getElementById('notice-date');
        const noticeStatus = document.getElementById('notice-status');
        const editNoticeBtns = document.querySelectorAll('.edit-notice-btn');
        const deleteNoticeBtns = document.querySelectorAll('.delete-notice-btn');
        const deleteModal = document.getElementById('delete-modal');
        const closeDeleteModal = document.getElementById('close-delete-modal');
        const cancelDelete = document.getElementById('cancel-delete');
        const confirmDelete = document.getElementById('confirm-delete');

        // Open modal for adding new notice
        addNoticeBtn.addEventListener('click', () => {
            modalTitle.textContent = 'Add New Notice';
            noticeId.value = '';
            noticeTitle.value = '';
            noticeDescription.value = '';
            noticeDate.value = '';
            noticeStatus.value = 'active';
            noticeModal.classList.remove('hidden');
        });

        // Open modal for editing notice
        editNoticeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // In a real app, you would fetch the notice data from the server
                // Here we're just simulating with dummy data
                const row = btn.closest('tr');
                const title = row.querySelector('div.text-sm.font-medium').textContent;
                const description = row.querySelector('div.text-sm.text-gray-500').textContent;
                const date = row.querySelector('td:nth-child(2) div').textContent;
                const status = row.querySelector('span').textContent.toLowerCase();
                
                modalTitle.textContent = 'Edit Notice';
                noticeId.value = '123'; // This would be the actual notice ID
                noticeTitle.value = title;
                noticeDescription.value = description;
                noticeDate.value = date;
                noticeStatus.value = status;
                noticeModal.classList.remove('hidden');
            });
        });

        // Delete notice
        deleteNoticeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                deleteModal.classList.remove('hidden');
                // In a real app, you would set the notice ID to be deleted
            });
        });

        // Close modals
        closeModal.addEventListener('click', () => noticeModal.classList.add('hidden'));
        cancelNotice.addEventListener('click', () => noticeModal.classList.add('hidden'));
        closeDeleteModal.addEventListener('click', () => deleteModal.classList.add('hidden'));
        cancelDelete.addEventListener('click', () => deleteModal.classList.add('hidden'));

        // Confirm delete
        confirmDelete.addEventListener('click', () => {
            // In a real app, you would send a request to delete the notice
            alert('Notice deleted successfully!');
            deleteModal.classList.add('hidden');
            // Reload or remove the notice from the table
        });

        // Form submission
        noticeForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // In a real app, you would send the form data to the server
            const formData = {
                id: noticeId.value,
                title: noticeTitle.value,
                description: noticeDescription.value,
                date: noticeDate.value,
                status: noticeStatus.value
            };
            
            console.log('Form submitted:', formData);
            alert(noticeId.value ? 'Notice updated successfully!' : 'Notice added successfully!');
            noticeModal.classList.add('hidden'); 
            
            // Reload or update the table
        });

        // Close modals when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === noticeModal) {
                noticeModal.classList.add('hidden');
            }
            if (e.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });
    </script>
</body>
</html>