<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    private $doctors;

    public function __construct(DoctorRepositoryInterface $doctors)
    {
        $this->doctors = $doctors;
    }

    public function index()
    {
        return $this->doctors->index();
    }


    public function create()
    {
        return $this->doctors->create();
    }

    public function store(Request $request)
    {
        return $this->doctors->store($request);
    }


    public function update(Request $request)
    {
        //
    }


    public function destroy(Request $request)
    {
        return $this->doctors->destroy($request);
    }
}
