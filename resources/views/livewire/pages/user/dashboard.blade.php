<div>
    <x-header title="Dashboard" subtitle="Selamat datang kembali!" separator />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-card title="Profil Saya" icon="o-user">
            <div class="flex items-center gap-4">
                <x-avatar :placeholder="strtoupper(substr(auth()->user()->name, 0, 1))" class="w-16 h-16 text-2xl" />
                <div>
                    <p class="font-bold text-lg">{{ auth()->user()->name }}</p>
                    <p class="opacity-50 text-sm">{{ auth()->user()->email }}</p>
                    <x-badge value="program" class="badge-secondary mt-1" />
                </div>
            </div>
        </x-card>

        <x-card title="Menu Tersedia" icon="o-squares-2x2">
            <div class="grid grid-cols-2 gap-3">
                <a href="/program/teacher">
                    <x-button label="Teacher" icon="o-academic-cap" class="btn-outline w-full" />
                </a>
                <a href="/program/subject">
                    <x-button label="Subject" icon="o-book-open" class="btn-outline w-full" />
                </a>
                <a href="/program/schedule">
                    <x-button label="Schedule" icon="o-calendar" class="btn-outline w-full" />
                </a>
                <a href="/program/assignment">
                    <x-button label="Assignment" icon="o-clipboard-document" class="btn-outline w-full" />
                </a>
            </div>
        </x-card>
    </div>
</div>
