<div>
    <x-header title="Data Guru" subtitle="Manajemen data guru" separator>
        <x-slot:actions>
            <x-button label="+ Tambah Guru" wire:click="openModal" class="btn-primary" icon="o-plus" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Mata Pelajaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->kode_guru }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <x-avatar :placeholder="strtoupper(substr($teacher->nama, 0, 1))" class="w-8 h-8" />
                                {{ $teacher->nama }}
                            </div>
                        </td>
                        <td>{{ $teacher->email }}</td>
                        <td>{{ $teacher->no_hp ?? '-' }}</td>
                        <td>{{ $teacher->mata_pelajaran ?? '-' }}</td>
                        <td>
                            <x-badge :value="$teacher->status" class="{{ $teacher->status === 'Aktif' ? 'badge-success' : 'badge-error' }}" />
                        </td>
                        <td class="flex gap-2">
                            <x-button label="Edit" wire:click="edit({{ $teacher->id }})" class="btn-sm btn-info" icon="o-pencil" />
                            <x-button label="Hapus" wire:click="delete({{ $teacher->id }})" wire:confirm="Yakin ingin menghapus?" class="btn-sm btn-error" icon="o-trash" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8">
                            <x-icon name="o-academic-cap" class="w-12 h-12 mx-auto opacity-30 mb-2" />
                            <p class="opacity-50">Belum ada data guru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    <x-modal wire:model="showModal" title="{{ $editMode ? 'Edit Guru' : 'Tambah Guru Baru' }}">
        <x-input label="Kode Guru" wire:model="kode_guru" disabled />
        <x-input label="Nama" wire:model="nama" placeholder="Masukkan nama guru" class="mt-3" />
        @error('nama') <span class="text-error text-xs">{{ $message }}</span> @enderror

        <x-input label="Email" wire:model="email" type="email" placeholder="Masukkan email" class="mt-3" />
        @error('email') <span class="text-error text-xs">{{ $message }}</span> @enderror

        <x-input label="No. HP" wire:model="no_hp" placeholder="Masukkan no. HP" class="mt-3" />
        <x-input label="Mata Pelajaran" wire:model="mata_pelajaran" placeholder="Masukkan mata pelajaran" class="mt-3" />

        <x-select label="Status" wire:model="status" class="mt-3" :options="[
            ['id' => 'Aktif', 'name' => 'Aktif'],
            ['id' => 'Nonaktif', 'name' => 'Nonaktif'],
        ]" />

        <x-slot:actions>
            <x-button label="Batal" wire:click="closeModal" icon="o-x-mark" />
            <x-button label="Simpan" wire:click="save" class="btn-primary" icon="o-check" />
        </x-slot:actions>
    </x-modal>
</div>
