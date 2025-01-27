<!-- Modal Filter Component -->
<div class="modal fade" id="filterComponentModal" tabindex="-1" role="dialog" aria-labelledby="filterComponentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterComponentModalLabel">Filter by Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('magnetic_plucks.index') }}">
                    <div class="form-group">
                        <label for="component">Component</label>
                        <select name="component" id="component" class="form-control">
                            <option value="">-- All Component --</option>
                            @foreach ($uniqueComponents as $comp)
                                <option value="{{ $comp }}" {{ request('component') == $comp ? 'selected' : '' }}>
                                    {{ $comp }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="">-- Select Rating --</option>
                            @foreach ($uniqueRatings as $rate)
                                <option value="{{ $rate }}" {{ request('rating') == $rate ? 'selected' : '' }}>
                                    {{ $rate }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Apply</button>
                        <a href="{{ route('magnetic_plucks.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
