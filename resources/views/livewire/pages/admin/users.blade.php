<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Manajemen User</h1>
    <div class="bg-base-100 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-base-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->getRoleNames()->join(', ') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
