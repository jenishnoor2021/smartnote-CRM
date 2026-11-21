<div class="navbar navbar-inverse">
  <div class="navbar-header">
      <a class="navbar-brand" href="<?= URL::to('/admin/dashboard') ?>">NISL Demo</a>
      <ul class="nav navbar-nav visible-xs-block">
          <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
          <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
      </ul>
  </div>
  <div class="navbar-collapse collapse" id="navbar-mobile">
      <ul class="nav navbar-nav">
          <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
              
          </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <li class="dropdown dropdown-user">
              <a class="dropdown-toggle" data-toggle="dropdown">
                  <span></span>
                  <span>{{ Auth::user()->name ?? (Session::get('user')['name'] ?? 'User') }} ({{ (Auth::user() && Auth::user()->isSuperAdmin()) ? 'Super Admin' : 'Seller' }})</span>
                  <i class="caret"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                  @if(Auth::check() && Auth::user()->isSuperAdmin())
                  <li><a href="/profile/{{ Auth::id() ?? Session::get('user')['id'] }}">{{ __('Change Password') }}</a></li>
                  @endif
                  <li><a href="/logout">{{ __('Logout') }}</a></li>
              </ul>
          </li>
      </ul>
  </div>
</div>
