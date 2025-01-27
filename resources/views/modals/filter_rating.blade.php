<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter by Rating</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="{{ route($currentRouteName) }}">
                <div class="modal-body">
                    <!-- Dropdown Filter for Rating -->
                    <div class="form-group">
                        <label for="rating">Filter by Rating</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="">All Ratings</option>
                            @foreach ($uniqueRatings as $rating)
                                <option value="{{ $rating }}" {{ request('rating') == $rating ? 'selected' : '' }}>
                                    {{ $rating }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>
