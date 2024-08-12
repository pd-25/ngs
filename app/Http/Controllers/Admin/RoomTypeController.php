<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Amenity;
use App\Models\BedType;
use App\Models\Complement;
use App\Models\RoomTypeImage;
use App\Models\Room;

class RoomTypeController extends Controller
{
    public function index()
    {
        $pageTitle   = 'All Room Types';
        $amenities   = Amenity::active()->get();
        $complements = Complement::all();
        $typeList    = RoomType::with('amenities', 'complements')->withCount('rooms')->latest()->paginate(getPaginate());
        return view('admin.hotel.room_type.list', compact('pageTitle', 'typeList', 'amenities', 'complements'));
    }

    public function create()
    {
        $pageTitle   = 'Add Room Type';
        $amenities   = Amenity::active()->get();
        $complements = Complement::all();
        $bedTypes    = BedType::all();
        return view('admin.hotel.room_type.create', compact('pageTitle', 'amenities', 'complements', 'bedTypes'));
    }

    public function edit($id)
    {
        $roomType    = RoomType::with('amenities', 'complements', 'rooms', 'images')->findOrFail($id);
        $pageTitle   = 'Update Room Type -' . $roomType->name;
        $amenities   = Amenity::active()->get();
        $complements = Complement::all();
        $bedTypes    = BedType::all();
        $images      = [];

        foreach ($roomType->images as $key => $image) {
            $img['id']  = $image->id;
            $img['src'] = getImage(getFilePath('roomTypeImage') . '/' . $image->image);
            $images[]   = $img;
        }

        return view('admin.hotel.room_type.create', compact('pageTitle', 'roomType', 'amenities', 'complements', 'bedTypes', 'images'));
    }

    public function save(Request $request, $id = 0)
    {

        $this->validation($request, $id);
        $bedArray         = array_values($request->bed ?? []);

        if ($id) {
            $roomType         = RoomType::findOrFail($id);
            $notification     = 'Room type updated successfully';
        } else {
            $roomType         = new RoomType();
            $notification     = 'Room type added successfully';
        }

        $roomType->name        = $request->name;
        $roomType->total_adult = $request->total_adult;
        $roomType->total_child = $request->total_child;
        $roomType->fare        = $request->fare;
        $roomType->keywords    = $request->keywords ?? [];
        $roomType->description = $request->description;
        $roomType->beds        = $bedArray;
        $roomType->feature_status = $request->feature_status ? 1 : 0;
        $roomType->save();

        $roomType->amenities()->sync($request->amenities);
        $roomType->complements()->sync($request->complements);

        $this->insertRooms($request, $roomType->id);
        $this->insertImages($request, $roomType);

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }


    protected function validation($request, $id)
    {
        $roomValidation     = 'required|array';

        if ($id) {
            $roomValidation = 'nullable';
        }

        $request->validate([
            'name'          => 'required|string|max:255|unique:room_types,name,' . $id,
            'total_adult'   => 'required|integer|gte:0',
            'total_child'   => 'required|integer|gte:0',
            'fare'          => 'required|gt:0',
            'amenities'     => 'nullable|array',
            'amenities.*'   => 'integer|exists:amenities,id',
            'keywords'      => 'nullable|array',
            'keywords.*'    => 'string',
            'complements'   => 'nullable|array',
            'complements.*' => 'integer|exists:complements,id',
            'total_bed'     => 'required|gt:0',
            'bed'           => 'required|array',
            'bed.*'         => 'exists:bed_types,name',
            'room'          => $roomValidation
        ]);
    }


    protected function insertRooms($request, $roomTypeId)
    {
        if ($request->room) {
            foreach ($request->room as $roomNumber) {
                $room               = new Room();
                $room->room_type_id = $roomTypeId;
                $room->room_number  = $roomNumber;
                $room->save();
            }
        }
    }

    protected function insertImages($request, $roomType)
    {
        $path = getFilePath('roomTypeImage');
        $this->removeImages($request, $roomType, $path);

        if ($request->hasFile('images')) {
            $size = getFileSize('roomTypeImage');
            $images = [];

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                try {
                    $name = fileUploader($file, $path, $size);
                    $roomTypeImage        = new RoomTypeImage();
                    $roomTypeImage->image = $name;
                    $images[] = $roomTypeImage;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload the logo'];
                    return back()->withNotify($notify);
                }
            }

            $roomType->images()->saveMany($images);
        }
    }

    protected function removeImages($request, $roomType, $path)
    {
        $previousImages = $roomType->images->pluck('id')->toArray();
        $imageToRemove  = array_values(array_diff($previousImages, $request->old ?? []));

        foreach ($imageToRemove as $item) {
            $roomImage   = RoomTypeImage::find($item);
            @unlink($path . '/' . $roomImage->image);
            $roomImage->delete();
        }
    }

    public function status($id)
    {
        $roomType = RoomType::findOrFail($id);
        $roomType->status = $roomType->status == 1 ? 0 : 1;
        $roomType->save();

        if ($roomType->status == 1) {
            $message = 'Room type enabled successfully';
        } else {
            $message = 'Room type disabled successfully';
        }

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }
}
