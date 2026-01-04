<?php

namespace App\Livewire\Config\Audio;

use App\Enums\AudioIdentifier;
use App\Models\Audio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithFileUploads;
    use WithPagination;
    use Interactions;

    public $name;
    public $description;
    public $file;
    public $modalOpen = false;

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'description' => 'nullable|string',
        'file' => 'required|file|mimes:mp3,wav|max:10240', // Max 10MB
    ];

    public function save()
    {
        $this->validate([
            'name' => ['required', \Illuminate\Validation\Rule::enum(AudioIdentifier::class)],
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:mp3,wav|max:10240',
        ]);

        try {
            // Read file content as binary
            $content = file_get_contents($this->file->getRealPath());

            // Get original extension
            $extension = $this->file->getClientOriginalExtension();

            // Sanitize name: remove special chars, replace spaces with underscores, convert to lowercase
            $sanitizedName = \Illuminate\Support\Str::slug($this->name, '_');

            // Create filename without timestamp
            $filename = $sanitizedName . '.' . $extension;

            // Store in storage/app/public/audios
            $storedPath = $this->file->storeAs('public/audios', $filename);

            // Generate full system path
            $fullPath = storage_path('app/' . $storedPath);

            // Use Hex encoding for Postgres Bytea to avoid "Malformed UTF-8" issues in PHP strings
            // Postgres accepts hex format starting with \x
            $hexContent = '\x' . bin2hex($content);

            // Free up memory from raw content
            $content = null;

            // Use Query Builder to avoid Eloquent/Livewire serialization issues with large binary blobs
            \Illuminate\Support\Facades\DB::table('audio')->insert([
                'name' => $this->name,
                'description' => $this->description,
                'filename' => $filename,
                'mime_type' => $this->file->getMimeType(),
                'content' => $hexContent,
                'path' => $fullPath,
                'file_size' => $this->file->getSize(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->toast()->success('Áudio enviado com sucesso!')->send();
            $this->reset(['name', 'description', 'file']);
            $this->modalOpen = false;

        } catch (\Exception $e) {
            $this->toast()->error('Erro ao salvar áudio: ' . $e->getMessage())->send();
        }
    }

    public function play($id)
    {
        try {
            $audio = Audio::findOrFail($id);

            // Return response with audio content
            return response($audio->content)
                ->header('Content-Type', $audio->mime_type)
                ->header('Content-Disposition', 'inline; filename="' . $audio->filename . '"');

        } catch (\Exception $e) {
            $this->toast()->error('Erro ao reproduzir áudio: ' . $e->getMessage())->send();
        }
    }

    public function delete($id)
    {
        try {
            $audio = Audio::findOrFail($id);

            // Delete physical file if it exists
            if ($audio->path && file_exists($audio->path)) {
                unlink($audio->path);
            }

            // Delete database record
            $audio->delete();

            $this->toast()->success('Áudio removido com sucesso!')->send();
        } catch (\Exception $e) {
            $this->toast()->error('Erro ao remover: ' . $e->getMessage())->send();
        }
    }

    public function render()
    {
        // Select only necessary columns to avoid loading binary content
        $audios = Audio::select(['id', 'name', 'description', 'filename', 'path', 'mime_type', 'created_at', 'file_size'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.config.audio.index', compact('audios'));
    }
}
