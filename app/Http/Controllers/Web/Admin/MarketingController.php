<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

            $repositoryCreate = Repository::create([
                'name' => $request->input('name'),
                'image' => $this->uploadImage('repository', $request->file('image')),
                'file' => $request->input('file'),
                'category' => $request->input('category'),
            ]);
            if(!$repositoryCreate->wasRecentlyCreated) throw new \Exception('Erro ao criar o cadastrar o arquivo no repositório.');
    
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

            $repositoryUpdate = $repository->update([
                'name' => $request->input('name', $repository->name),
                'image' => $request->hasFile('image') ? $this->uploadImage('repository', $request->file('image'), 'public', $repository->image) : $repository->image,
                'file' => $request->input('file', $repository->file),
                'category' => $request->input('category', $repository->category),
            ]);
            if($repositoryUpdate === 0) throw new \Exception('Erro ao atualizar o arquivo no repositório.');

            return $this->provideSuccess('update');
        }catch(\Throwable $e){
            $this->provideException($e);
        }
    }

    public function deleteRepository($id)
    {
        try {
            $repository = Repository::where('id', $id)->firstOrFail();

            if ($repository->image) {
                $this->deleteImage($repository->image);
            }
            if (!$repository->delete()) {
                throw new \Exception('Não foi possível deletar o repositório.');
            }

            return $this->provideSuccess('delete');
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
