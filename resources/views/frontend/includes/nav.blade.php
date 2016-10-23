<nav class="navbar navbar-fixed-top navbar-dark bg-primary">
      <div class="container" style="padding-bottom:10px;padding-top:10px;">

	<button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#navbar-header" aria-controls="navbar-header" aria-expanded="false" aria-label="Toggle navigation"></button>
     
        <div class="collapse navbar-toggleable-xs" id="navbar-header">

           <!-- <a class="navbar-brand href='/'>Imgup</a> -->		
           {{ link_to_route('frontend.index', "Imgup", [], ['class' => 'navbar-brand']) }}

           <ul class="nav navbar-nav">
              <li class="nav-item">
                 {{ link_to_route('frontend.index', "Home",[], ['class' => 'nav-link']) }}
              </li>
       
	       @if (access()->guest())
                    <li class="nav-item">{{ link_to('login', "Login", ['class' => 'nav-link']) }}</li>
                    <li class="nav-item">{{ link_to('register', "Register", ['class' => 'nav-link'])}}</li>
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ access()->user()->name }} 
                        </a>

                        <ul class="dropdown-menu">
                            <li class="dropdown-item">{{ link_to_route('frontend.user.dashboard', trans('navs.frontend.dashboard')) }}</li>

                            @if (access()->user()->canChangePassword())
                                <li class="dropdown-item">{{ link_to_route('auth.password.change', trans('navs.frontend.user.change_password')) }}</li>
                            @endif

                            @permission('view-backend')
                            <li class="dropdown-item">{{ link_to_route('admin.dashboard', trans('navs.frontend.user.administration')) }}</li>
                            @endauth

                            <li class="dropdown-item">{{ link_to_route('auth.logout', trans('navs.general.logout')) }}</li>
                        </ul>
                    </li>
                @endif
				
	   </ul>
	</div>
   </div>
</nav>	


