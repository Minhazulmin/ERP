<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Http\Controllers\Backend\Website\Gallery;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Website\Gallery\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SliderController extends BaseController {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        $query = Slider::oldest( 'sorting' );
        $query->whereLike( $request->field_name, $request->value );

        $datas = $query->paginate( $request->pagination );
        return new Resource( $datas );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'layouts.backend_app' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        Cache::forget( 'website_cache' );
        if ( $this->validateCheck( $request ) ) {
            $data = $request->all();
            if ( !empty( $request->slider ) ) {
                $data['slider'] = $this->upload( $request->slider, 'slider', null, true );
            }

            Slider::create( $data );
            return response()->json( ['message' => 'Create Successfully!'], 200 );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, Slider $slider ) {
        if ( $request->format() == 'html' ) {
            return view( 'layouts.backend_app' );
        }
        return $slider;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit( Slider $slider ) {
        return view( 'layouts.backend_app' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Slider $slider ) {
        Cache::forget( 'website_cache' );
        $data = $request->all();
        $file = $request->slider;

        if ( !empty( $file ) && $request->slider != $slider->slider ) {
            $data['slider'] = $this->upload( $file, 'slider', $slider->slider, true );
        } else {
            $data['slider'] = $this->oldFile( $slider->slider );
        }

        $slider->update( $data );
        return response()->json( ['message' => 'Update Successfully!'], 200 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy( Slider $slider ) {
        Cache::forget( 'website_cache' );
        $old = $this->oldFile( $slider->slider );
        if ( Storage::disk( 'public' )->exists( $old ) ):
            Storage::delete( $old );
        endif;
        if ( $slider->delete() ) {
            return response()->json( ['message' => 'Delete Successfully!'], 200 );
        } else {
            return response()->json( ['message' => 'Delete Unsuccessfully!'], 200 );
        }
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck( $request ) {
        return $request->validate( [
            'title'  => 'required',
            'slider' => 'required',
        ] );
    }
}
