<div>
    <x-header title="Admin Dashboard" subtitle="Selamat datang, {{ auth()->user()->name }}!" separator />

    {{-- Stats Row 1: Core --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <x-card>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-primary/10 rounded-lg">
                    <x-icon name="o-users" class="w-6 h-6 text-primary" />
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                    <p class="text-xs opacity-50">Total Pengguna</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-secondary/10 rounded-lg">
                    <x-icon name="o-shield-check" class="w-6 h-6 text-secondary" />
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $totalRoles }}</p>
                    <p class="text-xs opacity-50">Total Roles</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-accent/10 rounded-lg">
                    <x-icon name="o-archive-box" class="w-6 h-6 text-accent" />
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $totalPrograms }}</p>
                    <p class="text-xs opacity-50">Total Program Studi</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-warning/10 rounded-lg">
                    <x-icon name="o-cube" class="w-6 h-6 text-warning" />
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $totalInventory }}</p>
                    <p class="text-xs opacity-50">Inventaris</p>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Stats Row 2: Academic --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <x-card>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-success/10 rounded-lg">
                    <x-icon name="o-academic-cap" class="w-6 h-6 text-success" />
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $totalTeachers }}</p>
                    <p class="text-xs opacity-50">Dosen Aktif</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-info/10 rounded-lg">
                    <x-icon name="o-book-open" class="w-6 h-6 text-info" />
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $totalSubjects }}</p>
                    <p class="text-xs opacity-50">Mata Kuliah</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-primary/10 rounded-lg">
                    <x-icon name="o-calendar" class="w-6 h-6 text-primary" />
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $totalSchedules }}</p>
                    <p class="text-xs opacity-50">Jadwal Aktif</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <div class="p-3 bg-error/10 rounded-lg">
                    <x-icon name="o-clipboard-document" class="w-6 h-6 text-error" />
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $totalAssignments }}</p>
                    <p class="text-xs opacity-50">Tugas Aktif</p>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Recent Data --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Recent Users --}}
        <x-card title="Pengguna Terbaru" icon="o-user-plus">
            @forelse($recentUsers as $user)
            <div class="flex items-center justify-between py-2 border-b border-base-200 last:border-0">
                <div class="flex items-center gap-3">
                    <div class="avatar placeholder">
                        <div class="bg-primary text-primary-content rounded-full w-8">
                            <span class="text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ $user->name }}</p>
                        <p class="text-xs opacity-50">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    @foreach($user->getRoleNames() as $role)
                        <x-badge :value="$role === 'program' ? 'Staff Prodi' : $role" class="{{ $role === 'admin' ? 'badge-primary' : 'badge-secondary' }} badge-sm" />
                    @endforeach
                    <p class="text-xs opacity-40 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-center opacity-40 py-4 text-sm">Belum ada pengguna.</p>
            @endforelse
            <div class="mt-3">
                <a href="/admin/users">
                    <x-button label="Lihat Semua Pengguna" icon="o-arrow-right" class="btn-sm btn-ghost w-full" />
                </a>
            </div>
        </x-card>

        {{-- Recent Programs --}}
        <x-card title="Program Studi Terbaru" icon="o-archive-box">
            @forelse($recentPrograms as $program)
            <div class="flex items-center justify-between py-2 border-b border-base-200 last:border-0">
                <div>
                    <p class="font-medium text-sm">{{ $program->nama_program }}</p>
                    <p class="text-xs opacity-50">{{ $program->kode_program }} · {{ $program->jalur ?? '-' }}</p>
                </div>
                <x-badge
                    :value="$program->status"
                    class="{{
                        $program->status === 'Aktif' ? 'badge-success' :
                        ($program->status === 'Pending' ? 'badge-warning' : 'badge-error')
                    }} badge-sm"
                />
            </div>
            @empty
            <p class="text-center opacity-40 py-4 text-sm">Belum ada program studi.</p>
            @endforelse
            <div class="mt-3">
                <a href="/admin/program">
                    <x-button label="Lihat Semua Program Studi" icon="o-arrow-right" class="btn-sm btn-ghost w-full" />
                </a>
            </div>
        </x-card>
    </div>
</div>
