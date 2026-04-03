<div>
    <x-header title="Jadwal" subtitle="Manajemen jadwal pelajaran" separator>
        <x-slot:actions>
            <x-button label="+ Tambah Jadwal" wire:click="openModal" class="btn-primary" icon="o-plus" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr><th>Hari</th><th>Jam</th><th>Mata Pelajaran</th><th>Guru</th><th>Ruangan</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->hari }}</td>
                        <td>{{ $schedule->jam_mulai }} - {{ $schedule->jam_selesai }}</td>
                        <td>{{ $schedule->mata_pelajaran }}</td>
                        <td>{{ $schedule->guru }}</td>
                        <td>{{ $schedule->ruangan ?? '-' }}</td>
                        <td><x-badge :value="$schedule->status" class="{{ $schedule->status === 'Aktif' ? 'badge-success' : 'badge-error' }}" /></td>
                        <td class="flex gap-2">
                            <x-button label="Edit" wire:click="edit({{ $schedule->id }})" class="btn-sm btn-info" icon="o-pencil" />
                            <x-button label="Hapus" wire:click="delete({{ $schedule->id }})" wire:confirm="Yakin?" class="btn-sm btn-error" icon="o-trash" />
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-8"><x-icon name="o-calendar" class="w-12 h-12 mx-auto opacity-30 mb-2" /><p class="opacity-50">Belum ada jadwal.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
    <x-modal wire:model="showModal" title="{{ $editMode ? 'Edit Jadwal' : 'Tambah Jadwal' }}">
        <x-select label="Hari" wire:model="hari" :options="[
            ['id'=>'Senin','name'=>'Senin'],['id'=>'Selasa','name'=>'Selasa'],
            ['id'=>'Rabu','name'=>'Rabu'],['id'=>'Kamis','name'=>'Kamis'],
            ['id'=>'Jumat','name'=>'Jumat'],['id'=>'Sabtu','name'=>'Sabtu'],
        ]" placeholder="Pilih hari" />
        @error('hari') <span class="text-error text-xs">{{ $message }}</span> @enderror
        <x-input label="Jam Mulai" wire:model="jam_mulai" type="time" class="mt-3" />
        @error('jam_mulai') <span class="text-error text-xs">{{ $message }}</span> @enderror
        <x-input label="Jam Selesai" wire:model="jam_selesai" type="time" class="mt-3" />
        <x-input label="Mata Pelajaran" wire:model="mata_pelajaran" placeholder="Masukkan mata pelajaran" class="mt-3" />
        @error('mata_pelajaran') <span class="text-error text-xs">{{ $message }}</span> @enderror
        <x-input label="Guru" wire:model="guru" placeholder="Masukkan nama guru" class="mt-3" />
        @error('guru') <span class="text-error text-xs">{{ $message }}</span> @enderror
        <x-input label="Ruangan" wire:model="ruangan" placeholder="Masukkan ruangan" class="mt-3" />
        <x-select label="Status" wire:model="status" class="mt-3" :options="[['id'=>'Aktif','name'=>'Aktif'],['id'=>'Nonaktif','name'=>'Nonaktif']]" />
        <x-slot:actions>
            <x-button label="Batal" wire:click="closeModal" icon="o-x-mark" />
            <x-button label="Simpan" wire:click="save" class="btn-primary" icon="o-check" />
        </x-slot:actions>
    </x-modal>
</div>
