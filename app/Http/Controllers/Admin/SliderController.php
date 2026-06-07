<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SliderImage;

class SliderController extends Controller
{
    public function index()
    {
        $images = SliderImage::orderBy('created_at', 'desc')->get();

        return view('admin.slider.index', compact('images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        // المسار الصحيح الذي يستطيع Laravel عرضه
        $path = storage_path('app/public/sliders');

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();

        // حفظ الصورة في المسار الصحيح
        $request->file('image')->move($path, $imageName);

        // حفظ داخل قاعدة البيانات
        SliderImage::create([
            'path' => $imageName,
            'created_at' => now()
        ]);

        return redirect()->route('admin.slider.index')
                         ->with('success', 'تم رفع الصورة بنجاح');
    }

    public function delete($id)
    {
        $image = SliderImage::findOrFail($id);

        // المسار الصحيح
        $file = storage_path('app/public/sliders/' . $image->path);

        if (file_exists($file)) {
            unlink($file);
        }

        $image->delete();

        return back();
    }
}
