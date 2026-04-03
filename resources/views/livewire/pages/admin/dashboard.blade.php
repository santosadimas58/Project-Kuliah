<div>
    <x-header title="Admin Dashboard" subtitle="Selamat datang, {{ auth()->user()->name }}!" separator />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <x-stat
            title="Total Users"
            value="{{ $totalUsers }}"
            icon="o-users"
            color="text-primary"
            description="Terdaftar di sistem"
        />
        <x-stat
            title="Total Roles"
            value="{{ $totalRoles }}"
            icon="o-shield-check"
            color="text-secondary"
            description="Role tersedia"
        />
        <x-stat
            title="Total Program"
            value="{{ $totalPrograms }}"
            icon="o-archive-box"
            color="text-accent"
            description="Program aktif"
        />
    </div>
</div>
