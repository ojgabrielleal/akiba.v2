<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;

use App\Models\Poll;
use App\Models\PollOption;

use App\Http\Controllers\Web\Admin\EventsController;

class MediasController extends Controller
{
    use ProvideSuccess, ProvideException;

    public function permissions()
    {
        try{
            $user = request()->user();

            return [
                'create_poll' => $user->permissions_keys->contains('administrator'),
                'edit_poll' => $user->permissions_keys->contains('administrator'), 
                'deactivate_poll' => $user->permissions_keys->contains('administrator'), 
                'deactivate_event' => $user->permissions_keys->contains('administrator')
            ];
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function listEvents()
    {
        try{
            $eventsController = new EventsController();
            return $eventsController->listEvents();
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function deactivateEvent($slug)
    {
        try{
            $eventsController = new EventsController();
            return $eventsController->deactivateEvent($slug);
        }catch(\Throwable $e){
            return $this->provideException($e);
        } 
    }

    public function listPolls()
    {
        try{
            return Poll::orderBy('created_at', 'desc')->with('options')->where('is_active', true)->get();
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function getPoll($id)
    {
        try{
            if($id){
                return Poll::where('id', $id)->with('options')->firstOrFail();
            }
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function createPoll(Request $request)
    {
        try {
            $request->validate([
                'question' => 'required',
                'option_one' => 'required',
                'option_two' => 'required', 
                'option_three' => 'required',
                'option_four' => 'required'
            ], [
                'question.required' => "Pergunta",
                'option_one.required' => "1º Opção",
                'option_two.required' => "2º Opção",
                'option_three.required' => "3º Opção",
                'option_four.required' => "4º Opção",
            ]);

            $exists = Poll::where('question', $request->input('question'))->exists();
            if($exists) return $this->provideSuccess('exists');

            $poll = Poll::create([
                'question' => $request->input('question')
            ]);

            $options = [
                $request->input('option_one'),
                $request->input('option_two'),
                $request->input('option_three'),
                $request->input('option_four'),
            ];

            foreach ($options as $optionText) {
                PollOption::create([
                    'poll_id' => $poll->id,
                    'option' => $optionText
                ]);
            }

            return $this->provideSuccess('save');

        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }
    
    public function updatePoll(Request $request, $id)
    {
        try{
            $request->validate([
                'question' => 'required',
                'option_one' => 'required',
                'option_two' => 'required', 
                'option_three' => 'required',
                'option_four' => 'required'
            ], [
                'question.required' => "Pergunta",
                'option_one.required' => "1º Opção",
                'option_two.required' => "2º Opção",
                'option_three.required' => "3º Opção",
                'option_three.required' => "4º Opção",
            ]);

            $poll = Poll::where('id', $id)->with('options')->firstOrFail();
            $poll->update([
                'question' => $request->input('question', $poll->question)
            ]);

            $options = [
                'option_one' => $poll->options[0] ?? null,
                'option_two' => $poll->options[1] ?? null,
                'option_three' => $poll->options[2] ?? null,
                'option_four' => $poll->options[3] ?? null,
            ];

            foreach ($options as $key => $option) {
                if ($option) {
                    $option->update([
                        'option' => $request->input($key)
                    ]);
                }
            }

            return $this->provideSuccess('update');
        }catch(\Throwable $e) {
            return $this->provideException($e);
        }
    }
    
    public function deactivatePoll($id){
        try{
            Poll::where('id', $id)->update([
                'is_active' => false
            ]);

            return $this->provideSuccess('deactivate');
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }
    
    public function createVote($id)
    {
        try{
            $option = PollOption::where('id', $id)->firstOrFail();
            $option->update([
                'votes' => $option->votes + 1
            ]);

            return $this->provideSuccess('vote');
        }catch(\Throwable $e){
            return $this->provideException($e);
        }
    }

    public function render()
    {
        return Inertia::render('admin/Medias', [
            'permissions' => $this->permissions(),
            'polls' => $this->listPolls(),
            'events' => $this->listEvents()
        ]);
    }
}
