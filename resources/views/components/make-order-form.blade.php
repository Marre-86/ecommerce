
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <fieldset>
            <div class="form-group">
                <label for="phone" class="form-label mt-4">Contact phone number</label>
                <div>
                    <input class="form-control" name="phone" style="width:10rem; float:left; margin-right: 3rem" value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="color: #df382c;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <label for="description" class="form-label mt-4">Below you can make any comments related to your order, including contact information</label>
                <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
            </div>    
            <button type="submit" class="btn btn-primary" style="margin-top:10px">Create an order</button>
        </fieldset>
    </form>
