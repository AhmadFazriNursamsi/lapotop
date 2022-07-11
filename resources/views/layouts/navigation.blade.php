<?php
    use App\Http\Controllers\HelpersController as Helpers;
    $listmenu = Helpers::getListMenu();
    $uri = \Request::route()->getName();
?>

<nav class="navbar navbar-expand-lg navbar-light " style="background-color: #bbe2ff;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">MyAppsZ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <?php
            foreach($listmenu->data as $key => $menu) {
                $class = '';
                if($uri == $menu->url) $class = 'active';
                if($menu->dropdown == 0) {
                    $url = route($menu->url);
                    echo '<li class="nav-item"><a class="nav-link '.$class.'" aria-current="page" href="'.$url.'"><i class="'.$menu->icon.'"></i> '.$menu->name.'</a></li>';
                } else {
                    echo '<li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="'.$menu->icon.'"></i> 
                        '.$menu->name.'
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    
                    foreach($menu->list_child as $child){
                        $urlchild = $child->url;
                        echo '<li><a class="dropdown-item" href="'.$urlchild.'"><i class="'.$menu->icon.'"></i> '.$child->name.'</a></li>';
                    }

                    echo '</ul></li>';
                }
            }
        ?>
      </ul>
      <div class="d-flex">
        <form method="POST" action="{{ route('logout') }}">
            @csrf        
            <a class="btn btn-warning btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
        </form>
      </div>
    </div>
  </div>
</nav>