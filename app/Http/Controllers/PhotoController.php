<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use App\Services\UploadFileService;
use App\Services\ValidationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maize\Markable\Models\Like;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::paginate(10);
        
        return $this->core->setResponse('success', 'Successfully', $photos);
    }

    public function store(Request $request)
    {
        if($validator = ValidationService::createPhoto())
            return $this->core->setResponse('error', $validator, NULL, false , 400  );

            try {
            
                DB::beginTransaction();
    
                $photo = Photo::create($request->all());
                $photo->tags()->sync($request->tags);
    
                $upload = UploadFileService::photos($photo->id);
                if(! $upload->success)
                    return $this->core->setResponse('error', $upload->message, NULL, false , 400  );
                
                DB::commit();
    
                return $this->core->setResponse('success', 'Photo Upload Successfully', $photo);
    
            } catch (Exception $e) {
                DB::rollBack();
    
                return $this->core->setResponse('error', $e->getMessage(), NULL, false , 400  );
            }
    }

    public function show($id)
    {
        if (! $photo = Photo::find($id))
            return $this->core->setResponse('error', 'Photo Not Found', NULL, FALSE, 404);

        return $this->core->setResponse('success', 'Photo Found', $photo);
    }

    public function update(Request $request, $id)
    {
        if($validator = ValidationService::updatePhoto())
            return $this->core->setResponse('error', $validator, NULL, false , 400  );

        if (! $photo = Photo::find($id))
            return $this->core->setResponse('error', 'Photo Not Found', NULL, FALSE, 404);

        try {
        
            DB::beginTransaction();
            
            $photo->fill($request->all())->save();
            $photo->tags()->sync($request->tags);

            DB::commit();

            return $this->core->setResponse('success', 'Product Successfully', $photo);

        } catch (Exception $e) {
            DB::rollBack();

            return $this->core->setResponse('error', $e->getMessage(), NULL, false , 400  );
        }

    }

    public function destroy($id)
    {
        if (! $photo = Photo::find($id))
            return $this->core->setResponse('error', 'Photo Not Found', NULL, FALSE, 404);

        $dir = $photo->getFirstMedia('photo')->id;
        $photo->delete();

        Storage::disk('media')->deleteDirectory($dir);

        return $this->core->setResponse('success', 'Photo Successfully Deleted');
    }

    public function like($id)
    {
        if (! $photo = Photo::find($id))
            return $this->core->setResponse('error', 'Photo Not Found', NULL, FALSE, 404);

        $user = User::find(auth()->user()->id);
        Like::add($photo, $user);

        return $this->core->setResponse('success', 'Like Photo Successfully');
    }
    
    public function unlike($id)
    {
        if (! $photo = Photo::find($id))
            return $this->core->setResponse('error', 'Photo Not Found', NULL, FALSE, 404);

        $user = User::find(auth()->user()->id);
        Like::remove($photo, $user);

        return $this->core->setResponse('success', 'Unlike Photo Successfully');
    }
}
