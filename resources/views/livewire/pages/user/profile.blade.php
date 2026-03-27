<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Profile</h1>
    <div class="bg-base-100 rounded-lg shadow p-6">
        <div class="mb-4">
            <label class="text-gray-500 text-sm">Nama</label>
            <p class="font-bold">{{ auth()->user()->name }}</p>
        </div>
        <div class="mb-4">
            <label class="text-gray-500 text-sm">Email</label>
            <p class="font-bold">{{ auth()->user()->email }}</p>
        </div>
    </div>
</div>
