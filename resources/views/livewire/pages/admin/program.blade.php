<div>
    <x-header title="Program Studi" subtitle="Manajemen data program studi universitas" separator>
        <x-slot:actions>
            <x-button label="+ Tambah Program Studi" wire:click="openModal" class="btn-primary" icon="o-plus" />
        </x-slot:actions>
    </x-header>
    <div class="flex flex-wrap gap-3 mb-4 items-center">
        <x-input
            placeholder="Cari kode atau nama program studi..."
            wire:model.live.debounce.300ms="search"
            icon="o-magnifying-glass"
            class="flex-1 min-w-[200px]"
        />
        <x-select
            placeholder="Semua Jenjang"
            wire:model.live="filterJalur"
            :options="[
                ['id' => 'S1', 'name' => 'S1 - Sarjana'],
                ['id' => 'S2', 'name' => 'S2 - Magister'],
                ['id' => 'S3', 'name' => 'S3 - Doktor'],
                ['id' => 'D3', 'name' => 'D3 - Diploma'],
                ['id' => 'D4', 'name' => 'D4 - Sarjana Terapan'],
            ]"
            class="w-44"
        />
        <x-select
            placeholder="Semua Status"
            wire:model.live="filterStatus"
            :options="[
                ['id' => 'Aktif',    'name' => 'Aktif'],
                ['id' => 'Nonaktif', 'name' => 'Nonaktif'],
                ['id' => 'Pending',  'name' => 'Pending'],
            ]"
            class="w-40"
        />
        <select wire:model.live="perPage" class="select select-bordered select-sm">
            <option value="5">5 / halaman</option>
            <option value="10">10 / halaman</option>
            <option value="25">25 / halaman</option>
        </select>
        @if($search || $filterStatus || $filterJalur)
        <x-button label="Reset" wire:click="resetFilter" class="btn-ghost btn-sm" icon="o-x-mark" />
        @endif
    </div>
    <x-card>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Prodi</th>
                        <th>Nama Program Studi</th>
                        <th>Deskripsi</th>
                        <th>Jenjang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $program)
                    <tr>
                        <td>{{ $programs->firstItem() + $loop->index }}</td>
                        <td><span class="font-mono text-sm">{{ $program->kode_program }}</span></td>
                        <td class="font-medium">{{ $program->nama_program }}</td>
                        <td class="max-w-xs truncate text-sm opacity-60">{{ $program->deskripsi ?? '-' }}</td>
                        <td>
                            @if($program->jalur)
                                <x-badge :value="$program->jalur" class="badge-outline" />
                            @else
                                <span class="opacity-40">-</span>
                            @endif
                        </td>
                        <td>
                            <x-badge
                                :value="$program->status"
                                class="{{
                                    $program->status === 'Aktif' ? 'badge-success' :
                                    ($program->status === 'Pending' ? 'badge-warning' : 'badge-error')
                                }}"
                            />
                        </td>
                        <td class="flex gap-2">
                            <x-button label="Edit" wire:click="edit({{ $program->id }})" class="btn-sm btn-info" icon="o-pencil" />
                            <x-button label="Hapus" wire:click="delete({{ $program->id }})" wire:confirm="Yakin ingin menghapus program studi ini?" class="btn-sm btn-error" icon="o-trash" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8">
                            <x-icon name="o-academic-cap" class="w-12 h-12 mx-auto opacity-30 mb-2" />
                            <p class="opacity-50">{{ $search || $filterStatus || $filterJalur ? 'Tidak ada hasil yang cocok.' : 'Belum ada data program studi.' }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $programs->links() }}
        </div>
    </x-card>
    <x-modal wire:model="showModal" :title="$editMode ? 'Edit Program Studi' : 'Tambah Program Studi'" separator>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Kode Prodi" wire:model="kode_program" disabled class="bg-base-200" />
            <x-select
                label="Status"
                wire:model="status"
                :options="[
                    ['id' => 'Aktif',    'name' => 'Aktif'],
                    ['id' => 'Nonaktif', 'name' => 'Nonaktif'],
                    ['id' => 'Pending',  'name' => 'Pending'],
                ]"
            />
            <div class="md:col-span-2">
                <x-input label="Nama Program Studi" wire:model="nama_program" placeholder="Contoh: Teknik Informatika" />
                @error('nama_program') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2">
                <x-textarea label="Deskripsi" wire:model="deskripsi" placeholder="Deskripsi program studi (opsional)" rows="3" />
            </div>
            <div class="md:col-span-2">
                <x-select
                    label="Jenjang"
                    wire:model="jalur"
                    :options="[
                        ['id' => 'S1', 'name' => 'S1 - Sarjana'],
                        ['id' => 'S2', 'name' => 'S2 - Magister'],
                        ['id' => 'S3', 'name' => 'S3 - Doktor'],
                        ['id' => 'D3', 'name' => 'D3 - Diploma'],
                        ['id' => 'D4', 'name' => 'D4 - Sarjana Terapan'],
                    ]"
                    placeholder="Pilih jenjang"
                />
                @error('jalur') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
        <x-slot:actions>
            <x-button label="Batal" wire:click="closeModal" icon="o-x-mark" />
            <x-button :label="$editMode ? 'Update' : 'Simpan'" wire:click="save" class="btn-primary" icon="o-check" />
        </x-slot:actions>
    </x-modal>
</div>
