<?php

namespace App\Repository\Doctors;

use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Models\Doctor;
use App\Models\Image;
use App\Models\Section;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Summary of DoctorRepository
 */
class DoctorRepository implements DoctorRepositoryInterface
{
    use UploadTrait;

    public function index()
    {
        $doctors = Doctor::all();
        return view('Dashboard.Doctors.index', compact('doctors'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('Dashboard.Doctors.add', compact('sections'));
    }



    public function store($request)
    {
        DB::beginTransaction();

        try {
            $doctor = Doctor::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'section_id' => $request->section_id,
                'phone' => $request->phone,
                'price' => $request->price,
                'status' => 1,
                'name' => $request->name,
                'appointments' => implode(",", $request->appointments),
            ]);

            // Upload img
            $this->verifyAndStoreImage($request, 'photo', 'doctors', 'upload_image', $doctor->id, 'App\Models\Doctor');

            DB::commit();
            session()->flash('add');
            return redirect()->route('doctors.create');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function update($request)
    {
    }

    public function destroy($request)
    {
        $doctors = Doctor::findOrFail($request->id)->delete();
        session()->flash('delete');
        return redirect()->route('doctors.index');
    }
}
