<?php

namespace App\Livewire;

use App\Models\Player;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class PlayerShotSpeedBoard extends Component
{
    use WithPagination;

    public string $playerName = '';

    public ?float $shotSpeed = null;

    public ?int $editingPlayerId = null;

    public string $editPlayerName = '';

    public ?float $editShotSpeed = null;

    /**
     * @throws ValidationException
     */
    public function savePlayer(): void
    {
        $validated = $this->validate([
            'playerName' => ['required', 'string', 'max:255'],
            'shotSpeed' => ['required', 'numeric', 'min:1', 'max:300'],
        ]);

        $player = Player::query()->create([
            'name' => $validated['playerName'],
            'shot_speed_kmh' => $validated['shotSpeed'],
        ]);

        $this->reset(['playerName', 'shotSpeed']);
        $this->resetPage();

          // Dispatch browser event so JS can trigger the animation
        $this->dispatch('player-saved', id: $player->id);
    }

    public function startEditing(int $playerId): void
    {
        $player = Player::query()->findOrFail($playerId);

        $this->editingPlayerId = $player->id;
        $this->editPlayerName = $player->name;
        $this->editShotSpeed = (float) $player->shot_speed_kmh;
    }

    public function cancelEditing(): void
    {
        $this->reset(['editingPlayerId', 'editPlayerName', 'editShotSpeed']);
    }

    /**
     * @throws ValidationException
     */
    public function updatePlayer(int $playerId): void
    {
        $validated = $this->validate([
            'editPlayerName' => ['required', 'string', 'max:255'],
            'editShotSpeed' => ['required', 'numeric', 'min:1', 'max:300'],
        ]);

        Player::query()->findOrFail($playerId)->update([
            'name' => $validated['editPlayerName'],
            'shot_speed_kmh' => $validated['editShotSpeed'],
        ]);

        $this->cancelEditing();

        // Dispatch browser event so JS can trigger the animation
        $this->dispatch('player-saved', id: $playerId);
    }

    public function deletePlayer(int $playerId): void
    {
        Player::query()->findOrFail($playerId)->delete();

        if ($this->editingPlayerId === $playerId) {
            $this->cancelEditing();
        }

        $this->resetPage();
    }

    public function render(): View
    {
        $playersQuery = Player::query()
            ->orderByDesc('shot_speed_kmh')
            ->orderBy('name');

        $averageSpeed = Player::query()->avg('shot_speed_kmh') ?? 0;

        return view('livewire.player-shot-speed-board', [
            'players' => $playersQuery->paginate(20),
            'averageSpeed' => $averageSpeed,
        ]);
    }
}
