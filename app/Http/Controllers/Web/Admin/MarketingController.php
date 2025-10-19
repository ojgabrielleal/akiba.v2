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
            $tutorials = Repository::orderBy('created_at', 'desc')->where('category', 'tutorial')->get();
            $installers = Repository::orderBy('created_at', 'desc')->where('category', 'installer')->get();
            $packages = Repository::orderBy('created_at', 'desc')->where('category', 'package')->get();

            if ($tutorials && $installers && $packages) {
                return response()->json([
                    'tutorials' => $tutorials,
                    'installers' => $installers,
                    'packages' => $packages
                ], 200);
            }
        } catch (\Throwable $e) {
            $this->provideException($e);
        }
    }
    
    public function createRepository(Request $request)
    {
        try{
            $request->validate([
                'image' => 'required',
                'file' => 'required',
                'category' => 'required',
            ], [
                'image.required' => 'Icone do arquivo',
                'file.required' => 'Link do arquivo',
                'category.required' => 'Categoria do arquivo',
            ]);

            $repositoryCreate = Repository::create([
                'image' => $this->uploadImage('repository', $request->file('image')),
                'file' => $request->file,
                'category' => $request->category,
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
                'image' => 'sometimes',
                'file' => 'sometimes',
                'category' => 'sometimes',
            ], [
                'image.required' => 'Icone do arquivo',
                'file.required' => 'Link do arquivo',
                'category.required' => 'Categoria do arquivo',
            ]);

            $repository = Repository::where('id', $id)->firstOrFail();

            $repositoryUpdate = $repository->update([
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

    public function deactivateRepository($id)
    {
        try {
            $repository = Repository::where('id', $id)->firstOrFail();

            $repositoryDeactivate = $repository->update([
                'active' => false
            ]);
            if ($repositoryDeactivate === 0) throw new \Exception('Não foi possível desativar o arquivo no repositório.');

            return $this->provideSuccess('deactivate');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Marketing', [
            'repositories' => $this->getRepositories(),
        ]);
    }
}
