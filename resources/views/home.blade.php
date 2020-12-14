@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Welcome') }} {{Auth::user()->first_name}}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ url('contact_reg') }}" enctype='multipart/form-data'>
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }} <span class="require">*</span></label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middle_name" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>

                            <div class="col-md-6">
                                <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') }}" autocomplete="middle_name" autofocus>

                                @error('middle_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }} <span class="require">*</span></label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Primary Phone') }} <span class="require">*</span></label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_optional" class="col-md-4 col-form-label text-md-right">{{ __('Secondary Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone_optional" type="text" class="form-control @error('phone_optional') is-invalid @enderror" name="phone_optional" value="{{ old('phone_optional') }}" autocomplete="phone_optional" autofocus>

                                @error('phone_optional')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} <span class="require">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Contact image/photo') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" autocomplete="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>


                    <div style="margin-top: 20px;">
                        <label>List of Contact Details</label>
                    </div>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Optional Phone</th>
                                <th>Email</th>
                                <th>Image</th>
                                <th>Action</th>
                                <th>Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @if(isset($data))
                                @foreach($data as $k => $v)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$v->first_name}} {{$v->middle_name}} {{$v->last_name}}</td>
                                        <td>{{$v->phone}}</td>
                                        <td>{{$v->phone_optional}}</td>
                                        <td>{{$v->email}}</td>
                                        @if(isset($v->image))
                                        <td><a href="{{asset($v->image)}}" download>Download</a></td>
                                        @else
                                        <td>-</td>
                                        @endif
                                        <td><a href="{{url('edit')}}/{{$v->id}}" class="btn btn-primary">Edit</a></td>
                                        @php $class = 'btn-primary'; @endphp
                                        @if($v->creted_by == Auth::id() && $v->modified_by == Auth::id())
                                        @php $class = 'btn-danger share'; @endphp
                                        @endif
                                        <td><input type="button" class="btn  {{$class}}" value="Share" id="{{$v->id}}" data_id = "{{$v->id}}" data-toggle="modal" data-target="#myModal"></td>
                                    </tr>
                                    @php $i++ @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal" role="dialog" data-backdrop="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Share Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <select class="form-control share_id">
        @foreach($other_user as $k => $v)
            <option value="{{$v->id}}">{{$v->first_name}} {{$v->last_name}}</option>
        @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <input type="button" class="btn btn-primary share_submit" name="submit" value="Submit">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="myModal1" class="modal" role="dialog" data-backdrop="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Share Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <select class="form-control share_id">
        @foreach($other_user as $k => $v)
            <option value="{{$v->id}}">{{$v->first_name}} {{$v->last_name}}</option>
        @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <input type="button" class="btn btn-primary share_submit" name="submit" value="Submit">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    } );

    var id = '';
    $(document).on('click','.share',function()
    {
        id  = $(this).attr('data_id');
        $(this).hide();
    });

    $(document).on('click','.share_submit',function(){

        var share_user_id  = $('.share_id').val();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });


        $.ajax({
            url: "{{url('share_deatils')}}",
            data: {"_token": "{{ csrf_token() }}","id":id,'share_user_id':share_user_id},
            type: 'POST',
            success: function(data){
                alert(data.msg);
                $('#myModal').hide();
                $('#'+id).removeClass('share');
                return false;
            }
        });
    });
</script>
@endsection
