<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;
use App\Traits\Upload\HandlesImageUpload;

use App\Models\Repository;

class MarketingController extends Controller
{
    use HandlesImageUpload, ProvideSuccess, ProvideException;

    public function getRepositories()
    {
        try {
            $query = Repository::whereIn('category', ['tutorials', 'installers', 'packages']);
            $query->where('is_active', true);
            $query->orderBy('created_at', 'desc');
            $repository = $query->get();

            return $repository;
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }

    public function getRepository($id)
    {
        try{
            if($id){
                return Repository::where('id', $id)->firstOrFail();
            }
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }
    
    public function createRepository(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'image' => 'required',
                'file' => 'required',
                'category' => 'required',
            ], [
                'name' => 'Nome do arquivo',
                'image.required' => 'Icone do arquivo',
                'file.required' => 'URL do conteúdo hospedado externamente',
                'category.required' => 'Categoria do arquivo'
            ]);

            $exists = Repository::where('file', $request->input('file'))->where('name', $request->input('name'))->exists();
            if($exists) return $this->provideSuccess('exists');

            Repository::create([
                'name' => $request->input('name'),
                'image' => $this->uploadImage('repository', $request->file('image')),
                'file' => $request->input('file'),
                'category' => $request->input('category'),
            ]);
    
            return $this->provideSuccess('save');
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }

    function updateRepository(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'image' => 'required',
                'file' => 'required',
                'category' => 'required',
            ], [
                'name' => 'Nome do arquivo',
                'image.required' => 'Icone do arquivo',
                'file.required' => 'URL do conteúdo hospedado externamente',
                'category.required' => 'Categoria do arquivo'
            ]);

            $repository = Repository::where('id', $id)->firstOrFail();
            $repository->update([
                'name' => $request->input('name', $repository->name),
                'image' => $request->hasFile('image') ? $this->uploadImage('repository', $request->file('image'), 'public', $repository->image) : $repository->image,
                'file' => $request->input('file', $repository->file),
                'category' => $request->input('category', $repository->category),
            ]);

            return $this->provideSuccess('update');
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }

    public function deactivateRepository($id)
    {
        try {
            $repository = Repository::where('id', $id)->firstOrFail();
            $repository->update([
                'is_active' => false,
            ]);

            return $this->provideSuccess('deactivate');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Marketing', [
            'repositories' => $this->getRepositories()
        ]);
    }
}
