
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
      {{ Form::number('price', $item->price, ['class' => 'form-control', 'step' => '0.01', 'required' => 'required'])}}
    </div>
    <div class="form-group col">
      {{ Form::label('weight', 'Weight') }}
      {{ Form::number('weight', $item->weight, ['class' => 'form-control', 'step' => '0.01'])}}
    </div>
    <div class="form-group col">
      {{ Form::label('length', 'Length') }}
      {{ Form::number('length', $item->length, ['class' => 'form-control', 'step' => '0.01'])}}
    </div>
    <div class="form-group col">
      {{ Form::label('width', 'Width') }}
      {{ Form::number('width', $item->width, ['class' => 'form-control', 'step' => '0.01'])}}
    </div>
  </div>
  
  <div class="form-group" style="margin-bottom:10px;">
    {{ Form::label('description', 'Description') }}
    {{ Form::textarea('description', $item->description, ['class' => 'form-control', 'style' => 'width:80%', 'rows' => 4])}}
  </div>
