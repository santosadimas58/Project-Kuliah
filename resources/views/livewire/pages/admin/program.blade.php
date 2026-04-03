<div>
    <x-header title="Program" subtitle="Manajemen data program" separator>
        <x-slot:actions>
            <x-button label="+ Tambah Program" wire:click="openModal" class="btn-primary" icon="o-plus" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Program</th>
                        <th>Jalur</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $program)
                    <tr>
                        <td>{{ $program->kode_program }}</td>
                        <td>{{ $program->nama_program }}</td>
                        <td>{{ $program->jalur }}</td>
                        <td>
                            <x-badge :value="$program->status" class="{{ $program->status === 'Aktif' ? 'badge-success' : ($program->status === 'Nonaktif' ? 'badge-error' : 'badge-warning') }}" />
                        </td>
                        <td class="flex gap-2">
                            <x-button label="Edit" wire:click="edit({{ $program->id }})" class="btn-sm btn-info" icon="o-pencil" />
                            <x-button label="Hapus" wire:click="delete({{ $program->id }})" wire:confirm="Yakin ingin menghapus?" class="btn-sm btn-error" icon="o-trash" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8">
                            <x-icon name="o-archive-box" class="w-12 h-12 mx-auto opacity-30 mb-2" />
                            <p class="opacity-50">Belum ada data program.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    <x-modal wire:model="showModal" title="{{ $editMode ? 'Edit Program' : 'Tambah Program Baru' }}">
        <x-input label="Kode Program" wire:model="kode_program" disabled />
        <x-input label="Nama Program" wire:model="nama_program" placeholder="Masukkan nama program" class="mt-3" />
        @error('nama_program') <span class="text-error text-xs">{{ $message }}</span> @enderror

        <x-textarea label="Deskripsi" wire:model="deskripsi" placeholder="Masukkan deskripsi program" class="mt-3" />

        <x-select label="Jalur" wire:model="jalur" class="mt-3" :options="[
            ['id' => 'Jalur A', 'name' => 'Jalur A'],
            ['id' => 'Jalur B', 'name' => 'Jalur B'],
            ['id' => 'Jalur C', 'name' => 'Jalur C'],
        ]" placeholder="Pilih jalur" />
        @error('jalur') <span class="text-error text-xs">{{ $message }}</span> @enderror

        <x-select label="Status" wire:model="status" class="mt-3" :options="[
            ['id' => 'Aktif', 'name' => 'Aktif'],
            ['id' => 'Nonaktif', 'name' => 'Nonaktif'],
            ['id' => 'Pending', 'name' => 'Pending'],
        ]" placeholder="Pilih status" />
        @error('status') <span class="text-error text-xs">{{ $message }}</span> @enderror

        <x-slot:actions>
            <x-button label="Batal" wire:click="closeModal" icon="o-x-mark" />
            <x-button label="Simpan" wire:click="save" class="btn-primary" icon="o-check" />
        </x-slot:actions>
    </x-modal>
</div>
