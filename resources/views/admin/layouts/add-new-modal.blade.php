<!-- Generic Add New Modal -->
<div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewModalLabel">Add New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-new-form">
                    @csrf
                    <input type="hidden" id="add-new-entity-type" name="entity_type">
                    <input type="hidden" id="add-new-dropdown-id" name="dropdown_id">
                    <div class="mb-3">
                        <label for="add-new-name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="add-new-name" name="name" required>
                        <div class="invalid-feedback" id="add-new-name-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="add-new-description" class="form-label">Description</label>
                        <textarea class="form-control" id="add-new-description" name="description" rows="3"></textarea>
                    </div>
                    <!-- Additional fields for specific entities -->
                    <div id="add-new-additional-fields"></div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>