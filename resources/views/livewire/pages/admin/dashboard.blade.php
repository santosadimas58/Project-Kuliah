<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-base-100 rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Total Users</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalUsers }}</p>
        </div>
        <div class="bg-base-100 rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Total Roles</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalRoles }}</p>
        </div>
        <div class="bg-base-100 rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm">Logged in as</h3>
            <p class="text-xl font-bold mt-2">{{ auth()->user()->name }}</p>
        </div>
    </div>
</div>
