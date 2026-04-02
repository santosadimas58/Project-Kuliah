<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen User</h1>
        <x-button label="+ Tambah User" wire:click="openModal" class="btn-primary" />
    </div>

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->getRoleNames() as $role)
                        <span class="badge {{ $role === 'admin' ? 'badge-primary' : 'badge-secondary' }}">
                            {{ $role }}
                        </span>
                        @endforeach
                    </td>
                    <td class="flex gap-2">
                        <x-button label="Edit" wire:click="edit({{ $user->id }})" class="btn-sm btn-info" />
                        <x-button label="Hapus" wire:click="delete({{ $user->id }})" wire:confirm="Yakin ingin menghapus user ini?" class="btn-sm btn-error" />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-modal wire:model="showModal" title="{{ $editMode ? 'Edit User' : 'Tambah User Baru' }}">
        <x-input label="Nama" wire:model="name" placeholder="Masukkan nama" />
        @error('name') <span class="text-error text-xs">{{ $message }}</span> @enderror

        <x-input label="Email" wire:model="email" type="email" placeholder="Masukkan email" class="mt-3" />
        @error('email') <span class="text-error text-xs">{{ $message }}</span> @enderror

        <x-input label="{{ $editMode ? 'Password Baru (kosongkan jika tidak diubah)' : 'Password' }}" wire:model="password" type="password" placeholder="Masukkan password" class="mt-3" />
        @error('password') <span class="text-error text-xs">{{ $message }}</span> @enderror

        <x-select label="Role" wire:model="selectedRole" class="mt-3"
            :options="$roles->map(fn($r) => ['id' => $r->name, 'name' => ucfirst($r->name)])->toArray()"
            placeholder="Pilih role" />
        @error('selectedRole') <span class="text-error text-xs">{{ $message }}</span> @enderror

        <x-slot:actions>
            <x-button label="Batal" wire:click="closeModal" />
            <x-button label="Simpan" wire:click="save" class="btn-primary" />
        </x-slot:actions>
    </x-modal>
</div>
