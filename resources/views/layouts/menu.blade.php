<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="{{ asset('img/change1.png') }}">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"> 

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      
      <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
      
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.0/css/all.css">
      <link href="{{ asset('/css/styles.css')}}" rel="stylesheet" type="text/css">


      @yield('styles')
     

      <title>@yield('title')</title>
  
   </head>
   <body>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <div class="container-fluid">
      <div class="row">
         <div class="sidebar col-12 col-sm-auto fixed">
            <nav class=" lista menu h5 d-flex d-sm-block justify-content-center flex-wrap" id="lista"> 
               <a href="{{ route('home') }}" class="link {{ (request()->routeIs('home')) ? 'active' : '' }}"><i class="fas fa-home fa-fw"></i><span>Inicio</span></a> 
               <a href="{{ route('reservations.index') }}" class="link {{ (request()->routeIs('reservations.index')) ? 'active' : '' }}"><i class="fas fa-calendar-alt fa-fw"></i><span>Reservar</span></a> 
               <a href="#" class="link"><i class="fas fa-heartbeat fa-fw"></i><span>Mi cuerpo</span></a> 
               <a href="{{ route('profiles.index') }}" class="link {{ (request()->routeIs('profiles.index')) ? 'active' : '' }}"><i class="fas fa-user-edit fa-fw"></i><span>Perfil</span></a> 
               @if(auth()->user()->hasRole(['admin', 'trainer']))
               <hr class="mx-3 divider">
               @if(auth()->user()->hasRole(['admin']))
               <a href="{{ route('clients.index') }}" class="link {{ (request()->routeIs('clients.index')) ? 'active' : '' }}"><i class="fas fa-users fa-fw"></i><span>Clientes</span></a>
               <a href="{{ route('trainers.index') }}" class="link {{ (request()->routeIs('trainers.index')) ? 'active' : '' }}"><i class="fas fa-briefcase fa-fw"></i><span>Entrenadores</span></a>
               <a href="{{ route('subscriptions.index') }}" class="link {{ (request()->routeIs('subscriptions.index')) ? 'active' : '' }}"><i class="fas fa-dollar-sign fa-fw"></i><span>Pagos</span></a>
               <a href="#" class="link"><i class="fas fa-chart-area fa-fw"></i><span>Estadisticas</span></a>
               <a href="{{ route('trainings.index') }}" class="link {{ (request()->routeIs('trainings.index')) ? 'active' : '' }}"><i class="fas fa-dumbbell fa-fw"></i><span>Entrenos</span></a>
               @endif
               @if(auth()->user()->hasRole(['trainer']))
               <a href="{{ route('trainings.index') }}" class="link"><i class="fas fa-dumbbell fa-fw"></i><span> Mis Entrenos</span></a>
               @endif
               <a href="#" class="link"><i class="fas fa-envelope fa-fw"></i><span>Enviar mensaje</span></a>
               @endif
            </nav>
            <div>
               <div class="profile">
                  <div class="row profile-all">
                     <div class="col col-item photo">
                        <img src="/img/{{ auth()->user()->photo->route }}" alt="profilePhoto" class="profile-photo"> 
                     </div>
                     <div class="col col-item name">
                        <a href="{{ route('profiles.index') }}" class="link">{{ auth()->user()->name }} {{ auth()->user()->surname }}</a>
                     </div>
                     <div class="col col-item icon-bar fa-fw ">
                        <a href="{{ route('logout') }}" class="link"  onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt fa-fw" ></i></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <main class="main col">
           @yield('content')
         </main>
      </div>
   </div>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
  </script>
  <script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
   <script>
      $("document").ready(function(){
         setTimeout(function(){
            $("div.alert-success").remove();
            $("div.alert-reservation").remove();
         }, 10000 ); // 10 seg

      });
   </script>

  @yield('scripts') 

   </body>
</html>

