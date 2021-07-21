@extends('store.layout.app')
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
     <a href="{{route('store_AddD_boy')}}" class="btn btn-primary ml-auto" style="width:15%;float:right;padding: 3px 0px 3px 0px;">{{ __('keywords.Add')}} {{ __('keywords.Delivery Boy')}}</a>
</div> 
<div class="col-lg-12">
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title" style="width:50%;float:left;">{{ __('keywords.Delivery Boy')}} {{ __('keywords.List')}}</h4>
    </div>
    
<div class="container"><br> 
<table id="datatableDefault" class="table text-nowrap w-100">
    <thead class="thead-light">
        <tr>
            <th> # </th>
            <th>{{ __('keywords.Boy Name')}}</th>
            <th>{{ __('keywords.Boy Phone')}}</th>
            <th>{{ __('keywords.Boy Password')}}</th>
            <th>{{ __('keywords.Status')}}</th>
            <th>{{ __('keywords.Orders')}}</th>
            <th class="text-right">{{ __('keywords.Actions')}}</th>
        </tr>
    </thead>
    <tbody>
           @if(count($d_boy)>0)
          @php $i=1; @endphp
          @foreach($d_boy as $d_boys)
        <tr>
            <td class="text-center">{{$i}}</td>
            <td>{{$d_boys->boy_name}}</td>
           
            <td>{{$d_boys->boy_phone}}</td>
       
            <td>{{$d_boys->password}}</td>
            @if($d_boys->status == 1)
            <td><p style="color:green">on duty</p></td>
            @else
            <td><p style="color:red">off duty</p></td>
            @endif
            <td>

                <a href="{{route('store_dboy_orders',$d_boys->dboy_id)}}" rel="tooltip" class="btn btn-primary">
                    <i class="fa fa-cubes"></i></td>
            <td class="td-actions text-right">

                @if($d_boys->added_by == 'store')
                <a href="{{route('store_EditD_boy',$d_boys->dboy_id)}}" rel="tooltip" class="btn btn-success">
                    <i class="fa fa-edit"></i>
                </a>
                @else
                <p><b style="color:red">{{ __('keywords.added by admin')}}</b></p>
                @endif
               <a href="{{route('store_DeleteD_boy',$d_boys->dboy_id)}}" onClick="return confirm('Are you sure you want to permanently remove this Store.')" rel="tooltip" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                </a>
                
            </td>
        </tr>
          @php $i++; @endphp
                 @endforeach
                  @else
                    <tr>
                      <td>{{ __('keywords.No data found')}}s</td>
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

    @endsection
</div>