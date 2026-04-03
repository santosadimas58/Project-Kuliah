<div>
    <x-header title="Tugas" subtitle="Manajemen data tugas" separator>
        <x-slot:actions>
            <x-button label="+ Tambah Tugas" wire:click="openModal" class="btn-primary" icon="o-plus" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr><th>Judul</th><th>Mata Pelajaran</th><th>Deadline</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->judul }}</td>
                        <td>{{ $assignment->mata_pelajaran }}</td>
                        <td>{{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}</td>
                        <td><x-badge :value="$assignment->status" class="{{ $assignment->status === 'Aktif' ? 'badge-success' : ($assignment->status === 'Selesai' ? 'badge-info' : 'badge-error') }}" /></td>
                        <td class="flex gap-2">
                            <x-button label="Edit" wire:click="edit({{ $assignment->id }})" class="btn-sm btn-info" icon="o-pencil" />
                            <x-button label="Hapus" wire:click="delete({{ $assignment->id }})" wire:confirm="Yakin?" class="btn-sm btn-error" icon="o-trash" />
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-8"><x-icon name="o-clipboard-document" class="w-12 h-12 mx-auto opacity-30 mb-2" /><p class="opacity-50">Belum ada tugas.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
    <x-modal wire:model="showModal" title="{{ $editMode ? 'Edit Tugas' : 'Tambah Tugas' }}">
        <x-input label="Judul" wire:model="judul" placeholder="Masukkan judul tugas" />
        @error('judul') <span class="text-error text-xs">{{ $message }}</span> @enderror
        <x-textarea label="Deskripsi" wire:model="deskripsi" placeholder="Masukkan deskripsi" class="mt-3" />
        <x-input label="Mata Pelajaran" wire:model="mata_pelajaran" placeholder="Masukkan mata pelajaran" class="mt-3" />
        @error('mata_pelajaran') <span class="text-error text-xs">{{ $message }}</span> @enderror
        <x-input label="Deadline" wire:model="deadline" type="date" class="mt-3" />
        @error('deadline') <span class="text-error text-xs">{{ $message }}</span> @enderror
        <x-select label="Status" wire:model="status" class="mt-3" :options="[['id'=>'Aktif','name'=>'Aktif'],['id'=>'Selesai','name'=>'Selesai'],['id'=>'Batal','name'=>'Batal']]" />
        <x-slot:actions>
            <x-button label="Batal" wire:click="closeModal" icon="o-x-mark" />
            <x-button label="Simpan" wire:click="save" class="btn-primary" icon="o-check" />
        </x-slot:actions>
    </x-modal>
</div>
