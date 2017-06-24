<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Http\Requests\ValidateProfilePageRequest;
use LaravelEnso\Core\app\Models\User;

class ProfilePageController extends Controller
{
	public function __invoke(ValidateProfilePageRequest $request, User $user)
    {
    	$this->authorize('update-profile', $user);
        $user->update($request->all());
        flash()->success(__('The Changes have been saved!'));

        return back();
    }
}