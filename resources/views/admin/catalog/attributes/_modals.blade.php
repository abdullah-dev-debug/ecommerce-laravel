<!-- Color Modal -->
<div class="modal fade" id="colorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="colorForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="colorModalTitle">
                        <i class="fa fa-palette me-2"></i> Add Color
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="colorId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Color Name *</label>
                        <input type="text" class="form-control" id="colorName" name="name" required>
                        <div class="invalid-feedback" id="colorNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="colorHex" class="form-label">Hex Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control" name="code" id="colorHex">
                        </div>
                        <div class="form-text">Click on the color picker below to select</div>
                    </div>

                    <div class="mb-3">
                        <label for="colorStatus">Status</label>
                        <select name="status" id="colorStatus" class="form-select">
                            <option value="" disabled selected>Select Color Status</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="colorSubmitBtn">
                        <i class="fa fa-save me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Size Modal -->
<div class="modal fade" id="sizeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sizeForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="sizeModalTitle">Add Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="sizeId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Size Name *</label>
                        <input type="text" class="form-control" id="sizeName" name="name" required>
                        <div class="invalid-feedback" id="sizeNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Size Code</label>
                        <input type="text" class="form-control" id="sizeCode" name="code" placeholder="e.g., S, M, L">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="sizeDesc" name="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sizeStatus">Status</label>
                        <select name="status" id="sizeStatus" class="form-select">
                            <option value="" disabled selected>Select Size Status</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="sizeSubmitBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Unit Modal -->
<div class="modal fade" id="unitModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="unitForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="unitModalTitle">Add Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="unitId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Unit Name *</label>
                        <input type="text" class="form-control" id="unitName" name="name" required>
                        <div class="invalid-feedback" id="unitNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="symbol" class="form-label">Symbol</label>
                        <input type="text" class="form-control" id="unitSymbol" name="symbol"
                            placeholder="e.g., kg, g, L">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="unitType" name="type">
                            <option value="weight">Weight</option>
                            <option value="volume">Volume</option>
                            <option value="length">Length</option>
                            <option value="quantity">Quantity</option>
                            <option value="general">General</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="unitStatus">Status</label>
                        <select name="status" id="unitStatus" class="form-select">
                            <option value="" disabled selected>Select Unit Status</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info" id="unitSubmitBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-question-circle me-2"></i> Help</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Manage your product attributes efficiently.</p>
                <ul>
                    <li><strong>Colors:</strong> Define product color options</li>
                    <li><strong>Sizes:</strong> Define size variations</li>
                    <li><strong>Units:</strong> Define measurement units</li>
                </ul>
            </div>
        </div>
    </div>
</div>