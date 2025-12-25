<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\RepositoryService;

class MarketingController extends Controller
{
    use FlashMessageTrait;

    public function getRepository($repositoryId)
    {
        $repository = new RepositoryService();
        return $repository->get($repositoryId);
    }
    
    public function createRepository(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'file' => 'required',
            'category' => 'required',
        ]);

        $repository = new RepositoryService();
        $create = $repository->create($request->all());

        if($create){
            return $this->flashMessage('save');
        }
    }

    function updateRepository(Request $request, $repositoryId)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'file' => 'required',
            'category' => 'required',
        ]);

        $repository = new RepositoryService();
        $update = $repository->update($repositoryId, $request->all());
        
        if($update){
            return $this->flashMessage('update');
        }
    }

    public function deactivateRepository($repositoryId)
    {
        $repository = new RepositoryService();
        $deactivate = $repository->deactivate($repositoryId);

        if($deactivate){
            return $this->flashMessage('deactivate');
        }
    }

    public function render()
    {
        $repository = new RepositoryService();
        
        return Inertia::render('admin/Marketing', [
            'repositories' => $repository->list(),
        ]);
    }
}
