<div class="modal fade" id="filterUnitModelModal" tabindex="-1" aria-labelledby="filterUnitModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterUnitModelLabel">Filter by Unit Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <form method="GET" action="{{ route($currentRouteName)}}">
                <div class="modal-body">
                    <select name="unit_model" class="form-control">
                        <option value="">-- Select Unit Model --</option>
                        @foreach ($unitModels as $model)
                            <option value="{{ $model }}" {{ request('unit_model') == $model ? 'selected' : '' }}>
                                {{ $model }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>
