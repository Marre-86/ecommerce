
@if ($errors->any())
    <div>
      <ul>
        @foreach ($errors->all() as $error)
          <li style="color: #df382c">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif

<div class="form-group" style="margin-bottom:10px">
    {{ Form::label('name', 'Item name') }}
    {{ Form::text('name', $item->name, ['class' => 'form-control', 'style' => 'width:50%', 'required' => 'required'])}}
</div>

<div class="form-group" style="margin-bottom:10px">
  {{ Form::label('category_id', 'Category') }}
                      <select class="form-control" name="category_id" style="width:50%", required="required">
                        <option value="">----------</option>

                        @foreach ($categories as $category)
                          <option value="{{ $category->id }}" {{ ((old('category_id') == $category->id) or (isset($item) && ($category->id == $item->category_id))) ? ' selected' : '' }}>{{ $category->name }}</option>
                          @if ($category->children)
                            @foreach ($category->children as $child)
                                <option value="{{ $child->id }}"{{ ((old('category_id') == $child->id) or (isset($item) && ($child->id == $item->category_id))) ? ' selected' : '' }}>{{ "..." . $category->name . "/" . $child->name }}</option>
                                @if ($child->children)
                                  @foreach ($child->children as $grandchild)
                                    <option value="{{ $grandchild->id }}"{{ ((old('category_id') == $grandchild->id) or (isset($item) && ($grandchild->id == $item->category_id))) ? ' selected' : '' }}>{{ "......" . $category->name . "/" . $child->name . "/" . $grandchild->name }}</option>
                                  @endforeach
                                @endif
                            @endforeach
                          @endif
                        @endforeach
                      </select>
  </div>

  <div class="row" style="width:83%; margin-bottom:10px;">
    <div class="form-group col">
      {{ Form::label('price', 'Price') }}
      {{ Form::number('price', $item->price, ['class' => 'form-control', 'step' => '0.01', 'required' => 'required', 'min' => '0'])}}
    </div>
    <div class="form-group col">
      {{ Form::label('weight', 'Weight') }}
      {{ Form::number('weight', $item->weight, ['class' => 'form-control', 'step' => '0.01', 'min' => '0'])}}
    </div>
    <div class="form-group col">
      {{ Form::label('length', 'Length') }}
      {{ Form::number('length', $item->length, ['class' => 'form-control', 'step' => '0.01', 'min' => '0'])}}
    </div>
    <div class="form-group col">
      {{ Form::label('width', 'Width') }}
      {{ Form::number('width', $item->width, ['class' => 'form-control', 'step' => '0.01', 'min' => '0'])}}
    </div>
  </div>  
  <div class="form-group" style="margin-bottom:10px;">
    {{ Form::label('description', 'Description') }}
    {{ Form::textarea('description', $item->description, ['class' => 'form-control', 'style' => 'width:80%', 'rows' => 4])}}
  </div>

  @if (Request::route()->getName() === 'items.edit')     
    <p style="margin-bottom:0.2rem">Image</p>
    <div style="width:10rem; margin-bottom:1rem">
                <img src="{{ asset('storage/images/'.$item->image) }}" class="img-form">
    </div>
    <small id="imageHelp" class="form-text text-muted">Impossible to delete the image.</small><br>
    {{ Form::label('image', 'If you want to replace it with another file, then choose it:') }}
  @elseif (Request::route()->getName() === 'items.edit')     
    {{ Form::label('image', 'Image') }}
  @endif

  <div class="form-group" style="margin-bottom:10px;">
    {{ Form::file('image', ['class' => 'form-control', 'style' => 'width:40%'])}}
    <small id="imageHelp" class="form-text text-muted">Max size is 1024 kB.</small>
 </div>