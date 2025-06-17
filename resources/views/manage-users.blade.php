<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry - Manage Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/manage-users.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="{{ route('admin.dashboard') }}" class="logo"> <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.orders') }}">Manage Orders</a></li>
                <li><a href="{{ route('admin.users') }}" class="active">Manage Users</a></li>
            </ul>
            <div class="user-menu">
                <div class="dropdown" id="userDropdown">
                    <div class="user-avatar" id="userAvatarToggle"> <img
                            src="https://randomuser.me/api/portraits/men/46.jpg" alt="Admin Avatar">
                    </div>
                    <div class="dropdown-content" id="userDropdownContent"> <a
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.orders') }}"><i class="fas fa-tasks"></i> Manage Orders</a></li>
                <li><a href="{{ route('admin.users') }}" class="active"><i class="fas fa-users-cog"></i> Manage
                        Users</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>User Management</h1>
                <a href="#" class="quick-action-btn" id="addNewUserBtnOpenModal"><i class="fas fa-user-plus"></i>
                    Add New User</a>
            </div>

            <div class="search-filter-bar">
                <form action="{{ route('admin.users') }}" method="GET" class="search-form">
                    <input type="text" name="search" id="userSearchInput"
                        placeholder="Search by name, email, or phone..." value="{{ $searchQuery ?? '' }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                    @if ($searchQuery)
                        <a href="{{ route('admin.users') }}" class="btn btn-outline">Reset</a>
                    @endif
                </form>
            </div>

            <div class="data-table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        @forelse ($users as $index => $user)
                            <tr>
                                {{-- $index + 1 hanya berlaku untuk halaman pertama jika tidak ada paginasi nomor halaman --}}
                                <td>{{ $index + 1 }}</td>
                                <td data-label="Name">{{ $user['name'] ?? '-' }}</td>
                                <td data-label="Email">{{ $user['email'] ?? '-' }}</td>
                                <td data-label="Phone">{{ $user['phone'] ?? '-' }}</td>
                                {{-- Asumsi 'address' adalah field di dokumen user atau diisi di controller --}}
                                <td data-label="Address">{{ $user['address'] ?? '-' }}</td>
                                <td data-label="Joined Date">{{ $user['joinedDate'] ?? '-' }}</td>
                                <td>
                                    <button class="action-btn edit-user" data-id="{{ $user['id'] ?? '' }}"
                                        data-name="{{ $user['name'] ?? '' }}" data-email="{{ $user['email'] ?? '' }}"
                                        data-phone="{{ $user['phone'] ?? '' }}" title="Edit User"><i
                                            class="fas fa-edit"></i></button>
                                    <form action="{{ route('admin.users.destroy', $user['id']) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-user" title="Delete User"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center;">Tidak ada pengguna ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>



        </main>
    </div>

    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New User</h2>
                <span class="close-btn" id="closeAddUserModalBtn">&times;</span>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="name-fields">
                        <div class="form-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first_name" class="form-control"
                                placeholder="Enter your first name" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last_name" class="form-control"
                                placeholder="Enter your last name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control"
                            placeholder="Enter your phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Create a password" required>
                        <div class="password-strength">
                            <div class="password-strength-bar"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-register">Create Account</button>
                </form>
            </div>
        </div>
    </div>

    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit User</h2>
                <span class="close-btn" id="closeEditUserModalBtn">&times;</span>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-user-id" name="user_id">
                    <div class="name-fields">
                        <div class="form-group">
                            <label for="edit-first-name">First Name</label>
                            <input type="text" id="edit-first-name" name="first_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit-last-name">Last Name</label>
                            <input type="text" id="edit-last-name" name="last_name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit-email">Email Address</label>
                        <input type="email" id="edit-email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-phone">Phone Number</label>
                        <input type="tel" id="edit-phone" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-address">Address</label>
                        <input type="text" id="edit-address" name="address" class="form-control"
                            placeholder="Enter your address">
                    </div>
                    <div class="form-group">
                        <label for="edit-password">Password (leave blank if not changing)</label>
                        <input type="password" id="edit-password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ... (Kode Modal yang sudah ada) ...
            const addUserModal = document.getElementById('addUserModal');
            const openModalBtn = document.getElementById('addNewUserBtnOpenModal');
            const closeModalBtn = document.getElementById('closeAddUserModalBtn');
            // const cancelAddUserBtn = document.getElementById('cancelAddUserBtn'); // Tidak ada di HTML
            const editUserModal = document.getElementById('editUserModal');
            const closeEditUserModalBtn = document.getElementById('closeEditUserModalBtn');
            const editUserForm = document.getElementById('editUserForm');
            const userSearchInput = document.getElementById('userSearchInput');
            const usersTableBody = document.getElementById('usersTableBody');
            const tableHeaders = document.querySelectorAll('.data-table-container th[data-sort]'); // Akan dihapus

            // Event Listeners untuk Modal Tambah User
            if (openModalBtn) {
                openModalBtn.addEventListener('click', () => {
                    if (addUserModal) addUserModal.style.display = 'block';
                });
            }
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', () => {
                    if (addUserModal) addUserModal.style.display = 'none';
                });
            }
            // if (cancelAddUserBtn) { // Tidak ada di HTML
            //     cancelAddUserBtn.addEventListener('click', () => {
            //         if (addUserModal) addUserModal.style.display = 'none';
            //     });
            // }
            if (addUserModal) {
                window.addEventListener('click', (event) => {
                    if (event.target === addUserModal) {
                        addUserModal.style.display = 'none';
                    }
                });
            }

            // Event Listeners untuk Modal Edit User
            if (closeEditUserModalBtn) {
                closeEditUserModalBtn.addEventListener('click', () => {
                    if (editUserModal) editUserModal.style.display = 'none';
                });
            }
            if (editUserModal) {
                window.addEventListener('click', (event) => {
                    if (event.target === editUserModal) {
                        editUserModal.style.display = 'none';
                    }
                });
            }


            if (usersTableBody) {
                usersTableBody.addEventListener('click', function(event) {
                    const targetButton = event.target.closest('button.action-btn');
                    if (!targetButton) return;

                    const userId = targetButton.dataset.id; // User ID langsung dari data-id
                    const row = targetButton.closest('tr');

                    if (targetButton.classList.contains('edit-user')) {
                        // Ambil data dari data-attribute tombol itu sendiri
                        const name = targetButton.dataset.name;
                        const email = targetButton.dataset.email;
                        const phone = targetButton.dataset.phone;

                        // Pisahkan nama jadi first dan last name
                        const nameParts = name.split(' ');
                        const firstName = nameParts.slice(0, -1).join(' ') || nameParts[0];
                        const lastName = nameParts.length > 1 ? nameParts.slice(-1).join(' ') : '';

                        // Isi form edit
                        document.getElementById('edit-user-id').value = userId;
                        document.getElementById('edit-first-name').value = firstName;
                        document.getElementById('edit-last-name').value = lastName;
                        document.getElementById('edit-email').value = email;
                        document.getElementById('edit-phone').value = phone;
                        document.getElementById('edit-password').value = ''; // Selalu kosongkan password

                        // Set action form ke route update
                        editUserForm.action = `/admin/users/${userId}`;

                        // Tampilkan modal
                        editUserModal.style.display = 'block';
                    }
                });
            }

            // Client-Side Search/Filter Logic (ini akan dihapus jika menggunakan server-side search)
            // Jika Anda hanya ingin client-side search pada halaman yang sedang ditampilkan,
            // maka kode ini bisa dipertahankan. Tapi untuk pencarian data di seluruh koleksi,
            // server-side search (yang sudah kita terapkan di controller) lebih baik.
            // Jika tetap ingin client-side: Pastikan data 'users' yang di-loop di blade adalah semua data
            // atau semua data di halaman saat ini.
            if (userSearchInput && usersTableBody) {
                userSearchInput.addEventListener('keyup', function() {
                    // Kode ini hanya akan memfilter data yang SUDAH ADA di tabel
                    // Untuk search seluruh data di Firestore, Anda harus submit form ke server
                    // atau menggunakan JS SDK Firebase langsung (tapi tidak disarankan untuk admin panel)
                    const searchTerm = this.value.toLowerCase();
                    const rows = usersTableBody.getElementsByTagName('tr');
                    Array.from(rows).forEach(row => {
                        const nameText = row.querySelector('td[data-label="Name"]')?.textContent
                            .toLowerCase() || '';
                        const emailText = row.querySelector('td[data-label="Email"]')?.textContent
                            .toLowerCase() || '';
                        const phoneText = row.querySelector('td[data-label="Phone"]')?.textContent
                            .toLowerCase() || '';

                        if (nameText.includes(searchTerm) || emailText.includes(searchTerm) ||
                            phoneText.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

        });
        document.addEventListener('DOMContentLoaded', function() {
            const userAvatarToggle = document.getElementById('userAvatarToggle');
            const userDropdownContent = document.getElementById('userDropdownContent');
            const userDropdown = document.getElementById('userDropdown'); // Tambahkan ini

            if (userAvatarToggle && userDropdownContent) {
                userAvatarToggle.addEventListener('click', function() {
                    // Toggle class 'show' untuk menampilkan/menyembunyikan dropdown
                    userDropdownContent.classList.toggle('show');
                });

                // Optional: Tutup dropdown saat klik di luar area dropdown
                document.addEventListener('click', function(event) {
                    // Periksa apakah klik terjadi di luar elemen .dropdown
                    if (userDropdown && !userDropdown.contains(event.target)) {
                        if (userDropdownContent.classList.contains('show')) {
                            userDropdownContent.classList.remove('show');
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
