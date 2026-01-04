<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Gerenciamento de Áudios</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Upload de arquivos de áudio para mensagens de bloqueio e
                URA.</p>
        </div>
        <div>
            <x-ui-button color="emerald" icon="plus" label="Novo Áudio" wire:click="$set('modalOpen', true)" />
        </div>
    </div>

    <!-- Tabela de Áudios -->
    <div
        class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                        Nome</th>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                        Caminho</th>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                        Player</th>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                        Tamanho</th>
                    <th
                        class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-200">
                        Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @forelse($audios as $audio)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-100">
                            {{ $audio->name }}
                            @if($audio->description)
                                <p class="text-xs text-gray-500">{{ $audio->description }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 font-mono whitespace-nowrap dark:text-gray-500">
                            {{ $audio->path }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="custom-audio-player">
                                <audio id="audio-{{ $audio->id }}" preload="none">
                                    <source src="{{ route('audio.play', $audio->id) }}" type="{{ $audio->mime_type }}">
                                </audio>
                                <div
                                    class="flex items-center gap-3 p-3 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-lg border border-emerald-200 dark:border-emerald-700">
                                    <button onclick="togglePlay({{ $audio->id }})"
                                        class="play-btn flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-emerald-500 hover:bg-emerald-600 text-white transition-all duration-200 shadow-md hover:shadow-lg">
                                        <svg class="play-icon w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                        </svg>
                                        <svg class="pause-icon hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z" />
                                        </svg>
                                    </button>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span
                                                class="current-time text-xs font-medium text-emerald-700 dark:text-emerald-300">0:00</span>
                                            <div class="flex-1 h-2 bg-emerald-200 dark:bg-emerald-800 rounded-full overflow-hidden cursor-pointer"
                                                onclick="seek(event, {{ $audio->id }})">
                                                <div class="progress-bar h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-100"
                                                    style="width: 0%"></div>
                                            </div>
                                            <span
                                                class="duration text-xs font-medium text-emerald-700 dark:text-emerald-300">0:00</span>
                                        </div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400">{{ $audio->filename }}</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M10 3.75a2 2 0 10-4 0 2 2 0 004 0zM17.25 4.5a.75.75 0 000-1.5h-5.5a.75.75 0 000 1.5h5.5zM5 3.75a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5a.75.75 0 01.75.75zM4.25 17a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5h1.5zM17.25 17a.75.75 0 000-1.5h-5.5a.75.75 0 000 1.5h5.5zM9 10a.75.75 0 01-.75.75h-5.5a.75.75 0 010-1.5h5.5A.75.75 0 019 10zM17.25 10.75a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5h1.5z" />
                                        </svg>
                                        <input type="range" min="0" max="100" value="100"
                                            onchange="setVolume({{ $audio->id }}, this.value)"
                                            class="volume-slider w-16 h-1 bg-emerald-200 dark:bg-emerald-800 rounded-lg appearance-none cursor-pointer">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                            {{ number_format(($audio->file_size ?? 0) / 1024, 2) }} KB
                        </td>
                        <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                            <x-ui-button.circle color="red" icon="trash" wire:click="delete({{ $audio->id }})"
                                wire:confirm="Deseja realmente excluir este áudio?" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500 dark:text-gray-400">
                            Nenhum áudio cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $audios->links() }}
        </div>
    </div>

    <!-- Modal de Upload -->
    <x-ui-modal wire="modalOpen" title="Novo Áudio">
        <div class="space-y-4">
            <x-ui-select.styled label="Nome Identificador *" wire:model="name"
                :options="\App\Enums\AudioIdentifier::options()" select="label:label|value:value" searchable />
            <x-ui-textarea label="Descrição" wire:model="description" placeholder="Detalhes sobre este áudio..." />

            <div
                class="p-4 border border-dashed rounded-lg border-gray-300 bg-gray-50 dark:bg-gray-800 dark:border-gray-600">
                <label class="block">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Arquivo de Áudio (MP3/WAV) *
                    </span>
                    <input type="file" wire:model="file" accept="audio/*" class="block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-emerald-50 file:text-emerald-700
                            hover:file:bg-emerald-100
                            dark:file:bg-emerald-900/20 dark:file:text-emerald-400
                            dark:hover:file:bg-emerald-900/30
                            cursor-pointer" />
                    @if($file)
                        <p class="mt-2 text-sm text-emerald-600 dark:text-emerald-400">
                            ✓ Arquivo selecionado: {{ $file->getClientOriginalName() }}
                        </p>
                    @endif
                </label>
            </div>

            <div wire:loading wire:target="file" class="text-sm text-blue-500">
                Carregando arquivo...
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <x-ui-button color="gray" wire:click="$set('modalOpen', false)">
                    Cancelar
                </x-ui-button>
                <x-ui-button color="emerald" wire:click="save" loading="save">
                    Salvar
                </x-ui-button>
            </div>
        </x-slot:footer>
    </x-ui-modal>

    <script>
        // Audio player controls
        function togglePlay(audioId) {
            const audio = document.getElementById(`audio-${audioId}`);
            const btn = event.currentTarget;
            const playIcon = btn.querySelector('.play-icon');
            const pauseIcon = btn.querySelector('.pause-icon');

            if (audio.paused) {
                audio.play();
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
            } else {
                audio.pause();
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            }
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        function seek(event, audioId) {
            const audio = document.getElementById(`audio-${audioId}`);
            const progressBar = event.currentTarget;
            const rect = progressBar.getBoundingClientRect();
            const percent = (event.clientX - rect.left) / rect.width;
            audio.currentTime = percent * audio.duration;
        }

        function setVolume(audioId, value) {
            const audio = document.getElementById(`audio-${audioId}`);
            audio.volume = value / 100;
        }

        // Initialize audio players
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('audio').forEach(audio => {
                const player = audio.closest('.custom-audio-player');
                if (!player) return;

                const currentTime = player.querySelector('.current-time');
                const duration = player.querySelector('.duration');
                const progressBar = player.querySelector('.progress-bar');
                const playBtn = player.querySelector('.play-btn');
                const playIcon = playBtn.querySelector('.play-icon');
                const pauseIcon = playBtn.querySelector('.pause-icon');

                // Update duration when metadata is loaded
                audio.addEventListener('loadedmetadata', () => {
                    duration.textContent = formatTime(audio.duration);
                });

                // Update progress
                audio.addEventListener('timeupdate', () => {
                    currentTime.textContent = formatTime(audio.currentTime);
                    const percent = (audio.currentTime / audio.duration) * 100;
                    progressBar.style.width = `${percent}%`;
                });

                // Reset when ended
                audio.addEventListener('ended', () => {
                    playIcon.classList.remove('hidden');
                    pauseIcon.classList.add('hidden');
                    progressBar.style.width = '0%';
                });
            });
        });

        // Reinitialize after Livewire updates
        document.addEventListener('livewire:navigated', function () {
            document.dispatchEvent(new Event('DOMContentLoaded'));
        });
    </script>
</div>