@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top">
                <h5 class="mb-0">Feedback Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('update_feedback', ['id' => $feedback->id]) }}" method="post">
                    @csrf
                    @method('PATCH')
                
                    <div>
                        <input type="hidden" name="user_id" value="{{ $feedback->user_id }}">
                        <input type="hidden" name="menu_id" value="{{ $feedback->menu_id }}">
                        
                        <div class="mb-4">
                            <label for="menuName" class="form-label fw-semibold">Menu</label>
                            <input type="text" class="form-control border-0 bg-light" id="menuName" value="{{ $feedback->menu->name }}" readonly>
                        </div>
                        
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-semibold">Comment</label>
                            <textarea class="form-control border-0 bg-light" id="comment" name="comment" rows="4">{{ $feedback->comment }}</textarea>
                        </div>
                        
                        <div class="mb-4 d-flex align-items-center">
                            <label for="rating" class="form-label fw-semibold me-3">Rating</label>
                            <div id="rating" class="star-rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" class="star-input"
                                        {{ $i == $feedback->rating ? 'checked' : '' }} hidden>
                                    <label for="rating-{{ $i }}" class="star">&#9733;</label>
                                @endfor
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="feedbackDate" class="form-label fw-semibold">Date</label>
                            <input type="date" class="form-control border-0 bg-light" id="feedbackDate" name="date" value="{{ $feedback->date }}">
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning text-white">Save</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="reset" class="btn btn-danger text-white">Reset</button>
                    </div>
                </form>                
            </div>
        </div>
    </div>
@endsection