<form method="post" action="{{ route('category.update', $category->id) }}" enctype="multipart/form-data"
    id="modifyCategory{{ $category->id }}">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modifyCategoryModal{{ $category->id }}" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-labelledby="modifyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">update category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="text-start" for="name">Name:</label>
                    <div class="form-container m-0 p-0">
                        <input type="text" class="input text-dark" name="name" id="name{{ $category->id }}"
                            placeholder="Name" value="{{ old('name', $category->name) }}" required>
                    </div>

                    <label class="text-start" for="stdResolutionTime">Standard resolution time(min):</label>
                    <div class="form-container m-0 p-0">
                        <input type="number" class="input text-dark" name="stdResolutionTime"
                            id="stdResolutionTime{{ $category->id }}" placeholder="resolution Time"
                            value="{{ old('stdResolutionTime', $category->stdResolutionTime) }}" min="1"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">update</button>
                </div>
            </div>
        </div>
    </div>
</form>
