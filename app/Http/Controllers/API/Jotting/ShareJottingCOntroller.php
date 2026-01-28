<?php

namespace App\Http\Controllers\API\Jotting;

use App\Http\Controllers\Controller;
use App\Models\Jotting;
use App\Models\User;
use App\Models\JottingShare;
use App\Notifications\JottingShared;
use App\Notifications\JottingUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SharedJottingController extends Controller
{
    /**
     * Share a jotting with other users
     */
    public function share(Request $request, Jotting $jotting)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'uuid|exists:users,id',
        ]);

        $userIds = $request->user_ids;

        DB::transaction(function () use ($userIds, $jotting) {
            foreach ($userIds as $userId) {
                $user = User::findOrFail($userId);

                // Create or update share record
                JottingShare::updateOrCreate(
                    [
                        'jotting_id' => $jotting->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'shared_by' => auth('api')->user()->id,
                    ]
                );

                // Send notification
                $user->notify(new JottingShared($jotting, auth('api')->user()->name));
            }
        });

        return response()->json([
            'message' => 'Jotting shared successfully',
        ]);
    }

    /**
     * Send back an updated jotting to the original owner or other users
     */
    public function sendBack(Request $request, Jotting $jotting)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $editor = auth('api')->user();

        // Update jotting content
        $jotting->update(['content' => $request->content]);

        // Create snapshot/version
        app(\App\Services\JottingVersionService::class)->snapshot($jotting, $editor);

        // Notify all users who originally shared this jotting, except current editor
        foreach ($jotting->shares as $share) {
            if ($share->user_id !== $editor->id) {
                $share->user->notify(new JottingUpdatedNotification($jotting, $editor->name));
            }
        }

        return response()->json([
            'message' => 'Jotting sent back successfully',
            'jotting' => $jotting->load('versions', 'shares')
        ]);
    }

    /**
     * List all jottings shared with the current user
     */
    public function index()
    {
        $user = auth('api')->user();

        $sharedJottings = Jotting::whereHas('shares', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['versions', 'shares'])->get();

        return response()->json($sharedJottings);
    }
}
