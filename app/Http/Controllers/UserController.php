<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{
    /**
     * Action store
     *
     * @param ProfileRequest $request
     */
    public function store(ProfileRequest $request)
    {
        $validatedData = $request->validated();
        User::create($validatedData);

        return redirect()->route('home');
    }

    /**
     * Action update
     *
     * @param int $id
     * @param ProfileRequest $request
     * @throws
     */
    public function update(int $id, ProfileRequest $request)
    {
        $user = User::find($id);

        if (!$user) {
            throw new \Exception("Не существующая запись", 1);
        }

        $validatedData = $request->validated();
        $user->update($validatedData);

        return redirect()->route('home');
    }

    /**
     * Action fileUpload
     * @param ProfileRequest $request
     */
    public function fileUpload(ProfileRequest $request)
    {
        if($request->isMethod('POST')){
            if($request->hasFile('member_photo')){
                $file = $request->file('member_photo');
                $file->move(public_path() . '/path', 'filename.img');
            }
        }
    }
}
