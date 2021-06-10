@extends('layouts.app')

@section('content')
<!-- Navbar-->
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <!-- Navbar Brand -->
            <a href="#" class="navbar-brand">
                
            </a>
        </div>
    </nav>
</header>


<div class="container">
    <div class="row align-items-center" style="padding-top: 10%">
       
        <!-- Registeration Form -->
        <div class="container col-8">
            <h1 class=" pb-3">Login Admin</h1>
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <!-- Email Address -->
                    
                    <!-- <label>Username</label> -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-user-o text-muted"></i>
                            </span>
                        </div>  
                        <input id="username" type="text" placeholder="Username" class="form-control" name="username" value="{{ old('username') }}"
                                required autocomplete="username" autofocus>
                            
                            @if(Session::get('error'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ Session::get('error') }}</strong>
                            </span>
                            @endif
                    </div>
                    <!-- Password -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-lock text-muted"></i>
                            </span>
                        </div>
                        <input id="password" type="password" placeholder="Password" class="form-control" name="password" required
                    autocomplete="current-password">
              
                <div class="bar"></div>
                    @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                        </div>
                            <button type="submit"  class="btn btn-primary btn-block py-2">
                                <span class="font-weight-bold">Login</span>
                            </button>
                        </div>
                </div>
            </form>
        </div>
         <!-- For Demo Purpose -->
        
    </div>
</div>

@endsection
