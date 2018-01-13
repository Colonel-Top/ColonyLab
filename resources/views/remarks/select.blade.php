<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<body>
<style>
.outer {
  position: relative;
  width: 80px;
  cursor: pointer;
}

.inner {
  width: inherit;
  text-align: center;
}

label { 
  font-size: .8em; 
  line-height: 4em;
  font-weight: 600;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: #fff;
  transition: all .3s ease-in;
  opacity: 0;
  cursor: pointer;
}

.inner:before, .inner:after {
  position: absolute;
  content: '';
  height: 4px;
  width: inherit;
  background: #2c3e50;
  left: 0;
  transition: all .3s ease-in;
}

.inner:before {
  top: 45%; 
  transform: rotate(45deg);  
}

.inner:after {  
  bottom: 50%;
  transform: rotate(-45deg);  
}

.outer:hover label {
  opacity: 1;
}

.outer:hover .inner:before,
.outer:hover .inner:after {
  transform: rotate(0);
}

.outer:hover .inner:before {
  top: 0;
}

.outer:hover .inner:after {
  bottom: 0;
}
html, body {
  background: #2ecc71;
  font-family: Helvetica, Arial, sans-serif;
  height: 100%;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>

<div class="container">
    <div class="col-lg-12">
   @if (Session::has('message1'))
    <div class="alert alert-info">{{ Session::get('message1') }}</div>
    @endif
    <!-- courses list -->
  
        <div class="row">
            <div class = "m-b-md">
                <div class = " outer">
                <div class ="inner">

                    <a href = "{{route('admin.couses.routeremark')}}"><label>View By Courses</label></a>
                </div>
            </div>
           </div>
           <div class = "m-b-md">
                <div class = " outer">
                <div class ="inner">

                    <a href = "{{route('admin.couses.routeremark')}}"><label>View By User</label></a>
                </div>
            </div>
           </div>
        </div>

    </div>
</div>
</body>
</html>