<?php
namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Contracts\View\View;

class PlayerReportController extends Controller
{
    public function show(Player $player): View
    {
        $averageSpeed = Player::query()->avg('shot_speed_kmh') ?? 0;

        return view('player-report', [
            'player'       => $player,
            'averageSpeed' => $averageSpeed,
        ]);
    }
}
