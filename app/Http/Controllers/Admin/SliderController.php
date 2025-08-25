<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Services\SliderService;
use App\Http\Controllers\Controller;
use App\Models\Termmeta;
use Illuminate\Support\Str;


class SliderController extends Controller
{
    protected $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }
 
    public function index(Request $request)
    {
        $counter['active'] = Term::where('status','active')->whereIn('type', sliderTypes())->count();
        $counter['inactive'] = Term::where('status','inactive')->whereIn('type', sliderTypes())->count();
        
        $search_query = $request->search_query;
        $status = $request->status ?? 'active';
        $sliders = Term::select('id', 'title', 'created_at', 'status','type')
            ->whereIn('type', sliderTypes())
            ->where('title', 'like', '%' . $search_query . '%')
            ->paginate(10)
            ->appends(['search_query' => $search_query, 'status' => $status]);

        return view('admin.sliders.index', compact('sliders','counter'));
    }


    public function create()
    {
        return view('admin.sliders.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate( [
            'title' => 'required|unique:terms',
            'type' => 'unique:terms,type',
        ]);

        if(!$request->slider_info) return redirect()->back()->with('error', 'No Slider found!');
        

        $slider = new Term();
        $slider->title = $request->title;
        // $slider->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        // if(Term::where('slug', $slider->slug)->exists()){
        //     return redirect()->back()->with('error', 'Slug already exists!!');
        // }

        $slider->status = $request->status;
        $slider->type = $request->type ?? sliderTypes()[0];
        $slider->save();

        // $data['description'] = $request->description;

        $sliders = $request->slider_info;

        $data = $this->sliderService->generateSliderArray($sliders); 
        // $data = array_merge($data, $slider_arr);

        $info = new Termmeta();
        $info->term_id = $slider->id;
        $info->key = 'slider_info';
        $info->value = json_encode($data);
        $info->save();
        
        return redirect()->route('admin.sliders.index')->with('success', 'Slider Successfully Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {       
        $slider = Term::with('sliderInfo')->findOrFail($id);

        // if (request()->ajax()) {
        //     $slider_info = isset($slider?->sliderInfo?->value) ? (json_decode($slider?->sliderInfo?->value)?->slide_images ?? []) : [];
        //     return response()->json($slider_info);
        // }

        return view('admin.sliders.edit', compact('slider'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            // 'slug' => 'required|unique:terms,slug,' . $id,
            'type' => 'required|unique:terms,type,' . $id,
        ]);

        if(!$request->slider_info) return redirect()->back()->with('error', 'No Slide Data selected!');

        $slider = Term::with('sliderInfo')->findOrFail($id);
        $slider->title = $request->title;
        // $slider->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        // if(Term::where([
        //     ['slug', $slider->slug],
        //     ['id', '!=' , $id],
        // ])->exists()){
        //     return redirect()->back()->with('error', 'Slug already exists!!');
        // }

        $slider->status = $request->status;
        $slider->type = $request->type ?? 'top_slider';
        $slider->save();


        // $data['description'] = $request->description;

        $sliders = $request->slider_info;

        $slider_info = $slider->sliderInfo;

        // if($slider_info){
        //     $existing_slider_array = isset($slider_info->value) ? (json_decode($slider_info->value)->slide_images ?? []) : [];
        //     $this->sliderService->deleteExistingSliderImage($existing_slider_array, $sliders);
        // }

        
        $data = $this->sliderService->generateSliderArray($sliders); 
        // $data = array_merge($data, $slider_arr);

        $info = $slider_info ?? new Termmeta();
        $info->term_id = $slider->id;
        $info->key = 'slider_info';
        $info->value = json_encode($data);
        $info->save();
        
        return redirect()->route('admin.sliders.index')->with('success', 'Slider Successfully Updated!');
    }

    public function destroy(Request $request, $id)
    {
        $deleted = $request->deleted;
        try {
            // update deleted status
            Term::where('id', $id)->delete();

            $status = "success";
            $message = "Slider successfully deleted";
        } catch (\Illuminate\Database\QueryException $ex) {
            $status = "error";
            $message = $ex->getMessage();
        }
        // display success message
        return redirect()->back()->with($status, $message);
    }

    // public function status(Request $request)
    // {
    //     $ids = explode(",", $request->ids);
    //     $type = $request->type;
    //     try {
    //         if ($type == 'delete') {
    //             slider::whereIn('id', $ids)->delete();
    //         } elseif ($type == 'inactive' || $type == 'active') {
    //             slider::whereIn('id', $ids)->update(['status' => $type]);
    //         }
    //         // update deleted status
    //         $status = "success";
    //         $message = "Status successfully Updated";
    //     } catch (\Illuminate\Database\QueryException $ex) {
    //         $status = "error";
    //         $message = $ex->getMessage();
    //     }
    //     // display success message
    //     return redirect()->back()->with($status, $message);
    // }

    // function arraySortByObjectKey(array $arrayOfObject, $position){
    //     return usort($arrayOfObject, function($first, $second) use ($position){
    //         $first=(object)$first;
    //         $second=(object)$second;
    //         return (int)$first->$position > (int)$second->$position;
    //     });
    // }
}
