            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <h3>Create Category</h3>
                </div>

                <div class="card-body">
                  <form action="{{ route('category.store') }}" method="POST">
                    @csrf

                    <div class="form-group" style="margin-bottom:10px">
                      <select class="form-control" name="parent_id">
                        <option value="">Select Parent Category</option>

                        @foreach ($categories as $category)
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @if ($category->children)
                            @foreach ($category->children as $child)
                                <option value="{{ $child->id }}">{{ "..." . $category->name . "/" . $child->name }}</option>
                            @endforeach
                          @endif
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group" style="margin-bottom:10px">
                      <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Category Name" required>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-success">Create</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>