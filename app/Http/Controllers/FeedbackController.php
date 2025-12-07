<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Menu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function displaydummy(): View {
        return view('manageFeedback.dummydisplay');
    }

    public function viewListOFeedback($id): View {
        $user = User::findOrFail($id);

        if ($user->role === 'customer') {
            $feedbacks = Feedback::where('user_id', $user->id)->get();
        } elseif ($user->role === 'staff') {
            $feedbacks = Feedback::all();
        }

        foreach ($feedbacks as $fb) {
            $fb->date = Carbon::parse($fb->date)->format(' j F Y');
        }

        return view('manageFeedback.listofFeedback', [
            'feedbacks' => $feedbacks,
            'user' => $user,
        ]);
    }

    public function viewAddFeedback($menu_id): View {
        $menu = Menu::findOrFail($menu_id);

        return view('manageFeedback.addFeedback', [
            'menu' => $menu,
        ]);
    }

    public function viewFeedbackDetails($id): View {
        $feedback = Feedback::findOrFail($id);

        $feedback->date = Carbon::parse($feedback->date)->format('j F Y');

        return view('manageFeedback.feedbackDetails', [
            'feedback' => $feedback,
        ]);
    }

    public function viewEditFeedback($id): View {
        $feedback = Feedback::findOrFail($id);

        return view('manageFeedback.editFeedback', [
            'feedback' => $feedback,
        ]);
    }

    public function createFeedback(Request $request) {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'menu_id' => ['required', 'exists:menus,id'],
            'comment' => ['required', 'string', 'max:50'],
            'rating' => ['required', 'integer'],
            'date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        Feedback::create([
            'user_id' => $request->user_id,
            'menu_id' => $request->menu_id,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'date' => $request->date,
        ]);

        return redirect()->route('view_add_Feedback', ['menu_id' => $request->menu_id])->with('blue-message', 'Thank you for your feedback!');
    }

    public function updateFeedback(Request $request, $id): RedirectResponse {
        $request->validate([
            'comment' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer'],
            'date' => ['required', 'date'],
        ]);

        $feedback =  Feedback::findOrFail($id);

        $feedback->update([
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
            'date' => $request->input('date'),
            'user_id' => $feedback->user_id,
            'menu_id' => $feedback->menu_id,
        ]);
        return redirect()->route('view_feedback_details', ['id' => $feedback->id])->with('blue-message', 'Successfully Update Feedback');
    }

    public function deleteFeedback($id) {
        $feedback = Feedback::findOrFail($id);
        $user = $feedback->user;
        $feedback->delete();

        return redirect()->route('view_all_feedback', ['id' => $user->id])->with('red-message', 'Feedback Successfully Deleted!');
    }
}
