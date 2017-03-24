<?php

namespace LaravelEnso\Core\App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use LaravelEnso\Core\App\Models\Avatar;
use LaravelEnso\FileManager\Classes\FileManager;

class AvatarsController extends Controller
{
    private $fileManager;

    public function __construct()
    {
        $this->fileManager = new FileManager(env('AVATARS_PATH'));
    }

    public function store()
    {
        if (!request()->file('avatar')->isValid()) {
            return reponse()->json([
                [
                    'level'   => 'error',
                    'message' => __('File is not valid'),
                ],
            ], 500);
        }

        return $this->uploadAvatar();
    }

    public function show($avatar)
    {
        $fileWrapper = $this->fileManager->getFile($avatar);

        return $fileWrapper->getInlineResponse();
    }

    public function destroy(Avatar $avatar)
    {
        if (!request()->user()->can('updateProfile', $avatar->user)) {
            return false;
        }

        \DB::transaction(function () use ($avatar) {
            $avatar->delete();
            $this->fileManager->delete($avatar);
        });
    }

    private function uploadAvatar()
    {
        $avatar = null;

        \DB::transaction(function () use (&$avatar) {
            $file = request()->file('avatar');
            $this->fileManager->startSingleFileUpload($file);
            $avatar = new Avatar($this->fileManager->uploadedFiles->first());

            //fixme -> modify users.show to hide upload button when user has avatar
            $oldAvatar = Avatar::whereUserId(request()->user()->id)->first();

            if ($oldAvatar) {
                $this->fileManager->delete($oldAvatar->saved_name);
            }

            $avatar->user_id = request()->user()->id;
            $avatar->save();
            $this->fileManager->commitUpload();
        });

        return $avatar;
    }
}
