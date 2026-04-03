<div>
    <x-header title="Mata Pelajaran" subtitle="Manajemen data mata pelajaran" separator>
        <x-slot:actions>
            <x-button label="+ Tambah Mapel" wire:click="openModal" class="btn-primary" icon="o-plus" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr><th>Kode</th><th>Nama Mapel</th><th>Kategori</th><th>SKS</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                    <tr>
                        <td>{{ $subject->kode_mapel }}</td>
                        <td>{{ $subject->nama_mapel }}</td>
                        <td>{{ $subject->kategori ?? '-' }}</td>
                        <td>{{ $subject->sks }}</td>
                        <td><x-badge :value="$subject->status" class="{{ $subject->status === 'Aktif' ? 'badge-success' : 'badge-error' }}" /></td>
                        <td class="flex gap-2">
                            <x-button label="Edit" wire:click="edit({{ $subject->id }})" class="btn-sm btn-info" icon="o-pencil" />
                            <x-button label="Hapus" wire:click="delete({{ $subject->id }})" wire:confirm="Yakin?" class="btn-sm btn-error" icon="o-trash" />
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-8"><x-icon name="o-book-open" class="w-12 h-12 mx-auto opacity-30 mb-2" /><p class="opacity-50">Belum ada data mata pelajaran.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
    <x-modal wire:model="showModal" title="{{ $editMode ? 'Edit Mapel' : 'Tambah Mata Pelajaran' }}">
        <x-input label="Kode Mapel" wire:model="kode_mapel" disabled />
        <x-input label="Nama Mapel" wire:model="nama_mapel" placeholder="Masukkan nama mapel" class="mt-3" />
        @error('nama_mapel') <span class="text-error text-xs">{{ $message }}</span> @enderror
        <x-input label="Kategori" wire:model="kategori" placeholder="Masukkan kategori" class="mt-3" />
        <x-input label="SKS" wire:model="sks" type="number" min="1" class="mt-3" />
        @error('sks') <span class="text-error text-xs">{{ $message }}</span> @enderror
        <x-select label="Status" wire:model="status" class="mt-3" :options="[['id'=>'Aktif','name'=>'Aktif'],['id'=>'Nonaktif','name'=>'Nonaktif']]" />
        <x-slot:actions>
            <x-button label="Batal" wire:click="closeModal" icon="o-x-mark" />
            <x-button label="Simpan" wire:click="save" class="btn-primary" icon="o-check" />
        </x-slot:actions>
    </x-modal>
</div>
