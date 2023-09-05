<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


trait UploadTrait
{
    // ...

    public function verifyAndStoreImage(Request $request, $inputname, $foldername, $disk, $imageable_id, $imageable_type)
    {
        if ($request->hasFile($inputname)) {
            $photo = $request->file($inputname);

            // Check if the uploaded file is valid
            if (!$photo->isValid()) {
                session()->flash('error', 'Invalid Image!');
                return redirect()->back()->withInput();
            }

            $name = Str::slug($request->input('name'));
            $filename = $name . '.' . $photo->getClientOriginalExtension();

            // Insert Image
            $image = Image::create([
                'filename' => $filename,
                'imageable_id' => $imageable_id,
                'imageable_type' => $imageable_type,
            ]);

            $photo->storeAs($foldername, $filename, ['disk' => $disk]);

            return $image;
        }

        return null;
    }


    public function verifyAndStoreImageForeach($varforeach, $foldername, $disk, $imageable_id, $imageable_type)
    {
        // Insert Image
        $image = Image::create([
            'filename' => $varforeach->getClientOriginalName(),
            'imageable_id' => $imageable_id,
            'imageable_type' => $imageable_type,
        ]);

        $varforeach->storeAs($foldername, $varforeach->getClientOriginalName(), ['disk' => $disk]);

        return $image;
    }

    public function deleteAttachment($disk, $path, $id)
    {
        Storage::disk($disk)->delete($path);
        Image::where('imageable_id', $id)->delete();
    }
}
