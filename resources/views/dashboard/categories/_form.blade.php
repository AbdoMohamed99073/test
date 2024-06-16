<div class="form-group">


    <lable for="">Category Name</lable>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name' , $category->name)}}">
    @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
    @enderror
</div>
<div class="form-group">
    <lable for="">Parent</lable>
    <select name="Parent_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach ($parents as $parent)
            <option value="{{$parent->id}}" @selected(old('Parent_id',$category->Parent_id ) == $parent->id)>{{$parent->name}}</option>
            @error('Parent_id')
                <div class="alert alert-danger">
                    <ul>
                        <li>{{$message}}</li>
                    </ul>
                </div>
            @enderror
        @endforeach
    </select>
</div>
<div class="form-group">
    <lable for="">Category Description</lable>
    <textarea type="text" name="description" class="form-control">{{old('description' , $category->description)}}</textarea>
    @if ($errors->has('description'))
        <div class="alert alert-danger">
            <ul>
                <li>{{$errors->frist('description')}}</li>
            </ul>
        </div>
    @endif
</div>
<div class="form-group">
    <lable for="">Category image</lable>
    <div class="mb-3">
        <input class="form-control" type="file"  name="logo_image">
    </div>
    @if ($category->logo_image)
        <img src="{{asset('storage/' . $category->logo_image)}}" alt="" height="50">
    @endif
</div>
<div class="form-group">
    <lable for="">Category Status</lable>
    <div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="active"
                @checked(old('status' , $category->status) == 'active')>
            <label class="form-check-label">
                active
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="archived"
                @checked(old('status' , $category->status) == 'archived')>
            <label class="form-check-label">
                disactive
            </label>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{$button_lable}}</button>
</div>