<?php

namespace App\Http\Controllers;
use App\Library\Html;
use App\Models;
use Illuminate\Http\Request;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseClient;
use Parse\ParseFile;
use Parse\ParseObject;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Yaml\Exception\ParseException;

class ProfileServiceController extends Controller {

    public function upload(Request $request) {
        if ( isset( $_FILES['image'] ) ) {
            // save file to Parse
            try {
                $fname = str_replace(' ', '', $_FILES['image']['name']);
                $file = ParseFile::createFromData( file_get_contents( $_FILES['image']['tmp_name'] ), $fname );
                $file->save();

                // save something to class TestObject
                $asset = new ParseObject( "Assets" );
                // add the file we saved above
                $asset->set( "file", $file );
                $asset->save();

                $ret = [
                    'status' => 'success',
                    'data' => [
                        'asset' => ['id' => $asset->getObjectId()],
                        'file' => ['url' => $file->getUrl()]
                    ]
                ];
                return response()->json($ret);

            } catch (ParseException $ex) {
                $ret = [
                    'status' => 'fail',
                    'error' => $ex->getMessage()
                ];
                return response()->json($ret);
            }

        } else {
            $ret = [
                'status' => 'fail',
                'error' => 'no file selected'
            ];
            return response()->json($ret);
        }
    }
}