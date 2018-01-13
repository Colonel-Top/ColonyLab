@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css?family=Barrio|Montserrat:700');
$green: #00d166;

body {
  font-family: 'Montserrat', sans-serif;
  display: flex;
  height: 100vh;
  width: 100vw;
  background: #111;
}

button {
  margin: auto;
  padding: 1rem;
  text-transform: uppercase;
  color: #fafafa;
  background-color: $green;
  border: none;
  border-radius: 3px;
  box-shadow: 1px 1px 10px rgba(50,50,50,.4);
  transition: .3s all ease;
  letter-spacing: .1rem;
  font-size: .85rem;
  position: relative;
  top: 0;
  right: 0;
  padding-left: 2.5rem;
  
  &:after,
  &:before {
    position: absolute;
    font-family: 'Barrio', sans-serif;
    font-weight: bold;
    font-size: 1rem;
    color: darken($green, 20%);
    transition: .3s all ease;
  }
  
  &:before {
    content: '_';
    position: absolute;
    left: 1.4rem;
    top: .9rem;
  }
  
  &:after {
    content: '>';
    position: absolute;
    left: .8rem;
    top: 1rem;
  }
  
  &:hover {
    box-shadow: 1px 1px 20px rgba(150,150,150,.2);
    top: -.1rem;
    right: -.1rem;
    cursor: pointer;
    
    
    &:before {
      content: '_';
      position: absolute;
      left: .8rem;
      top: .7rem;
      transform: translateY(-1px);
    }
  
    &:after {
      content: '>';
      position: absolute;
      left: 1.1rem;
      top: 1rem;
    }
  }
}
</style>
<div class="container">
    <div class="col-lg-12">
   @if (Session::has('message1'))
    <div class="alert alert-info">{{ Session::get('message1') }}</div>
    @endif
    <!-- courses list -->
  
        <div class="row">
            <h3>Select Mode to explore</h3>
            <div class = "m-b-md">
              
                <button>
                    <a href = "{{route('admin.couses.routeremark')}}"><label>View By Courses</label></a>
                </button>
            </div>
           </div>
           <div class = "m-b-md">
               
<button>
                    <a href = "{{route('admin.couses.routeremark')}}"><label>View By User</label></a>
               </button>
           </div>
        </div>

    </div>
</div>
@endsection