<?php

/**
 * @Oshit Sutra Dhar
 */

namespace App\Http\Controllers\Backend\Website\Gallery;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Website\Gallery\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PhotoController extends BaseController {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        $query = Photo::with( 'album' )->oldest( 'sorting' );
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
            if ( !empty( $request->image ) ) {
                $data['image'] = $this->upload( $request->image, 'photos', null, true );
            }

            Photo::create( $data );
            return response()->json( ['message' => 'Create Successfully!'], 200 );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, Photo $photo ) {
        if ( $request->format() == 'html' ) {
            return view( 'layouts.backend_app' );
        }
        return $photo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit( Photo $photo ) {
        return view( 'layouts.backend_app' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Photo $photo ) {
        Cache::forget( 'website_cache' );
        $data = $request->all();
        if ( !empty( $request->image ) && $request->image != $photo->image ) {
            $data['image'] = $this->upload( $request->image, 'photos', $photo->image, true );
        } else {
            $data['image'] = $this->oldFile( $photo->image );
        }

        $photo->update( $data );
        return response()->json( ['message' => 'Update Successfully!'], 200 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy( Photo $photo ) {
        Cache::forget( 'website_cache' );
        $old = $this->oldFile( $photo->image );
        if ( Storage::disk( 'public' )->exists( $old ) ) {
            Storage::delete( $old );
        }

        if ( $photo->delete() ) {
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
            'title' => 'required',
            'image' => 'required',
        ] );
    }
}
