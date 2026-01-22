<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;
use App\Services\Process\ImageService;

use App\Models\Repository;

class MarketingController extends Controller
{
    use FlashMessageTrait;

    private ImageService $image;
    private $render = 'private/Marketing';

    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    public function indexRepositories()
    {
        return Repository::active()
                ->get();
    }

    public function showRepository(Repository $repository)
    {
        return Inertia::render($this->render, [
            'repository' => $repository,
        ]);
    }
    
    public function createRepository(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:repositories,name',
            'file' => 'required|unique:repositories,file',
            'image' => 'required',
            'category' => 'required',
        ]);

        Repository::create([
            'name' => $request->input('name'),
            'file' => $request->input('file'),
            'image' => $this->image->store('repository', $request->input('image')),
            'category' => $request->input('category'),
        ]);

        return $this->flashMessage('save');
    }

    function updateRepository(Request $request, Repository $repository)
    {
        $repository->fill([
            'name' => $request->input('name', $repository->name),
            'file' => $request->input('file', $repository->file),
            'image' => $this->image->store('repository', $request->input('image'), 'public', $repository->image),
            'category' => $request->input('category', $repository->category),
        ]);

        if($repository->isDirty()){
            $repository->save();
        }

        return $this->flashMessage('update');
    }

    public function deactivateRepository(Repository $repository)
    {
        $repository->update([
            'is_active' => false,
        ]);

        return $this->flashMessage('deactivate');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'repositories' => $this->indexRepositories(),
        ]);
    }
}
