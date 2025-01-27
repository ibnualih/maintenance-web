<div class="modal fade" id="filterUnitCodeModal" tabindex="-1" aria-labelledby="filterUnitCodeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="GET" action="{{route($currentRouteName)}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterUnitCodeLabel">Filter by Unit Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select name="unit_code" class="form-control">
                        <option value="">-- Select Unit Code --</option>
                        @foreach ($unitCodes as $code)
                            <option value="{{ $code }}" {{ request('unit_code') == $code ? 'selected' : '' }}>
                                {{ $code }}
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
