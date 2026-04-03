<div>
    <x-header title="Manajemen User" subtitle="Kelola user dan role" separator>
        <x-slot:actions>
            <x-button label="+ Tambah User" wire:click="openModal" class="btn-primary" icon="o-plus" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <div class="overflow-x-auto">
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
                        <td>
                            <div class="flex items-center gap-3">
                                <x-avatar :placeholder="strtoupper(substr($user->name, 0, 1))" class="w-8 h-8" />
                                {{ $user->name }}
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->getRoleNames() as $role)
                            <x-badge :value="$role" class="{{ $role === 'admin' ? 'badge-primary' : 'badge-secondary' }}" />
                            @endforeach
                        </td>
                        <td class="flex gap-2">
                            <x-button label="Edit" wire:click="edit({{ $user->id }})" class="btn-sm btn-info" icon="o-pencil" />
                            <x-button label="Hapus" wire:click="delete({{ $user->id }})" wire:confirm="Yakin ingin menghapus user ini?" class="btn-sm btn-error" icon="o-trash" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8">
                            <x-icon name="o-users" class="w-12 h-12 mx-auto opacity-30 mb-2" />
                            <p class="opacity-50">Belum ada data user.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

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
            <x-button label="Batal" wire:click="closeModal" icon="o-x-mark" />
            <x-button label="Simpan" wire:click="save" class="btn-primary" icon="o-check" />
        </x-slot:actions>
    </x-modal>
</div>
