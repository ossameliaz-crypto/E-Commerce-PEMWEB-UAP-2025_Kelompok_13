<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800" x-data="userManager()">

    <div class="flex">
        
        <!-- SIDEBAR (Menu User Aktif) -->
        <aside class="w-72 bg-white border-r border-gray-200 min-h-screen hidden md:block fixed z-20 shadow-sm">
            <div class="h-24 flex items-center px-8 border-b border-gray-100">
                <span class="text-3xl mr-3">🛡️</span>
                <div>
                    <span class="font-extrabold text-gray-800 text-lg block leading-none">Admin Panel</span>
                    <span class="text-xs text-orange-500 font-bold tracking-widest uppercase">Super User</span>
                </div>
            </div>
            
            <nav class="p-6 space-y-2">
                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition">
                    <span class="grayscale hover:grayscale-0 transition">📊</span> Dashboard
                </a>
                
                <!-- MENU AKTIF -->
                <a href="{{ route('admin.users') }}" class="flex items-center gap-4 px-4 py-3.5 bg-orange-50 text-orange-700 font-bold rounded-xl border border-orange-100 shadow-sm transition">
                    <span>👥</span> Kelola User
                </a>
                
                <a href="{{ route('admin.stores') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-bold rounded-xl transition group">
                    <span class="grayscale group-hover:grayscale-0 transition">🏪</span> Kelola Toko
                </a>

                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mt-8 mb-2">Lainnya</p>
                <a href="{{ url('/') }}" class="flex items-center gap-4 px-4 py-3.5 text-gray-400 hover:text-orange-600 font-bold rounded-xl transition hover:bg-orange-50">
                    <span>⬅️</span> Kembali ke Web
                </a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 md:ml-72 p-6 md:p-10">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Daftar Pengguna</h1>
                    <p class="text-gray-500 mt-1">Manajemen akun member dan seller.</p>
                </div>
                
                <div class="flex gap-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" x-model="search" placeholder="Cari user..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none w-64">
                        <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                    </div>

                    <!-- Tombol Tambah User -->
                    <button @click="openModal()" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1 flex items-center gap-2">
                        <span>+</span> Tambah User
                    </button>
                </div>
            </div>

            <!-- TABEL USER -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden min-h-[400px]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-orange-50/50 text-gray-500 text-xs uppercase font-bold tracking-wider">
                            <tr>
                                <th class="px-8 py-5">Nama User</th>
                                <th class="px-6 py-5">Email</th>
                                <th class="px-6 py-5">Role</th>
                                <th class="px-6 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            
                            <template x-for="user in filteredUsers" :key="user.id">
                                <tr class="hover:bg-orange-50/30 transition group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold border" 
                                                 :class="user.avatarColor + ' ' + user.avatarBorder">
                                                <span x-text="user.initials"></span>
                                            </div>
                                            <span class="font-bold text-gray-800" x-text="user.name"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-gray-600" x-text="user.email"></td>
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold"
                                              :class="{
                                                  'bg-red-100 text-red-700': user.role === 'admin',
                                                  'bg-green-100 text-green-700': user.role === 'seller',
                                                  'bg-blue-100 text-blue-700': user.role === 'member'
                                              }" 
                                              x-text="capitalize(user.role)">
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex items-center gap-1 font-bold text-xs"
                                              :class="user.status === 'Active' ? 'text-green-600' : 'text-red-600'">
                                            <span class="w-2 h-2 rounded-full" :class="user.status === 'Active' ? 'bg-green-500' : 'bg-red-500'"></span>
                                            <span x-text="user.status"></span>
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex justify-end gap-2" x-show="user.role !== 'admin'">
                                            <button @click="editUser(user)" class="text-blue-500 hover:text-blue-700 font-bold text-xs border border-blue-200 px-3 py-1 rounded-lg hover:bg-blue-50 transition">
                                                Edit
                                            </button>
                                            <button @click="deleteUser(user.id)" class="text-red-500 hover:text-red-700 font-bold text-xs border border-red-200 px-3 py-1 rounded-lg hover:bg-red-50 transition">
                                                Hapus
                                            </button>
                                        </div>
                                        <div x-show="user.role === 'admin'" class="text-xs text-gray-400 italic">Super Admin</div>
                                    </td>
                                </tr>
                            </template>

                            <tr x-show="filteredUsers.length === 0">
                                <td colspan="5" class="px-8 py-10 text-center text-gray-400">Tidak ada user ditemukan.</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- Pagination Dummy -->
                <div class="p-4 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400">
                    <span x-text="'Menampilkan ' + filteredUsers.length + ' user'"></span>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 border rounded hover:bg-gray-50 disabled:opacity-50" disabled>Previous</button>
                        <button class="px-3 py-1 border rounded hover:bg-gray-50 disabled:opacity-50" disabled>Next</button>
                    </div>
                </div>
            </div>

        </main>

        <!-- MODAL EDIT/ADD USER -->
        <div x-show="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak x-transition>
            <div @click.away="closeModal()" class="bg-white rounded-[2rem] w-full max-w-md p-8 shadow-2xl relative border-4 border-orange-100">
                <button @click="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 font-bold bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">✕</button>

                <h3 class="text-2xl font-extrabold text-gray-800 mb-6" x-text="editMode ? 'Edit User' : 'Tambah User'"></h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" x-model="form.name" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" x-model="form.email" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Role</label>
                        <select x-model="form.role" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none bg-white">
                            <option value="member">Member</option>
                            <option value="seller">Seller</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                        <select x-model="form.status" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none bg-white">
                            <option value="Active">Active</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>

                    <button @click="saveUser()" class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition shadow-lg mt-4">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- ALPINE.JS LOGIC -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('userManager', () => ({
                search: '',
                isModalOpen: false,
                editMode: false,
                
                // Data Dummy User Realistis
                users: [
                    { id: 1, name: 'Admin Pusat', email: 'admin@buildateddy.com', role: 'admin', status: 'Active', initials: 'AP', avatarColor: 'bg-red-100 text-red-600', avatarBorder: 'border-red-200' },
                    { id: 2, name: 'Budi Santoso', email: 'budi.santoso@example.com', role: 'seller', status: 'Active', initials: 'BS', avatarColor: 'bg-blue-100 text-blue-600', avatarBorder: 'border-blue-200' },
                    { id: 3, name: 'Ossa Putri', email: 'ossa.putri@example.com', role: 'member', status: 'Active', initials: 'OP', avatarColor: 'bg-orange-100 text-orange-600', avatarBorder: 'border-orange-200' },
                    { id: 4, name: 'Dewi Lestari', email: 'dewi.lestari@example.com', role: 'member', status: 'Suspended', initials: 'DL', avatarColor: 'bg-purple-100 text-purple-600', avatarBorder: 'border-purple-200' },
                    { id: 5, name: 'Rizky Ramadhan', email: 'rizky.r@example.com', role: 'seller', status: 'Active', initials: 'RR', avatarColor: 'bg-green-100 text-green-600', avatarBorder: 'border-green-200' },
                ],

                form: { id: null, name: '', email: '', role: 'member', status: 'Active' },

                get filteredUsers() {
                    if (this.search === '') return this.users;
                    return this.users.filter(user => 
                        user.name.toLowerCase().includes(this.search.toLowerCase()) || 
                        user.email.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                capitalize(str) {
                    return str.charAt(0).toUpperCase() + str.slice(1);
                },

                openModal() {
                    this.editMode = false;
                    this.form = { id: null, name: '', email: '', role: 'member', status: 'Active' };
                    this.isModalOpen = true;
                },

                editUser(user) {
                    this.editMode = true;
                    // Clone object agar tidak reaktif langsung saat edit
                    this.form = { ...user };
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                },

                saveUser() {
                    if (this.editMode) {
                        // Update existing user
                        let index = this.users.findIndex(u => u.id === this.form.id);
                        if (index !== -1) {
                            // Update visual properties based on name/role
                            let names = this.form.name.split(' ');
                            this.form.initials = names[0].charAt(0) + (names.length > 1 ? names[names.length - 1].charAt(0) : '');
                            
                            // Set color based on role (simple logic)
                            if (this.form.role === 'admin') {
                                this.form.avatarColor = 'bg-red-100 text-red-600';
                                this.form.avatarBorder = 'border-red-200';
                            } else if (this.form.role === 'seller') {
                                this.form.avatarColor = 'bg-green-100 text-green-600';
                                this.form.avatarBorder = 'border-green-200';
                            } else {
                                this.form.avatarColor = 'bg-blue-100 text-blue-600';
                                this.form.avatarBorder = 'border-blue-200';
                            }

                            this.users[index] = { ...this.form };
                            alert('Data user berhasil diperbarui!');
                        }
                    } else {
                        // Add new user (Simulation)
                        let newUser = { ...this.form, id: Date.now() };
                        // Generate initials & color for new user
                        let names = newUser.name.split(' ');
                        newUser.initials = (names[0]?.charAt(0) || 'U') + (names.length > 1 ? names[names.length - 1].charAt(0) : '');
                        newUser.avatarColor = 'bg-gray-100 text-gray-600';
                        newUser.avatarBorder = 'border-gray-200';
                        
                        this.users.push(newUser);
                        alert('User baru berhasil ditambahkan!');
                    }
                    this.closeModal();
                },

                deleteUser(id) {
                    if(confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                        this.users = this.users.filter(user => user.id !== id);
                        // Di real app, panggil fetch DELETE ke backend di sini
                    }
                }
            }));
        });
    </script>

</body>
</html>