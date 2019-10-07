<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Imagick;

class ProfilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $data = [
            'user' => new User,
        ];

        return view('profile.edit', $data);
    }

    /**
     * Action update
     *
     * @param ProfileRequest $reuest
     * @throws
     */
    public function update(ProfileRequest $request)
    {
        $validatedData = $request->validated();

        if ($photo = $request->get('photo')) {
            $mime = $this->getImageMime($photo);
            preg_match('#^data:image/([^;]+);#', $mime, $matches);
            $type = $matches[1];
            $photo = str_replace($mime, '', $photo);

            $imagick = $this->getImage($photo);
            $filename = uniqid() . '.' . $type;
            $imagick->writeImage(storage_path('app/public/photo/') . $filename);
            $validatedData['photo'] = $filename;
        }

        Auth::user()->update($validatedData);

        return redirect()->route('profile.edit');
    }

    public function cropImage(Request $request)
    {
        $data = $request->get('imgUrl');
        $mime = $this->getImageMime($data);
        $data = str_replace($mime, '', $data);

        $imagick = $this->getImage($data);
        $imagick->resizeImage(
            $request->get('imgW'),
            $request->get('imgH'),
            \Imagick::COLOR_YELLOW,
            1
        );

        $imagick->cropImage(
            $request->get('cropW'),
            $request->get('cropH'),
            $request->get('imgX1'),
            $request->get('imgY1')
        );

        return [
            "status" => 'success',
            "url" => $mime . base64_encode($imagick),
        ];
    }

    private function getImage(string $data): Imagick
    {
        $imagick = new \Imagick();
        $imagick->readImageBlob(base64_decode($data));

        return $imagick;
    }

    private function getImageMime(string $data): string
    {
        preg_match('#^data:image/[^;]+;base64,#', $data, $matches);

        return $matches[0];
    }
}
