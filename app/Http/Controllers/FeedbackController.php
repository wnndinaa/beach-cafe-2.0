<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function displaydummy(): View
    {
        return view('manageFeedback.dummydisplay');
    }

    /**
     * FEEDBACK LIST
     * - Customer: sees own feedback
     * - Staff: sees feedback grouped by ORDER ID
     */
    public function viewListOFeedback($id): View
    {
        $user = User::findOrFail($id);

        if ($user->role === 'customer') {

            // CUSTOMER: only their own feedback
            $feedbacks = Feedback::with('order')
                ->where('user_id', $user->id)
                ->get();
        } elseif ($user->role === 'staff') {

            // STAFF: feedback grouped by ORDER ID
            $feedbacks = Feedback::with(['user', 'order'])
                ->whereNotNull('order_id')
                ->orderBy('order_id')
                ->get()
                ->groupBy('order_id');
        }

        // Format date for display
        foreach ($feedbacks as $group) {
            if ($group instanceof \Illuminate\Support\Collection) {
                foreach ($group as $fb) {
                    $fb->date = Carbon::parse($fb->date)->format('j F Y');
                }
            } else {
                $group->date = Carbon::parse($group->date)->format('j F Y');
            }
        }

        return view('manageFeedback.listofFeedback', compact('feedbacks', 'user'));
    }

    /**
     * CUSTOMER: Add feedback (ORDER based)
     */
    public function viewAddFeedback($order_id): View
    {
        $order = Order::with('items.menu')->findOrFail($order_id);

        return view('manageFeedback.addFeedback', compact('order'));
    }

    /**
     * VIEW FEEDBACK DETAILS
     * - Customer: see own feedback
     * - Staff: see feedback + order + items + reply
     */
    public function viewFeedbackDetails($id): View
    {
        $feedback = Feedback::with(['user', 'order.items.menu'])
            ->findOrFail($id);

        $feedback->date = Carbon::parse($feedback->date)->format('j F Y');

        return view('manageFeedback.feedbackDetails', compact('feedback'));
    }

    public function viewEditFeedback($id): View
    {
        $feedback = Feedback::findOrFail($id);

        return view('manageFeedback.editFeedback', compact('feedback'));
    }

    /**
     * CREATE FEEDBACK (ORDER BASED)
     */
    public function createFeedback(Request $request)
    {
        $request->validate([
            'user_id'  => ['required', 'exists:users,id'],
            'order_id' => ['required', 'exists:orders,id'],
            'comment'  => ['required', 'string', 'max:50'],
            'rating'   => ['required', 'integer'],
            'date'     => ['required', 'date', 'before_or_equal:today'],
        ]);

        Feedback::create([
            'user_id'  => $request->user_id,
            'order_id' => $request->order_id,
            'menu_id'  => null,
            'comment'  => $request->comment,
            'rating'   => $request->rating,
            'date'     => $request->date,
        ]);

        return redirect()->route('order.history')
            ->with('blue-message', 'Thank you for your feedback!');
    }

    public function updateFeedback(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:255'],
            'rating'  => ['required', 'integer'],
            'date'    => ['required', 'date'],
        ]);

        $feedback = Feedback::findOrFail($id);

        $feedback->update([
            'comment' => $request->comment,
            'rating'  => $request->rating,
            'date'    => $request->date,
        ]);

        return redirect()
            ->route('view_feedback_details', $feedback->id)
            ->with('blue-message', 'Feedback updated successfully.');
    }

    public function deleteFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        $user = $feedback->user;

        $feedback->delete();

        return redirect()
            ->route('view_all_feedback', $user->id)
            ->with('red-message', 'Feedback successfully deleted!');
    }

    /**
     * STAFF: Add reply
     */
    public function addReply(Request $request, $id)
    {
        $request->validate([
            'reply' => ['required', 'string'],
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->reply = $request->reply;
        $feedback->replied_at = now();
        $feedback->save();

        return back()->with('blue-message', 'Reply added successfully.');
    }

    /**
     * STAFF: Delete reply
     */
    public function deleteReply($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->reply = null;
        $feedback->replied_at = null;
        $feedback->save();

        return back()->with('red-message', 'Reply deleted.');
    }
}
