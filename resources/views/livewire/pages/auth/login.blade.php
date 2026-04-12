<div class="min-h-screen flex items-center justify-center bg-base-200">
    <div class="w-full max-w-md px-4">
        {{-- Logo & App Name --}}
        <div class="text-center mb-17">
            <div class="flex items-center justify-center gap-2 mb-2">
             <x-icon name="o-sparkles" class="w-8 h-8 text-primary" />
                <span class="text-3xl font-black text-primary">SimProdi</span>
            </div>
            <p class="text-sm opacity-50">Sistem Informasi Manajemen Program Studi</p>
        </div>

        {{-- Login Card --}}
        <x-card class="w-full shadow-xl">
            <div class="text-center mb-6">
                <h1 class="text-xl font-bold">Masuk ke Sistem</h1>
                <p class="text-sm opacity-50 mt-1">Masukkan kredensial Anda untuk melanjutkan</p>
            </div>
            <div class="flex flex-col gap-4">
                <div>
                    <x-input
                        label="Email"
                        wire:model="email"
                        type="email"
                        placeholder="Masukkan email"
                        icon="o-envelope"
                    />
                    @error('email')
                        <x-alert title="{{ $message }}" class="alert-error mt-2" />
                    @enderror
                </div>
                <div>
                    <x-input
                        label="Password"
                        wire:model="password"
                        type="password"
                        placeholder="Masukkan password"
                        icon="o-key"
                    />
                </div>
                <x-button
                    label="Login"
                    wire:click="authenticate"
                    class="btn-primary w-full mt-2"
                    icon="o-arrow-right-on-rectangle"
                />
            </div>
        </x-card>

        <p class="text-center text-xs opacity-30 mt-6">© 2026 SimProdi. All rights reserved.</p>
    </div>
</div>