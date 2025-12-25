<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\PollService;
use App\Services\Domain\EventService;

class MediasController extends Controller
{
    use FlashMessageTrait;

    public function deactivateEvent($eventId){
        $eventService = new EventService();
        $eventDeactivate = $eventService->deactivate($eventId);

        if($eventDeactivate){
            return $this->flashMessage('deactivate');
        }
    }

    public function getPoll($pollId)
    {
        $pollService = new PollService();
        return $pollService->get($pollId);
    }

    public function createPoll(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'option_one' => 'required',
            'option_two' => 'required', 
            'option_three' => 'required',
            'option_four' => 'required'
        ]);

        $pollService = new PollService();
        $pollCreate = $pollService->create($request->all());

        if($pollCreate){
            return $this->flashMessage('save');
        }
    }
    
    public function updatePoll(Request $request, $pollId)
    {
        $request->validate([
            'question' => 'required',
            'option_one' => 'required',
            'option_two' => 'required', 
            'option_three' => 'required',
            'option_four' => 'required'
        ]);

        $pollService = new PollService();
        $pollUpdate = $pollService->update($pollId, $request->all());

        if($pollUpdate){
            return $this->flashMessage('save');
        }
    }
    
    public function deactivatePoll($pollId){

        $pollService = new PollService();
        $pollDeactivate = $pollService->deactivate($pollId);

        if($pollDeactivate){
            return $this->flashMessage('deactivate');
        }
    }
    
    public function createVote($pollOptionId)
    {
        $pollService = new PollService();
        $pollVoteCreate = $pollService->createVote($pollOptionId);

        if($pollVoteCreate){
            return $this->flashMessage('save');
        }
    }

    public function render()
    {
        $events = new EventService();
        $polls = new PollService();

        return Inertia::render('admin/Medias', [
            'polls' => $polls->list(),
            'events' => $events->list()
        ]);
    }
}
