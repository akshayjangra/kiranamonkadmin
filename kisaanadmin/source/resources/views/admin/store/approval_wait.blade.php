@extends('admin.layout.app')
<style>
 
    .material-icons{
        margin-top:0px !important;
        margin-bottom:0px !important;
    }
</style>
@section ('content')
<div class="container-fluid">
      
 <div class="row">
<div class="col-lg-12">
    @if (session()->has('success'))
   <div class="alert alert-success">
    @if(is_array(session()->get('success')))
            <ul>
                @foreach (session()->get('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
            @else
                {{ session()->get('success') }}
            @endif
        </div>
    @endif
     @if (count($errors) > 0)
      @if($errors->any())
        <div class="alert alert-danger" role="alert">
          {{$errors->first()}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      @endif
    @endif
    </div>
<div class="col-lg-12">
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title ">{{ __('keywords.Store List(Waiting for approval)')}}</h4>
    </div>
<div class="container"> <br> 
<table id="datatableDefault" class="table text-nowrap w-100">
    <thead class="thead-light">
        <tr>
            <th class="text-center">#</th>
                
                      <th>{{ __('keywords.Store Name')}}</th>
                      <th>{{ __('keywords.City')}}</th>
                      <th>{{ __('keywords.Mobile')}}</th>
                      <th>{{ __('keywords.Email')}}</th>
                      <th>{{ __('keywords.Admin Share')}}</th>
                      <th>{{ __('keywords.Owner name')}}</th>
                      <th>{{ __('keywords.Document')}} </th>
                      <th>{{ __('keywords.Action')}}</th>
                    </thead>
                    <tbody>
                         @if(count($city)>0)
                          @php $i=1; @endphp
                          @foreach($city as $cities)
                            <tr>
                                <td class="text-center">{{$i}}</td>
                                <td>{{$cities->store_name}}</td>
                                <td>{{$cities->city}}</td>
                                <td>{{$cities->phone_number}}</td>
                                <td>{{$cities->email}}</td>
                                <td>{{$cities->admin_share}} %</td>
                                <td>{{$cities->employee_name}}</td>
                               <td> @if($cities->document != NULL)<a target="_blank" rel="noopener noreferrer"  class="image-link btn btn-success" href="{{url($cities->document)}}">{{ __('keywords.View document')}}</a>
                                @else
                                <span style="color:red"> {{ __('keywords.No Document submitted')}}</span>
                                @endif</td>
                                
                                <td class="td-actions text-center">
                    
                                    <a href="{{route('storeapproved', $cities->id)}}" button type="button" class="btn btn-success">
                                        <i class="material-icons">check</i>{{ __('keywords.Approve')}}
                                    </button></a>
                                     <a href="{{route('storedelete', $cities->id)}}" button type="button" class="btn btn-danger">
                                        <i class="material-icons">close</i> {{ __('keywords.Delete')}}
                                    </button></a>
                                </td>
                            </tr>      
                        @php $i++; @endphp
                        @endforeach
                      @else
                        <tr>
                          <td>{{ __('keywords.No data found')}}</td>
                        </tr>
                      @endif  
                    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<div>
    </div>

    <script>  $(document).ready(function() {
  $('.image-link').magnificPopup({type:'image'});
});</script>
    @endsection
</div>